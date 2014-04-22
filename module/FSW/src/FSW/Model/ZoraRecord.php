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

    private $rawXMLPrepared;
    private $rawXML;


    public static $personCharactertoReplace = array("/ä/i","/ü/i","/ö/i","/'/i","/è/i","/é/i","/à/i");
    public static $personCharacterReplacemets = array("","","","","","","");


    //public function getItemType() {
    //    return 1;
    //}


    public function setRawOAIRecord ($rawrecord, $id,$status,$datestamp ) {

        //$this->rawXML = $rawrecord;
        $this->setRecXML($rawrecord);

        $sxml= new \SimpleXMLElement($rawrecord);
        $namespaces = null;
        $namespaces = $sxml->getDocNamespaces(true);



        if (! $this->testToInclude()) {
            throw new \Exception("now FSW record");
        }

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

        $tempDate = (string)$date;
        $monthDate = explode("-",$tempDate);
        if (count($monthDate) > 1) {
            $tempDate = $monthDate[0];
        }
        if (!ctype_digit($tempDate)) {
            //todo make conversion
            $date = 2010;
        }
        $this->date = $date;
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

}
