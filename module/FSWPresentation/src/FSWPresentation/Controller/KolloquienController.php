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



class KolloquienController extends BaseController {


    protected $mediumTable;
    protected $personTable;

    public function showAction()
    {

        $id = $this->params()->fromRoute('id',0);

        return new ViewModel(array(
            'kolloquienWithDpendencies' => $this->facade->getKolloquiumWithDependencies($id)
        ));

    }

    public function allPersonenKolloquienAction ()
    {
        $test = "";
        return new ViewModel(array(
            'personenZuKolloquien' => $this->facade->getPersonenZuKolloquien()
        ));

    }

}