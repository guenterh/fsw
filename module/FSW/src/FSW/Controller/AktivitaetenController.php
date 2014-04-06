<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 06.04.14
 * Time: 16:15
 */

namespace FSW\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AktivitaetenController extends BaseController {



    /**
     * @return ViewModel
     */
    public function indexAction() {


        $aktivitaetentyp = $this->getEvent()->getRouteMatch()->getParam("aktivitaetentyp");
        $mitid = $this->getEvent()->getRouteMatch()->getParam("mitid");

        $aktivitaeten = $this->histSemDBService->getAktivitaetFacade();
        $all = $aktivitaeten->find(null,1000);

        return new ViewModel();

    }

} 