<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 10:03 PM
 */

namespace FSW\Controller;

use FSW\Form\KolloquiumForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class KolloquienController extends BaseController {


    public function indexAction () {

        $kolloquien = $this->facade->getKolloquien();


        //201201
        return new ViewModel(
            array(
                "kolloquien" => $kolloquien
            )

        );

    }


    public function editAction () {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }

        $idKolloquium = (int)$this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if (!$idKolloquium) {
            return $this->redirect()->toRoute('kolloquien', array(
                'action' => 'add'
            ));
        }

        // Get the Medium with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $kolloquium = $this->facade->getKolloquim($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('kolloquien', array(
                'action' => 'index'
            ));
        }


        //$rL = $this->facade->getMedienPersonen();
        //$personTable = $this->getPersonTable();
        //$rL = $personTable->find(null,200);
        //$simpleList = $this->toList($rL,true);


        $form  = new KolloquiumForm('kolloquium');
        $form->bind($kolloquium);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($kolloquium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //$this->getMediumTable()->saveMedium($medium);

                // Redirect to list of albums
                return $this->redirect()->toRoute('kolloquien');
            } else {
                $test =  $form->getMessages();
                $eins = "";
            }
        }


        //$form->setAttribute('action', $this->makeUrl('institution', 'edit', $idInstitution));




        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('kolloquien_edit', 'FSW'),
        ));


    }


    public function insertKolloquienFSWAction () {


        $this->facade->insertKolloquienFSW();

    }


} 