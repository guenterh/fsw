<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 10:03 PM
 */

namespace FSW\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class KolloquienController extends AbstractActionController {


    public function indexAction () {


        return new ViewModel(
            array(
                "hello" => "hello"
            )

        );

    }

} 