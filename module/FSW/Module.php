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


} 