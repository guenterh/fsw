<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 06.04.14
 * Time: 16:15
 */

namespace FSW\Controller;


use FSW\Form\ForschungFieldset;
use FSW\Form\ForschungForm;
use FSW\Model\PersonForschungUebersicht;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ForschungController extends BaseController {



    /**
     * @return ViewModel
     */
    public function indexAction() {

        //http://localhost:30000/aktivitaeten/27?aktivitaetentyp[]=Dissertation&aktivitaetentyp[]=Lizentiatsarbeit
        //http://localhost:30000/aktivitaeten?aktivitaetentyp[]=Dissertation&aktivitaetentyp[]=Lizentiatsarbeit

        /*
        $mitid = $this->getEvent()->getRouteMatch()->getParam("mitid");
        $forschungstyp = $this->params()->fromQuery("forschungstyp");

        $mitid = !is_null($mitid) ? $mitid : 0;
        $forschungstyp = !is_null($forschungstyp) ? $forschungstyp : array();



        //$t = array('Lizentiatsarbeit');
        //$result = $aktivitaetenFacade->getForschungen($forschungstyp,$mitid);

        $result = $this->facade->getFSWPersonen();

        $simpleList = $this->toList($result);
        $model = array('items' => $simpleList);
        return new ViewModel($model);
        */

        return new ViewModel(array(
            'forschung' => $this->facade->getFSWPersonen()

        ));

    }

    public function editAction()
    {


        $pers_id = (int)$this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if (!$pers_id) {
            return $this->redirect()->toRoute('forschung');
        }

        $forschungstypen = array('Lizentiatsarbeit','Masterarbeit');
        $params = compact('pers_id','forschungstypen');

        $lizz_master = $this->facade->getForschungen($params);

        $forschungstypen = array('Dissertation');
        $params = compact('pers_id','forschungstypen');

        $dissertations = $this->facade->getForschungen($params);

        $forschungUebersicht =  new PersonForschungUebersicht();

        $forschungUebersicht->setLizentiatmaster($lizz_master);
        $forschungUebersicht->setDissertation($dissertations);

        //$dissertations = new ForschungFieldset('dissertations',$dissertations);
        //$fs = new ForschungFieldset('lizz_master',$lizz_master);


        //$test = $dissertations->getElements();

        $form = new ForschungForm('forschungen');
        $form->bind($forschungUebersicht);


        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('forschung_edit', 'FSW'),
        ));

    }


} 