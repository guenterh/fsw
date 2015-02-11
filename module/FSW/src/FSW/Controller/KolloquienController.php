<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 10:03 PM
 */

namespace FSW\Controller;

use FSW\Form\KolloquiumFieldset;
use FSW\Form\KolloquiumForm;

use FSW\Form\VeranstaltungForm;
use FSW\Form\VeranstaltungKolloquiumPersonForm;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use \Zend\Mvc\Controller\Plugin\FlashMessenger;



class KolloquienController extends BaseController {


    public function indexAction () {

        $kolloquien = $this->facade->getKolloquien();

        return new ViewModel(
            array(
                "kolloquien" => $kolloquien
            )
    
        );

    }


    public function editPersonenVeranstaltungAction () {


        /*
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('kolloquien', array(
                'action' => 'index'
            ));
        }
        */

        $idVeranstaltung = (int)$this->params()->fromRoute('id', 0);
        $veranstaltung = $this->facade->getVeranstaltung($idVeranstaltung);

        $form  = new VeranstaltungForm('Veranstaltung');
        $form->bind($veranstaltung);


        return $this->getAjaxView(array(
            'form' => $form

        ));

    }



    public function updatePersonVeranstaltungAction() {


        $inputData = array(
            'id' => $this->params()->fromRoute('id', null),
        );

        $request = $this->getRequest();
        if ($request->isPost()) {

            $personDataForUpdate = $request->getPost()->toArray();
            $this->facade->updatePersonVeranstaltung($personDataForUpdate, $inputData['id']);

            $this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage("Person erfolgreich aktualisiert");


        }

        $veranstaltung = $this->facade->getVeranstaltungZuPerson($inputData);

        $params = array(
            'action' => 'editPersonenVeranstaltung',
            'id'    =>  $veranstaltung->getId_kolloquium_veranstaltung()
        );

        return $this->forward()->dispatch('FSW\Controller\Kolloquien', $params);


    }



