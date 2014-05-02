<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;



class MedienFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */

    protected $tableGatewayPersExtended;
    protected $tableGatewayZoraAuthor;

    protected $searchFields = array(
        'gespraechstitel',
        'sendetitel',
    );

    public function __construct(TableGateway $tableMedienGateway)
    {
        $this->tableGateway = $tableMedienGateway;

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
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }



    public function getMedium($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('medienid' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function deleteMedium($id)
    {
        $this->tableGateway->delete(array('medienid' => $id));
    }


    public function saveMedium(Medium $medium)
    {
        $data = array(
            'mit_id' => $medium->mit_id,
            'sendetitel'  => $medium->sendetitel,
            'datum'  => $medium->datum,
            'gespraechstitel'  => $medium->gespraechstitel,
            'icon'  => $medium->icon,
            'link'  => $medium->link,
            'medientyp'  => $medium->medientyp,
        );

        $id = (int)$medium->medienid;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getMedium($id)) {
                $this->tableGateway->update($data, array('medienid' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
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
                $sql = $sql .  $this->qV($matching[$r['sendetitel']]) . ')';
                $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
            }


        }
    }


}