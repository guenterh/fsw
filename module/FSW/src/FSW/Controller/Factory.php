<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 11:19 PM
 */

namespace FSW\Controller;

use FSW\Services\Facade\FacadeAwareInterface;
use Zend\ServiceManager\ServiceManager;

class Factory {


    public static function getPersonenController(ServiceManager $sm) {


        $pC = new \FSW\Controller\PersonenController();
        if ($pC instanceof FacadeAwareInterface)  {

            $pC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade'));

        }
        return $pC;
    }


    public static function getMedienController(ServiceManager $sm) {


        $uC = new \FSW\Controller\MedienController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\MedienFacade'));

        }
        return $uC;
    }


}