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



class MedienController extends BaseController {



    public function indexAction()
    {

        //return $this->forward()->dispatch('FSW\Controller\Personen', array('action' => 'edit','id' => 101 ));

        return new ViewModel(array(
            'medien' => $this->facade->fetchAll()
        ));

    }

    public function addAction()
    {


        $request = $this->getRequest();
        if ($request->isPost()) {
            $rL = $this->facade->getFSWPersonen();

            $simpleList = $this->toList($rL,true);

            $form = new MediumForm('medium',$simpleList);


            $medium = new Medium();
            $form->setInputFilter($medium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $medium->exchangeArray($form->getData());
                $idUpdated =  $this->facade->saveMedium($medium);
                $this->flashMessenger()->addMessage("neues Medium gespeichert");
                // Redirect to list of albums
                //return $this->forward()->toRoute('medien',array("action" => 'edit','id' => '52'));
                return $this->forward()->dispatch('FSW\Controller\Medien', array('action' => 'show','id' => $idUpdated ));
            }


        } else {

            $rL = $this->facade->getFSWPersonen();


            $simpleList = $this->toList($rL,true);

            $form = new MediumForm('medium',$simpleList);
            $form->get('submit')->setValue('Add');

            $medium =  new Medium();



            $form->bind($medium);

        }

        return $this->getAjaxView(array('form' => $form));

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }


        //new


        $idMedium = (int)$this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if (!$idMedium) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }

        // Get the Medium with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $medium = $this->facade->getMedium($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'index'
            ));
        }

        $rL = $this->facade->getFSWPersonen();
        $simpleList = $this->toList($rL,true);


        $form  = new MediumForm('medium', $simpleList);
        $form->bind($medium);

        //$myurl = $this->url()->fromRoute('medien',array('action' => 'edit', 'id' => 10), array( 'query' =>  ['jdjdj' => 'jdjdj', 'bla' => 'kdkdk']));
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $t = $request->getPost();


            $form->setInputFilter($medium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->facade->saveMedium($medium);
                $this->flashMessenger()->addMessage("Medium aktualisiert");

                // Redirect to list of albums
                //return $this->redirect()->toRoute('medien');
            } else {
                $test =  $form->getMessages();
                $eins = "";
            }
        }

        //$form->setAttribute('action', $this->makeUrl('institution', 'edit', $idInstitution));

        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('medien_edit', 'FSW'),
        ));



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
                $id = (int) $id;
                $this->facade->deleteMedium($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('medien');
        }

        return array(
            'id'    => $id,
            'medium' => $this->facade->getMedium($id)

        );
    }



    public function insertMedienFSWAction () {


        $this->facade->insertMedienFSW();

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
            'route' => 'medien',
            'listItems' => $this->facade->searchInMedien($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }


    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }


        //new


        $idMedium = (int)$this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if (!$idMedium) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'add'
            ));
        }

        // Get the Medium with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $medium = $this->facade->getMedium($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('medien', array(
                'action' => 'index'
            ));
        }

        $rL = $this->facade->getFSWPersonen();
        $simpleList = $this->toList($rL,true);


        $form  = new MediumForm('medium', $simpleList);
        $form->bind($medium);
        $form->get('submit')->setAttribute('value', 'Edit');



        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('medien_show', 'FSW'),
        ));



    }

    protected function getEntityName () {
        return 'Medium';
    }


    protected function getEntityNames () {
        return 'Medien';
    }



}