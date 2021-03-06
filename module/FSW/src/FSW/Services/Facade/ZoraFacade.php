<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 15:10
 */

namespace FSW\Services\Facade;


use FSW\Model\BaseModel;
use FSW\Model\ZoraRecord;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\Adapter\Adapter;



class ZoraFacade extends BaseFacade {


    //protected $tableGatewayZoraDoc;
    //protected $tableGatewayZoraAuthor;
    //protected $tableGatewayZoraDocType;
    //protected $tableGatewayCover;
    protected $sm;
    //protected $adapter;
    protected $messages = array();

    private $searchOldCovers = false;


    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */
    public function __construct(ServiceManager $sm)
    {

        //$this->tableGatewayCover = $tablegatewayCover;
        //$this->tableGatewayZoraAuthor = $tableGatewayZoraAuthor;
        //$this->tableGatewayZoraDoc = $tableGatewayZoraDoc;
        //$this->tableGatewayZoraDocType = $tablegatewayZoraDocType;
        $this->sm = $sm;
        //$this->adapter =  $this->histSemDBService->getAdapter();

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

        //$zR = $this->prepareZR();

        $zR = $args->getParam('oaiR');

        if ($zR  instanceof ZoraRecord) {
            //$connection = $this->adapter->getDriver()->getConnection();
            //$connection->beginTransaction();
            //do some jobs - e.g : multiple tables update or insert.
            //$connection->commit();
            //$connection->rollback();
            //$connection->getLastGeneratedValue();



            if (strtoupper($zR->getRecordStatus()) === "DELETED") {
                $this->deleteValuesFromZoraTables($zR->getIdentifier());
                $message = "<b>" . $zR->getIdentifier() . "</b>" . " was sent as deleted and was deleted in the database ";
                $this->messages[] = $message;
                return;

            }

            if ($this->isOneAuthorFSWRelated($zR)) {

                if ($this->isRecordInDB($zR->getIdentifier())) {

                    if ($this->isRecordInDBandUpdated($zR->getIdentifier(),$zR->getDatestamp())) {
                        $this->deleteValuesFromZoraTables($zR->getIdentifier());

                        $this->insertValuesIntoZoraTables($zR);
                        $message = "<b>" . $zR->getIdentifier() . "</b>" . " was <b>updated</b> because datestamp has changed";
                        $this->messages[] = $message;

                    } else {
                        $message = "<b>" . $zR->getIdentifier() . "</b>" . " was not updated because datestamp hasn't changed";
                        $this->messages[] = $message;

                    }

                } else {
                    $this->insertValuesIntoZoraTables($zR, 'new inserted');
                    $message = "<b>" . $zR->getIdentifier() . "</b>" . " was <b>inserted</b> because wasn't in database before";
                    $this->messages[] = $message;

                }
            } else {
                $message = $zR->getIdentifier() . ': none of the persons (creators: ' . $zR->getAllCreators() . ' or contributors: '  . $zR->getAllContributors() . ' are in FSW DB -> nothing was done';
                $this->messages[] = $message;
            }
        } else {
            $message = 'sent record wasn\'t an instance of ZoraRecord: ' . $args['oaiR'];
            $this->messages[] = $message;;
        }

    }

