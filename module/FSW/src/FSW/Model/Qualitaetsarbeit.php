<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 4:54 PM
 */

namespace FSW\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Qualitaetsarbeit extends BaseModel {




    protected $qarb_arb_abschlussjahr;
    protected $qarb_arb_abstract;
    protected $qarb_arb_autor_rollid;
    protected $qarb_arb_autor2_rollid;
    protected $qarb_arb_autorid;
    protected $qarb_arb_autorid_rollid;
    protected $qarb_arb_bemerkungen;
    protected $qarb_arb_betreuer1;
    protected $qarb_arb_betreuer1_rollid;
    protected $qarb_arb_betreuer2;
    protected $qarb_arb_betreuer2_rollid;
    protected $qarb_arb_changed;
    protected $qarb_arb_changedby;
    protected $qarb_arb_changedip;
    protected $qarb_arb_FDB;
    protected $qarb_arb_DOI;
    protected $qarb_arb_id;
    protected $qarb_arb_imwebsichtbar;
    protected $qarb_arb_ISBN;
    protected $qarb_arb_ISSN;
    protected $qarb_arb_istabgeschlossen;
    protected $qarb_arb_rollid;
    protected $qarb_arb_semester;
    protected $qarb_arb_titel;
    protected $qarb_arb_typ;
    protected $qarb_arb_URL;
    protected $qarb_arb_ZORA;
    protected $pers_name;
    protected $pers_vorname;
    protected $pers_id;
    protected $profilURL;


    protected $autorInfo2 = null;

    protected $betreuerInfo = array();







