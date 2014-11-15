<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 14:54
 */

namespace FSW\Model;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ZoraDocOnlyCover extends BaseModel implements InputFilterAwareInterface {


    public $id;
    public $frontpage;
    public $coverlink;
    public $oai_identifier;
    public $inputFilter;


    /**
     * Get record ID
     *
     * @return    Integer
     */
    public function getId()
    {
        return $this->id;
    }


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
        return "";
    }

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
                'id'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'oai_identifier',
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
    public function getCoverlink()
    {
        return $this->coverlink;
    }

    /**
     * @param mixed $coverlink
     */
    public function setCoverlink($coverlink)
    {
        $this->coverlink = $coverlink;
    }

    /**
     * @return mixed
     */
    public function getFrontpage()
    {
        return $this->frontpage;
    }

    /**
     * @param mixed $frontpage
     */
    public function setFrontpage($frontpage)
    {
        $this->frontpage = $frontpage;
    }

    /**
     * @return mixed
     */
    public function getOai_identifier()
    {
        return $this->oai_identifier;
    }

    /**
     * @param mixed $oai_identifier
     */
    public function setOai_identifier($oai_identifier)
    {
        $this->oai_identifier = $oai_identifier;
    }



}