    public function addPersonVeranstaltungAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form  = new VeranstaltungKolloquiumPersonForm('Vortragend');
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $lastInsertedValue = $this->facade->insertVortragendKolloquium($request->getPost()->toArray()['vortragend']);
                $form->getBaseFieldset()->get('id')->setValue($lastInsertedValue);
                $this->flashMessenger()->clearCurrentMessages();
                $this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage("Person wurde hinzugefügt");

            }

            $templateDaten = array(
                'form' => $form,
                'id'    =>  0,
                'update' => true
            );


        } else {
            //hier noch Pruefung einbauen

            $veranstaltungsId = $this->params()->fromRoute('id',0);

            $person = $this->facade->getEmptyPerson();
            $person->setId_kolloquium_veranstaltung($veranstaltungsId);

            $form  = new VeranstaltungKolloquiumPersonForm('Vortragend');
            $form->bind($person);

            $templateDaten = array(
                'form' => $form,
                'id'    =>  0,
                'update' => false
            );

        }


        return $this->getAjaxView(
            $templateDaten
        );


    }


    public function editVeranstaltungAction () {

        $request = $this->getRequest();
        if ($request->isPost()) {

            $idVeranstaltung = $this->params()->fromPost('id', null);
            $form  = new VeranstaltungForm('Veranstaltung');
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $this->facade->updateVeranstaltung($request->getPost()->toArray()['Veranstaltungen']);
            } else {

                $test = $form->getMessages();
            }

            $templateDaten = array(
                'form' => $form,
                'id'    =>  $idVeranstaltung,
                'update' => true
            );


        } else {
            //hier noch Pruefung einbauen
            $idVeranstaltung = (int)$this->params()->fromRoute('id', 0);
            $veranstaltung = $this->facade->getVeranstaltung($idVeranstaltung);

            $form  = new VeranstaltungForm('Veranstaltung');
            $form->bind($veranstaltung);

            $templateDaten = array(
                'form' => $form,
                'id'    =>  $idVeranstaltung,
                'update' => false
            );

        }
        return $this->getAjaxView(
            $templateDaten
        );
    }


    public function addVeranstaltungAction () {

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form  = new VeranstaltungForm('Veranstaltung');
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $lastInsertedValue = $this->facade->insertVeranstaltung($request->getPost()->toArray()['Veranstaltungen']);
                $form->getBaseFieldset()->get('id')->setValue($lastInsertedValue);

            }

            $templateDaten = array(
                'form' => $form,
                'id'    =>  0,
                'update' => true
            );


        } else {
            //hier noch Pruefung einbauen

            $veranstaltung = $this->facade->getEmptyVeranstaltung();
            $idKoll = $this->params()->fromQuery('id_kolloquium', 0);
            $veranstaltung->setId_kolloquium($idKoll);
            $veranstaltung->setId(0);

            $form  = new VeranstaltungForm('Veranstaltung');
            $form->bind($veranstaltung);

            $templateDaten = array(
                'form' => $form,
                'id'    =>  0,
                'update' => false
            );

        }


        return $this->getAjaxView(
            $templateDaten
        );
    }



    public function addKolloquiumAction() {





        $kolloquium = $this->facade->getEmptyKolloquium();
        $form = new KolloquiumForm('Kolloquium');

        $form->bind($kolloquium);


        return $this->getAjaxView(
            array(
                'form' => $form
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


        //$rL = $this->facade->getFSWPersonen();
        //$personTable = $this->getPersonTable();
        //$rL = $personTable->find(null,200);
        //$simpleList = $this->toList($rL,true);


        $form  = new KolloquiumForm('kolloquium');

        //$veranstaltungen = $form->get('Kolloqium')->get('veranstaltung');
        //foreach ($veranstaltungen as $veranstaltung) {
        //    $test =  $veranstaltung->get("vortragend");
        //    $t = "";
        //}

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


        $isCompleteView = $this->params()->fromQuery('completeView',false);
        if ($this->getRequest()->isGet() && $isCompleteView) {
            $kolloquien = $this->facade->getKolloquien();
            return new ViewModel(
                array(
                    'kolloquien' => $kolloquien,
                    'form' => $form,
                    'complete' => true,
                    'title' => $this->translate('kolloquien_edit', 'FSW'),
                )
            );
        } else {
            return $this->getAjaxView(array(
                'form' => $form,
                'title' => $this->translate('kolloquien_edit', 'FSW'),
                'complete' => false
            ));

        }




    }


    public function insertKolloquienFSWAction () {


        //$this->facade->insertKolloquienFSW();
        $this->facade->insertKolloquienFromXMLFile();

    }


    public function testValidKolloquiumAction() {

        //$titel = $this->params()->fromQuery('titel', null);
        //$id_kolloquium =  $this->params()->fromQuery('id_kolloquium', null);

        $inputData = array(
            'titel' => $this->params()->fromQuery('titel', null),
            'id_kolloquium' => $this->params()->fromQuery('id_kolloquium', null)
        );



        $titleInput = new Input('titel');
        $id_kolloquium = new Input('id_kolloquium');


        $inputFilter = new InputFilter();
        $inputFilter->add($titleInput)->add($id_kolloquium);

        $inputFilter->setData($inputData);
        if (!$inputFilter->isValid())
        {
            $messages = array();
            foreach ($inputFilter->getMessages() as $element => $message) {
                $messages[$element] = current($message);
            }

            $jsonResponse = array(
                'status' => 'notok',
                'messages' => $messages
            );
        } else {
            $jsonResponse = array(
                'status' => 'ok',
            );

        }

        //$messages = $inputFilter->getMessages();
        //$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);

        return new JsonModel(
            $jsonResponse
        );

    }

    public function addSaveKolloquiumAction () {


        //im Moment hier keine Validierungen mehr da vorher testValidKolloquiumAction
        //aufgerufen worden ist
        //kann man noch ändern
        $inputData = array(
            'titel' => $this->params()->fromQuery('titel', null),
            'id_kolloquium' => $this->params()->fromQuery('id_kolloquium', null)
        );

        $kolloquium = $this->facade->addSaveKolloquim($inputData);

        return new JsonModel(
            array()
        );

    }

    function deleteKolloquiumAction() {

        $inputData = array(
            'id' => $this->params()->fromQuery('id', null),
        );

        $kolloquium = $this->facade->deleteKolloquim($inputData);

        return new JsonModel(
            array()
        );

    }

    function editKolloquiumAttrAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {

            $idKolloquium = $request->getPost()->toArray()['Kolloqium']['id'];
            $form  = new KolloquiumForm('Kolloquium');
            $test = $request->getPost()->toArray();
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $this->facade->updateKolloquium($request->getPost()->toArray()['Kolloqium']);

            }

            $templateDaten = array(
                'form' => $form,
                'id'    =>  $idKolloquium,
                'update' => true
            );


        } else {
            //hier noch Pruefung einbauen
            $idKolloquium = (int)$this->params()->fromRoute('id', 0);
            try {
                $kolloquium = $this->facade->getKolloquim($idKolloquium);

                $form  = new KolloquiumForm('Kolloquium');
                $form->bind($kolloquium);
            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('kolloquien', array(
                    'action' => 'index'
                ));
            }


            $templateDaten = array(
                'form' => $form,
                'id'    =>  $idKolloquium,
                'update' => false
            );

        }
        return $this->getAjaxView(
            $templateDaten
        );

    }

    public function deleteVeranstaltungAction () {

        $inputData = array(
            'id' => $this->params()->fromQuery('id', null),
        );

        $kolloquium = $this->facade->deleteVeranstaltung($inputData);

        return new JsonModel(
            array()
        );


    }


    public function deletePersonVeranstaltungAction () {

        $inputData = array(
            'id' => $this->params()->fromRoute('id', null),
        );

        $veranstaltung = $this->facade->getVeranstaltungZuPerson($inputData);
        $kolloquium = $this->facade->deletePersonVeranstaltung($inputData);

        $this->flashMessenger()->clearCurrentMessages();
        $this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage("Person mit id: " . $inputData['id'] . " gelöscht");


        $params = array(
            'action' => 'editPersonenVeranstaltung',
            'id'    =>  $veranstaltung->getId_kolloquium_veranstaltung()
        );

        return $this->forward()->dispatch('FSW\Controller\Kolloquien', $params);

    }

    /**
     * Search matching records
     *
     * @param	Integer		$limit        Search result limit
     * @return	ViewModel
     **/
    public function searchAction($limit = 15)
    {

        $query = $this->params()->fromQuery('query', '');
        $data = array(
            'route' => 'kolloquien',
            'listItems' => $this->facade->searchInEntities($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');

    }

    protected function getEntityName () {
        return 'Kolloquium';
    }


    protected function getEntityNames () {
        return 'Kolloquien';
    }




} 