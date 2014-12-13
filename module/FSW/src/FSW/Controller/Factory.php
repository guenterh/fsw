<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 11:19 PM
 */

namespace FSW\Controller;

use FSW\Controller\AuthenticationController;
use FSW\Services\Facade\FacadeAwareInterface;
use FSW\Services\FSWConfigAwareInterface;
use Zend\ServiceManager\ServiceManager;

class Factory {



    private static function checkConfigAwareInterface($object, ServiceManager $sm) {

        if ($object instanceof FSWConfigAwareInterface)  {

            $object->setFSWConfigService($sm->getServiceLocator()->get('FSW\Config'));

        }
        return $object;

    }


    public static function getPersonenController(ServiceManager $sm) {


        $pC = new \FSW\Controller\PersonenController();
        if ($pC instanceof FacadeAwareInterface)  {

            $pC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade'));

        }
        return static::checkConfigAwareInterface($pC, $sm);
    }

    public static function getPublicationsController(ServiceManager $sm) {

        $pC = new \FSW\Controller\PublicationsController();
        if ($pC instanceof FacadeAwareInterface)  {

            $pC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\PublicationsFacade'));

        }
        return static::checkConfigAwareInterface($pC, $sm);

    }


    public static function getMedienController(ServiceManager $sm) {


        $uC = new \FSW\Controller\MedienController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\MedienFacade'));

        }
        return static::checkConfigAwareInterface($uC, $sm);
    }



    public static function getKolloquienController(ServiceManager $sm) {


        $uC = new \FSW\Controller\KolloquienController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('KolloquienFacade'));

        }
        return static::checkConfigAwareInterface($uC, $sm);
    }

    public static function getForschungController(ServiceManager $sm) {


        $uC = new \FSW\Controller\ForschungController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\ForschungFacade'));

        }
        return static::checkConfigAwareInterface($uC, $sm);
    }

    public static function getPersonAktivitaetController(ServiceManager $sm) {


        $uC = new \FSW\Controller\PersonenAktivitaetenController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\PersonenAktivitaetFacade'));

        }
        return static::checkConfigAwareInterface($uC, $sm);
    }

    public static function getLehrveranstaltungenController(ServiceManager $sm) {

        $uC = new \FSW\Controller\LehrveranstaltungController();
        if ($uC instanceof FacadeAwareInterface)  {

            $uC->setFacadeService($sm->getServiceLocator()->get('LehrveranstaltungenFacade'));

        }
        return static::checkConfigAwareInterface($uC, $sm);

    }

    public static function getBackendLoginController(ServiceManager $sm) {

        $uC = new \FSW\Controller\LoginController();
        //if ($uC instanceof FacadeAwareInterface)  {

        //    $uC->setFacadeService($sm->getServiceLocator()->get('LehrveranstaltungenFacade'));

        //}
        return static::checkConfigAwareInterface($uC, $sm);

    }

    public static function getHarvesterController(ServiceManager $sm) {

        $uC = new \FSW\Controller\HarvestController();
        //if ($uC instanceof FacadeAwareInterface)  {

        //    $uC->setFacadeService($sm->getServiceLocator()->get('LehrveranstaltungenFacade'));

        //}
        return static::checkConfigAwareInterface($uC, $sm);

    }











}