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

    public function showAction()
    {


        $id = $this->params()->fromRoute('id',0);

        //$this->layout('layout\layoutlehrveranstaltung');

        return new ViewModel(array(
            'lvWithDpendencies' => $this->facade->getLehrveranstaltungenWithDependencies($id),
            'archivLabels' => $this->getServiceLocator()->get('FSW\Config')->get('config')->LehrveranstaltungArchivLabel->toArray()
        ));

    }

}