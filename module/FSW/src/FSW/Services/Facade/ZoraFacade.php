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

        $zR = $this->prepareZR();

        $names = null;

        $tDBCreator = null;

        foreach ($zR->getCreator() as $creator) {
            $tcreator = $this->analyzeEncoding($creator);
            if ($tDBCreator == null && $this->isFSWMA($tcreator) ) {
                $tDBCreator = $tcreator;
            }

            //echo mb_detect_encoding($creator) . "\n";

            $insertTemplate = "insert into " . FSWConfig::$table_mitarbeiter_oai . " (zoraName, oaiIdentifier, rolle)
                        values ('ZORANAME', 'IDENTIFIER','ROLLE')";
            $insertTemplate = preg_replace("/IDENTIFIER/",$zR->getIdentifier(),$insertTemplate );
            $insertTemplate = preg_replace("/ZORANAME/",$tcreator,$insertTemplate );
            $insertTemplate = preg_replace("/ROLLE/","CREATOR" ,$insertTemplate);
            if (!mysql_query($insertTemplate,$this->dbConnection)) {
                die(mysql_error($this->dbConnection));
            }
        }


    }

    private function prepareZR() {


        $xml = <<< EOD
<oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
        <dc:title>The economics of primary prevention of cardiovascular disease - A systematic review of economic evaluations</dc:title>
        <dc:creator>Schwappach, D L B</dc:creator>
        <dc:creator>Boluarte, T A</dc:creator>
        <dc:creator>Suhrcke, M</dc:creator>
        <dc:subject>Swiss Research Institute for Public Health and Addiction</dc:subject>
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

    private function analyzeEncoding($toAnalyze){

        $eencoding = false;

        $eencoding = strcmp(mb_detect_encoding($toAnalyze) ,"UTF-8") ==  0 ? true:false;
        $tcreator = null;

        if ($eencoding) {
            $tcreator = utf8_decode($toAnalyze);
        }
        else {
            $tcreator = $toAnalyze;
        }

        return $tcreator;

    }

    public function isFSWMA ($maName) {

        /*
        $istMA = false;
        $sql = "SELECT * from mitarbeiterZoraName where  zoraName = '" . $maName . "'";
        $handler = mysql_query($sql,$this->dbConnection);
        if (!$handler) {
            echo mysql_error($this->dbConnection);
        } else {
            $num_rows = mysql_num_rows($handler);
            if( $num_rows <> 0) {
                $istMA = true;
            }
        }
        return $istMA;
        */
        return true;
    }

}