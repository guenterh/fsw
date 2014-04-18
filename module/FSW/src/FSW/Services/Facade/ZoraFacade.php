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
use Zend\ServiceManager\ServiceManager;



class ZoraFacade extends BaseFacade {


    protected $tableGatewayZoraDoc;
    protected $tableGatewayZoraAuthor;
    protected $tableGatewayZoraDocType;
    protected $tableGatewayCover;
    protected $sm;


    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */
    public function __construct(TableGateway $tableGatewayZoraDoc,
                                TableGateway $tableGatewayZoraAuthor,
                                TableGateway $tablegatewayZoraDocType,
                                TableGateway $tablegatewayCover,
                                ServiceManager $sm)
    {

        $this->tableGatewayCover = $tablegatewayCover;
        $this->tableGatewayZoraAuthor = $tableGatewayZoraAuthor;
        $this->tableGatewayZoraDoc = $tableGatewayZoraDoc;
        $this->tableGatewayZoraDocType = $tablegatewayZoraDocType;
        $this->sm = $sm;

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

    public function getOAIClient($options = array()) {

        $oaiClient = $this->sm->get('oaiClient');

        $oaiClient->getEventManager()->attach('processOAIItem',array($this,'processOAIItem'));

        return $oaiClient;



    }


    public function processOAIItem($args) {


        $t = "";

    }

}