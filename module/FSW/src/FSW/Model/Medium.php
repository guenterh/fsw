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


class Medium extends BaseModel implements InputFilterAwareInterface {


    public $datum;
    public $gespraechstitel;
    public $icon;
    public $id;
    public $link;
    public $medientyp;
    public $mit_id_per_extended;
    public $sendetitel;

    private $beteiligter;

    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getId() {
        return $this->id;
    }

    public function getListLabel() {
        return $this->gespraechstitel;    }


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
                'name'     => 'mit_id_per_extended',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));


            $inputFilter->add(array(
                'name'     => 'medientyp',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));



            $inputFilter->add(array(
                'name'     => 'datum',
                'required' => true
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
                            'max'      => 300,
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
                            'max'      => 1000,
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
                            'max'      => 1000,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $gespraechstitel
     */
    public function setGespraechstitel($gespraechstitel)
    {
        $this->gespraechstitel = $gespraechstitel;
    }

    /**
     * @return mixed
     */
    public function getGespraechstitel()
    {
        return $this->gespraechstitel;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
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
    /*
    public function getId()
    {
        return $this->id;
    }
    */

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $medientyp
     */
    public function setmedientyp($medientyp)
    {
        $this->medientyp = $medientyp;
    }

    /**
     * @return mixed
     */
    public function getMedientyp()
    {
        return $this->medientyp;
    }

    /**
     * @param mixed $mit_id_per_extended
     */
    public function setMit_id_per_extended($mit_id_per_extended)
    {
        $this->mit_id_per_extended = $mit_id_per_extended;
    }

    /**
     * @return mixed
     */
    public function getMit_id_per_extended()
    {
        return $this->mit_id_per_extended;
    }

    /**
     * @param mixed $sendetitel
     */
    public function setSendetitel($sendetitel)
    {
        $this->sendetitel = $sendetitel;
    }

    /**
     * @return mixed
     */
    public function getSendetitel()
    {
        return $this->sendetitel;
    }

    /**
     * @return mixed
     */
    public function getBeteiligter()
    {
        return $this->beteiligter;
    }

    /**
     * @param mixed $beteiligter
     */
    public function setBeteiligter($beteiligter)
    {
        $this->beteiligter = $beteiligter;
    }






} 