    private function prepareZR() {


        $xml = <<< EOD
<oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
        <dc:title>The ää àà ä öö economics \\ //of primary 'prevention' of "cardiovascular disease" - A systematic review of economic evaluations</dc:title>
        <dc:creator>Schwüüppachppach, D L B</dc:creator>
        <dc:creator>Tanner, Jakob</dc:creator>
        <dc:contributor>Schwager, Nicole</dc:contributor>
        <dc:creator>Suhrcke, M</dc:creator>
        <dc:subject>Swiss Research Institute for Public Health \\ // ??and Addiction</dc:subject>
        <dc:subject>610 Medicine &amp; health</dc:subject>
        <dc:description>BACKGROUND: In the quest for public and private resources, prevention continues to face a difficult challenge in obtaining tangible public and political support. This may be partly because the economic evidence in favour of prevention is often said to be largely missing. The overall aim of this paper is to examine whether economic evidence in favour of prevention does exist, and if so, what its main characteristics, weaknesses and strengths are. We concentrate on the evidence regarding primary prevention that targets cardiovascular disease event or risk reduction. METHODS: We conducted a systematic literature review of journal articles published during the period 1995-2005, based on a comprehensive key-word based search in generic and specialized electronic databases, accompanied by manual searches of expert databases. The search strategy consisted of combinations of freetext and keywords related to economic evaluation, cardiovascular diseases, and primary preventive interventions of risk assessment or modification. RESULTS: A total of 195 studies fulfilled all of the relevant inclusion criteria. Overall, a significant amount of relevant economic evidence in favour of prevention does exist, despite important remaining gaps. The majority of studies were cost-effectiveness-analyses, expressing benefits as "life years gained", were conducted in a US or UK setting, assessed clinical prevention, mainly drugs targeted at lowering lipid levels, and referred to subjects aged 35-64 years old with at least one risk factor. CONCLUSIONS: First, this review has demonstrated the obvious lack of economic evaluations of broader health promotion interventions, when compared to clinical prevention. Second, the clear role for government to engage more actively in the economic evaluation of prevention has become very obvious, namely, to fill the gap left by private industry in terms of the evaluation of broader public health interventions and regarding clinical prevention, in light of the documented relationship between study funding and reporting of favourable results. Third, the value of greater adherence to established guidelines on economic evaluation cannot be emphasised enough. Finally, there appear to be certain methodological features in the practice of health economic evaluations that might bias the choice between prevention and cure in favour of the latter.</dc:description>
        <dc:publisher>BioMed Central</dc:publisher>
        <dc:date>2007</dc:date>
        <dc:type>Journal Article</dc:type>
        <dc:type>PeerReviewed</dc:type>
        <dc:format>application/pdf</dc:format>
        <dc:identifier>http://dx.doi.org/10.5167/uzh-2</dc:identifier>
        <dc:source>Schwappach, D L B; Boluarte, T A; Suhrcke, M (2007). The economics of primary prevention of cardiovascular disease - A systematic review of economic evaluations. Cost Effectiveness and Resource Allocation : C/E, 5:5.</dc:source>
        <dcterms:bibliographicCitation>Cost Effectiveness and Resource Allocation : C/E, 5:5.</dcterms:bibliographicCitation>
        <dc:language>eng</dc:language>
        <dc:identifier>info:doi/10.1186/1478-7547-5-5</dc:identifier>
        <dc:identifier>info:pmid/17501999</dc:identifier>
        <dc:rights>info:eu-repo/semantics/openAccess</dc:rights>
        <dc:relation>http://www.zora.uzh.ch/2/</dc:relation></oai_dc:dc>


EOD;

        $datestamp = '2014-04-03T12:57:43Z';
        $id = 'oai:www.zora.uzh.ch:2';
        $status = 'updated';

        $zR = new \FSW\Model\ZoraRecord();
        $zR->setRawOAIRecord($xml,$id,$status,$datestamp);

        return $zR;



    }


    public function isFSWZoraAuthor ($zoraDocPublishedYear, $zoraAuthorName) {

        $isZoraAuthor = array();
        //todo: hier noch prüfen ob überhaupt Zora Author vom daterange!
        $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($zoraAuthorName);
        $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        if (count($result) == 1) {
            $row = $result->current();
            $inRange = $this->checkAuthorsDateRange($zoraDocPublishedYear, $row['year_from'],$row['year_until']);
            if ($inRange) {

                $isZoraAuthor['id'] = $row['id'];
                $isZoraAuthor['zora_name'] = $row['zora_name'];
            }
        }


        return $isZoraAuthor;
    }


    public function isOneAuthorFSWRelated (ZoraRecord $object) {

        $isZoraAuthor = false;


        foreach ($object->getCreator() as $creator) {
            $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($creator);
            $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
            if (count($result) == 1) {
                $row = $result->current();
                $inRange = $this->checkAuthorsDateRange($object->getYear(), $row['year_from'],$row['year_until']);
                if ($inRange) {
                    $isZoraAuthor = true;
                    break;
                }
            }
        }

        if (! $isZoraAuthor) {
            foreach ($object->getContributor() as $contributor) {
                $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($contributor);
                $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                if (count($result) == 1) {

                    $row = $result->current();
                    $inRange = $this->checkAuthorsDateRange($object->getYear(), $row['year_from'],$row['year_until']);
                    if ($inRange) {
                        $isZoraAuthor = true;
                        break;
                    }


                }
            }
        }
        return $isZoraAuthor;
    }


    private function checkAuthorsDateRange($yearRecord, $yearFromAuthor, $yearUntilAuthor)
    {
        $inRange = true;

        //sometimes it is a SimpleXMLElement (should be treated in ZoraRecord - not now...)
        $tempYearRecord = (string) $yearRecord;
        if (strcmp($yearFromAuthor,'0') != 0)
        {
            //es wurde ein from-Datum gesetzt
            if (((int) $yearRecord) < ((int) $yearFromAuthor)) {
                return false;
            }

        }
        if (strcmp($yearUntilAuthor,'0') != 0)
        {
            //es wurde ein from-Datum gesetzt
            if (((int) $yearRecord) > ((int) $yearUntilAuthor)) {
                return false;
            }

        }

        return $inRange;
    }


