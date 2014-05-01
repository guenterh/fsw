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


class Person extends BaseModel implements InputFilterAwareInterface {

    public $pers_id;
    public $pers_uzhshortname;
    public $pers_name;
    public $pers_midname;
    public $pers_vorname;
    public $pers_fullname;
    public $pers_anrede;
    public $pers_titel;
    public $pers_titel_OLD;
    public $pers_strasse;
    public $pers_plz;
    public $pers_ort;
    public $pers_land;
    public $pers_tel_privat;
    public $pers_tel_mobile;
    public $pers_email;
    public $pers_sex;
    public $pers_changedate;
    public $pers_oldid;

    protected $personExtended = array();
    protected $zoraAuthors = array();




    //public $mit_id;
    //public $name;
    //public $txt;
    //public $email;
    //public $bild;
    //public $typ;
    //public $lehrstuhl;
    //public $login;
    //public $pwd;
    //public $status;
    //public $info_liz;
    //public $info_liz_pruef;
    //public $profilURL;

    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getID() {
        return $this->pers_id;
    }

    public function getListLabel() {
        return $this->pers_vorname . ' ' . $this->pers_name;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'pers_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'pers_uzhshortname',
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
                            'max'      => 10,
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
                'name'     => 'pers_name',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'pers_midname',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'pers_vorname',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param mixed $pers_anrede
     */
    public function setPers_anrede($pers_anrede)
    {
        $this->pers_anrede = $pers_anrede;
    }

    /**
     * @return mixed
     */
    public function getPers_anrede()
    {
        return $this->pers_anrede;
    }

    /**
     * @param mixed $pers_changedate
     */
    public function setPers_changedate($pers_changedate)
    {
        $this->pers_changedate = $pers_changedate;
    }

    /**
     * @return mixed
     */
    public function getPers_changedate()
    {
        return $this->pers_changedate;
    }

    /**
     * @param mixed $pers_email
     */
    public function setPers_email($pers_email)
    {
        $this->pers_email = $pers_email;
    }

    /**
     * @return mixed
     */
    public function getPers_email()
    {
        return $this->pers_email;
    }

    /**
     * @param mixed $pers_fullname
     */
    public function setPers_fullname($pers_fullname)
    {
        $this->pers_fullname = $pers_fullname;
    }

    /**
     * @return mixed
     */
    public function getPers_fullname()
    {
        return $this->pers_fullname;
    }

    /**
     * @param mixed $pers_id
     */
    public function setPers_id($pers_id)
    {
        $this->pers_id = $pers_id;
    }

    /**
     * @return mixed
     */
    public function getPers_id()
    {
        return $this->pers_id;
    }

    /**
     * @param mixed $pers_land
     */
    public function setPers_land($pers_land)
    {
        $this->pers_land = $pers_land;
    }

    /**
     * @return mixed
     */
    public function getPers_land()
    {
        return $this->pers_land;
    }

    /**
     * @param mixed $pers_midname
     */
    public function setPers_midname($pers_midname)
    {
        $this->pers_midname = $pers_midname;
    }

    /**
     * @return mixed
     */
    public function getPers_midname()
    {
        return $this->pers_midname;
    }

    /**
     * @param mixed $pers_name
     */
    public function setPers_name($pers_name)
    {
        $this->pers_name = $pers_name;
    }

    /**
     * @return mixed
     */
    public function getPers_name()
    {
        return $this->pers_name;
    }

    /**
     * @param mixed $pers_oldid
     */
    public function setPers_oldid($pers_oldid)
    {
        $this->pers_oldid = $pers_oldid;
    }

    /**
     * @return mixed
     */
    public function getPers_oldid()
    {
        return $this->pers_oldid;
    }

    /**
     * @param mixed $pers_ort
     */
    public function setPers_ort($pers_ort)
    {
        $this->pers_ort = $pers_ort;
    }

    /**
     * @return mixed
     */
    public function getPers_ort()
    {
        return $this->pers_ort;
    }

    /**
     * @param mixed $pers_plz
     */
    public function setPers_plz($pers_plz)
    {
        $this->pers_plz = $pers_plz;
    }

    /**
     * @return mixed
     */
    public function getPers_plz()
    {
        return $this->pers_plz;
    }

    /**
     * @param mixed $pers_sex
     */
    public function setPers_sex($pers_sex)
    {
        $this->pers_sex = $pers_sex;
    }

    /**
     * @return mixed
     */
    public function getPers_sex()
    {
        return $this->pers_sex;
    }

    /**
     * @param mixed $pers_strasse
     */
    public function setPers_strasse($pers_strasse)
    {
        $this->pers_strasse = $pers_strasse;
    }

    /**
     * @return mixed
     */
    public function getPers_strasse()
    {
        return $this->pers_strasse;
    }

    /**
     * @param mixed $pers_tel_mobile
     */
    public function setPers_tel_mobile($pers_tel_mobile)
    {
        $this->pers_tel_mobile = $pers_tel_mobile;
    }

    /**
     * @return mixed
     */
    public function getPers_tel_mobile()
    {
        return $this->pers_tel_mobile;
    }

    /**
     * @param mixed $pers_tel_privat
     */
    public function setPers_tel_privat($pers_tel_privat)
    {
        $this->pers_tel_privat = $pers_tel_privat;
    }

    /**
     * @return mixed
     */
    public function getPers_tel_privat()
    {
        return $this->pers_tel_privat;
    }

    /**
     * @param mixed $pers_titel
     */
    public function setPers_titel($pers_titel)
    {
        $this->pers_titel = $pers_titel;
    }

    /**
     * @return mixed
     */
    public function getPers_titel()
    {
        return $this->pers_titel;
    }

    /**
     * @param mixed $pers_titel_OLD
     */
    public function setPers_titel_OLD($pers_titel_OLD)
    {
        $this->pers_titel_OLD = $pers_titel_OLD;
    }

    /**
     * @return mixed
     */
    public function getPers_titel_OLD()
    {
        return $this->pers_titel_OLD;
    }

    /**
     * @param mixed $pers_uzhshortname
     */
    public function setPers_uzhshortname($pers_uzhshortname)
    {
        $this->pers_uzhshortname = $pers_uzhshortname;
    }

    /**
     * @return mixed
     */
    public function getPers_uzhshortname()
    {
        return $this->pers_uzhshortname;
    }

    /**
     * @param mixed $pers_vorname
     */
    public function setPers_vorname($pers_vorname)
    {
        $this->pers_vorname = $pers_vorname;
    }

    /**
     * @return mixed
     */
    public function getPers_vorname()
    {
        return $this->pers_vorname;
    }

    /**
     * @param mixed $personExtended
     */
    public function setPersonExtended($personExtended)
    {
        $this->personExtended = $personExtended;
    }

    /**
     * @return mixed
     */
    public function getPersonExtended()
    {
        return $this->personExtended;
    }

    /**
     * @param array $zoraAuthors
     */
    public function setZoraAuthors($zoraAuthors)
    {
        $this->zoraAuthors = $zoraAuthors;
    }

    /**
     * @return array
     */
    public function getZoraAuthors()
    {
        return $this->zoraAuthors;
    }






} 