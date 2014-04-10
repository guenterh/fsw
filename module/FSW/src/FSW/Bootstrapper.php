<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 11.04.14
 * Time: 00:00
 */

namespace FSW;
use Zend\Console\Console, Zend\Mvc\MvcEvent, Zend\Mvc\Router\Http\RouteMatch;

class Bootstrapper {

    public function __construct(MvcEvent $event)
    {
        $this->event = $event;
        $this->events = $event->getApplication()->getEventManager();
    }


    /**
     * Bootstrap all necessary resources.
     *
     * @return void
     */
    public function bootstrap()
    {
        // automatically call all methods starting with "init":
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (substr($method, 0, 4) == 'init') {
                $this->$method();
            }
        }
    }


    /**
     * Set up configuration manager.
     *
     * @return void
     */
    protected function initConfig()
    {
        // Create the configuration manager:
        $app = $this->event->getApplication();
        $serviceManager = $app->getServiceManager();
        $config = $app->getConfig();
        $cfg = new \Zend\ServiceManager\Config($config['fsw']['config_reader']);
        $serviceManager->setService(
            'FSW\Config', new \FSW\Services\Config\PluginManager($cfg)
        );

        // Use the manager to load the configuration used in subsequent init methods:
        //$this->config = $serviceManager->get('VuFind\Config')->get('config');
    }




} 