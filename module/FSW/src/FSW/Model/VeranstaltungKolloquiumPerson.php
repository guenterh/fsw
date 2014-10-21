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


class VeranstaltungKolloquiumPerson extends BaseModel implements InputFilterAwareInterface {


    private $resource;


    public $id;
    public $id_kolloquium_veranstaltung;
    public $id_personen_extended;
    public $nach_name;
    public $vor_name;
    public $personeninformation;
    public $person_link;
    public $institution_name;
    public $institution_link;
    public $institution_link_bild;



    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $this->inputFilter = $inputFilter;

            //todo: define fields for validation
        }

        return $this->inputFilter;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getId_kolloquium_veranstaltung()
    {
        return $this->id_kolloquium_veranstaltung;
    }

    /**
     * @param mixed $id_kolloquium_veranstaltung
     */
    public function setId_kolloquium_veranstaltung($id_kolloquium_veranstaltung)
    {
        $this->id_kolloquium_veranstaltung = $id_kolloquium_veranstaltung;
    }

    /**
     * @return mixed
     */
    public function getId_personen_extended()
    {
        return $this->id_personen_extended;
    }

    /**
     * @param mixed $id_personen_extended
     */
    public function setId_personen_extended($id_personen_extended)
    {
        $this->id_personen_extended = $id_personen_extended;
    }

    /**
     * @return mixed
     */
    public function getInstitution_link()
    {
        return $this->institution_link;
    }

    /**
     * @param mixed $institution_link
     */
    public function setInstitution_link($institution_link)
    {
        $this->institution_link = $institution_link;
    }

    /**
     * @return mixed
     */
    public function getInstitution_link_bild()
    {
        return $this->institution_link_bild;
    }

    /**
     * @param mixed $institution_link_bild
     */
    public function setInstitution_link_bild($institution_link_bild)
    {
        $this->institution_link_bild = $institution_link_bild;
    }

    /**
     * @return mixed
     */
    public function getInstitution_name()
    {
        return $this->institution_name;
    }

    /**
     * @param mixed $institution_name
     */
    public function setInstitution_name($institution_name)
    {
        $this->institution_name = $institution_name;
    }

    /**
     * @return mixed
     */
    public function getNach_name()
    {
        return $this->nach_name;
    }

    /**
     * @param mixed $nach_name
     */
    public function setNach_name($nach_name)
    {
        $this->nach_name = $nach_name;
    }

    /**
     * @return mixed
     */
    public function getVor_name()
    {
        return $this->vor_name;
    }

    /**
     * @param mixed $vor_name
     */
    public function setVor_name($vor_name)
    {
        $this->vor_name = $vor_name;
    }

    /**
     * @return mixed
     */
    public function getPerson_link()
    {
        return $this->person_link;
    }

    /**
     * @param mixed $person_link
     */
    public function setPerson_link($person_link)
    {
        $this->person_link = $person_link;
    }

    /**
     * @return mixed
     */
    public function getPersoneninformation()
    {
        return $this->personeninformation;
    }

    /**
     * @param mixed $personeninformation
     */
    public function setPersoneninformation($personeninformation)
    {
        $this->personeninformation = $personeninformation;
    }






    /**
     * Get list label key
     *
     * @return    String
     */
    public function getListLabel()
    {
        return "implement listlabel kolloquium Veranstaltung";
    }

    public function initFromSource($resource) {

        $this->resource = $resource;

    }

    public function parse() {

        foreach($this->resource->children() as $attr=>$val)
        {


            switch ($attr) {
                case "name":


                    foreach($val->children() as $attrName=>$valName)
                    {
                        switch ($attrName) {
                            case "nachName":

                                $this->nach_name = (string) $valName;
                                break;
                            case "vorName":
                                $this->vor_name = (string) $valName;
                                break;
                            default:
                                //todo: error logging
                        }

                    }


                    break;
                case "personenlink":
                    $this->person_link = (string) $val;
                    break;
                case "personeninformation":
                    $this->personeninformation = (string) $val;
                    break;
                case "institution":


                    foreach($val->children() as $attrInstitution=>$valInstitution)
                    {
                        switch ($attrInstitution) {
                            case "institutionName":

                                $this->institution_name = (string)$valInstitution;
                                break;
                            case "institutionLink":
                                $this->institution_link = (string) $valInstitution;
                                break;
                            case "institutionBildPfad":
                                $this->institution_link_bild = (string) $valInstitution;
                                break;
                        }
                    }

                    break;
                default:
                    echo $attr;

            }

        }

    }



}