<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;


use FSW\Model\BaseModel;
use FSW\Model\Lehrveranstaltung;
use FSW\Model\RelationPersonLehrveranstaltung;
use FSW\Model\PersonenInfo;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;
use Zend\Db\ResultSet\ResultSet;

class LehrveranstaltungFacade extends BaseFacade {



    protected $searchFields = array(
        'semester',
        'titel',
    );



    /**
     * Find elements
     *
     * @param    String $searchString
     * @param    Integer $limit
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30)
    {
        // TODO: Implement find() method.
    }


    public function getAllLehrveranstaltungen() {

        $lvTableGateway = $this->histSemDBService->getLehrveranstaltungenGateway();
        $select = $lvTableGateway->getSql()->select()->order('semester desc');
        return  $lvTableGateway->selectWith($select);



    }




    public function insertLehrveranstaltungFromOldDB ()
    {

        //Bischof-Bioti -> Müller, Margrit
        $swapMitId = array(204  => 30);

        $lehrveranstaltungTableGW = $this->histSemDBService->getLehrveranstaltungenGateway();
        $relationPersonLVTableGW = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();

        $sql = 'delete from fsw_lehrveranstaltung';
        $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_relation_personen_fsw_lehrveranstaltung';
        $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);


        $sql = "SELECT l. * , ll.olatlink, ll.vvzlink ";
        $sql .= " FROM lehrver l LEFT JOIN lehrverlinks ll ON ( l.ver_id = ll.ver_id ) ";
        $sql .= " ORDER BY l.semester DESC , l.leitung ASC ";


        $resultFSW = $this->getOldAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);

        foreach ($resultFSW as $rowLV) {


            $arrayCopy = $rowLV->getArrayCopy();
            $mit_id = $rowLV['mit_id'];


            //Es gibt einen Kurs, wo die Person, welche den Kurs leitet, nicht mit Ihrer mit_id aufgenommen worden ist
            if (array_key_exists($mit_id,$swapMitId)) {
                $mit_id = $swapMitId[$mit_id];
            }


            $sql = 'select * from mitarbeiter m where mit_id = ' . (int)$mit_id;
            $resultPerson = $this->getOldAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
            if ($resultPerson && $resultPerson->count() == 1) {


                $p = $resultPerson->current();
                $name = $p['name'];
                $splitted = preg_split('/,/', $name);

                if (count($splitted) == 2) {

                    if ($mit_id == 52) {
                        //bei einer Person (Ischer, Philipp) ist die like Abfrage nicht präzise genug
                        $sql = 'select * from Per_Personen p where p.pers_id = 325';

                    } else {

                        $sql = 'select * from Per_Personen p where p.pers_name like "%';
                        $sql .= trim($splitted[0]) . '%" && p.pers_vorname like "%' . trim($splitted[1]) . '%"' ;
                        $sql .= " && p.pers_name not like '%Duplicate%' ";
                    }


                    $resultNewPerson = $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
                    if ($resultNewPerson && $resultNewPerson->count() == 1) {
                        $nP = $resultNewPerson->current();
                        $test1 = $nP->getArrayCopy();
                        $pIDNew = $nP['pers_id'];

                        $lehrveranstaltungTableGW->insert (array(
                            'von_zeit'  =>  $rowLV['von_zeit'],
                            'bis_zeit'  =>  $rowLV['bis_zeit'],
                            'semester'  =>  $rowLV['semester'],
                            'titel'     =>  $rowLV['titel'],
                            'tag'  =>  $rowLV['tag'],
                            'vvzlink'  =>  $rowLV['vvzlink'],
                            'olatlink'  =>  $rowLV['olatlink'],
                            'beschreibung'  =>  $rowLV['txt']


                        ));

                        $latestId = $lehrveranstaltungTableGW->getLastInsertValue();

                        $relationPersonLVTableGW->insert(array(

                            'fper_personen_pers_id' =>  $pIDNew,
                            'ffsw_lehrveranstaltungen_id'   =>  $latestId


                        ));


                    } else {
                        $this->lehrveranstaltungNotFound($arrayCopy,  'pers_name: ' . $splitted[0] . ' / pers_vorname: ' . $splitted[1] . ' nicht gefunden');

                    }
                } else {
                    $this->lehrveranstaltungNotFound($arrayCopy, 'kein Komma zwischen Name und Vorname');
                }

            } else {
                $this->lehrveranstaltungNotFound($arrayCopy, 'mit_id nicht gefunden');
            }
        }
    }

    private function lehrveranstaltungNotFound($data = array(), $message)
    {

        Debug::dump($data, $message);

    }

    public function searchInEntities ($query, $limit = 15) {


        $select = new Select();
        $likeCondition = $this->getSearchFieldsLikeCondition($query);


        $targetGateway = $this->histSemDBService->getLehrveranstaltungenGateway();

        $select->from($targetGateway->getTable())
            ->order("semester")
            //->limit($limit)
            ->where($likeCondition);


        //$sql = new Sql($this->tableGateway->getAdapter(), $this->getTable());
        //$test = $sql->getSqlStringForSqlObject($select);
        //var_dump($sql->getSqlStringForSqlObject($select));

        return $targetGateway->selectWith($select);

    }

    public function getLehrveranstaltung ($id) {

        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();
        $relPersonLV = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();

        $result = $lvGateway->select(array(
            'id' => $id
        ));

        $lV=  $result->current();
        $resultPersonen = $relPersonLV->select(array(

           'ffsw_lehrveranstaltungen_id' => $lV->getId()
        ));

        $personen = array();
        foreach ($resultPersonen as $person) {
            //$lV->addPerson($person);
            $personen[] = $person;
        }
        $lV->setPersonenLehrveranstaltung($personen);

        return $lV;
    }

    public function getRelationPersonLehrveranstaltung ($postData = array()) {

        $relPersonLVGateway = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();
        $result = $relPersonLVGateway->select(array(
            'id' => $postData['id']
        ));
        $relPerson=  $result->current();
        return $relPerson;

    }

    public function getHSPersonenGateway () {

        return $this->histSemDBService->getPersonenGateway();
    }

    public function updatePersonLehrveranstaltung ($postData = array()) {

        $relPersonLVGateway = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();
        $relPersonLVGateway->update(array(
                'fper_personen_pers_id' =>  $postData['fper_personen_pers_id'],
                'ffsw_lehrveranstaltungen_id' =>  $postData['ffsw_lehrveranstaltungen_id'],
            ),
            array(
                'id' =>  $postData['id']
            ));


    }

    public function getEmptyPersonLehrveranstaltung($postData = array()) {

        $rPLV = new RelationPersonLehrveranstaltung();
        $rPLV->setFfsw_lehrveranstaltungen_id($postData['ffsw_lehrveranstaltungen_id']);
        $rPLV->setId(0);
        $rPLV->setFper_personen_pers_id("");

        return $rPLV;

    }

    public function getEmptyLehrveranstaltung()  {

        $lV = new Lehrveranstaltung();
        $lV->setId(0);

        return $lV;


    }

    public function getLehrveranstaltungOnly($id) {

        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();


        $result = $lvGateway->select(array(
            'id' => $id
        ));

        $lV=  $result->current();

        return $lV;


    }

    public function insertNewPersonLehrveranstaltung ($postData = array()) {

        $relPersonLVGateway = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();
        $relPersonLVGateway->insert(array(
            'fper_personen_pers_id' => $postData['fper_personen_pers_id'],
            'ffsw_lehrveranstaltungen_id'   =>  $postData['ffsw_lehrveranstaltungen_id']

        ))  ;

        $postData['id'] = $relPersonLVGateway->getLastInsertValue();

        return $this->getRelationPersonLehrveranstaltung($postData);


    }

    public function deletePersonRelationLV($id) {
        $relPersonLVGateway = $this->histSemDBService->getRelationPersonenLehrveranstaltungGateway();
        $relPersonLVGateway->delete(array(
           'id' => $id
        ));


    }

    public function saveLehrveranstaltung($postData = array()) {
        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();

        $lvGateway->update(
            array(
                'von_zeit'  => $postData['lehrveranstaltung']['von_zeit'],
                'bis_zeit'  =>  $postData['lehrveranstaltung']['bis_zeit'],
                'tag'  =>  $postData['lehrveranstaltung']['tag'],
                'semester'  =>  $postData['lehrveranstaltung']['semester'],
                'titel'  =>  $postData['lehrveranstaltung']['titel'],
                'vvzlink'  =>  $postData['lehrveranstaltung']['vvzlink'],
                'olatlink'  =>  $postData['lehrveranstaltung']['olatlink'],
                'beschreibung'  =>  $postData['lehrveranstaltung']['beschreibung'],
                'lvtyp'         =>  $postData['lehrveranstaltung']['lvtyp']
            ),
            array(
                'id'    =>  $postData['lehrveranstaltung']['id']
            )
        );
    }


    public function insertLehrveranstaltung($postData = array()) {

        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();

        $lvGateway->insert(
            array(
                'von_zeit'  => $postData['lehrveranstaltung']['von_zeit'],
                'bis_zeit'  =>  $postData['lehrveranstaltung']['bis_zeit'],
                'tag'  =>  $postData['lehrveranstaltung']['tag'],
                'semester'  =>  $postData['lehrveranstaltung']['semester'],
                'titel'  =>  $postData['lehrveranstaltung']['titel'],
                'vvzlink'  =>  $postData['lehrveranstaltung']['vvzlink'],
                'olatlink'  =>  $postData['lehrveranstaltung']['olatlink'],
                'beschreibung'  =>  $postData['lehrveranstaltung']['beschreibung'],
                'lvtyp'         =>  $postData['lehrveranstaltung']['lvtyp']
            )
        );

        return $lvGateway->getLastInsertValue();


    }

    public function deleteLehrveranstaltung($id) {
        $relPersonLVGateway = $this->histSemDBService->getLehrveranstaltungenGateway();
        $relPersonLVGateway->delete(array(
            'id' => $id
        ));

    }


    public function getLehrveranstaltungenArchiv() {

        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();

        $lvArchivDefinitionen = $this->getFSWConfigLocator()->get('config')->LehrveranstaltungArchiv;
        $inValues = array_keys($lvArchivDefinitionen->toArray());

        $select  = $lvGateway->getSql()->select();
        $select->where->in('semester',$inValues);
        $select->order('titel');
        $resultset =  $lvGateway->selectWith($select);

        $lehrveranstaltungen = $resultset ? $this->compileLehrveranstaltungen($resultset) : array();

        return $lehrveranstaltungen;

    }


    public function getLehrveranstaltungenAktuell() {

        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();

        $lvAktuellDefinitionen = $this->getFSWConfigLocator()->get('config')->LehrveranstaltungAktuell;
        $inValues = array_keys($lvAktuellDefinitionen->toArray());

        $select  = $lvGateway->getSql()->select();
        $select->where->in('semester',$inValues);
        $select->order('titel');

        $resultset =  $lvGateway->selectWith($select);




        $lehrveranstaltungen = $resultset ? $this->compileLehrveranstaltungen($resultset) : array();

        return $lehrveranstaltungen;

    }


    public function getLehrveranstaltungenMitarbeiter($mitId) {

        /*
        $lvGateway =  $this->histSemDBService->getLehrveranstaltungenGateway();

        $select  = $lvGateway->getSql()->select();
        $select->join(array(
            'rel_lv' => 'fsw_relation_personen_fsw_lehrveranstaltung'),
            'rel_lv.ffsw_lehrveranstaltungen_id = fsw_lehrveranstaltung.id'
        );
        $select->where(
            array(
                'rel_lv.fper_personen_pers_id' => $mitId
            )
        );

        */
        $sql = " SELECT fsw_lehrveranstaltung.* FROM fsw_lehrveranstaltung inner JOIN fsw_relation_personen_fsw_lehrveranstaltung AS rel_lv ";
        $sql .= " ON rel_lv.ffsw_lehrveranstaltungen_id = fsw_lehrveranstaltung.id WHERE rel_lv.fper_personen_pers_id = " . $mitId;
        $sql .= " order by semester DESC, titel ASC ";
        $resultset = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $lehrveranstaltungen = array();

