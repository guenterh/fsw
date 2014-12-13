<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 11:19 PM
 */

namespace FSWPresentation\Controller;

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


    public static function getPublicationsController(ServiceManager $sm) {

        $pC = new PublicationsController();
        if ($pC instanceof FacadeAwareInterface)  {

            $pC->setFacadeService($sm->getServiceLocator()->get('FSWPresentation\Services\Facade\PublicationsFacade'));

        }
        return static::checkConfigAwareInterface($pC, $sm);

    }

    public static function getMedienController(ServiceManager $sm) {

        $mC = new MedienController();

        if ($mC instanceof FacadeAwareInterface) {

            $mC->setFacadeService($sm->getServiceLocator()->get('FSW\Services\Facade\MedienFacade'));

        }

        return static::checkConfigAwareInterface($mC, $sm);
    }


    public static function getKolloquienController(ServiceManager $sm) {

        $mC = new KolloquienController();

        if ($mC instanceof FacadeAwareInterface) {

            $mC->setFacadeService($sm->getServiceLocator()->get('KolloquienFacade'));

        }

        return static::checkConfigAwareInterface($mC, $sm);

    }



    public static function getLehrveranstaltungController(ServiceManager $sm) {

        $mC = new LehrveranstaltungController();

        if ($mC instanceof FacadeAwareInterface) {

            $mC->setFacadeService($sm->getServiceLocator()->get('LehrveranstaltungenFacade'));

        }

        return static::checkConfigAwareInterface($mC, $sm);

    }

    public static function getQArbController(ServiceManager $sm) {

        $qarbC = new QArbController();

        if ($qarbC instanceof FacadeAwareInterface) {

            $qarbC->setFacadeService($sm->getServiceLocator()->get('FSWPresentation\Services\Facade\QArbFacade'));

        }

        return static::checkConfigAwareInterface($qarbC, $sm);
    }



}