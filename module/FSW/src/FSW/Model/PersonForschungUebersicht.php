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


class PersonForschungUebersicht extends BaseModel implements InputFilterAwareInterface {


    public $lizentiatmaster = array();
    public $dissertation = array();


    //private $arbeiten = array();
    //private    $position = 0;


    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getID() {

        //return $this->qarb_arb_id;
    }

    public function getListLabel() {
        //return substr($this->qarb_arb_titel,0,15);
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
     * @param array $dissertation
     */
    public function setDissertation($dissertation)
    {
        $this->dissertation = $dissertation;
    }

    /**
     * @return array
     */
    public function getDissertation()
    {
        return $this->dissertation;
    }

    /**
     * @param array $lizentiatmaster
     */
    public function setLizentiatmaster($lizentiatmaster)
    {
        $this->lizentiatmaster = $lizentiatmaster;
    }

    /**
     * @return array
     */
    public function getLizentiatmaster()
    {
        return $this->lizentiatmaster;
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
//    public function current()
//    {
//       return $this->arbeiten[$this->position];
//    }
//
//    /**
//     * (PHP 5 &gt;= 5.0.0)<br/>
//     * Move forward to next element
//     * @link http://php.net/manual/en/iterator.next.php
//     * @return void Any returned value is ignored.
//     */
//    public function next()
//    {
//        ++$this->position;
//    }
//
//    /**
//     * (PHP 5 &gt;= 5.0.0)<br/>
//     * Return the key of the current element
//     * @link http://php.net/manual/en/iterator.key.php
//     * @return mixed scalar on success, or null on failure.
//     */
//    public function key()
//    {
//        $this->position;
//    }
//
//    /**
//     * (PHP 5 &gt;= 5.0.0)<br/>
//     * Checks if current position is valid
//     * @link http://php.net/manual/en/iterator.valid.php
//     * @return boolean The return value will be casted to boolean and then evaluated.
//     * Returns true on success or false on failure.
//     */
//    public function valid()
//    {
//        return isset($this->arbeiten[$this->position]);
//    }
//
//    /**
//     * (PHP 5 &gt;= 5.0.0)<br/>
//     * Rewind the Iterator to the first element
//     * @link http://php.net/manual/en/iterator.rewind.php
//     * @return void Any returned value is ignored.
//     */
//    public function rewind()
//    {
//        $this->position = 0;
//    }




}