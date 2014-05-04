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


class KolloquienController extends BaseController {


    public function indexAction () {

        $kolloquien = $this->facade->getKolloquien();


        //201201
        return new ViewModel(
            array(
                "kolloquien" => $kolloquien
            )

        );

    }

    public function insertKolloquienFSWAction () {


        $this->facade->insertKolloquienFSW();

    }


} 