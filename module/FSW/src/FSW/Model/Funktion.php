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


class Funktion extends BaseModel implements InputFilterAwareInterface {


    public $funk_abk;
    public $funk_id;
    public $funk_name;

    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getId() {
        return $this->funk_id;
    }

    public function getListLabel() {
        return $this->funk_name;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'funk_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'funk_name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return mixed
     */
    public function getFunk_abk()
    {
        return $this->funk_abk;
    }

    /**
     * @param mixed $funk_abk
     */
    public function setFunk_abk($funk_abk)
    {
        $this->funk_abk = $funk_abk;
    }

    /**
     * @return mixed
     */
    public function getFunk_id()
    {
        return $this->funk_id;
    }

    /**
     * @param mixed $funk_id
     */
    public function setFunk_id($funk_id)
    {
        $this->funk_id = $funk_id;
    }

    /**
     * @return mixed
     */
    public function getFunk_name()
    {
        return $this->funk_name;
    }

    /**
     * @param mixed $funk_name
     */
    public function setFunk_name($funk_name)
    {
        $this->funk_name = $funk_name;
    }




} 