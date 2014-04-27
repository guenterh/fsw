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

    protected $kolloquiumTable;
    protected $veranstaltungenTable;

    public function indexAction () {

        //201201
        return new ViewModel(
            array(
                "kolloquien" => $this->getKolloquiumTable()->fetchAll()
            )

        );

    }

    public function getKolloquiumTable()
    {
        if (!$this->kolloquiumTable) {
            $sm = $this->getServiceLocator();
            $this->kolloquiumTable = $sm->get('FSW\Model\KolloquiumTable');
        }

        $extendedAdapter = $this->getServiceLocator()->get("HistSemDBService");


        return $this->kolloquiumTable;
    }

    public function getVeranstaltungen () {
        if (!$this->veranstaltungenTable) {
            $sm = $this->getServiceLocator();
            $this->veranstaltungenTable = $sm->get('FSW\Model\KolloqiumVeranstaltungTable');
        }
        return $this->veranstaltungenTable;

    }


} 