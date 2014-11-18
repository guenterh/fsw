<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 17.11.14
 * Time: 22:42
 */

namespace FSW\Model;


class PersonenInfo {


    private $nachName;
    private $vorName;
    private $profilURL;
    private $id;
    private $extendedId;

    /**
     * @return mixed
     */
    public function getExtendedId()
    {
        return $this->extendedId;
    }

    /**
     * @param mixed $extendedId
     */
    public function setExtendedId($extendedId)
    {
        $this->extendedId = $extendedId;
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
    public function getNachName()
    {
        return $this->nachName;
    }

    /**
     * @param mixed $nachName
     */
    public function setNachName($nachName)
    {
        $this->nachName = $nachName;
    }

    /**
     * @return mixed
     */
    public function getProfilURL()
    {
        return $this->profilURL;
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
    public function getVorName()
    {
        return $this->vorName;
    }

    /**
     * @param mixed $vorName
     */
    public function setVorName($vorName)
    {
        $this->vorName = $vorName;
    }




} 