        foreach ($resultset as $row) {

            $lv = new Lehrveranstaltung();
            $lv->exchangeArray($row->getArrayCopy());

            $lehrveranstaltungen[] = $lv;
        }


        $lehrveranstaltungen = count($lehrveranstaltungen) > 0 ? $this->compileLehrveranstaltungen($lehrveranstaltungen, $mitId) : array();

        return $lehrveranstaltungen;

    }



    private function compileLehrveranstaltungen($resultset, $excludemitid = 0) {
        //werden die Lehrveranstaltungen zu einer Person angezeigt, sollen die Angaben zu dieser Person nicht nochmals
        //mit angezeigt werden. Deshalb ein exclude
        $lehrveranstaltungen = array();

        if ($resultset) {


            //$lvPersGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();
            $sqlTemplate = 'select p.pers_name as name, p.pers_vorname as vorname, pe.profilURL as url, p.pers_id as id from fsw_lehrveranstaltung l ';
            $sqlTemplate .= ' join fsw_relation_personen_fsw_lehrveranstaltung rpl on (l.id = rpl.ffsw_lehrveranstaltungen_id) join ';
            $sqlTemplate .= 'Per_Personen p on (rpl.fper_personen_pers_id = p.pers_id) left join fsw_personen_extended pe on (p.pers_id = pe.pers_id) ';
            $sqlTemplate .= ' where  l.id = LVID order by p.pers_name, p.pers_vorname';

            foreach ($resultset as $lv) {

                $sql = preg_replace('/LVID/',$lv->getId(),$sqlTemplate );
                $rPinfo =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                foreach($rPinfo as $pinfo) {

                    if ($excludemitid == 0 || $pinfo['id'] != $excludemitid) {
                        $pi = new PersonenInfo();

                        $pi->setId($pinfo['id']);
                        $pi->setNachName($pinfo['name']);
                        $pi->setVorName($pinfo['vorname']);
                        $pi->setProfilURL($pinfo['url']);
                        $lv->addPersonenInfo($pi);

                    }
                }

                $lehrveranstaltungen[$lv->getSemester()][] = $lv;

            }

        }

        return $lehrveranstaltungen;
    }





}