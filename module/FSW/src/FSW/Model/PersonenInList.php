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


class PersonenInList extends Person {


    public $idExtended = null;
    public $profilURL = null;
    public $fullname = null;

    /**
     * @return null
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param null $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return null
     */
    public function getId_extended()
    {
        return $this->idExtended;
    }

    /**
     * @param null $idExtended
     */
    public function setId_extended($idExtended)
    {
        $this->idExtended = $idExtended;
    }

    /**
     * @return null
     */
    public function setProfilURL($profilURL)
    {
        return $this->profilURL = $profilURL;
    }

    /**
     * @param null $profilURL
     */
    public function getProfilURL()
    {
        return $this->profilURL;
    }

    public function markListItem() {
        return !is_null($this->idExtended)?true: false;
    }




} 