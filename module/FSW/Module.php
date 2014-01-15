<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/10/13
 * Time: 10:39 PM
 */

namespace FSW;

use FSW\Model\Kolloqium;
use FSW\Model\KolloqiumTable;
use FSW\Model\KolloqiumVeranstaltungTable;
use FSW\Model\Veranstaltung;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use FSW\Model\Medium;
use FSW\Model\MediumTable;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;



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
                'FSW\Model\MediumTable' =>  function($sm) {
                        $tableGateway = $sm->get('MediumTableGateway');
                        $table = new MediumTable($tableGateway);
                        return $table;
                    },
                'MediumTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Medium());
                        return new TableGateway('medien', $dbAdapter, null, $resultSetPrototype);
                    },
                'FSW\Model\KolloquiumTable' =>  function($sm) {
                        $tableGateway = $sm->get('KolloquiumTableGateway');
                        $table = new KolloqiumTable($tableGateway);
                        return $table;
                    },
                'KolloquiumTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Kolloqium());
                        return new TableGateway('kolloquium', $dbAdapter, null, $resultSetPrototype);
                    },
                'FSW\Model\KolloqiumVeranstaltungTable' =>  function($sm) {
                        $tableGateway = $sm->get('KolloquiumVeranstaltungTableGateway');
                        $table = new KolloqiumVeranstaltungTable($tableGateway);
                        return $table;
                    },
                'KolloquiumVeranstaltungTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Veranstaltung());
                        return new TableGateway('kolloquium_veranstaltung', $dbAdapter, null, $resultSetPrototype);
                    },



            ),
        );
    }



} 