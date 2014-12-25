<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: Oct 30, 2010
 * Time: 3:46:28 PM
 * To change this template use File | Settings | File Templates.
 */

namespace FSW\Model;

 
class ZoraRecord  {

    private $identifier = null;
    private $contributor = array();
    private $creator = array();
    private $date;
    private $type = array();
    private $subtype = array();
    private $datestamp = null;
    private $recxml = null;
    private $title = null;
    private $sqlOrderCriteria = null;

    //1 = normalRecord
    //2 = deleted
    private $recordStatus = "normal";



    //for presentation
    private $identifierLink = null;
    private $subject = array();
    private $description = null;
    private $publisher = null;
    private $originallyPublished = null;
    private $journalTitle= null;
    private $swissbibISBN = null;
    private $format = null;
    private $relationZora = null;
    private $relationExtern = null;
    private $pagerange = null;
    private $institution = null;
    private $fulltext = null;
    private $booktitle = null;
    private $place_of_pub = null;
    private $language = null;
    private $referee = array();
    private $faculty = null;
    private $source = null;
    private $customcreators = null ;
    private $customcontributors = null;
    private $coverLink = null;

    private $year = null;

    private $zoraAuthorInfo = array();



    private $rawXMLPrepared;
    private $rawXML;


    public static $personCharactertoReplace = array("/ä/i","/ü/i","/ö/i","/'/i","/è/i","/é/i","/à/i");
    public static $personCharacterReplacemets = array("","","","","","","");


    //public function getItemType() {
    //    return 1;
    //}


    public function setRawOAIDeletedRecord($rawrecord, $id,$status,$datestamp) {

        $this->setRecXML($rawrecord);
        $this->setRecordStatus($status);
        $this->setIdentifier($id);
        $this->setDatestamp($datestamp);

    }


    public function setRawOAIRecord ($rawrecord, $id,$status,$datestamp ) {

        //$this->rawXML = $rawrecord;
        $this->setRecXML($rawrecord);

        $sxml= new \SimpleXMLElement($rawrecord);
        $namespaces = null;
        $namespaces = $sxml->getDocNamespaces(true);


        /* ich pruefe dies beim Einfügen des Satzes in die Datenbank
        könnte man wohl auch noch schöner machen. Refactring der Abhängigkeiten erforderlich
        if (! $this->testToInclude()) {
            throw new \Exception("now FSW record");
        }
        */

        $this->setRecordStatus($status);
        $this->setIdentifier($id);
        $this->setDatestamp($datestamp);

        $creators = array();
        $contributors = array();

        //es scheint wihtig zu sein, foreach so zu benutzen
        //$dcElements = $sxml->children($namespaces['dc']);
        //-> das geht nicht
        //foreach($dcElements  as $dcTag => $dcValue)
        //-> php bekommt ein Problem mit multiplen tags...
        //s. auch Hinweise zur Benutzung: http://www.sitepoint.com/parsing-xml-with-simplexml/


        foreach($sxml->children($namespaces['dc'])  as $dcTag => $dcValue)
        {

            //nur fur die Wirtschaftshistoriker, s. alte Implementierung
            //if ($restrictedAuthors && !$this->checkIfAuthorInclude($zR)) {
            //    continue;
            //author shouldn't be included
            //}

            switch ($dcTag){
                case "contributor":
                    $this->setContributor($dcValue);
                    $contributors[] = $dcValue;

                    break;
                case "date":
                    $this->setDate($dcValue);
                    break;
                case "type":

                    $this->setType($dcValue);
                    break;
                case "subtype":
                    $this->setSubtype($dcValue);
                    break;
                case "creator":
                    $this->setCreator($dcValue);
                    $creators[] = $dcValue;

                    break;
                case "title":

                    //echo $vdc;
                    $this->setTitle($dcValue);
                    break;

                default:
                    break;

            }

            continue;

        }
        $customizedCreators = preg_replace(ZoraRecord::$personCharactertoReplace,ZoraRecord::$personCharacterReplacemets,$creators);
        $customizedContributors = preg_replace(ZoraRecord::$personCharactertoReplace,ZoraRecord::$personCharacterReplacemets,$contributors);

        $sxml->addChild('dc:customizedCreators',implode('##',$customizedCreators),"http://purl.org/dc/elements/1.1/");
        $sxml->addChild('dc:customizedcontributors',implode('##',$customizedContributors),"http://purl.org/dc/elements/1.1/");

    }

