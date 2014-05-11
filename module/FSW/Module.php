<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/10/13
 * Time: 10:39 PM
 */

namespace FSW;

use FSW\Services\HistSemDBServiceAwareInterface;
use Zend\Mvc\MvcEvent;




class Module {

    public function onBootstrap(MvcEvent $e)
    {
        $sM = $e->getApplication()->getServiceManager();
//        $controllerManager        = $sM->get('Zend\Mvc\Controller\ControllerManager');
        $controllerManager        = $sM->get('controllerloader');
        $controllerManager->addInitializer(

            function ($instance) use ($sM){

                if ($instance instanceof HistSemDBServiceAwareInterface) {
                    $dbService = $sM->get("HistSemDBService");
                    $instance->setHistSemDBService($dbService);
                }

            }

        );

    {
        $bootstrapper = new Bootstrapper($e);
        $bootstrapper->bootstrap();
    }

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(

            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),

            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function modulecheck ($e) {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller','');
        $test = __NAMESPACE__;
        if (0 !== strpos($controller,__NAMESPACE__)) {
            return;
            //not our module
        }

        $h = "";

    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'FSW\Model\MediumTable' =>  'FSW\Model\Factories\MediumTableFactory',
                //todo bessere namensgebung
                'FSW\Model\MedienTable' =>  'FSW\Model\Factories\MediumTableFactory',
                'MediumTableGateway' => 'FSW\Model\Factories\MediumTableGatewayFactory',

                'FSW\Table\PersonTable' => 'FSW\Services\Factory::getPersonFacade',
                'PersonTableGateway' => 'FSW\Services\Factory::getPersonTableGateway',


                'FSW\Model\KolloquiumTable' =>  'FSW\Model\Factories\KolloquiumTableFactory',
                'KolloquiumTableGateway' => 'FSW\Model\Factories\KolloquiumTableGatewayFactory',
                'FSW\Model\KolloqiumVeranstaltungTable' =>  'FSW\Model\Factories\KolloqiumVeranstaltungTableFactory',
                'KolloquiumVeranstaltungTableGateway' => 'FSW\Model\Factories\KolloquiumVeranstaltungTableGatewayFactory',
                'FSWPersonenExtendedAdapter' => 'FSW\Model\Factories\DB\PersonenExtendedAdapterFactory',
                'HistSemDBService'          =>  'FSW\Model\Factories\HistSemDBServiceFactory',
                'HistSemDBAdapter'          =>  'FSW\Model\Factories\DB\HistSemDBAdapterFactory',


                //'FSW\Services\Facade\ForschungFacade'    =>  'FSW\Services\Factory::getAktivitaetFassade',
                //'ForschungTableGateway'          =>  'FSW\Services\Factory::getAktivitaetTableGateway'
            ),
        );
    }

}