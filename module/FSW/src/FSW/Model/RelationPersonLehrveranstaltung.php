<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 15:05
 */

namespace FSW\Model;


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
        // TODO: Implement getInputFilter() method.
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
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        // TODO: Implement getListLabel() method.
    }




}