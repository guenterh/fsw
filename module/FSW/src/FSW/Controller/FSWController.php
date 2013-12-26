<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/19/13
 * Time: 11:59 PM
 */

namespace FSW\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\EventManager\EventManager;
use Zend\EventManager\StaticEventManager;
use Zend\EventManager\SharedEventManager;

use Zend\EventManager\Event;




class FSWController extends AbstractActionController {


    protected $mediumTable;

    public function indexAction()
    {

        return new ViewModel(array(
            'medien' => $this->getMediumTable()->fetchAll(),
        ));

    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }




    public function getMediumTable()
    {
        if (!$this->mediumTable) {
            $sm = $this->getServiceLocator();
            $this->mediumTable = $sm->get('FSW\Model\MediumTable');
        }
        return $this->mediumTable;
    }



} 