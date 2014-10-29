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


    private $jsonActions = array(
        'FSW\Controller\Kolloquien' => array('testValidKolloquium')
    );


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


    public function initJson ()
    {
        $this->events->attach(
            'render', array($this, 'registerJSONStrategy')
        );

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





    public function registerJSONStrategy($e) {



        $controller = $e->getRouteMatch()->getParam('controller');
        $action = $e->getRouteMatch()->getParam('action');

        //if (array_key_exists($controller, $this->jsonActions) && in_array($this->jsonActions, $action)) {
        if (array_key_exists($controller, $this->jsonActions) && in_array($action, $this->jsonActions[$controller]) ) {

            $serviceManager = $e->getApplication()->getServiceManager();
            $view = $serviceManager->get('Zend\View\View');
            $jsonStrategy = $serviceManager->get('ViewJsonStrategy');

            $view->getEventManager()->attach($jsonStrategy,100);
        }


    }




} 