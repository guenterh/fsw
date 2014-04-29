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

    protected $personExtended;
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
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->pers_email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->pers_email;
    }

    /**
     * @param mixed $pers_anrede
     */
    public function setPersAnrede($pers_anrede)
    {
        $this->pers_anrede = $pers_anrede;
    }

    /**
     * @return mixed
     */
    public function getPersAnrede()
    {
        return $this->pers_anrede;
    }

    /**
     * @param mixed $pers_changedate
     */
    public function setPersChangedate($pers_changedate)
    {
        $this->pers_changedate = $pers_changedate;
    }

    /**
     * @return mixed
     */
    public function getPersChangedate()
    {
        return $this->pers_changedate;
    }

    /**
     * @param mixed $pers_fullname
     */
    public function setPersFullname($pers_fullname)
    {
        $this->pers_fullname = $pers_fullname;
    }

    /**
     * @return mixed
     */
    public function getPersFullname()
    {
        return $this->pers_fullname;
    }

    /**
     * @param mixed $pers_id
     */
    public function setPersId($pers_id)
    {
        $this->pers_id = $pers_id;
    }

    /**
     * @return mixed
     */
    public function getPersId()
    {
        return $this->pers_id;
    }

    /**
     * @param mixed $pers_land
     */
    public function setPersLand($pers_land)
    {
        $this->pers_land = $pers_land;
    }

    /**
     * @return mixed
     */
    public function getPersLand()
    {
        return $this->pers_land;
    }

    /**
     * @param mixed $pers_midname
     */
    public function setPersMidname($pers_midname)
    {
        $this->pers_midname = $pers_midname;
    }

    /**
     * @return mixed
     */
    public function getPersMidname()
    {
        return $this->pers_midname;
    }

    /**
     * @param mixed $pers_name
     */
    public function setPersName($pers_name)
    {
        $this->pers_name = $pers_name;
    }

    /**
     * @return mixed
     */
    public function getPersName()
    {
        return $this->pers_name;
    }

    /**
     * @param mixed $pers_oldid
     */
    public function setPersOldid($pers_oldid)
    {
        $this->pers_oldid = $pers_oldid;
    }

    /**
     * @return mixed
     */
    public function getPersOldid()
    {
        return $this->pers_oldid;
    }

    /**
     * @param mixed $pers_ort
     */
    public function setPersOrt($pers_ort)
    {
        $this->pers_ort = $pers_ort;
    }

    /**
     * @return mixed
     */
    public function getPersOrt()
    {
        return $this->pers_ort;
    }

    /**
     * @param mixed $pers_plz
     */
    public function setPersPlz($pers_plz)
    {
        $this->pers_plz = $pers_plz;
    }

    /**
     * @return mixed
     */
    public function getPersPlz()
    {
        return $this->pers_plz;
    }

    /**
     * @param mixed $pers_sex
     */
    public function setPersSex($pers_sex)
    {
        $this->pers_sex = $pers_sex;
    }

    /**
     * @return mixed
     */
    public function getPersSex()
    {
        return $this->pers_sex;
    }

    /**
     * @param mixed $pers_strasse
     */
    public function setPersStrasse($pers_strasse)
    {
        $this->pers_strasse = $pers_strasse;
    }

    /**
     * @return mixed
     */
    public function getPersStrasse()
    {
        return $this->pers_strasse;
    }

    /**
     * @param mixed $pers_tel_mobile
     */
    public function setPersTelMobile($pers_tel_mobile)
    {
        $this->pers_tel_mobile = $pers_tel_mobile;
    }

    /**
     * @return mixed
     */
    public function getPersTelMobile()
    {
        return $this->pers_tel_mobile;
    }

    /**
     * @param mixed $pers_tel_privat
     */
    public function setPersTelPrivat($pers_tel_privat)
    {
        $this->pers_tel_privat = $pers_tel_privat;
    }

    /**
     * @return mixed
     */
    public function getPersTelPrivat()
    {
        return $this->pers_tel_privat;
    }

    /**
     * @param mixed $pers_titel
     */
    public function setPersTitel($pers_titel)
    {
        $this->pers_titel = $pers_titel;
    }

    /**
     * @return mixed
     */
    public function getPersTitel()
    {
        return $this->pers_titel;
    }

    /**
     * @param mixed $pers_titel_OLD
     */
    public function setPersTitelOLD($pers_titel_OLD)
    {
        $this->pers_titel_OLD = $pers_titel_OLD;
    }

    /**
     * @return mixed
     */
    public function getPersTitelOLD()
    {
        return $this->pers_titel_OLD;
    }

    /**
     * @param mixed $pers_uzhshortname
     */
    public function setPersUzhshortname($pers_uzhshortname)
    {
        $this->pers_uzhshortname = $pers_uzhshortname;
    }

    /**
     * @return mixed
     */
    public function getPersUzhshortname()
    {
        return $this->pers_uzhshortname;
    }

    /**
     * @param mixed $pers_vorname
     */
    public function setPersVorname($pers_vorname)
    {
        $this->pers_vorname = $pers_vorname;
    }

    /**
     * @return mixed
     */
    public function getPersVorname()
    {
        return $this->pers_vorname;
    }

    /**
     * @param mixed $pers_email
     */
    public function setPersEmail($pers_email)
    {
        $this->pers_email = $pers_email;
    }

    /**
     * @return mixed
     */
    public function getPersEmail()
    {
        return $this->pers_email;
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