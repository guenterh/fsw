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


class PersonZoraAuthor extends BaseModel implements InputFilterAwareInterface {


    protected $inputFilter;
    public $zora_name;
    public $zora_name_customized;
    public $pers_id;
    public $fid_personen;


    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        // TODO: Implement setInputFilter() method.
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'pers_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'profilURL',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'fullname',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
            ));

        }

        return $this->inputFilter;
    }

    /**
     * @param mixed $fid_personen
     */
    public function setFidPersonen($fid_personen)
    {
        $this->fid_personen = $fid_personen;
    }

    /**
     * @return mixed
     */
    public function getFidPersonen()
    {
        return $this->fid_personen;
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
    public function getPersId()
    {
        return $this->pers_id;
    }

    /**
     * @param mixed $zora_name
     */
    public function setZoraName($zora_name)
    {
        $this->zora_name = $zora_name;
    }

    /**
     * @return mixed
     */
    public function getZoraName()
    {
        return $this->zora_name;
    }

    /**
     * @param mixed $zora_name_customized
     */
    public function setZoraNameCustomized($zora_name_customized)
    {
        $this->zora_name_customized = $zora_name_customized;
    }

    /**
     * @return mixed
     */
    public function getZoraNameCustomized()
    {
        return $this->zora_name_customized;
    }


}