<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 11.02.15
 * Time: 22:24
 */

namespace FSW\Model;


class PersonKolloquiumShort extends BaseModel {


    private $id;
    //`nach_name`, `vor_name`, `institution_link`, `person_link`, id_kolloquium
    private $nach_name;
    private $vor_name;
    private $institution_link;
    private $person_link;
    private $id_kolloquium = array();
    private $kolloqiumLabel = array();



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
        //nothing to do
        return "";
    }

    /**
     * @return mixed
     */
    public function getNachName()
    {
        return $this->nach_name;
    }

    /**
     * @param mixed $nach_name
     */
    public function setNachName($nach_name)
    {
        $this->nach_name = $nach_name;
    }

    /**
     * @return mixed
     */
    public function getVorName()
    {
        return $this->vor_name;
    }

    /**
     * @param mixed $vor_name
     */
    public function setVorName($vor_name)
    {
        $this->vor_name = $vor_name;
    }

    /**
     * @return mixed
     */
    public function getInstitutionLink()
    {
        return $this->institution_link;
    }

    /**
     * @param mixed $institution_link
     */
    public function setInstitutionLink($institution_link)
    {
        $this->institution_link = $institution_link;
    }

    /**
     * @return mixed
     */
    public function getPersonLink()
    {
        return $this->person_link;
    }

    /**
     * @param mixed $person_link
     */
    public function setPersonLink($person_link)
    {
        $this->person_link = $person_link;
    }

    /**
     * @return mixed
     */
    public function getIdKolloquium()
    {
        return $this->id_kolloquium;
    }

    /**
     * @param mixed $id_kolloquium
     */
    public function addIdKolloquium($id_kolloquium)
    {
        $this->id_kolloquium[] = $id_kolloquium;

        $year = substr($id_kolloquium,0,4);
        $semester = substr($id_kolloquium,4);

        $this->kolloqiumLabel[$id_kolloquium] = $semester == '01' ? 'FS ' . $year : 'HS ' . $year;
    }

    public function getKolloquiumLabel()
    {
        return $this->kolloqiumLabel;
    }





}