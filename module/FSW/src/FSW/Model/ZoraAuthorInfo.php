<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 17.11.14
 * Time: 22:42
 */

namespace FSW\Model;


class ZoraAuthorInfo {


    private $zora_name;
    private $zora_name_customized;
    private $profilURL;
    private $id;


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
    public function getProfilURL()
    {
        $url = preg_replace("/&?extern=true/","",$this->profilURL);
        return $url;

    }

    public function isSetProfilURL()
    {
        return !is_null($this->profilURL) && strlen($this->profilURL) > 0 ? true : false;
    }


    /**
     * @param mixed $profilURL
     */
    public function setProfilURL($profilURL)
    {
        $this->profilURL = $profilURL;
    }


    public function exchangeArray($data)
    {
        if (is_object($data)) {
            $data = $data->getArrayCopy();
        }

        $this->initLocalVariables($data);
    }

    protected function initLocalVariables(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getZoraName()
    {
        return $this->zora_name;
    }

    /**
     * @param mixed $zora_name
     */
    public function setZoraName($zora_name)
    {
        $this->zora_name = $zora_name;
    }

    /**
     * @return mixed
     */
    public function getZoraNameCustomized()
    {
        return $this->zora_name_customized;
    }

    /**
     * @param mixed $zora_name_customized
     */
    public function setZoraNameCustomized($zora_name_customized)
    {
        $this->zora_name_customized = $zora_name_customized;
    }

} 