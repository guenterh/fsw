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



class KolloquienFacade extends BaseFacade {


    protected $searchFields = array(
        'gespraechstitel',
        'sendetitel',
    );

    public function getKolloquien() {

        $kolloquienTableGateway =  $this->histSemDBService->getKolloquienGateway();
        $resultset =  $kolloquienTableGateway->select();
        return $resultset;

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

    public function getKolloquim($id)
    {
        $id  = (int) $id;
        $kolloquienTableGateway =  $this->histSemDBService->getKolloquienGateway();
        $rowset = $kolloquienTableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }





    public function insertKolloquienFSW () {

        $sql = 'delete from fsw_kolloquium';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $sql = 'delete from fsw_kolloquium_veranstaltung';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        //es fehlt
        //254 FSW (Siegenthaler)
        //in medien (old) gibt es einen Eintrag mit der id 11 für die es keinen Mitarbeiter gibt





        $sql = 'select * from kolloquium';

        $result =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['idkolloquium']) || empty ($r['idkolloquium'])) {
                continue;
            }

            $sql = "insert into fsw_kolloquium (id_kolloquium, titel) ";
            $sql = $sql . ' values ('  . $this->qV($r['idkolloquium']) . ',' ;
            $sql = $sql .  $this->qV($r['titel']) . ')';

            $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            $sql = 'select * from kolloquium_veranstaltung where idkolloquium = ' . $this->qV($r['idkolloquium']);

            $resultVeranstaltungen =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            foreach ($resultVeranstaltungen as $rowV) {

                $rV = $rowV->getArrayCopy();

                $sql = "insert into fsw_kolloquium_veranstaltung (id_kolloquium, beschreibung, datum, personenname) ";
                $sql = $sql . ' values ('  . $this->qV($r['idkolloquium']) . ',' ;
                $sql = $sql .  $this->qV($rV['beschreibung']) . ',';
                $sql = $sql .  $this->qV($rV['datum']) . ',';
                $sql = $sql .  $this->qV($rV['personenname']) . ')';

                $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
            }


        }
    }


}