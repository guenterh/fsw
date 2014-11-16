<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/10/13
 * Time: 10:39 PM
 */

namespace FSWPresentation;
use Zend\Mvc\MvcEvent;



class Module {

    public function onBootstrap(MvcEvent $e)
    {

        $bootstrapper = new Bootstrapper($e);
        $bootstrapper->bootstrap();

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

}