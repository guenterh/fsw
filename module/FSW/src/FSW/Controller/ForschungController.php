<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 06.04.14
 * Time: 16:15
 */

namespace FSW\Controller;


use FSW\Form\ForschungForm;
use FSW\Model\PersonForschungUebersicht;

use Zend\Stdlib\ArrayObject;
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

        $forschungstypen = array('Habilitation');
        $params = compact('pers_id','forschungstypen');

        $habil = $this->facade->getForschungen($params);

        $person = $this->facade->getHSPerson($pers_id);



        //$forschungUebersicht =  new PersonForschungUebersicht();


        $bindObject = new ArrayObject();
        $bindObject['dissertation'] = $dissertations;
        $bindObject['lizentiatmaster'] = $lizz_master;
        $bindObject['habilitation'] = $habil;


        //$forschungUebersicht->setLizentiatmaster($lizz_master);
        //$forschungUebersicht->setDissertation($dissertations);

        //$dissertations = new ForschungFieldset('dissertations',$dissertations);
        //$fs = new ForschungFieldset('lizz_master',$lizz_master);


        //$test = $dissertations->getElements();

        $form = new ForschungForm('forschungen');
        $form->bind($bindObject);


        return $this->getAjaxView(array(
            'person' => $person,
            'form' => $form,
            'title' => $this->translate('Lizz / Master / Diss / Habil', 'FSW'),
        ));

    }

    /**
     * Search matching records
     *
     * @param	Integer		$limit        Search result limit
     * @return	ViewModel
     **/
    public function searchAction()
    {
        $query = $this->params()->fromQuery('query', '');
        $data = array(
            'route' => 'forschungAdmin',
            'listItems' => $this->facade->searchFSWPersonen($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }

    public function presentAction()
    {

        //http://localhost:30000/forschungPresent/present
        //http://localhost:30000/forschungPresent/present/liz?abgeschlossen=1&mitid=5
        //http://localhost:30000/forschungPresent/present/diss?abgeschlossen=1&mitid=5
        //http://localhost:30000/forschungPresent/present/master?abgeschlossen=1&mitid=5



        //Pruefe gueltige Werte
        $lower_valid_type_values = array('diss' => 'Dissertation','liz' => 'Lizentiatsarbeit',
            'master' => 'Masterarbeit','all' => 'all');
        $valid_abgeschlossen_types = array('0','1');
        $tAbgeschlossen =  $this->params()->fromQuery('abgeschlossen');
        if (!is_null($tAbgeschlossen)) {
            $tAbgeschlossen = in_array($tAbgeschlossen,$valid_abgeschlossen_types) ? $tAbgeschlossen : null;
        }
        $tMitid = $this->params()->fromQuery('mitid');
        if (!is_null($tMitid)) {
            $tMitid =  ((int) $tMitid != 0) ? ((int) $tMitid) : null;
        }

        $type = $this->getEvent()->getRouteMatch()->getParam('type') == null ? 'all' : strtolower($this->getEvent()->getRouteMatch()->getParam('type'));
        $type = array_key_exists($type,$lower_valid_type_values) ? $lower_valid_type_values[$type] : 'all';


        return new ViewModel(array(
            'forschungsArbeiten' => $this->facade->getForschungsarbeitenFSW($type, $tAbgeschlossen, $tMitid)
        ));


    }


} 