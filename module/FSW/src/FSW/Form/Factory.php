<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 26.11.14
 * Time: 21:06
 */

namespace FSW\Form;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class Factory {




    public static function getPersonCoreFieldset(ServiceManager $sm) {


        //brauch ich hier noch weitere Informationen?

        $pR = $sm->get('PersonRolleFieldset');
        return new PersonCoreFieldset($pR);
    }


    public static function getPersonRolleFieldset(ServiceManager $sm) {

        $facade = $sm->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade');

        $abteilungen =  $facade->getAbteilungValues();
        $funktionen = $facade->getFunktionenValues();
        $rf = new PersonRolleFieldset($abteilungen,$funktionen);
        $rf->setName('rolle');
        return $rf;
    }

    public static function getQualifikationsarbeitFieldset(ServiceManager $sm) {

        $facade = $sm->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade');

        $arollPersonInfo =  $facade->getRollIdPersonenValues();
        $rf = new ForschungFieldset("forschung",$arollPersonInfo);

        return $rf;

    }


}