    /**
     * @param $value
     * @return string
     * Each value inserted into DB has to be quoted and escaped
     * for the target storage (in our case MySQL)
     */

    /* neu in BaseFacade
    private function qV ($value) {

        return $this->getAdapter()->getPlatform()->quoteValue($value);

    }
    */


    /**
     * @param ZoraRecord $zR
     * @return string
     * look for the first creator / contributor  who belongs to FSW
     * this person is used for sort operations
     */
    private function getDBCreator (ZoraRecord $zR) {



        $docYearPublished = $zR->getYear();
        foreach ($zR->getCreator() as $creator) {

            if ($this->isFSWZoraAuthor($docYearPublished, $creator)) {
                return $creator;
            }
        }

        foreach ($zR->getContributor() as $contributor) {
            if ($this->isFSWZoraAuthor($docYearPublished, $contributor)) {
                return $contributor;
            }
        }

        return '';

    }

    private function isRecordInDB($oai_identifier) {

        $sql = 'select * from fsw_zora_doc where oai_identifier = ' . $this->qV($oai_identifier);

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $contained = count($result) > 0;
        return $contained;
    }

    private function isRecordInDBandUpdated($oai_identifier, $datestamp) {

        $sql = 'select * from fsw_zora_doc where oai_identifier = ' . $this->qV($oai_identifier);
        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $updated = true;

        if (count($result) == 1) {
            $row = $result->current();
            $updated = strcmp($row["datestamp"],$datestamp) != 0 ? true : false;
        }

        return $updated;

    }





    private function insertValuesIntoZoraTables($zR, $recordStatus = 'updated') {



        $sqlTemplate = ' insert into fsw_zora_doc  (author, datestamp, oai_identifier,status,title,xmlrecord,year,date) ';
        $sqlTemplate .= ' values (AUTHOR, DATESTAMP,OAI_IDENTIFIER,STATUS,TITLE,XMLFRAGMENT,YEAR,DATE)';
        $sqlTemplate = preg_replace('/AUTHOR/',$this->qV($this->getDBCreator($zR)),$sqlTemplate );
        $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
        $sqlTemplate = preg_replace('/DATESTAMP/',$this->qV($zR->getDatestamp()),$sqlTemplate );
        $sqlTemplate = preg_replace('/YEAR/',$this->qV($zR->getYear()),$sqlTemplate );
        $sqlTemplate = preg_replace('/DATE/',$this->qV($zR->getDate()),$sqlTemplate );
        $sqlTemplate = preg_replace('/TITLE/',$this->qV($zR->getTitle()),$sqlTemplate );
        $sqlTemplate = preg_replace('/STATUS/',$this->qV($recordStatus),$sqlTemplate );
        $sqlTemplate = preg_replace('/XMLFRAGMENT/', $this->qV($zR->getRecXML()),$sqlTemplate );

        $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);

        $genIdZoraDoc = $this->getAdapter()->getDriver()->getLastGeneratedValue();