    public function setTitle($title){
        
        //$this->title = preg_replace("/'/","\'",$title );
        $this->title = $title ;
        //echo $this->title . "\n";

    }

    public function setIdentifier($identifier) {
        //$this->identifier = preg_replace("/'/","\'",$identifier );
        $this->identifier = $identifier ;
    }

    public function setCreator($creator) {
        //$this->creator[] = preg_replace("/'/","\'",$creator );
        $this->creator[] = $creator ;
    }

    public function setContributor($contributor) {
        //$this->contributor[] = preg_replace("/'/","\'",$contributor );
        $this->contributor[] = $contributor ;
    }

    public function setDate($date) {

        //es kann sein, dass im Zora kein Jahr sondern ein dateformat yyyy-mm-dd hinterlegt ist
        //in diesem Fall ziehen wir das Jahr heraus und hinterlegen es separat.

        $dateString  = (string) $date;
        $yearString = null;

        if (strlen($dateString) > 4) {

            try {
                $timestamp = strtotime($date);
                $yearString = strftime("%G", $timestamp);
            } catch (\Exception $ex) {
                //im Falle einer Exception auf 0 setzen, da in der Datenbank int definiert ist
                $yearString = 0;

            }
        } else {
            $yearString = $dateString;
        }


        $this->date = $dateString;
        $this->year = $yearString;

    }

    public function setType($type) {
        //$this->type[] = preg_replace("/'/","\'",$type );
        $this->type[] = $type ;
    }

    public function setSubtype($subtype) {
        //$this->subtype[] = preg_replace("/'/","\'",$subtype );
        $this->subtype[] = $subtype ;
    }


    public function setDatestamp($datestamp) {
        //$this->datestamp = preg_replace("/'/","\'",$datestamp );
        $this->datestamp = $datestamp ;
    }

    public function setRecXML($recxml) {
        //$this->recxml = preg_replace("/'/","\'",$recxml );
        $this->recxml = $recxml ;
    }


    public function setRecordStatus($recType) {
        $this->recordStatus = $recType;
    }



    public function getIdentifier() {
        return $this->identifier;
    }

    public function getCreator() {
        //todo: make flat array
        return $this->creator;
    }

    public function getFirstCreator() {
        //todo: make flat array
        return  count($this->creator) > 0 ? $this->creator[0] : null;
    }

    public function getContributor() {
        return $this->contributor;
    }

    public function getFirstContributor() {
        //todo: make flat array
        return  count($this->contributor) > 0 ? $this->contributor[0] : null;
    }

    public function getDate() {
        return $this->date;
    }

    public function getType() {
        return $this->type;
    }

    public function getSubtype() {
        return $this->subtype;
    }


    public function getDatestamp() {
        return $this->datestamp;
    }

    public function getRecXML() {
        return $this->recxml;
    }


