<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use Zend\Db\TableGateway\TableGateway;



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





}