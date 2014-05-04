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


class Veranstaltung extends BaseModel implements InputFilterAwareInterface {


    public $idveranstaltung;
    public $idkolloquium;
    public $datum;
    public $personenname;
    public $beschreibung;

    public $id;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->idveranstaltung     = (isset($data['idveranstaltung'])) ? $data['idveranstaltung'] : null;
        $this->idkolloquium = (isset($data['idkolloquium'])) ? $data['idkolloquium'] : null;
        $this->datum  = (isset($data['datum'])) ? $data['datum'] : null;
        $this->personenname  = (isset($data['personenname'])) ? $data['personenname'] : null;
        $this->beschreibung  = (isset($data['beschreibung'])) ? $data['beschreibung'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'idveranstaltung',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'idkolloquium',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            /*
            $inputFilter->add(array(
                'name'     => 'datum',
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
            */

            $inputFilter->add(array(
                'name'     => 'personenname',
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

            $inputFilter->add(array(
                'name'     => 'beschreibung',
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