<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 4:54 PM
 */

namespace FSW\Model;

use Traversable;
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


    private $arbeiten = array();
    privATE    $position = 0;


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
    public function setQarb_arb_DOI($qarb_arb_DOI)
    {
        $this->qarb_arb_DOI = $qarb_arb_DOI;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_DOI()
    {
        return $this->qarb_arb_DOI;
    }

    /**
     * @param mixed $qarb_arb_FDB
     */
    public function setQarb_arb_FDB($qarb_arb_FDB)
    {
        $this->qarb_arb_FDB = $qarb_arb_FDB;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_FDB()
    {
        return $this->qarb_arb_FDB;
    }

    /**
     * @param mixed $qarb_arb_ISBN
     */
    public function setQarb_arb_ISBN($qarb_arb_ISBN)
    {
        $this->qarb_arb_ISBN = $qarb_arb_ISBN;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_ISBN()
    {
        return $this->qarb_arb_ISBN;
    }

    /**
     * @param mixed $qarb_arb_ISSN
     */
    public function setQarb_arb_ISSN($qarb_arb_ISSN)
    {
        $this->qarb_arb_ISSN = $qarb_arb_ISSN;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_ISSN()
    {
        return $this->qarb_arb_ISSN;
    }

    /**
     * @param mixed $qarb_arb_URL
     */
    public function setQarb_arb_URL($qarb_arb_URL)
    {
        $this->qarb_arb_URL = $qarb_arb_URL;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_URL()
    {
        return $this->qarb_arb_URL;
    }

    /**
     * @param mixed $qarb_arb_ZORA
     */
    public function setQarb_arb_ZORA($qarb_arb_ZORA)
    {
        $this->qarb_arb_ZORA = $qarb_arb_ZORA;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_ZORA()
    {
        return $this->qarb_arb_ZORA;
    }

    /**
     * @param mixed $qarb_arb_abschlussjahr
     */
    public function setQarb_arb_abschlussjahr($qarb_arb_abschlussjahr)
    {
        $this->qarb_arb_abschlussjahr = $qarb_arb_abschlussjahr;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_abschlussjahr()
    {
        return $this->qarb_arb_abschlussjahr;
    }

    /**
     * @param mixed $qarb_arb_abstract
     */
    public function setQarb_arb_abstract($qarb_arb_abstract)
    {
        $this->qarb_arb_abstract = $qarb_arb_abstract;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_abstract()
    {
        return $this->qarb_arb_abstract;
    }

    /**
     * @param mixed $qarb_arb_autor_rollid
     */
    public function setQarb_arb_autor_rollid($qarb_arb_autor_rollid)
    {
        $this->qarb_arb_autor_rollid = $qarb_arb_autor_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_autor_rollid()
    {
        return $this->qarb_arb_autor_rollid;
    }

    /**
     * @param mixed $qarb_arb_autorid
     */
    public function setQarb_arb_autorid($qarb_arb_autorid)
    {
        $this->qarb_arb_autorid = $qarb_arb_autorid;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_autorid()
    {
        return $this->qarb_arb_autorid;
    }

    /**
     * @param mixed $qarb_arb_bemerkungen
     */
    public function setQarb_arb_bemerkungen($qarb_arb_bemerkungen)
    {
        $this->qarb_arb_bemerkungen = $qarb_arb_bemerkungen;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_bemerkungen()
    {
        return $this->qarb_arb_bemerkungen;
    }

    /**
     * @param mixed $qarb_arb_betreuer1
     */
    public function setQarb_arb_betreuer1($qarb_arb_betreuer1)
    {
        $this->qarb_arb_betreuer1 = $qarb_arb_betreuer1;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_betreuer1()
    {
        return $this->qarb_arb_betreuer1;
    }

    /**
     * @param mixed $qarb_arb_betreuer1_rollid
     */
    public function setQarb_arb_betreuer1_rollid($qarb_arb_betreuer1_rollid)
    {
        $this->qarb_arb_betreuer1_rollid = $qarb_arb_betreuer1_rollid;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_betreuer1_rollid()
    {
        return $this->qarb_arb_betreuer1_rollid;
    }

    /**
     * @param mixed $qarb_arb_betreuer2
     */
    public function setQarb_arb_betreuer2($qarb_arb_betreuer2)
    {
        $this->qarb_arb_betreuer2 = $qarb_arb_betreuer2;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_betreuer2()
    {
        return $this->qarb_arb_betreuer2;
    }

    /**
     * @param mixed $qarb_arb_changed
     */
    public function setQarb_arb_changed($qarb_arb_changed)
    {
        $this->qarb_arb_changed = $qarb_arb_changed;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_changed()
    {
        return $this->qarb_arb_changed;
    }

    /**
     * @param mixed $qarb_arb_id
     */
    public function setQarb_arb_id($qarb_arb_id)
    {
        $this->qarb_arb_id = $qarb_arb_id;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_id()
    {
        return $this->qarb_arb_id;
    }

    /**
     * @param mixed $qarb_arb_imwebsichtbar
     */
    public function setQarb_arb_imwebsichtbar($qarb_arb_imwebsichtbar)
    {
        $this->qarb_arb_imwebsichtbar = $qarb_arb_imwebsichtbar;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_imwebsichtbar()
    {
        return $this->qarb_arb_imwebsichtbar;
    }

    /**
     * @param mixed $qarb_arb_istabgeschlossen
     */
    public function setQarb_arb_istabgeschlossen($qarb_arb_istabgeschlossen)
    {
        $this->qarb_arb_istabgeschlossen = $qarb_arb_istabgeschlossen;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_istabgeschlossen()
    {
        return $this->qarb_arb_istabgeschlossen;
    }

    /**
     * @param mixed $qarb_arb_semester
     */
    public function setQarb_arb_semester($qarb_arb_semester)
    {
        $this->qarb_arb_semester = $qarb_arb_semester;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_semester()
    {
        return $this->qarb_arb_semester;
    }

    /**
     * @param mixed $qarb_arb_titel
     */
    public function setQarb_arb_titel($qarb_arb_titel)
    {
        $this->qarb_arb_titel = $qarb_arb_titel;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_titel()
    {
        return $this->qarb_arb_titel;
    }

    /**
     * @param mixed $qarb_arb_typ
     */
    public function setQarb_arb_typ($qarb_arb_typ)
    {
        $this->qarb_arb_typ = $qarb_arb_typ;
    }

    /**
     * @return mixed
     */
    public function getQarb_arb_typ()
    {
        return $this->qarb_arb_typ;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
       return $this->arbeiten[$this->position];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        $this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->arbeiten[$this->position]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    public function addForschungsarbeit($arbeit) {
        $this->arbeiten[] = $arbeit;
    }

    public function getArbeiten() {
        return $this->arbeiten;
    }


}