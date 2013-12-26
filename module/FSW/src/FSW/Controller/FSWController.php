<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/19/13
 * Time: 11:59 PM
 */

namespace FSW\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\EventManager\EventManager;
use Zend\EventManager\StaticEventManager;
use Zend\EventManager\SharedEventManager;

use Zend\EventManager\Event;

class MyClass {}
class MyClass1 {}


class FSWController extends AbstractActionController {

    public function indexAction()
    {

        $myEvent = new Event();

        //new SharedEventManager();

        $sEM = StaticEventManager::getInstance();
        $t = __CLASS__;
        //$sEM->attach(__CLASS__,$myEvent,array($this,'halloIhr'),100);
        $sEM->attach(__CLASS__,"halloIhr",function ($e) {

            //print "angekommen";

        },100);

        $sEM->attach(__CLASS__,"jetztNeu",array($this,"halloIhr"),100);
        //$sEM->attach(__CLASS__,"jetztNeu",array('FSW\Controller\FSWController','halloIhr2'),101);
        //warum das geht? - das weiss wohl nur PHP
        $sEM->attach(__CLASS__,"jetztNeu",array($this,'halloIhr2'),105);
        $sEM->attach(__CLASS__,"jetztNeu",'FSW\Controller\FSWController::halloIhr3',107);



        $events = new EventManager(__CLASS__);
        $events->attach('do', function ($e) {

            $event = $e->getName();
            $params = $e->getParams();



            $target = $e->getTarget();

            $mytype = is_object($target) ? get_class($target) : gettype($target);

            //printf('Handled event "%s" with params %s ',
            //        $event,
            //        json_encode($params)
            //);

        });

        $params = array("foo" => "foo", "bar" => "bar");
        $events->trigger("do", 10,$params);
        $events->trigger('halloIhr',null,array("eins" => "zwei"));
        $events->trigger('jetztNeu',null,array("eins" => "zwei"),function ($result) {
            return $result instanceof MyClass;
        });



        return new ViewModel();
    }

    public function halloIhr() {

        //echo "here we are";

    }

    public static function halloIhr2() {

        //echo "here we are static";
        return new MyClass1();

    }

    public static function halloIhr3() {

        return new MyClass();

    }


} 