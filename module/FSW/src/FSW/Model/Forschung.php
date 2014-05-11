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


class Forschung extends BaseModel implements InputFilterAwareInterface {


    public $qarb_arb_id;
    public $qarb_arb_autorid;
    public $qarb_arb_autor_rollid;
    public $qarb_arb_titel;
    public $qarb_arb_typ;
    public $qarb_arb_betreuer1;
    public $qarb_arb_betreuer1_rollid;
    public $qarb_arb_betreuer2;
    public $qarb_arb_istabgeschlossen;
    public $qarb_arb_abschlussjahr;
    public $qarb_arb_semester;
    public $qarb_arb_bemerkungen;
    public $qarb_arb_abstract;
    public $qarb_arb_imwebsichtbar;
    public $qarb_arb_DOI;
    public $qarb_arb_ISSN;
    public $qarb_arb_ISBN;
    //todo: was wird hier eingetagen
    public $qarb_arb_ZORA;
    //todo: was wird hier eingetagen
    public $qarb_arb_FDB;
    public $qarb_arb_URL;
    public $qarb_arb_changed;










    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getID() {

        return $this->qarb_arb_id;
    }

    public function getListLabel() {
        return substr($this->qarb_arb_titel,0,15);
    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
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
    public function getQarbArbDOI()
    {
        return $this->qarb_arb_DOI;
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
    public function getQarbArbFDB()
    {
        return $this->qarb_arb_FDB;
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
    public function getQarbArbISBN()
    {
        return $this->qarb_arb_ISBN;
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
    public function getQarbArbISSN()
    {
        return $this->qarb_arb_ISSN;
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
    public function getQarbArbURL()
    {
        return $this->qarb_arb_URL;
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
    public function getQarbArbZORA()
    {
        return $this->qarb_arb_ZORA;
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
    public function getQarbArbAbschlussjahr()
    {
        return $this->qarb_arb_abschlussjahr;
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
    public function getQarbArbAbstract()
    {
        return $this->qarb_arb_abstract;
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
    public function getQarbArbAutorRollid()
    {
        return $this->qarb_arb_autor_rollid;
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
    public function getQarbArbAutorid()
    {
        return $this->qarb_arb_autorid;
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
    public function getQarbArbBemerkungen()
    {
        return $this->qarb_arb_bemerkungen;
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
    public function getQarbArbBetreuer1()
    {
        return $this->qarb_arb_betreuer1;
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
    public function getQarbArbBetreuer1Rollid()
    {
        return $this->qarb_arb_betreuer1_rollid;
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
    public function getQarbArbBetreuer2()
    {
        return $this->qarb_arb_betreuer2;
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
    public function getQarbArbChanged()
    {
        return $this->qarb_arb_changed;
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
    public function getQarbArbId()
    {
        return $this->qarb_arb_id;
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
    public function getQarbArbImwebsichtbar()
    {
        return $this->qarb_arb_imwebsichtbar;
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
    public function getQarbArbIstabgeschlossen()
    {
        return $this->qarb_arb_istabgeschlossen;
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
    public function getQarbArbSemester()
    {
        return $this->qarb_arb_semester;
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
    public function getQarbArbTitel()
    {
        return $this->qarb_arb_titel;
    }

    /**
     * @param mixed $qarb_arb_typ
     */
    public function setQarbArbTyp($qarb_arb_typ)
    {
        $this->qarb_arb_typ = $qarb_arb_typ;
    }

    /**
     * @return mixed
     */
    public function getQarbArbTyp()
    {
        return $this->qarb_arb_typ;
    }





} 