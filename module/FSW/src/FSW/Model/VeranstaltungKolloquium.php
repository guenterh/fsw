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


class VeranstaltungKolloquium extends BaseModel implements InputFilterAwareInterface {



    private $resource;
    public $vortragend = array();


    public $id;
    public $id_kolloquium;
    public $datum;
    public $veranstaltung_titel;
    public $beschreibung;



    protected $inputFilter;

    /*
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
    */

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
                'name'     => 'id_kolloquium',
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
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
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
    public function getId_kolloquium()
    {
        return $this->id_kolloquium;
    }

    /**
     * @param mixed $id_kolloquium
     */
    public function setId_kolloquium($id_kolloquium)
    {
        $this->id_kolloquium = $id_kolloquium;
    }


    /**
     * @return mixed
     */
    public function getVeranstaltung_titel()
    {
        return $this->veranstaltung_titel;
    }

    /**
     * @param mixed $veranstaltung_titel
     */
    public function setVeranstaltung_titel($veranstaltung_titel)
    {
        $this->veranstaltung_titel = $veranstaltung_titel;
    }


    public function initFromSource($resource) {

        $this->resource = $resource;

    }


    public function parse() {
        foreach($this->resource->children() as $attr=>$val)
        {


            switch ($attr) {
                case "idveranstaltung":
                    $this->id = (string) $val;
                    break;
                case "veranstaltungsdatum":
                    $this->datum = (string) $val;
                    break;
                case "bemerkung":
                    $this->beschreibung = (string) $val;
                    break;
                case "topic":

                    foreach($val->children() as $attrtopic=>$valtopic)
                    {


                        switch ($attrtopic) {
                            case "titel":
                                $this->veranstaltung_titel = (string) $valtopic;
                                break;
                            default:
                                //todo: error logging
                        }

                    }


                    break;
                case "vortragende":

                    foreach($val->children() as $attrVortragend=>$valVortragend)
                    {

                        switch ($attrVortragend) {
                            case "person":
                                $oPerson = new VeranstaltungKolloquiumPerson();
                                $oPerson->initFromSource($valVortragend);
                                $oPerson->parse();
                                $this->vortragend[] = $oPerson;
                                break;

                        }

                    }

                    break;


            }

        }

    }

    /**
     * @return array
     */
    public function getVortragend()
    {
        return $this->vortragend;
    }

    /**
     * @param array $vortragend
     */
    public function setVortragend($vortragend)
    {
        $this->vortragend = $vortragend;
    }

    public function addVortragend($vortragend) {
        if ($vortragend  instanceof VeranstaltungKolloquiumPerson) {
            if (!is_array($this->vortragend)) {
                $this->vortragend = array();
            }
            $this->vortragend[] = $vortragend;

        }
    }








}