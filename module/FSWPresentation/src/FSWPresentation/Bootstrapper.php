<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 11.04.14
 * Time: 00:00
 */

namespace FSWPresentation;
use FSWPresentation\Controller\QArbController;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use FSWPresentation\Controller\LehrveranstaltungController;
use FSWPresentation\Controller\KolloquienController;



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



        $app = $this->event->getApplication();
        $em = $app->getEventManager();
        $sm = $em->getSharedManager();
        //wechsle das layout im Falle der Praesentation in Oberfläche
        $sm->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) {
            $controller = $e->getTarget();
            if ($controller instanceof LehrveranstaltungController ||
                $controller instanceof QArbController ) {
                $controller->layout()->setTemplate("presentation/layoutlv");
            } elseif ($controller instanceof KolloquienController) {

                $controller->layout()->setTemplate("presentation/layoutkolloquien");
            } else {
                $controller->layout()->setTemplate("presentation/layout");
            }
            //nicht noetig aufgrund der namespace Angabe nachgehen!
            //$routeName = $e->getRouteMatch()->getMatchedRouteName();
            //if (preg_match('{presentation/}',$routeName,$matches)) {}

        });
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($em);




    }





} 