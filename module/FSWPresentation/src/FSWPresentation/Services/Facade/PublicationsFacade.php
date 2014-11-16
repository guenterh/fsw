<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSWPresentation\Services\Facade;


use FSW\Model\ZoraRecord;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use FSW\Services\Facade\BaseFacade;



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

        $sql = 'select distinct p.*, zdoc.*, zdt.*, za.*, fc.coverlink, fc.frontpage  from fsw_zora_doctype zdt,';
        $sql .= ' fsw_relation_zora_author_zora_doc r_zdza, fsw_zora_author za,';
        $sql .= ' Per_Personen p, fsw_zora_doc zdoc LEFT JOIN fsw_cover fc on (zdoc.oai_identifier = fc.oai_identifier)';
        $sql .= ' where zdoc.oai_identifier = zdt.oai_identifier and ';
        $sql .= ' zdoc.oai_identifier = r_zdza.oai_identifier and ';
        $sql .= ' za.id =  r_zdza.fid_zora_author and ';
        $sql .= ' p.pers_id = za.pers_id and ';
        $sql .= 'zdt.oai_recordtyp <> \'PeerReviewed\' and ';
        $sql .= 'zdt.oai_recordtyp <> \'NonPeerReviewed\' ';



        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $zoraDocs  = array();

        foreach ($result as $row) {
            $r = $row->getArrayCopy();

            $z = new ZoraRecord();
            $z->setRawOAIRecord($r['xmlrecord'],$r['oai_identifier'],$r['status'],$r['datestamp']);

            $z->renderRecord();

            $zoraDocs[$r['oai_identifier']] = $z;


        }


        return $zoraDocs;

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