<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;



class PublicationsFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */


    protected $searchFields = array(
        'pers_name',
        'pers_vorname',
    );

    public function __construct()
    {

    }


    public function getPublications($type = 'all') {

        $zoraDocTableGateway = $this->histSemDBService->getZoraDocGateway();

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
    }

    public function fetchAll()
    {
    }



}