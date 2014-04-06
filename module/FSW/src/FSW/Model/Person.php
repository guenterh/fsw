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


    public $mit_id;
    public $name;
    public $txt;
    public $email;
    public $bild;
    public $typ;
    public $lehrstuhl;
    public $login;
    public $pwd;
    public $status;
    public $info_liz;
    public $info_liz_pruef;
    public $profilURL;

    protected $inputFilter;


    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getID() {
        return $this->mit_id;
    }

    public function getListLabel() {
        return $this->name;    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param mixed $bild
     */
    public function setBild($bild)
    {
        $this->bild = $bild;
    }

    /**
     * @return mixed
     */
    public function getBild()
    {
        return $this->bild;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $info_liz
     */
    public function setInfoLiz($info_liz)
    {
        $this->info_liz = $info_liz;
    }

    /**
     * @return mixed
     */
    public function getInfoLiz()
    {
        return $this->info_liz;
    }

    /**
     * @param mixed $info_liz_pruef
     */
    public function setInfoLizPruef($info_liz_pruef)
    {
        $this->info_liz_pruef = $info_liz_pruef;
    }

    /**
     * @return mixed
     */
    public function getInfoLizPruef()
    {
        return $this->info_liz_pruef;
    }

    /**
     * @param mixed $lehrstuhl
     */
    public function setLehrstuhl($lehrstuhl)
    {
        $this->lehrstuhl = $lehrstuhl;
    }

    /**
     * @return mixed
     */
    public function getLehrstuhl()
    {
        return $this->lehrstuhl;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $mit_id
     */
    public function setMitId($mit_id)
    {
        $this->mit_id = $mit_id;
    }

    /**
     * @return mixed
     */
    public function getMitId()
    {
        return $this->mit_id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $profilURL
     */
    public function setProfilURL($profilURL)
    {
        $this->profilURL = $profilURL;
    }

    /**
     * @return mixed
     */
    public function getProfilURL()
    {
        return $this->profilURL;
    }

    /**
     * @param mixed $pwd
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     * @return mixed
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $txt
     */
    public function setTxt($txt)
    {
        $this->txt = $txt;
    }

    /**
     * @return mixed
     */
    public function getTxt()
    {
        return $this->txt;
    }

    /**
     * @param mixed $typ
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;
    }

    /**
     * @return mixed
     */
    public function getTyp()
    {
        return $this->typ;
    }




} 