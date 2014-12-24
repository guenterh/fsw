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


class User extends BaseModel implements InputFilterAwareInterface {


    public $cat_password;
    public $cat_pass_enc;
    public $cat_username;
    public $college;
    public $created;
    public $email;
    public $firstname;
    public $home_library;
    public $id;
    public $lastname;
    public $major;
    public $password;
    public $pass_hash;
    public $username;
    public $verify_hash;

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
        return $this->firstname . ' ' . $this->lastname;
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

            /*
            $inputFilter->add(array(
                'name'     => 'email',
               // 'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));


            $inputFilter->add(array(
                'name'     => 'firstname',
               // 'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'lastname',
                //'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
            */

            $inputFilter->add(array(
                'name'     => 'username',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return mixed
     */
    public function getCatPassword()
    {
        return $this->cat_password;
    }

    /**
     * @param mixed $cat_password
     */
    public function setCatPassword($cat_password)
    {
        $this->cat_password = $cat_password;
    }

    /**
     * @return mixed
     */
    public function getCatPassEnc()
    {
        return $this->cat_pass_enc;
    }

    /**
     * @param mixed $cat_pass_enc
     */
    public function setCatPassEnc($cat_pass_enc)
    {
        $this->cat_pass_enc = $cat_pass_enc;
    }

    /**
     * @return mixed
     */
    public function getCatUsername()
    {
        return $this->cat_username;
    }

    /**
     * @param mixed $cat_username
     */
    public function setCatUsername($cat_username)
    {
        $this->cat_username = $cat_username;
    }

    /**
     * @return mixed
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * @param mixed $college
     */
    public function setCollege($college)
    {
        $this->college = $college;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
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
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getHomeLibrary()
    {
        return $this->home_library;
    }

    /**
     * @param mixed $home_library
     */
    public function setHomeLibrary($home_library)
    {
        $this->home_library = $home_library;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * @param mixed $major
     */
    public function setMajor($major)
    {
        $this->major = $major;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassHash()
    {
        return $this->pass_hash;
    }

    /**
     * @param mixed $pass_hash
     */
    public function setPassHash($pass_hash)
    {
        $this->pass_hash = $pass_hash;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getVerifyHash()
    {
        return $this->verify_hash;
    }

    /**
     * @param mixed $verify_hash
     */
    public function setVerifyHash($verify_hash)
    {
        $this->verify_hash = $verify_hash;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }





} 