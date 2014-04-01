<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/10/13
 * Time: 10:39 PM
 */

namespace FSW;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;




class Module {

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $app =  $e->getParam('application');
        $app->getEventManager()->attach('route',array($this,"modulecheck"),-100);
        $t = "";

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
                'FSW\Model\KolloquiumTable' =>  'FSW\Model\Factories\KolloquiumTableFactory',
                'KolloquiumTableGateway' => 'FSW\Model\Factories\KolloquiumTableGatewayFactory',
                'FSW\Model\KolloqiumVeranstaltungTable' =>  'FSW\Model\Factories\KolloqiumVeranstaltungTableFactory',
                'KolloquiumVeranstaltungTableGateway' => 'FSW\Model\Factories\KolloquiumVeranstaltungTableGatewayFactory',
                'FSWPersonenExtendedAdapter' => 'FSW\Model\Factories\DB\PersonenExtendedAdapterFactory',
                'HistSemDBService'          =>  'FSW\Model\Factories\HistSemDBServiceFactory',
                'HistSemDBAdapter'          =>  'FSW\Model\Factories\DB\HistSemDBAdapterFactory',


            ),
        );
    }



} 