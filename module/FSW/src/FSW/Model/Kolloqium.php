<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 9:37 PM
 */

namespace FSW\Model;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

class Kolloqium implements InputFilterAwareInterface{

    public $idkolloquium;
    public $titel;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->idkolloquium     = (isset($data['idkolloquium'])) ? $data['idkolloquium'] : null;
        $this->titel = (isset($data['titel'])) ? $data['titel'] : null;
    }

    /**
     * Retrieve object array
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("not used");
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
                    'name'     => 'idkolloquium',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'Int'),
                    ),
                )
            );

            $inputFilter->add(array(
                'name'     => 'titel',
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
                            'max'      => 10000,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}