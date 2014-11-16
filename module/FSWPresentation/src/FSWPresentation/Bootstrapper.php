<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 11.04.14
 * Time: 00:00
 */

namespace FSWPresentation;
use Zend\Mvc\MvcEvent;



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


    }





} 