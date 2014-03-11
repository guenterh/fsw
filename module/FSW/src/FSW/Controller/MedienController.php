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

use FSW\Form\MediumForm;
use FSW\Model\Medium;



class MedienController extends AbstractActionController {


    protected $mediumTable;

    public function indexAction()
    {

        return new ViewModel(array(
            'medien' => $this->getMediumTable()->fetchAll(),
        ));

    }

    public function addAction()
    {
        $form = new MediumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $medium = new Medium();
            $form->setInputFilter($medium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $medium->exchangeArray($form->getData());
                $this->getMediumTable()->saveMedium($medium);

                // Redirect to list of albums
                return $this->redirect()->toRoute('medien');
            }
        }
        return array('form' => $form);

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $medium = $this->getMediumTable()->getMedium($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'index'
            ));
        }

        $form  = new MediumForm();
        $form->bind($medium);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($medium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getMediumTable()->saveMedium($medium);

                // Redirect to list of albums
                return $this->redirect()->toRoute('medien');
            } else {
                $test =  $form->getMessages();
                $eins = "";
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('medien');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getMediumTable()->deleteMedium($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('medien');
        }

        return array(
            'id'    => $id,
            'medium' => $this->getMediumTable()->getMedium($id)
        );
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