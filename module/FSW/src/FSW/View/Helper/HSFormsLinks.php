<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/15/14
 * Time: 9:21 PM
 */

namespace FSW\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Config\Config;


class HSFormsLinks extends AbstractHelper {



    private $HSFormsUrlConfig;

    public function __construct(Config $config) {

        $this->HSFormsUrlConfig = $config;
    }



    /**
     * Merge author fields to a single list with urls
     *
     * @param    Array    $authors
     * @return    Array[]
     */
    public function __invoke()
    {

        return $this;
    }

    public function getQarbeitEdit($qarbID) {

        $url =  preg_replace('/{qarbId}/',$qarbID,$this->HSFormsUrlConfig->editQA);
        return $url;
    }


    public function getQarbeitNew($qarbID) {

        return $this->HSFormsUrlConfig->newQA;
    }


    public function getRollEdit($rollID) {

        $url =  preg_replace('/{rollId}/',$rollID,$this->HSFormsUrlConfig->editRolle);
        return $url;
    }

    public function getRollNew() {

        return $this->HSFormsUrlConfig->newRolle;    }

    public function getPersonEdit($personID) {

        $url =  preg_replace('/{persId}/',$personID,$this->HSFormsUrlConfig->editPerson);
        return $url;
    }

    public function getPersonNew() {

        return $this->HSFormsUrlConfig->newPerson;
    }


}