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


class Abteilung extends BaseModel implements InputFilterAwareInterface {


    public $abt_abk;
    public $abt_id;
    public $abt_name;
    public $abt_name2;
    public $abt_zeit_id;

    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getId() {
        return $this->abt_id;
    }

    public function getListLabel() {
        return $this->abt_name;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'abt_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'abt_name',
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
    public function getAbt_abk()
    {
        return $this->abt_abk;
    }

    /**
     * @param mixed $abt_abk
     */
    public function setAbt_abk($abt_abk)
    {
        $this->abt_abk = $abt_abk;
    }

    /**
     * @return mixed
     */
    public function getAbt_name()
    {
        return $this->abt_name;
    }

    /**
     * @param mixed $abt_name
     */
    public function setAbt_name($abt_name)
    {
        $this->abt_name = $abt_name;
    }

    /**
     * @return mixed
     */
    public function getAbt_name2()
    {
        return $this->abt_name2;
    }

    /**
     * @param mixed $abt_name2
     */
    public function setAbt_name2($abt_name2)
    {
        $this->abt_name2 = $abt_name2;
    }

    /**
     * @return mixed
     */
    public function getAbt_zeit_id()
    {
        return $this->abt_zeit_id;
    }

    /**
     * @param mixed $abt_zeit_id
     */
    public function setAbt_zeit_id($abt_zeit_id)
    {
        $this->abt_zeit_id = $abt_zeit_id;
    }

    /**
     * @return mixed
     */
    public function getAbt_id()
    {
        return $this->abt_id;
    }

    /**
     * @param mixed $abt_id
     */
    public function setAbt_id($abt_id)
    {
        $this->abt_id = $abt_id;
    }




} 