    /**
     * Get record ID
     *
     * @return    Integer
     */
    public function getId()
    {
        return $this->qarb_arb_id;
    }

    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        return $this->qarb_arb_titel;
    }

    /**
     * @return mixed
     */
    public function getPersId()
    {
        return $this->pers_id;
    }

    /**
     * @param mixed $pers_id
     */
    public function setPersId($pers_id)
    {
        $this->pers_id = $pers_id;
    }

    /**
     * @return mixed
     */
    public function getPersName()
    {
        return $this->pers_name;
    }

    /**
     * @param mixed $pers_name
     */
    public function setPersName($pers_name)
    {
        $this->pers_name = $pers_name;
    }

    /**
     * @return mixed
     */
    public function getPersVorname()
    {
        return $this->pers_vorname;
    }

    /**
     * @param mixed $pers_vorname
     */
    public function setPersVorname($pers_vorname)
    {
        $this->pers_vorname = $pers_vorname;
    }

    /**
     * @return mixed
     */
    public function getProfilURL()
    {
        $url = preg_replace("/&?extern=true/","",$this->profilURL);
        return $url;
    }

    /**
     * @return mixed
     */
    public function isSetProfilURL()
    {
        return !is_null($this->profilURL) && strlen($this->profilURL) > 0 ? true : false;
    }


    /**
     * @param mixed $profilURL
     */
    public function setProfilURL($profilURL)
    {
        $this->profilURL = $profilURL;
    }

    /**
     * @return mixed
     */
    public function getQarbArbDOI()
    {
        return $this->qarb_arb_DOI;
    }

    /**
     * @param mixed $qarb_arb_DOI
     */
    public function setQarbArbDOI($qarb_arb_DOI)
    {
        $this->qarb_arb_DOI = $qarb_arb_DOI;
    }

    /**
     * @return mixed
     */
    public function getQarbArbFDB()
    {
        return $this->qarb_arb_FDB;
    }

    /**
     * @param mixed $qarb_arb_FDB
     */
    public function setQarbArbFDB($qarb_arb_FDB)
    {
        $this->qarb_arb_FDB = $qarb_arb_FDB;
    }

    /**
     * @return mixed
     */
    public function getQarbArbISBN()
    {
        return $this->qarb_arb_ISBN;
    }

    /**
     * @param mixed $qarb_arb_ISBN
     */
    public function setQarbArbISBN($qarb_arb_ISBN)
    {
        $this->qarb_arb_ISBN = $qarb_arb_ISBN;
    }

    /**
     * @return mixed
     */
    public function getQarbArbISSN()
    {
        return $this->qarb_arb_ISSN;
    }

    /**
     * @param mixed $qarb_arb_ISSN
     */
    public function setQarbArbISSN($qarb_arb_ISSN)
    {
        $this->qarb_arb_ISSN = $qarb_arb_ISSN;
    }

    /**
     * @return mixed
     */
    public function getQarbArbURL()
    {
        return $this->qarb_arb_URL;
    }

    /**
     * @param mixed $qarb_arb_URL
     */
    public function setQarbArbURL($qarb_arb_URL)
    {
        $this->qarb_arb_URL = $qarb_arb_URL;
    }

    /**
     * @return mixed
     */
    public function getQarbArbZORA()
    {
        return $this->qarb_arb_ZORA;
    }

    /**
     * @param mixed $qarb_arb_ZORA
     */
    public function setQarbArbZORA($qarb_arb_ZORA)
    {
        $this->qarb_arb_ZORA = $qarb_arb_ZORA;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAbschlussjahr()
    {
        return $this->qarb_arb_abschlussjahr;
    }

    /**
     * @param mixed $qarb_arb_abschlussjahr
     */
    public function setQarbArbAbschlussjahr($qarb_arb_abschlussjahr)
    {
        $this->qarb_arb_abschlussjahr = $qarb_arb_abschlussjahr;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAbstract()
    {
        return $this->qarb_arb_abstract;
    }

    public function isSetAbstract()
    {
        return !is_null($this->qarb_arb_abstract) && strlen($this->qarb_arb_abstract) > 0 ? true : false;
    }


    /**
     * @param mixed $qarb_arb_abstract
     */
    public function setQarbArbAbstract($qarb_arb_abstract)
    {
        $this->qarb_arb_abstract = $qarb_arb_abstract;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAutor2Rollid()
    {
        return $this->qarb_arb_autor2_rollid;
    }

    /**
     * @param mixed $qarb_arb_autor2_rollid
     */
    public function setQarbArbAutor2Rollid($qarb_arb_autor2_rollid)
    {
        $this->qarb_arb_autor2_rollid = $qarb_arb_autor2_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAutorRollid()
    {
        return $this->qarb_arb_autor_rollid;
    }

    /**
     * @param mixed $qarb_arb_autor_rollid
     */
    public function setQarbArbAutorRollid($qarb_arb_autor_rollid)
    {
        $this->qarb_arb_autor_rollid = $qarb_arb_autor_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAutorid()
    {
        return $this->qarb_arb_autorid;
    }

    /**
     * @param mixed $qarb_arb_autorid
     */
    public function setQarbArbAutorid($qarb_arb_autorid)
    {
        $this->qarb_arb_autorid = $qarb_arb_autorid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbAutoridRollid()
    {
        return $this->qarb_arb_autorid_rollid;
    }

    /**
     * @param mixed $qarb_arb_autorid_rollid
     */
    public function setQarbArbAutoridRollid($qarb_arb_autorid_rollid)
    {
        $this->qarb_arb_autorid_rollid = $qarb_arb_autorid_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbBemerkungen()
    {
        return $this->qarb_arb_bemerkungen;
    }

    public function isSetBemerkungen()
    {
        return !is_null($this->qarb_arb_bemerkungen) && strlen($this->qarb_arb_bemerkungen) > 0 ? true : false;
    }




    /**
     * @param mixed $qarb_arb_bemerkungen
     */
    public function setQarbArbBemerkungen($qarb_arb_bemerkungen)
    {
        $this->qarb_arb_bemerkungen = $qarb_arb_bemerkungen;
    }

    /**
     * @return mixed
     */
    public function getQarbArbBetreuer1()
    {
        return $this->qarb_arb_betreuer1;
    }

    /**
     * @param mixed $qarb_arb_betreuer1
     */
    public function setQarbArbBetreuer1($qarb_arb_betreuer1)
    {
        $this->qarb_arb_betreuer1 = $qarb_arb_betreuer1;
    }

    /**
     * @return mixed
     */
    public function getQarbArbBetreuer1Rollid()
    {
        return $this->qarb_arb_betreuer1_rollid;
    }

    /**
     * @param mixed $qarb_arb_betreuer1_rollid
     */
    public function setQarbArbBetreuer1Rollid($qarb_arb_betreuer1_rollid)
    {
        $this->qarb_arb_betreuer1_rollid = $qarb_arb_betreuer1_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbBetreuer2()
    {
        return $this->qarb_arb_betreuer2;
    }

    /**
     * @param mixed $qarb_arb_betreuer2
     */
    public function setQarbArbBetreuer2($qarb_arb_betreuer2)
    {
        $this->qarb_arb_betreuer2 = $qarb_arb_betreuer2;
    }

    /**
     * @return mixed
     */
    public function getQarbArbBetreuer2Rollid()
    {
        return $this->qarb_arb_betreuer2_rollid;
    }

    /**
     * @param mixed $qarb_arb_betreuer2_rollid
     */
    public function setQarbArbBetreuer2Rollid($qarb_arb_betreuer2_rollid)
    {
        $this->qarb_arb_betreuer2_rollid = $qarb_arb_betreuer2_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbChanged()
    {
        return $this->qarb_arb_changed;
    }

    /**
     * @param mixed $qarb_arb_changed
     */
    public function setQarbArbChanged($qarb_arb_changed)
    {
        $this->qarb_arb_changed = $qarb_arb_changed;
    }

    /**
     * @return mixed
     */
    public function getQarbArbChangedby()
    {
        return $this->qarb_arb_changedby;
    }

    /**
     * @param mixed $qarb_arb_changedby
     */
    public function setQarbArbChangedby($qarb_arb_changedby)
    {
        $this->qarb_arb_changedby = $qarb_arb_changedby;
    }

    /**
     * @return mixed
     */
    public function getQarbArbChangedip()
    {
        return $this->qarb_arb_changedip;
    }

    /**
     * @param mixed $qarb_arb_changedip
     */
    public function setQarbArbChangedip($qarb_arb_changedip)
    {
        $this->qarb_arb_changedip = $qarb_arb_changedip;
    }

    /**
     * @return mixed
     */
    public function getQarbArbId()
    {
        return $this->qarb_arb_id;
    }

    /**
     * @param mixed $qarb_arb_id
     */
    public function setQarbArbId($qarb_arb_id)
    {
        $this->qarb_arb_id = $qarb_arb_id;
    }

    /**
     * @return mixed
     */
    public function getQarbArbImwebsichtbar()
    {
        return $this->qarb_arb_imwebsichtbar;
    }

    /**
     * @param mixed $qarb_arb_imwebsichtbar
     */
    public function setQarbArbImwebsichtbar($qarb_arb_imwebsichtbar)
    {
        $this->qarb_arb_imwebsichtbar = $qarb_arb_imwebsichtbar;
    }

    /**
     * @return mixed
     */
    public function getQarbArbIstabgeschlossen()
    {
        return $this->qarb_arb_istabgeschlossen;
    }

    /**
     * @param mixed $qarb_arb_istabgeschlossen
     */
    public function setQarbArbIstabgeschlossen($qarb_arb_istabgeschlossen)
    {
        $this->qarb_arb_istabgeschlossen = $qarb_arb_istabgeschlossen;
    }

    /**
     * @return mixed
     */
    public function getQarbArbRollid()
    {
        return $this->qarb_arb_rollid;
    }

    /**
     * @param mixed $qarb_arb_rollid
     */
    public function setQarbArbRollid($qarb_arb_rollid)
    {
        $this->qarb_arb_rollid = $qarb_arb_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarbArbSemester()
    {
        return $this->qarb_arb_semester;
    }

    /**
     * @param mixed $qarb_arb_semester
     */
    public function setQarbArbSemester($qarb_arb_semester)
    {
        $this->qarb_arb_semester = $qarb_arb_semester;
    }

    /**
     * @return mixed
     */
    public function getQarbArbTitel()
    {
        return $this->qarb_arb_titel;
    }

    /**
     * @param mixed $qarb_arb_titel
     */
    public function setQarbArbTitel($qarb_arb_titel)
    {
        $this->qarb_arb_titel = $qarb_arb_titel;
    }

    /**
     * @return mixed
     */
    public function getQarbArbTyp()
    {
        return $this->qarb_arb_typ;
    }

    /**
     * @param mixed $qarb_arb_typ
     */
    public function setQarbArbTyp($qarb_arb_typ)
    {
        $this->qarb_arb_typ = $qarb_arb_typ;
    }

    /**
     * @return null
     */
    public function getAutorInfo2()
    {
        return $this->autorInfo2;
    }

    /**
     * @param null $autorInfo2
     */
    public function setAutorInfo2(PersonenInfo $autorInfo2)
    {
        $this->autorInfo2 = $autorInfo2;
    }

    /**
     * @return array
     */
    public function getBetreuer1Info()
    {
        return is_array($this->betreuerInfo) && isset($this->betreuerInfo[0]) &&
            $this->betreuerInfo[0] instanceof PersonenInfo ? $this->betreuerInfo[0] : null;
    }

    /**
     * @return array
     */
    public function getBetreuer2Info()
    {
        return is_array($this->betreuerInfo) && isset($this->betreuerInfo[1]) &&
            $this->betreuerInfo[1] instanceof PersonenInfo ? $this->betreuerInfo[1] : null;
    }

    public function isSetBetreuer2Info()
    {

        return !is_null($this->getBetreuer2Info()) ? true : false;
    }

    public function isSetQarbArbURL()
    {

        return !is_null($this->getQarbArbURL()) && strlen($this->getQarbArbURL()) > 0 ? true : false;
    }

    public function isSetQarbArbISBN()
    {

        return !is_null($this->getQarbArbISBN()) && strlen($this->getQarbArbISBN()) > 0 ? true : false;
    }


    /**
     * @param array $betreuerInfo
     */
    public function addBetreuerInfo(PersonenInfo $betreuerInfo)
    {
        //Annahme: ich gehe davon aus, dass das erste item im Array immer Betreuer1 ist
        $this->betreuerInfo[] = $betreuerInfo;
    }





}