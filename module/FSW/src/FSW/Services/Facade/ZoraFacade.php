<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 15:10
 */

namespace FSW\Services\Facade;


use FSW\Model\BaseModel;
use Zend\Db\TableGateway\TableGateway;



class ZoraFacade extends BaseFacade {


    protected $tableGatewaZoraDoc;
    protected $tableGatewaZoraAuthor;
    protected $tableGatewaZoraDocType;
    protected $tableGatewaCover;


    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */
    public function __construct(TableGateway $tableGatewayZoraDoc,
                                TableGateway $tableGatewayZoraAuthor,
                                TableGateway $tablegatewayZoraDocType,
                                TableGateway $tablegatewayCover)
    {

        $this->tableGatewaCover = $tablegatewayCover;
        $this->tableGatewaZoraAuthor = $tableGatewayZoraAuthor;
        $this->tableGatewaZoraDoc = $tableGatewayZoraDoc;
        $this->tableGatewaZoraDocType = $tablegatewayZoraDocType;

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
        // TODO: Implement find() method.
    }
}