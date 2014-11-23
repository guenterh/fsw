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



class QArbController extends BaseController {


    protected $mediumTable;
    protected $personTable;

    public function showAction()
    {

        $queryParams = $this->params()->fromQuery();
      //$this->layout()->setTemplate("presentation/layout");

        return new ViewModel(array(
            'qArbeiten' => $this->facade->getQArbeiten($queryParams),
            'all' => array_key_exists('betreuer',$queryParams)
        ));

    }

}