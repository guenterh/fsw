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



class PersonFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */

    protected $tableGatewayPersExtended;
    protected $tableGatewayZoraAuthor;

    protected $searchFields = array(
        'pers_name',
        'pers_vorname',
    );

    public function __construct(TableGateway $tableGatewayPersCore,
                                TableGateway $tableGatewayPersExtended,
                                TableGateway $tableGatewayZoraAuthor)
    {
        $this->tableGateway = $tableGatewayPersCore;
        $this->tableGatewayPersExtended = $tableGatewayPersExtended;
        $this->tableGatewayZoraAuthor = $tableGatewayZoraAuthor;

    }



    /**
     * Find elements
     *
     * @param    String $searchString
     * @param    Integer $limit
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30)
    {
        //$test = $this->getAll(null,$limit);
        $test = $this->findFulltext($searchString,'pers_name',500);

        return $test;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }


    public function getPerson($persID) {



        $persCore =  $this->runSelect(array('pers_id' => (int) $persID));

        if (!$persCore) {
            throw new \Exception("Could not find any person with id:  $persID");
        } else  {
            $persExtended = $this->runSelect(array('pers_id' => (int)$persID), $this->tableGatewayPersExtended);

            if ($persExtended) {

                //sollen die extended Attribute des FSW als collection angezeigt werden
                //(duch die collection erscheinen bei Personen die nicht zur FSW gehören keine Eingabeelemente)
                //muss die gefundene Struktur als array übergeben werden. Ansonsten gibt es ein Problem beim Binden des Modells an die Form
                //dies passiert im Controller, der die Form dann der View übergibt
                $persCore->setPersonExtended(array($persExtended));
                $id = (int) $persExtended->getId();
                //$rowExtendedZora = $this->tableGatewayZoraAuthor->select(array('fid_personen' => $id))->current();
                $persExtendedZoraAuthorNames = $this->runSelect(array('fid_personen' => $id), $this->tableGatewayZoraAuthor,false);

                $zoraAuthorNames = array();
                foreach ($persExtendedZoraAuthorNames as  $zoraAuthor) {
                    $zoraAuthorNames[$zoraAuthor->getId()] = $zoraAuthor;
                }

                $persCore->setZoraAuthors($zoraAuthorNames);

            }
        }
        return $persCore;

    }


    public function insertIntoFSWExtended() {

        $sql = 'delete from fsw_personen_extended';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_zora_author';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        //zuerst: loesche die bereits bestehenden



        $sql = 'select * from Per_Personen';

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['pers_name']) || empty ($r['pers_name'])) {
                continue;
            }

            $sql = 'select * from mitarbeiter m ' ;
            $sql = $sql . ' where  m.name like "%' . $r['pers_name'] . '%" and m.name like "%' . $r['pers_vorname'] . '%";';
            $resultFSW =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            foreach ($resultFSW as $rowFSW) {

                $f = $rowFSW->getArrayCopy();
                $sql = "insert into fsw_personen_extended (pers_id,fullname,profilURL) ";
                $sql = $sql .  "values (" . $this->qV($r['pers_id']) . ',';
                $sql = $sql .  $this->qV($r['pers_name'] . ', ' . $r['pers_vorname']) . ',';
                $sql = $sql .  $this->qV($f['profilURL']) . ' )';

                $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                $genIdPersonenExtended = $this->getAdapter()->getDriver()->getLastGeneratedValue();


                $sql = 'select * from mitarbeiterZoraName mz where mz.mit_id = ' . $rowFSW['mit_id'];
                $resultZoraName =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                foreach ($resultZoraName as $zN) {
                    $z = $zN->getArrayCopy();

                    $sql = "insert into fsw_zora_author (fid_personen,pers_id,zora_name,zora_name_customized) ";
                    $sql = $sql .  "values (" . $this->qV($genIdPersonenExtended) . ',';
                    $sql = $sql .  $this->qV($r['pers_id']) . ',';
                    $sql = $sql .  $this->qV($z['zoraName']) . ',';
                    $sql = $sql .  $this->qV($z['zoraNameCustomized']) . ' )';

                    $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                }
            }
        }
    }



}