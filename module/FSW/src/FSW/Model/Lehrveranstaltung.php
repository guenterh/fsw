<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 14:58
 */

namespace FSW\Model;


use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Lehrveranstaltung extends BaseModel implements InputFilterAwareInterface{


    public $id;
    public $von_zeit;
    public $bis_zeit;
    public $semester;
    public $titel;
    public $tag;
    public $vvzlink;
    public $olatlink;
    public $beschreibung;
    public $personenLehrveranstaltung = null;
    public $lvtyp;

    protected $inputFilter;

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
        return  $this->semester . ": " . substr($this->titel,0,150);
    }

    /**
     * @return mixed
     */
    public function getBis_zeit()
    {
        return $this->bis_zeit;
    }

    /**
     * @param mixed $bis_zeit
     */
    public function setBis_zeit($bis_zeit)
    {
        $this->bis_zeit = $bis_zeit;
    }

    /**
     * @return mixed
     */
    public function getOlatlink()
    {
        return $this->olatlink;
    }

    /**
     * @param mixed $olatlink
     */
    public function setOlatlink($olatlink)
    {
        $this->olatlink = $olatlink;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public function getVon_zeit()
    {
        return $this->von_zeit;
    }

    /**
     * @param mixed $von_zeit
     */
    public function setVon_zeit($von_zeit)
    {
        $this->von_zeit = $von_zeit;
    }

    /**
     * @return mixed
     */
    public function getVvzlink()
    {
        return $this->vvzlink;
    }

    /**
     * @param mixed $vvzlink
     */
    public function setVvzlink($vvzlink)
    {
        $this->vvzlink = $vvzlink;
    }

    /**
     * @return mixed
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * @param mixed $beschreibung
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }



    /**
     * @return null
     */
    public function getPersonenLehrveranstaltung()
    {
        return $this->personenLehrveranstaltung;
    }

    /**
     * @param null $personenLehrveranstaltung
     */
    public function setPersonenLehrveranstaltung($personenLehrveranstaltung)
    {
        $this->personenLehrveranstaltung = $personenLehrveranstaltung;
    }

    /**
     * @return mixed
     */
    public function getLvtyp()
    {
        return $this->lvtyp;
    }

    /**
     * @param mixed $lvtyp
     */
    public function setLvtyp($lvtyp)
    {
        $this->lvtyp = $lvtyp;
    }







    /**
     * @return array
     */

    public function addPerson($personenLehrveranstaltung)
    {
        $this->personenLehrveranstaltung[] = $personenLehrveranstaltung;
    }


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
                'name'     => 'semester',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 20,
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name'     => 'titel',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 500,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'vvzlink',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 500,
                        ),
                    ),
                ),
            ));

            /*
            $inputFilter->add(array(
                'name'     => 'olatlink',
                //'required' => true,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),

                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 0,
                            'max'      => 500,
                        ),
                    ),
                ),

            ));
            */




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }



}