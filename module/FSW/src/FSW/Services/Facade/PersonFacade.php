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





}