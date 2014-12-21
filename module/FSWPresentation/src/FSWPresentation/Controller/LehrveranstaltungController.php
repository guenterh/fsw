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



class LehrveranstaltungController extends BaseController {


    protected $mediumTable;
    protected $personTable;

    public function showArchivAction()
    {


        return new ViewModel(array(
            'lvWithDpendencies' => $this->facade->getLehrveranstaltungenArchiv(),
            'archivLabels' => $this->getServiceLocator()->get('FSW\Config')->get('config')->LehrveranstaltungArchivLabel->toArray()
        ));

    }

    public function showAktuellAction()
    {


        return new ViewModel(array(
            'lvWithDpendencies' => $this->facade->getLehrveranstaltungenAktuell(),
            'aktuellLabels' => $this->getServiceLocator()->get('FSW\Config')->get('config')->LehrveranstaltungArchivLabel->toArray()
        ));

    }

    public function showMaAction()
    {

        $mitId = $this->params()->fromRoute('id',0);

        if ($mitId == 0) {
            return $this->forward()->dispatch('FSWPresentation\Controller\Publications', array('action' => 'show' ));
        }


        $allLV = array();
        foreach ($this->getServiceLocator()->get('FSW\Config')->get('config')->LehrveranstaltungArchiv as $key => $value) {

            $allLV[$key] = $value;
        }

        foreach ($this->getServiceLocator()->get('FSW\Config')->get('config')->LehrveranstaltungAktuell as $key => $value) {

            $allLV[$key] = $value;
        }

        return new ViewModel(array(
            'lvWithDpendencies' => $this->facade->getLehrveranstaltungenMitarbeiter($mitId),
            'lvLabels' => $allLV
        ));


    }



}