    public function getRecordStatus() {
        return $this->recordStatus;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setSqlOrderCriteria($sqlOrderCriteria)
    {
        $this->sqlOrderCriteria = (string)$sqlOrderCriteria;
    }

    public function getSqlOrderCriteria()
    {
        return $this->sqlOrderCriteria;
    }


    private function testToInclude() {

        //todo: check if the record belongs to FSW (see old code)
        return true;
    }

    public function getAllCreators() {

        $creatorsConcatenated = "";
        array_map(function ($element) use (&$creatorsConcatenated) {

            $creatorsConcatenated .= $element . "###";

        }, $this->creator);

        return substr($creatorsConcatenated,0,strlen($creatorsConcatenated) -3 );

    }

    public function getAllContributors () {

        $contributorsConcatenated = "";
        array_map(function ($element) use (&$contributorsConcatenated) {

            $contributorsConcatenated .= $element . "###";

        }, $this->contributor);

        return substr($contributorsConcatenated,0,strlen($contributorsConcatenated) -3 );

    }

    public function getCoverLink() {

        return $this->coverLink;
    }

    public function setCoverLink($coverlink) {

        $this->coverLink = $coverlink;
    }

    /**
     * @return null
     */
    public function getFulltext()
    {
        return $this->fulltext;
    }

    /**
     * @return null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return null
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return null
     */
    public function getIdentifierLink()
    {
        return $this->identifierLink;
    }

    /**
     * @return null
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @return null
     */
    public function getJournalTitle()
    {
        return $this->journalTitle;
    }

    /**
     * @return null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return null
     */
    public function getOriginallyPublished()
    {
        return $this->originallyPublished;
    }

    /**
     * @return null
     */
    public function getPagerange()
    {
        return $this->pagerange;
    }

    /**
     * @return null
     */
    public function getPlaceOfPub()
    {
        return $this->place_of_pub;
    }

    /**
     * @return null
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @return array
     */
    public function getReferee()
    {
        return $this->referee;
    }

    /**
     * @return null
     */
    public function getYear()
    {
        return $this->year;
    }




    /**
     * @return null
     */
    public function getRelationExtern()
    {
        return $this->relationExtern;
    }

    /**
     * @return null
     */
    public function getRelationZora()
    {
        return $this->relationZora;
    }

    /**
     * @return null
     */
    public function getSource()
    {
        $pattern = null;
        $replacement = null;


        $tosearch = array("(",")","?",":","[","]","/");
        $toreplace = array("\(","\)","\?","\:","\[","\]","\/");

        //(ZH, Zell/Rikon)  -> sucht ansonsten nach einer Option R die es nicht gibt


        try {

            $pattern = '/(' . str_replace($tosearch,$toreplace,trim($this->title)) .   ')/';
            $replacement = '<span class="titleZora">${1}</span>';

            $this->source =   preg_replace($pattern,$replacement,$this->source);

        } catch (Exception $e) {
            $test = "";
        }

        //preg_match("/\.(?[^.]+)\./",$this->source,$matches);


        foreach ($this->getCreator() as $creator) {

            $creator = (string) $creator;
            if (array_key_exists( $creator, $this->zoraAuthorInfo)) {


                if (! is_null($this->zoraAuthorInfo[$creator]->getProfilURL()) &&
                    strlen($this->zoraAuthorInfo[$creator]->getProfilURL()) > 0)
                {
                    $profilURL =  $this->zoraAuthorInfo[$creator]->getProfilURL();

                    $temp = strpos($this->source,$creator);
                    $firstPart = substr($this->source,0,$temp);

                    $lastPart =  substr($this->source,$temp + strlen($creator));

                    //im link wird dieser extra Prameter eingetragen und ein neues Fenster zu oeffnen (der Parameter selber kann bleiben, schadet nicht)
                    if (strpos($profilURL,"&extern=true")) {
                        $shorterLink = substr($profilURL,0,strpos($profilURL,"&extern=true"));
                        $combine = $firstPart . '<a  title="Teaser Link" class="www" href="' . $shorterLink . '" target="_blank" >'  . $creator  .   "</a>" . $lastPart;
                    } else {
                        $combine = $firstPart . "<a class='uzh displayParent' href='" . $profilURL . "' >"  . $creator  .   "</a>" . $lastPart;
                    }


                    $this->source = $combine;

                }


            }

        }


        foreach ($this->getContributor() as $contributor) {

            $contributor = (string) $contributor;

            if (array_key_exists($contributor, $this->zoraAuthorInfo)) {

                if (! is_null($this->zoraAuthorInfo[$contributor]->getProfilURL()) &&
                    strlen($this->zoraAuthorInfo[$contributor]->getProfilURL()) > 0)
                {
                    $profilURL =  $this->zoraAuthorInfo[$contributor]->getProfilURL();

                    $temp = strpos($this->source,$contributor);
                    $firstPart = substr($this->source,0,$temp);

                    $lastPart =  substr($this->source,$temp + strlen($contributor));

                    //im link wird dieser extra Prameter eingetragen und ein neues Fenster zu oeffnen (der Parameter selber kann bleiben, schadet nicht)
                    if (strpos($profilURL,"&extern=true")) {
                        $shorterLink = substr($profilURL,0,strpos($profilURL,"&extern=true"));
                        $combine = $firstPart . '<a  title="Teaser Link" class="www" href="' . $shorterLink . '" target="_blank" >'  . $contributor  .   "</a>" . $lastPart;
                    } else {
                        $combine = $firstPart . "<a class='uzh displayParent' href='" . $profilURL . "' >"  . $contributor  .   "</a>" . $lastPart;
                    }


                    $this->source = $combine;

                }
            }
        }

        return $this->source;



    }

    /**
     * @return array
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return null
     */
    public function getSwissbibISBN()
    {
        return $this->swissbibISBN;
    }



    public function renderRecord(){


        $journal_article = false;
        $isbn = false;





        $this->identifierLink = "http://www.zora.uzh.ch/cgi/oai2?verb=GetRecord&identifier=" . $this->identifier . "&metadataPrefix=oai_dc";


        //$result = $this->simpleXMLElement->xpath("//dc:creator");
        //while(list( , $node) = each($result)) {
        //    $this->creators[] = (string)$node;
        //}

        //if (count($this->creators) > 0) {
        //    $this->creators = FSWUtils::getMAFirstInListWithFullname($this->mitID, $this->creators);
        //}


        //$result = $this->recxml->xpath("//dc:contributor");
        //while(list( , $node) = each($result)) {
        //    $this->contributors[] = (string)$node;
        //}

        //if (count($this->contributors) > 0) {
        //    $this->contributors = FSWUtils::getMAFirstInListWithFullname($this->mitID, $this->contributors);
        //}

        $sxml= new \SimpleXMLElement($this->recxml);


        $result = $sxml->xpath("//dc:subject");
        while(list( , $node) = each($result)) {
            $this->subject[] = (string)$node;
        }

        $result = $sxml->xpath("//dc:description");
        if (count($result)  > 0 ) $this->description = (string)$result[0];

        $result = $sxml->xpath("//dc:date");
        if (count($result)  > 0) $this->date = (string)$result[0];


        $result = $sxml->xpath("//dc:publisher");
        if (count($result)  > 0)    $this->publisher = (string)$result[0];


        $result = $sxml->xpath("//dc:type");
        while(list( , $node) = each($result)) {
            $this->type[] = (string)$node;
            switch ((string)$node) {
                case "Journal Article":
                    $journal_article = true;
                    break;
                case "Edited Scientific Work":
                case "Monograph":
                case "Book Section":
                    $isbn = true;
                    break;


            }
        }


        //mit neuer Zoraversion (voraussichtlich) weggefallen -> kann spaeter entfernt werden
        $result = $sxml->xpath("//dc:originallypublishedat");
        if (count($result)  > 0) {
            $this->originallyPublished = (string)$result[0];
            if ($journal_article) {
                $analyzedString = (string)$result[0];

                //example
                //http://www.zora.uzh.ch/cgi/oai2?verb=GetRecord&identifier=oai:www.zora.uzh.ch:44541&metadataPrefix=oai_dc
                //Tanner, J (2010). "Das Grosse im Kleinen": Rudolf Braun als Innovator der Geschichtswissenschaft. Historische Anthropologie, 18(1):140-156.

                $myint = preg_match("/\.\W(?P<TITLE>[^.]+):[^:]*$/",$analyzedString,$matches);
                $this->journalTitle = $matches["TITLE"];


            } elseif ($isbn){
                //two different alternatives are possible
                //3-518-12368-8
                //978-0-521-11271-0

                $analyzedString = (string)$result[0];
                //Tanner, J (2009). Offenheit und Spezialisierung: ein Weg in den Wohlstand. In: Hebeisen, E. Geschichte Schweiz: Katalog der Dauerausstellung im Landesmuseum Zürich. Zürich, 171-174. ISBN 978-3-905875-04-1.
                //ISBN 978-3-905875-04-1
                $matches = array();
                //echo $analyzedString;
                //$myint = preg_match("/ISBN (\d{3}-\d{1}-\d{3,6}-\d{2,5}-\d{1})/",$analyzedString,$matches);
                $myint = preg_match("/ISBN ([-\d]*) {0,1}\./",$analyzedString,$matches);
                if (count($matches) == 2) {
                    $isbnHyphen = $matches[1];
                    $isbnNoHypen = preg_replace("/-/","",$isbnHyphen);
                    //http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=0540=%22978-3-8273-2482-5%22
                    $this->swissbibISBN = "http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=0540=%22" . $isbnNoHypen . "%22";
                } //else {
                //  $matches = array();
                //$myint = preg_match("/ISBN (\d{1}-\d{3}-\d{3,6}-\d{1})/",$analyzedString,$matches);
                //$myint = preg_match("/ISBN ([-\d]*)\./",$analyzedString,$matches);
                //  if (count($matches) == 2) {
                //      $isbnHyphen = $matches[1];
                //      $isbnNoHypen = preg_replace("/-/","",$isbnHyphen);
                //http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=0540=%22978-3-8273-2482-5%22
                //      $this->swissbibISBN = "http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=0540=%22" . $isbnNoHypen . "%22";
                //  }
                //}

                //evtl. noch eine Suche nach Booktitle

            }
        }


        $result = $sxml->xpath("//dc:format");
        if (count($result)  > 0) $this->format = (string)$result[0];


        $result = $sxml->xpath("//dc:relation");
        while(list( , $node) = each($result)) {
            //relation werden wohl immer auf die eigentliche Zoraadresse gesetzt
            //gelegentlich aber auch auf externe Adressen
            //<dc:relation>http://www.zora.uzh.ch/1/</dc:relation>
            // <dc:relation>http://www.biomedcentral.com/content/pdf/1472-6963-7-7.pdf</dc:relation>
            $tMatches = array();

            preg_match("/www\.zora\.uzh\.ch/",(string)$node,$tMatches);
            if (count($tMatches) > 0) {
                $this->relationZora = (string)$node;
            } else {
                $this->relationExtern = (string)$node;
            }


        }


        $result = $sxml->xpath("//dc:status");
        if (count($result)  > 0) $this->recordStatus = (string)$result[0];


        //mit neuer Zoraversion weggefallen -> kann spaeter entfernt werden
        $result = $sxml->xpath("//dc:pagerange");
        if (count($result)  > 0) $this->pagerange = (string)$result[0];

        $result = $sxml->xpath("//dc:institution");
        if (count($result)  > 0) $this->institution = (string)$result[0];

        //mit neuer Zoraversion (voraussichtlich) weggefallen -> kann spaeter entfernt werden
        $result = $sxml->xpath("//dc:subtype");
        while(list( , $node) = each($result)) {
            $this->subtype[] = (string)$node;
        }

        //dc:idetifier is used for different puposes
        //a) complete citation mark
        //b) link to the 'fulltext' of the resource (implemented at the moment only for pdf - which oher formats are used??
        //
        $result = $sxml->xpath("//dc:identifier");
        while(list( , $node) = each($result)) {

            $tMatches = array();
            preg_match("/\.pdf$/",(string)$node,$tMatches);
            if (count($tMatches) > 0) {
                $this->fulltext = (string)$node;
            }


            //<dc:identifier>urn:isbn:978-3-7965-1910-9</dc:identifier>

            preg_match("/:isbn:([-\d]*)$/",(string)$node,$tMatches);
            if (count($tMatches) == 2) {
                $isbnHyphen = $tMatches[1];
                $isbnNoHypen = preg_replace("/-/","",$isbnHyphen);
                //http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=0540=%22978-3-8273-2482-5%22
                //$this->swissbibISBN = "http://www.swissbib.ch/TouchPoint/start.do?Language=de&View=nose&Query=20=%22" . $isbnNoHypen . "%22";
                $this->swissbibISBN = "https://www.swissbib.ch/Search/Results?lookfor=" . $isbnNoHypen;
            }


        }

        //mit neuer Zoraversion (voraussichtlich) weggefallen -> kann spaeter entfernt werden
        $result = $sxml->xpath("//dc:book_title");
        if (count($result)  > 0) $this->booktitle = (string)$result[0];

        $result = $sxml->xpath("//dc:place_of_pub");
        if (count($result)  > 0) $this->place_of_pub = (string)$result[0];


        $result = $sxml->xpath("//dc:language");
        if (count($result)  > 0) $this->language = (string)$result[0];


        $result = $sxml->xpath("//dc:referee");
        while(list( , $node) = each($result)) {
            $this->referee[] = ((string)$node);
        }


        $result = $sxml->xpath("//dc:faculty");
        if (count($result)  > 0) $this->faculty = (string)$result[0];

        $result = $sxml->xpath("//dc:source");
        if (count($result)  > 0) $this->source = (string)$result[0];

        $result = $sxml->xpath("//dc:customizedCreators");

        if (count($result)  > 0 && strlen((string)$result[0]) > 0) {
            $this->customcreators = explode("##",(string)$result[0]);
        }


        $result = $sxml->xpath("//dc:customizedcontributors");

        if (count($result)  > 0 && strlen((string)$result[0]) > 0) {
            $this->customcontributors = explode("##",(string)$result[0]);
        }

    }

    public function addZoraAuthorInfo (array $authorInfo)
    {

        $this->zoraAuthorInfo = array_merge($this->zoraAuthorInfo, $authorInfo);

    }


}
