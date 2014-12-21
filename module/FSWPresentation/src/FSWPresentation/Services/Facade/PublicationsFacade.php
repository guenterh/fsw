<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSWPresentation\Services\Facade;


use FSW\Model\PersonenInfo;
use FSW\Model\ZoraAuthorInfo;
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


    public function getPublications($params = array()) {



        /*
        $sql    = 'select distinct p.*, zdoc.*, zdt.*, za.*, fc.coverlink, fc.frontpage, persext.profilURL  from fsw_zora_doctype zdt,';
        $sql .= ' fsw_relation_zora_author_zora_doc r_zdza, fsw_zora_author za, fsw_personen_extended persext, ';
        $sql .= ' Per_Personen p, fsw_zora_doc zdoc LEFT JOIN fsw_cover fc on (zdoc.oai_identifier = fc.oai_identifier)';
        $sql .= ' where zdoc.oai_identifier = zdt.oai_identifier and ';
        $sql .= ' zdoc.oai_identifier = r_zdza.oai_identifier and ';
        $sql .= ' za.id =  r_zdza.fid_zora_author and ';
        $sql .= ' p.pers_id = za.pers_id and persext.id = za.fid_personen and ';
        $sql .= ' zdt.oai_recordtyp <> \'PeerReviewed\' and ';
        $sql .= ' zdt.oai_recordtyp <> \'NonPeerReviewed\' ';
        */


        $sql  = 'select distinct zdoc.*, zdt.oai_recordtyp,zdt.typform, za.zora_name, za.zora_name_customized, ';
        $sql .= ' fc.coverlink, fc.frontpage from fsw_zora_doctype zdt,';
        $sql .= ' fsw_relation_zora_author_zora_doc r_zdza, fsw_zora_author za, ';
        $sql .= ' fsw_zora_doc zdoc LEFT JOIN fsw_cover fc on (zdoc.oai_identifier = fc.oai_identifier)';
        $sql .= ' where zdoc.oai_identifier = zdt.oai_identifier and ';
        $sql .= ' zdoc.id = r_zdza.fid_zora_doc and ';
        $sql .= ' za.id =  r_zdza.fid_zora_author and ';
        $sql .= ' zdt.oai_recordtyp <> \'PeerReviewed\' and ';
        $sql .= ' zdt.oai_recordtyp <> \'NonPeerReviewed\' ';



        $condition = isset($params['conditions']) ? $params['conditions'] : "";
        $restrictions = $this->getRestrictionForType($condition);


        $zoraDocs = array();

        foreach ($restrictions as $key => $value) {
            $tsql = $sql . ' and ' . $value;

            if (isset($params['mitid'])) {

                $tsql .= ' and za.pers_id = ' . $this->qV($params['mitid']);
            }

            //$tsql .= " group by zdoc.oai_identifier ORDER BY zdt.oai_recordtyp, zdoc.year desc, zdoc.author asc, zdoc.title asc";
            $tsql .= " group by zdoc.oai_identifier ORDER BY zdoc.year desc, zdoc.author asc, zdoc.title asc";




            $result =  $this->getAdapter()->query($tsql,Adapter::QUERY_MODE_EXECUTE);

            foreach ($result as $row) {
                $z = new ZoraRecord();
                $z->setRawOAIRecord($row['xmlrecord'],$row['oai_identifier'],$row['status'],$row['datestamp']);
                $z->renderRecord();
                $z->setCoverLink($row['coverlink']);
                $z->addZoraAuthorInfo($this->getPersonInfosForPublication($row['id']));
                $zoraDocs[$key][$row['oai_identifier']] = $z;
            }

        }

        return $zoraDocs;

    }


    /**
     * @param $zoraDocId
     * @return array
     */
    private function getPersonInfosForPublication($zoraDocId) {

        $sql = "select za.id, za.zora_name,za.zora_name_customized, persext.profilURL from fsw_relation_zora_author_zora_doc relAuthDoc join  fsw_zora_author za ";
        $sql .= " on (relAuthDoc.fid_zora_author = za.id) join fsw_personen_extended persext on (za.fid_personen = persext.id) ";
        $sql .= " where relAuthDoc.fid_zora_doc = " . $this->qV($zoraDocId);

        $result = $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);


        $zaInfo = array();
        foreach ($result as $row){
            $info = new ZoraAuthorInfo();
            $info->exchangeArray($row->getArrayCopy());
            $zaInfo[$info->getZoraName()] = $info;
        }

        return $zaInfo;

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


    private function getRestrictionForType ($condition)
    {



        switch ($condition) {
            case 'buchpublikationen':
                $restrictions = array('Monographien' => "r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'Monograph'",
                    'Herausgeberschaften' => " r_zdza.zora_rolle = 'CONTRIBUTOR' and zdt.oai_recordtyp = 'edited scientific work'");


                break;
            case 'buchtest':
                $restrictions = array('Aufsätze in Sammelbänden' =>  " mitarbeiterOAI.rolle = 'CREATOR' and typOAI.oairecordtyp = 'book section'");


                break;
            case 'noCover':
                //wofür brauchen wir das
                $restrictions = array('Aufsätze in Sammelbänden' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'book section'",
                    'Zeitschriftenaufsätze' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'journal article'",
                    'Dissertationen' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'dissertation'",
                    'Habilitationen' => " r_zdza.zora_rolle = 'CONTRIBUTOR' and zdt.oai_recordtyp = 'habilitation'");


                break;
            case 'booksection':
                $restrictions = array('Aufsätze in Sammelbänden' =>  " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'book section'");
                break;
            case 'journalarticle':
                $restrictions = array('Zeitschriftenaufsätze' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'journal article'",
                    'Elektronische Publikationen' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'Scientific Publication in Electronic Form'");
                break;
            default:
                //sequence defined by Manuela:
                //1) Monograhie -> Monograph
                //2) Herausgeberschaften -> edited scientific work
                //3) Sammelschriften -> Booksections
                //4) Zeitschriftenaufsätze -> journal article
                //5 -6) not defined so far
                $restrictions = array('Monographien' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'Monograph'",
                    'Herausgeberschaften' => " r_zdza.zora_rolle = 'CONTRIBUTOR' and zdt.oai_recordtyp = 'edited scientific work'",
                    'Aufsätze in Sammelbänden' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'book section'",
                    'Zeitschriftenaufsätze' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'journal article'",
                    'Dissertationen' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'dissertation'",
                    'Habilitationen' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'habilitation'",
                    'Elektronische Publikationen' => " r_zdza.zora_rolle = 'CREATOR' and zdt.oai_recordtyp = 'Scientific Publication in Electronic Form'");


                break;
        }

        return $restrictions;


    }

    private function getPersonenInfoWithPersId($id)
    {

        $info = null;

        $sql = 'select p.pers_name as nachName, p.pers_vorname as vorName, p.pers_id as id, pext.profilURL ';
        $sql .= 'from Per_Personen as p left join fsw_personen_extended as pext on (p.pers_id = pext.pers_id) ';
        $sql .= 'join Per_Rolle as r on (p.pers_id = r.roll_pers_id) ';
        $sql .= 'where r.roll_id = ' . $id;

        $result = $this->getAdapter()->query($sql, Adapter::QUERY_MODE_EXECUTE);
        $row = $result->current();
        if ($row) {
            $info = new PersonenInfo();
            $info->exchangeArray($row->getArrayCopy());

        }
        return $info;
    }




}