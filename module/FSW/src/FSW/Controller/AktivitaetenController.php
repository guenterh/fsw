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

        //http://localhost:30000/aktivitaeten/27?aktivitaetentyp[]=Dissertation&aktivitaetentyp[]=Lizentiatsarbeit
        //http://localhost:30000/aktivitaeten?aktivitaetentyp[]=Dissertation&aktivitaetentyp[]=Lizentiatsarbeit

        $mitid = $this->getEvent()->getRouteMatch()->getParam("mitid");
        $aktivitaetentyp = $this->params()->fromQuery("aktivitaetentyp");

        $mitid = !is_null($mitid) ? $mitid : 0;
        $aktivitaetentyp = !is_null($aktivitaetentyp) ? $aktivitaetentyp : array();

        $aktivitaetenFacade = $this->histSemDBService->getAktivitaetFacade();

        //$t = array('Lizentiatsarbeit');
        $result = $aktivitaetenFacade->getActivities($aktivitaetentyp,$mitid);
        $simpleList = $this->toList($result);
        $model = array('items' => $simpleList);
        return new ViewModel($model);

    }

} 