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


class RelationHSFSWPerson extends BaseModel implements InputFilterAwareInterface {



    protected $id;
    protected $fper_personen_pers_id;
    protected $fpersonen_extended_id;
    protected $fper_rolle_roll_id;




    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }



    public function getListLabel() {
        return $this->id;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'id'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param mixed $fper_personen_pers_id
     */
    public function setFper_personen_pers_id($fper_personen_pers_id)
    {
        $this->fper_personen_pers_id = $fper_personen_pers_id;
    }

    /**
     * @return mixed
     */
    public function getFper_personen_pers_id()
    {
        return $this->fper_personen_pers_id;
    }

    /**
     * @param mixed $fper_rolle_roll_id
     */
    public function setFper_rolle_roll_id($fper_rolle_roll_id)
    {
        $this->fper_rolle_roll_id = $fper_rolle_roll_id;
    }

    /**
     * @return mixed
     */
    public function getFper_rolle_roll_id()
    {
        return $this->fper_rolle_roll_id;
    }

    /**
     * @param mixed $fpersonen_extended_id
     */
    public function setFpersonen_extended_id($fpersonen_extended_id)
    {
        $this->fpersonen_extended_id = $fpersonen_extended_id;
    }

    /**
     * @return mixed
     */
    public function getFpersonen_extended_id()
    {
        return $this->fpersonen_extended_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }




} 