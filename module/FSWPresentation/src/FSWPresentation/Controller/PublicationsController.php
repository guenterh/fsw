<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/19/13
 * Time: 11:59 PM
 */

namespace FSWPresentation\Controller;

use Zend\View\Model\ViewModel;
use FSW\Controller\BaseController;



class PublicationsController extends BaseController {


    protected $mediumTable;
    protected $personTable;

    public function showAction()
    {

        $params = $this->params()->fromQuery();


        //$this->layout()->setTemplate("presentation/layout");

        return new ViewModel(array(
            'zoraDocs' => $this->facade->getPublications($params)
        ));

    }

}