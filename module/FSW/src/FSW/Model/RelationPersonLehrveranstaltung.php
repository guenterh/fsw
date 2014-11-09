<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 15:05
 */

namespace FSW\Model;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RelationPersonLehrveranstaltung extends BaseModel implements InputFilterAwareInterface{


    public $id;
    public $fper_personen_pers_id;
    public $ffsw_lehrveranstaltungen_id;



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
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'fper_personen_pers_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'ffsw_lehrveranstaltungen_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

        }

        return $this->inputFilter;

    }

    /**
     * Get record ID
     *
     * @return    Integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        // TODO: Implement getListLabel() method.
    }

    /**
     * @return mixed
     */
    public function getFfsw_lehrveranstaltungen_id()
    {
        return $this->ffsw_lehrveranstaltungen_id;
    }

    /**
     * @param mixed $ffsw_lehrveranstaltungen_id
     */
    public function setFfsw_lehrveranstaltungen_id($ffsw_lehrveranstaltungen_id)
    {
        $this->ffsw_lehrveranstaltungen_id = $ffsw_lehrveranstaltungen_id;
    }

    /**
     * @return mixed
     */
    public function getFper_personen_pers_id()
    {
        return $this->fper_personen_pers_id;
    }

    /**
     * @param mixed $fper_personen_pers_id
     */
    public function setFper_personen_pers_id($fper_personen_pers_id)
    {
        $this->fper_personen_pers_id = $fper_personen_pers_id;
    }







}