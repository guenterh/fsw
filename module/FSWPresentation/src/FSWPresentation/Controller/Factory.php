<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 11:19 PM
 */

namespace FSWPresentation\Controller;

use FSW\Services\Facade\FacadeAwareInterface;
use Zend\ServiceManager\ServiceManager;

class Factory {



    public static function getPublicationsController(ServiceManager $sm) {

        $pC = new \FSWPresentation\Controller\PublicationsController();
        if ($pC instanceof FacadeAwareInterface)  {

            $pC->setFacadeService($sm->getServiceLocator()->get('FSWPresentation\Services\Facade\PublicationsFacade'));

        }
        return $pC;

    }



}