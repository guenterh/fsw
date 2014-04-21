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


    protected $tableGatewayZoraDoc;
    protected $tableGatewayZoraAuthor;
    protected $tableGatewayZoraDocType;
    protected $tableGatewayCover;
    protected $sm;
    protected $adapter;


    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */
    public function __construct(TableGateway $tableGatewayZoraDoc,
                                TableGateway $tableGatewayZoraAuthor,
                                TableGateway $tablegatewayZoraDocType,
                                TableGateway $tablegatewayCover,
                                ServiceManager $sm,
                                Adapter $adapter)
    {

        $this->tableGatewayCover = $tablegatewayCover;
        $this->tableGatewayZoraAuthor = $tableGatewayZoraAuthor;
        $this->tableGatewayZoraDoc = $tableGatewayZoraDoc;
        $this->tableGatewayZoraDocType = $tablegatewayZoraDocType;
        $this->sm = $sm;
        $this->adapter = $adapter;

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

        $zR = $this->prepareZR();

        //$connection = $this->adapter->getDriver()->getConnection();
        //$connection->beginTransaction();
        //do some jobs - e.g : multiple tables update or insert.
        //$connection->commit();
        //$connection->rollback();
        //$connection->getLastGeneratedValue();



        if ($this->isFSWZoraAuthor($zR)) {

            $sqlTemplate = ' insert into fsw_zora_doc  (author, datestamp, oai_identifier,status,title,xmlrecord,year) ';
            $sqlTemplate .= ' values (AUTHOR, DATESTAMP,OAI_IDENTIFIER,STATUS,TITLE,XMLFRAGMENT,YEAR)';
            $sqlTemplate = preg_replace('/AUTHOR/',$this->qV($this->getDBCreator($zR)),$sqlTemplate );
            $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
            $sqlTemplate = preg_replace('/DATESTAMP/',$this->qV($zR->getDatestamp()),$sqlTemplate );
            $sqlTemplate = preg_replace('/YEAR/',$this->qV($zR->getDate()),$sqlTemplate );
            $sqlTemplate = preg_replace('/TITLE/',$this->qV($zR->getTitle()),$sqlTemplate );
            $sqlTemplate = preg_replace('/STATUS/',$this->qV($zR->getRecordStatus()),$sqlTemplate );
            $sqlTemplate = preg_replace('/XMLFRAGMENT/', $this->qV($zR->getRecXML()),$sqlTemplate );

            $this->adapter->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);

            $genIdZoraDoc = $this->adapter->getDriver()->getLastGeneratedValue();


            foreach ($zR->getCreator() as $creator) {


                if ( count($creatorAttribibutes = $this->isFSWZoraAuthor($creator)) > 0 ) {


                    $sqlTemplate = 'insert into fsw_relation_zora_author_zora_doc (fid_zora_author,fid_zora_doc,';
                    $sqlTemplate .= 'oai_identifier,zora_name,zora_rolle)';
                    $sqlTemplate .= 'values (FID_ZORA_AUTHOR, FID_ZORA_DOC,OAI_IDENTIFIER,ZORA_NAME,ZORA_ROLLE)';
                    $sqlTemplate = preg_replace('/FID_ZORA_AUTHOR/',$this->qV($creatorAttribibutes['id']),$sqlTemplate );
                    $sqlTemplate = preg_replace('/FID_ZORA_DOC/',$this->qV($genIdZoraDoc),$sqlTemplate );
                    $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
                    $sqlTemplate = preg_replace('/ZORA_NAME/',$this->qV($creator),$sqlTemplate );
                    $sqlTemplate = preg_replace('/ZORA_ROLLE/',$this->qV("CREATOR"),$sqlTemplate );
                    $this->adapter->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);


                }
            }
            foreach ($zR->getContributor() as $contributor) {


                if ( count($creatorAttribibutes = $this->isFSWZoraAuthor($contributor)) > 0 ) {


                    $sqlTemplate = 'insert into fsw_relation_zora_author_zora_doc (fid_zora_author,fid_zora_doc,';
                    $sqlTemplate .= 'oai_identifier,zora_name,zora_rolle)';
                    $sqlTemplate .= 'values (FID_ZORA_AUTHOR, FID_ZORA_DOC,OAI_IDENTIFIER,ZORA_NAME,ZORA_ROLLE)';
                    $sqlTemplate = preg_replace('/FID_ZORA_AUTHOR/',$this->qV($creatorAttribibutes['id']),$sqlTemplate );
                    $sqlTemplate = preg_replace('/FID_ZORA_DOC/',$this->qV($genIdZoraDoc),$sqlTemplate );
                    $sqlTemplate = preg_replace('/OAI_IDENTIFIER/',$this->qV($zR->getIdentifier()),$sqlTemplate );
                    $sqlTemplate = preg_replace('/ZORA_NAME/',$this->qV($contributor),$sqlTemplate );
                    $sqlTemplate = preg_replace('/ZORA_ROLLE/',$this->qV("CONTRIBUTOR"),$sqlTemplate );
                    $this->adapter->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
                }
            }

            foreach ($zR->getType() as $type) {
                $sqlTemplate = 'insert into fsw_zora_doctype (oai_identifier, oai_recordtyp, typform) ';
                $sqlTemplate .= ' values (OAI_IDENTIFIER, OAIRECORDTYP,TYPFORM)';
                $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace("/OAIRECORDTYP/",$this->qV($type),$sqlTemplate );
                $sqlTemplate = preg_replace("/TYPFORM/",$this->qV("typ") ,$sqlTemplate);

                $this->adapter->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
            }

            foreach ($zR->getSubtype() as $subtype) {
                $sqlTemplate = 'insert into fsw_zora_doctype (oai_identifier, oai_recordtyp, typform) ';
                $sqlTemplate .=  ' values (OAI_IDENTIFIER, OAIRECORDTYP,TYPFORM)';
                $sqlTemplate = preg_replace("/OAI_IDENTIFIER/",$this->qV($zR->getIdentifier()),$sqlTemplate );
                $sqlTemplate = preg_replace("/OAIRECORDTYP/",$this->qV($subtype),$sqlTemplate );
                $sqlTemplate = preg_replace("/TYPFORM/",$this->qV("subtyp") ,$sqlTemplate);

                $this->adapter->query($sqlTemplate,Adapter::QUERY_MODE_EXECUTE);
            }

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


    public function isFSWZoraAuthor ($object) {

        $isZoraAuthor = null;

        if ($object instanceof ZoraRecord) {

            foreach ($object->getCreator() as $creator) {
                $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($creator);
                $result = $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
                if (count($result > 0)) {
                    $isZoraAuthor = true;
                    break;
                }
            }

            if (is_null($isZoraAuthor)) {
                foreach ($object->getContributor() as $contributor) {
                    $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($contributor);
                    $result = $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
                    if (count($result > 0)) {
                        $isZoraAuthor = true;
                        return $isZoraAuthor;
                    }
                }
            }
        } else {
            $sql = 'SELECT * from fsw_zora_author where zora_name = ' . $this->qV($object);
            $result = $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
            $isZoraAuthor = array();
            foreach ($result as $row) {
                $r = $row->getArrayCopy();
                $isZoraAuthor['id'] = $r['id'];
                $isZoraAuthor['zora_name'] = $r['zora_name'];
            }

        }


        return $isZoraAuthor;
    }


    /**
     * @param $value
     * @return string
     * Each value inserted into DB has to be quoted and escaped
     * for the target storage (in our case MySQL)
     */
    private function qV ($value) {

        return $this->adapter->getPlatform()->quoteValue($value);

    }


    /**
     * @param ZoraRecord $zR
     * @return string
     * look for the first creator / contributor  who belongs to FSW
     * this person is used for sort operations
     */
    private function getDBCreator (ZoraRecord $zR) {


        foreach ($zR->getCreator() as $creator) {

            if ($this->isFSWZoraAuthor($creator)) {
                return $creator;
            }
        }

        foreach ($zR->getContributor() as $contributor) {
            if ($this->isFSWZoraAuthor($contributor)) {
                return $contributor;
            }
        }

        return '';

    }


    public function insertIntoFSWExtended() {


        $sql = 'select * from Per_Personen;';

        $result =  $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['pers_name']) || empty ($r['pers_name'])) {
                continue;
            }

            $sql = 'select * from FSWmitarbeiter m ' ;
            $sql = $sql . ' where  m.name like "%' . $r['pers_name'] . '%" and m.name like "%' . $r['pers_vorname'] . '%";';
            $resultFSW =  $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

            foreach ($resultFSW as $rowFSW) {

                $f = $rowFSW->getArrayCopy();
                $sql = "insert into fsw_personen_extended (pers_id,fullname,profilURL) ";
                $sql = $sql .  "values (" . $this->qV($r['pers_id']) . ',';
                $sql = $sql .  $this->qV($r['pers_name'] . ', ' . $r['pers_vorname']) . ',';
                $sql = $sql .  $this->qV($f['profilURL']) . ' )';

                $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
                $genIdPersonenExtended = $this->adapter->getDriver()->getLastGeneratedValue();


                $sql = 'select * from FSWmitarbeiterZoraName mz where mz.mit_id = ' . $rowFSW['mit_id'];
                $resultZoraName =  $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

                foreach ($resultZoraName as $zN) {
                    $z = $zN->getArrayCopy();

                    $sql = "insert into fsw_zora_author (fid_personen,pers_id,zora_name,zora_name_customized) ";
                    $sql = $sql .  "values (" . $this->qV($genIdPersonenExtended) . ',';
                    $sql = $sql .  $this->qV($r['pers_id']) . ',';
                    $sql = $sql .  $this->qV($z['zoraName']) . ',';
                    $sql = $sql .  $this->qV($z['zoraNameCustomized']) . ' )';

                    $this->adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);

                }

            }

        }


    }


}