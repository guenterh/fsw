<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use FSW\Model\PersonenInfo;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use FSW\Model\Medium;




class MedienFacade extends BaseFacade {



    protected $searchFields = array(
        'gespraechstitel',
        //'sendetitel',
    );

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        //in the past we used a specialized TableGateway
    }



    /**
     * Find institutions
     *
     * @param    String            $searchString
     * @param    Integer            $limit
     * @param    String            $order
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30, $order = 'gespraechstitel')
    {
        return $this->findFulltext($searchString, $order, $limit);
    }




    public function fetchAll()
    {
        //ich möchte nicht mehr mit dedizierten tables in den Fassaden arbeiten.
        //Facades sollten keine direkten Referenzen mehr auf Tabellen haben
        //$resultSet = $this->tableGateway->select();
        //$resultSet = $this->histSemDBService->getMedienGateway()->select();

        $targetGateway = $this->histSemDBService->getMedienGateway();
        $select = new Select();
        $select->from($targetGateway->getTable())->order("gespraechstitel");

        return $targetGateway->selectWith($select);

    }



    public function getMedium($id)
    {
        $id  = (int) $id;
        //$rowset = $this->tableGateway->select(array('id' => $id));
        $rowset = $this->histSemDBService->getMedienGateway()->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }



    public function deleteMedium($id)
    {
        //$this->tableGateway->delete(array('id' => $id));
        $this->histSemDBService->getMedienGateway()->delete(array('id' => $id));
    }


    public function saveMedium(Medium $medium)
    {

        $idToReturn = 0;
        $data = array(
            'mit_id_per_extended' => $medium->getMit_id_per_extended(),

            'sendetitel'  => $medium->getSendetitel(),
            'datum'  => $medium->getDatum(),
            'gespraechstitel'  => $medium->getGespraechstitel(),
            'icon'  => $medium->getIcon(),
            'link'  => $medium->getLink(),
            'medientyp'  => $medium->getMedientyp()
        );

        $id = (int)$medium->getId();
        $gW = $this->histSemDBService->getMedienGateway();
        if ($id == 0) {

            $gW->insert($data);
            $idToReturn = $gW->getLastInsertValue();

        } else {
            if ($this->getMedium($id)) {
                $this->histSemDBService->getMedienGateway()->update($data, array('id' => $id));
                $idToReturn = $id;
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

        return $idToReturn;
    }



    public function insertMedienFSW () {

        $sql = 'delete from fsw_medien';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        //matching IDS oldID => new ID
        $matching = array(

            4 => 103,   //Tanner
            6 => 101,   //Sarasin
            200 => 307, //Rossfeld
            201 => 835, //Straumann
            206 => 339, //Bänziger
            229 => 317, //Kuhn
            267 => 577  //Dal Molin
        );

        //es fehlt
        //254 FSW (Siegenthaler)
        //in medien (old) gibt es einen Eintrag mit der id 11 für die es keinen Mitarbeiter gibt





        $sql = 'select * from medien';

        $result =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['mit_id']) || empty ($r['mit_id'])) {
                continue;
            }


            if (array_key_exists($r['mit_id'],$matching)) {

                $sql = "insert into fsw_medien (datum, gespraechstitel, icon, link , medientyp, mit_id_per_extended, sendetitel) ";
                $sql = $sql .  "values (" . $this->qV($r['datum']) . ',';
                $sql = $sql .  $this->qV($r['gespraechstitel']) . ',';
                $sql = $sql .  $this->qV($r['icon']) . ',';
                $sql = $sql .  $this->qV($r['link']) . ',';
                $sql = $sql .  $this->qV($r['medientyp']) . ',';
                $sql = $sql .  $this->qV($matching[$r['mit_id']]) . ',';
                $sql = $sql .  $this->qV($r['sendetitel']) . ')';
                $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
            }


        }
    }

    public function searchInMedien ($query, $limit = 15) {


        $select = new Select();
        $likeCondition = $this->getSearchFieldsLikeCondition($query);


        $targetGateway = $this->histSemDBService->getMedienGateway();

        $select->from($targetGateway->getTable())
            ->order("gespraechstitel")
            //->limit($limit)
            ->where($likeCondition);


        return $targetGateway->selectWith($select);

    }


    public function getMedienByTyp($medientypen = array()) {



        $sql = 'SELECT m.* , p.pers_name, p.pers_vorname FROM `fsw_medien` as m, `Per_Personen` as p where m.mit_id_per_extended = p.pers_id ';
        if (count($medientypen) > 0) {
            $sql .= ' and medientyp in (' . implode(',',$medientypen) . ') ';

        }
        $sql .=  'order by datum DESC';
        $result = $this->getAdapter()->query(   $sql, Adapter::QUERY_MODE_EXECUTE);


        return $this->compileMedien($result, true);

    }

    public function getMedienByMitarbeiter($mitid) {

        $sql = 'SELECT m.* , p.pers_name, p.pers_vorname FROM `fsw_medien` as m, `Per_Personen` as p where m.mit_id_per_extended = p.pers_id ';
        $sql .= ' and p.pers_id = ' . $mitid;
        $sql .=  ' order by datum DESC';
        $result = $this->getAdapter()->query(   $sql, Adapter::QUERY_MODE_EXECUTE);


        return $this->compileMedien($result);
    }


    private function compileMedien (ResultSet $result, $addPerson = false) {

        $medien = array();

        foreach ($result as $row) {
            $m = new Medium();


            $m->setId($row['id']);
            $m->setDatum($row['datum']);
            $m->setGespraechstitel($row['gespraechstitel']);
            $m->setSendetitel($row['sendetitel']);
            $m->setMit_id_per_extended($row['mit_id_per_extended']);
            $m->setSendetitel($row['sendetitel']);
            $m->setIcon($row['icon']);
            $m->setLink($row['link']);

            $m->setBeteiligter($row['pers_vorname'] . ' ' . $row['pers_name']);



            if ($addPerson) {
                //$lvPersGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();
                $sql = 'select p.pers_name as name, p.pers_vorname as vorname, pe.profilURL as url, p.pers_id as id from ';
                $sql .= 'Per_Personen p inner join fsw_personen_extended pe on (p.pers_id = pe.pers_id) ';
                $sql .= ' where  p.pers_id = ' . $row['mit_id_per_extended'];

                $rPinfo = $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);

                if ($rPinfo && count($rPinfo) == 1) {
                    $pinfo = $rPinfo->current()->getArrayCopy();
                    $pi = new PersonenInfo();

                    $pi->setId($pinfo['id']);
                    $pi->setNachName($pinfo['name']);
                    $pi->setVorName($pinfo['vorname']);
                    $pi->setProfilURL($pinfo['url']);
                    $m->addPersonenInfo($pi);
                }
            }



            $medien[] = $m;
        }

        return $medien;


    }


}