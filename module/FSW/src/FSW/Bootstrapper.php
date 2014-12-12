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

    /*
     * MVCEvent
     * @var Zend\Mvc\MvcEvent
     */
    protected $event;


    /*
     * EventManager
     * @var Zend\EventManager\EventManager
     */
    protected $events;

    protected $config;


    private $jsonActions = array(
        'FSW\Controller\Kolloquien' => array('testValidKolloquium',
                                            'addSaveKolloquium',
                                            'deleteKolloquium',
                                            'deleteVeranstaltung'),
        'FSW\Controller\Lehrveranstaltungen'    =>  array(
                                            'deletePerson',
                                            'deleteLehrveranstaltung'

                                        ),
        'FSW\Controller\Personen'    =>  array(
                                            'deleteZoraAuthor'
                                        )
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

        $this->config = $serviceManager->get('FSW\Config')->get('config');
        // Use the manager to load the configuration used in subsequent init methods:
        //$this->config = $serviceManager->get('VuFind\Config')->get('config');
    }




    public function initJson ()
    {

        $this->events->attach(
            'render', array($this, 'registerJSONStrategy')
        );

    }



    public function registerJSONStrategy($e) {


        if (!is_null($e->getRouteMatch())) {

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

    protected function initSession()
    {
        // Don't bother with session in CLI mode (it just causes error messages):
        if (Console::isConsole()) {
            return;
        }

        // Get session configuration:
        if (!isset($this->config->Session->type)) {
            throw new \Exception('Cannot initialize session; configuration missing');
        }

        // Set up the session handler by retrieving all the pieces from the service
        // manager and injecting appropriate dependencies:
        $serviceManager = $this->event->getApplication()->getServiceManager();
        $sessionManager = $serviceManager->get('FSW\SessionManager');
        $sessionPluginManager = $serviceManager->get('FSW\SessionPluginManager');
        $sessionHandler = $sessionPluginManager->get($this->config->Session->type);
        $sessionHandler->setConfig($this->config->Session);
        $sessionManager->setSaveHandler($sessionHandler);

        // Start up the session:
        $sessionManager->start();

        // According to the PHP manual, session_write_close should always be
        // registered as a shutdown function when using an object as a session
        // handler: http://us.php.net/manual/en/function.session-set-save-handler.php
        register_shutdown_function(
            function () use ($sessionManager) {
                // If storage is immutable, the session is already closed:
                if (!$sessionManager->getStorage()->isImmutable()) {
                    $sessionManager->writeClose();
                }
            }
        );

        // Make sure account credentials haven't expired:
        $serviceManager->get('FSW\AuthManager')->checkForExpiredCredentials();
    }





} 