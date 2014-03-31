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


class Medium implements InputFilterAwareInterface {


    public $medienid;
    public $mit_id;
    public $sendetitel;
    public $gespraechstitel;
    public $link;
    public $icon;
    public $datum;
    public $medientyp;

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->medienid     = (isset($data['medienid'])) ? $data['medienid'] : null;
        $this->mit_id = (isset($data['mit_id'])) ? $data['mit_id'] : null;
        $this->sendetitel  = (isset($data['sendetitel'])) ? $data['sendetitel'] : null;
        $this->gespraechstitel  = (isset($data['gespraechstitel'])) ? $data['gespraechstitel'] : null;
        $this->link  = (isset($data['link'])) ? $data['link'] : null;
        $this->icon  = (isset($data['icon'])) ? $data['icon'] : null;
        $this->datum  = (isset($data['datum'])) ? $data['datum'] : null;
        $this->medientyp  = (isset($data['medientyp'])) ? $data['medientyp'] : null;


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


    public function getID() {
        return $this->medienid;
    }

    public function getListLabel() {
        return $this->gespraechstitel;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'medienid',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'mit_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'icon',
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
                'name'     => 'gespraechstitel',
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
                'name'     => 'sendetitel',
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


} 