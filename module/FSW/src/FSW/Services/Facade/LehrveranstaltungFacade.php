<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;


use FSW\Model\BaseModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

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

            $sql = 'select * from mitarbeiter m where mit_id = ' . (int)$mit_id;
            $resultPerson = $this->getOldAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
            if ($resultPerson && $resultPerson->count() == 1) {


                $p = $resultPerson->current();
                $name = $p['name'];
                $splitted = preg_split('/,/', $name);

                if (count($splitted) == 2) {
                    $sql = 'select * from Per_Personen p where p.pers_name like "%';
                    $sql .= trim($splitted[0]) . '%" && p.pers_vorname like "%' . trim($splitted[1]) . '%"';

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
                            'olatlink'  =>  $rowLV['olatlink']


                        ));

                        $latestId = $lehrveranstaltungTableGW->getLastInsertValue();

                        $relationPersonLVTableGW->insert(array(

                            'fper_personen_pers_id' =>  $pIDNew,
                            'ffsw_lehrveranstaltungen_id'   =>  $latestId


                        ));


                    } else {
                        $this->lehrveranstaltungNotFound($arrayCopy);

                    }
                } else {
                    $this->lehrveranstaltungNotFound($arrayCopy);
                }

            } else {
                $this->lehrveranstaltungNotFound($arrayCopy);
            }
        }
    }

    private function lehrveranstaltungNotFound($data = array())
    {

        Debug::dump($data, 'lehrveranstaltung nicht gefunden');

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

           'id' => $lV->getId()
        ));

        $personen = array();

        foreach ($resultPersonen as $person) {

            //$lV->addPerson($person);
            $personen[] = $person;

        }
        $lV->setPersonenLehrveranstaltung($personen);


        return $lV;


    }


}