        $docYearPublished = $zR->getYear();
        foreach ($zR->getCreator() as $creator) {

            $creatorAttributes = $this->isFSWZoraAuthor($docYearPublished, $creator);

            if ( count($creatorAttributes) > 0 ) {


                $sqlTemplate = 'insert into fsw_relation_zora_author_zora_doc (fid_zora_author,fid_zora_doc,';
                $sqlTemplate .= 'oai_identifier,zora_name,zora_rolle)';
                $sqlTemplate .= 'values (FID_ZORA_AUTHOR, FID_ZORA_DOC,OAI_IDENTIFIER,ZORA_NAME,ZORA_ROLLE)';
                $sqlTemplate = preg_replace('/FID_ZORA_AUTHOR/',$this->qV($creatorAttributes['id']),$sqlTemplate );
                $sqlTemplate = preg_replace('/FID_ZORA_DOC/',$this->qV($genIdZoraDoc),$sqlTemplate );
                $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace('/ZORA_NAME/',$this->qV($creator),$sqlTemplate );
                $sqlTemplate = preg_replace('/ZORA_ROLLE/',$this->qV("CREATOR"),$sqlTemplate );
                $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);


            }
        }
        foreach ($zR->getContributor() as $contributor) {

            $contributorAttributes = $this->isFSWZoraAuthor($docYearPublished,$contributor);

            if ( count($contributorAttributes) > 0 ) {


                $sqlTemplate = 'insert into fsw_relation_zora_author_zora_doc (fid_zora_author,fid_zora_doc,';
                $sqlTemplate .= 'oai_identifier,zora_name,zora_rolle)';
                $sqlTemplate .= 'values (FID_ZORA_AUTHOR, FID_ZORA_DOC,OAI_IDENTIFIER,ZORA_NAME,ZORA_ROLLE)';
                $sqlTemplate = preg_replace('/FID_ZORA_AUTHOR/',$this->qV($contributorAttributes['id']),$sqlTemplate );
                $sqlTemplate = preg_replace('/FID_ZORA_DOC/',$this->qV($genIdZoraDoc),$sqlTemplate );
                $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace('/ZORA_NAME/',$this->qV($contributor),$sqlTemplate );
                $sqlTemplate = preg_replace('/ZORA_ROLLE/',$this->qV("CONTRIBUTOR"),$sqlTemplate );
                $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
            }
        }

        foreach ($zR->getType() as $type) {
            $sqlTemplate = 'insert into fsw_zora_doctype (oai_identifier, oai_recordtyp, typform) ';
            $sqlTemplate .= ' values (OAI_IDENTIFIER, OAIRECORDTYP,TYPFORM)';
            $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
            $sqlTemplate = preg_replace("/OAIRECORDTYP/",$this->qV($type),$sqlTemplate );
            $sqlTemplate = preg_replace("/TYPFORM/",$this->qV("typ") ,$sqlTemplate);

            $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
        }

        foreach ($zR->getSubtype() as $subtype) {
            $sqlTemplate = 'insert into fsw_zora_doctype (oai_identifier, oai_recordtyp, typform) ';
            $sqlTemplate .=  ' values (OAI_IDENTIFIER, OAIRECORDTYP,TYPFORM)';
            $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
            $sqlTemplate = preg_replace("/OAIRECORDTYP/",$this->qV($subtype),$sqlTemplate );
            $sqlTemplate = preg_replace("/TYPFORM/",$this->qV("subtyp") ,$sqlTemplate);

            $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
        }



        //todo: das nur verwenden beim initialen Laden
        //muss fuer den normalen Betrieb noch angepasst werden
        if (! $this->isRecordInFSWCover($zR->getIdentifier())) {

            $cover = $this->isRecordInFSWCoverOldDB($zR->getIdentifier());
            if  (isset ($cover)) {

                $sqlTemplate = 'insert into fsw_cover (oai_identifier,frontpage,coverlink)';
                $sqlTemplate .= ' values (OAI_IDENTIFIER, FRONTPAGE, COVERLINK)';
                $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace("/FRONTPAGE/",$this->qV("nofrontpage"),$sqlTemplate );
                $sqlTemplate = preg_replace("/COVERLINK/",$this->qV($cover),$sqlTemplate );

                $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);

            } else {
                $sqlTemplate = 'insert into fsw_cover (oai_identifier,frontpage)';
                $sqlTemplate .= ' values (OAI_IDENTIFIER, FRONTPAGE)';
                $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace("/FRONTPAGE/",$this->qV("nofrontpage"),$sqlTemplate );

                $this->getAdapter()->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);

            }

        }

    }

    private function deleteValuesFromZoraTables($oai_identifier, $deleteAll = false) {

        $sql = 'delete from fsw_zora_doc where oai_identifier = ' . $this->qV ($oai_identifier) ;
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_zora_doctype where oai_identifier = ' . $this->qV ($oai_identifier);
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_relation_zora_author_zora_doc where oai_identifier = ' . $this->qV ($oai_identifier);
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        if ($deleteAll) {
            $sql = 'delete from fsw_cover where oai_identifier = ' . $this->qV ($oai_identifier);
            $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        }

    }

    private function isRecordInFSWCover($oai_identifier) {

        $sql = 'select * from fsw_cover where oai_identifier = ' . $this->qV ($oai_identifier) ;
        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        return count($result) > 0 ? true : false;
    }


    private function isRecordInFSWCoverOldDB($oai_identifier) {

        if (!$this->searchOldCovers) {
            return null;
        }

        $sql = 'select * from fswcoverlink where identifier = ' . $this->qV ($oai_identifier) ;
        $result =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        if (count($result) > 0) {
            $current =  $result->current();
            return $current['coverlink'];

        } else {
            return null;
        }



    }

    public function getMessages() {

        return $this->messages;

    }


    public function getDBAdapter ()
    {
        //fragwürdig...
        return $this->getAdapter();
    }

    /**
     * @param boolean $searchOldCovers
     */
    public function setSearchOldCovers($searchOldCovers)
    {
        $this->searchOldCovers = $searchOldCovers;
    }








}