<?php
/**
 * Created by iwerk.ch fuer FSW, UZH Zürich.
 * author: Guenter Hipler 
 * Date: 3/16/14
 * Time: 8:01 PM
 * Copyright (C) Forschungsstelle fuer Sozial- und Wirtschaftsgeschichte der Uni Zuerich, Schweiz
 * http://www.fsw.uzh.ch
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category 
 * @package  
 * @author   Guenter Hipler  <guenter.hipler@iwerk.ch>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://www.fsw.uzh.ch
 */

namespace FSW\Controller;

use FSW\Form\CoverlinkForm;
use FSW\Form\PersonCoreFieldset;
use FSW\Form\PersonExtendedFieldset;
use FSW\Form\PersonForm;
use FSW\Form\PersonFormAllHS;
use FSW\Form\PersonFSWExtendedForm;
use FSW\Form\PersonZoraFieldset;
use FSW\Form\ZoraAuthorForm;
use Zend\Stdlib\ArrayObject;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class PersonenController extends BaseController{




    public function indexAction() {


        $personen = $this->facade->getAllPersonen();
        return new ViewModel(array('personen' => $personen));

    }


    public function machwasAction() {

        $testJson = array('hallo' => 'null', 'zwei' => 'eins');
        $myJson =  json_encode($testJson);


        $this->redirect()->toRoute('medien');

        $viewModel = new ViewModel(array('jsonValues' => $myJson));
        $viewModel->setTerminal(true);


        return $viewModel;


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
            'route' => strtolower($this->getTypeName()),
            'listItems' => $this->facade->searchPersonen($query, $limit)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }

    public function editAction()
    {
        $pers_id = (int) $this->params()->fromRoute('id', 0);
        if (!$pers_id) {
            return $this->redirect()->toRoute('personen', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {

            //hole das Modell von der Facade
            $person =  $this->facade->getPerson($pers_id);


            $forschungstypen = array('Lizentiatsarbeit','Masterarbeit','Dissertation','Habilitation');
            $params = compact('pers_id','forschungstypen');

            $forschungsarbeiten = $this->facade->getForschungen($params);

            $bindObject = new ArrayObject();
            $bindObject['forschungsarbeiten'] = $forschungsarbeiten;
            $bindObject['PersonCore'] = $person;

            //letztes könnte eigentlich in die FSW Abfrage

            $isFswPerson = $this->facade->isFSWPerson($pers_id);
            if ($isFswPerson) {

                $params = compact('pers_id');
                //$zoraDocs = $this->facade->getZoraDocs($params);
                $zoraDocs = $this->facade->getZoraDocsWithCover($params);
                $relPersonRollenPersonExtend = $this->facade->getBeziehunhenPersonRolleExtended($params);

                $medien = $this->facade->getMedien($pers_id);

                $bindObject['BeziehungPersonRolle'] = $relPersonRollenPersonExtend;

                $bindObject['medien'] = $medien;
                $bindObject['zoradocs'] = $zoraDocs;

                //binde die Objekte

            } else {

                $bindObject['BeziehungPersonRolle'] = array();

                $bindObject['medien'] = array();
                $bindObject['zoradocs'] = array();
            }


            $coreFieldset = $this->getServiceLocator()->get('FormElementManager')->get('PersonCoreFieldset');
            $coreFieldset->setName('PersonCore');


            $personRelationRolleFSWExtendedFieldset = $this->getServiceLocator()->get('FormElementManager')->get('PersonRolleExtendedRelationFieldset');



            $qaArbeiten = $this->getServiceLocator()->get('FormElementManager')->get('QualifikationsArbeitFieldset');


            $coreFS = new PersonFormAllHS('Person',$coreFieldset,$qaArbeiten,$personRelationRolleFSWExtendedFieldset);

            $coreFS->bind($bindObject);

            $request = $this->getRequest();
            if ($request->isPost()) {
                $coreFS->setData($request->getPost());

                if ($coreFS->isValid()) {

                    $formData = $coreFS->getData();
                    $this->facade->savePersonEdit($formData);
                } else {
                    $test = "das war nichts";
//				$messages = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($form->getMessages()));
//				foreach($messages as $message) {
//					$flashMessenger->addErrorMessage($message);
//				}
                }
            }



        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('personen', array(
                'action' => 'index'
            ));
        }

        $coreFS->setAttribute('action', $this->makeUrl('personen', 'edit', $pers_id));


        /*
        return new ViewModel(array(

            'form' => $coreFS,
            'title' => $this->translate('Personenanzeige', 'FSW'),
        ));
        */

        $isCompleteView = $this->params()->fromQuery('completeView',false);
        if ($this->getRequest()->isGet() && $isCompleteView) {
            $personen = $this->facade->getAllPersonen();
            return new ViewModel(
                array(
                    'personen' => $personen,
                    'form' => $coreFS,
                    'title' => $this->translate('Personenanzeige', 'FSW'),
                    'complete' => true,
                    'isFswPerson' => $isFswPerson

                )
            );
        } else {
            return $this->getAjaxView(array(
                'form' => $coreFS,
                'title' => $this->translate('Personenanzeige', 'FSW'),
                'complete' => false,
                'isFswPerson' => $isFswPerson

            ));

        }






    }

    public function insertExtendedMAFSWAction () {


        $this->facade->insertIntoFSWExtended();

    }



    public function addZoraAuthorAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {


            $zoraFieldSet = new PersonZoraFieldset(false);
            $zoraFieldSet->setUseAsBaseFieldset(true);

            $form  = new ZoraAuthorForm("ZoraAuthor", $zoraFieldSet);

            $form->setData($request->getPost());
            if ($form->isValid()) {
                $paramsArray = $request->getPost()->toArray()['PersonZora'];

                //nur bei 0 ein insert (ansonsten kann es sich um einen doppelten click handeln
                if ((int)$paramsArray['id'] == 0) {

                    $lastInsertedValue = $this->facade->insertZoraAuthor($request->getPost()->toArray()['PersonZora']);
                    if ($lastInsertedValue) {
                        $form->getBaseFieldset()->get('id')->setValue($lastInsertedValue);
                    } else {
                        $form->getBaseFieldset()->get('id')->setValue(0);
                        //something went wrong (how to handle this??
                    }
                }



            } else {
                $form->getBaseFieldset()->get('id')->setValue(0);
            }

            $templateDaten = array(
                'form' => $form,
                'update' => false
            );


        } else {
            //hier noch Pruefung einbauen

            $personExtendedId = $this->params()->fromRoute('id',0);

            $zoraAuthor = $this->facade->getEmptyZoraAuthor();
            $zoraAuthor->setFid_personen($personExtendedId);

            $zoraFieldSet = new PersonZoraFieldset(false);
            $zoraFieldSet->setUseAsBaseFieldset(true);

            $form  = new ZoraAuthorForm("ZoraAuthor", $zoraFieldSet);

            $form->bind($zoraAuthor);

            $templateDaten = array(
                'form' => $form,
                'update' => false
            );

        }


        return $this->getAjaxView(
            $templateDaten
        );

    }

    public function editZoraAuthorAction() {

        $request = $this->getRequest();
        if ($request->isPost()) {


            $zoraFieldSet = new PersonZoraFieldset(false);
            $zoraFieldSet->setUseAsBaseFieldset(true);

            $form  = new ZoraAuthorForm("ZoraAuthor", $zoraFieldSet);

            $form->setData($request->getPost());
            if ($form->isValid()) {

                //bei update gibt es keinen lastInsertedValue
                $this->facade->updateZoraAuthor($request->getPost()->toArray()['PersonZora']);
                //if ($lastInsertedValue) {
                //    $form->getBaseFieldset()->get('id')->setValue($lastInsertedValue);
                //} else {
                //    $form->getBaseFieldset()->get('id')->setValue(0);
                    //something went wrong (how to handle this??
                //}


            }

            $templateDaten = array(
                'form' => $form,
                'update' => false
            );


        } else {
            //hier noch Pruefung einbauen

            $zoraAuthorId = $this->params()->fromRoute('id',0);
            $templateDaten = array();
            if ($zoraAuthorId) {

                $zoraAuthor = $this->facade->getZoraAuthor($zoraAuthorId);

                $zoraFieldSet = new PersonZoraFieldset(false);
                $zoraFieldSet->setUseAsBaseFieldset(true);

                $form  = new ZoraAuthorForm("ZoraAuthor", $zoraFieldSet);

                $form->bind($zoraAuthor);

                $templateDaten = array(
                    'form' => $form,
                    'update' => false
                );

            }


        }


        return $this->getAjaxView(
            $templateDaten,"fsw/personen/add-zora-author"
        );

    }

    public function editProfilURLAction() {

        $request = $this->getRequest();
        $idPersonExtended = $this->params()->fromRoute('id',0);

        if ($request->isGet() && $idPersonExtended > 0) {
            $personExtended = $this->facade->getExtendedFSWPersonAttributes($idPersonExtended);

            $persExtendedFieldset = new PersonExtendedFieldset(false);
            $persExtendedFieldset->setUseAsBaseFieldset(true);

            $form = new PersonFSWExtendedForm('FSWPersonExtended', $persExtendedFieldset);
            $form->bind($personExtended);
        } elseif ($request->isPost()) {

            $persExtendedFieldset = new PersonExtendedFieldset(false);
            $persExtendedFieldset->setUseAsBaseFieldset(true);
            $form = new PersonFSWExtendedForm('FSWPersonExtended', $persExtendedFieldset);

            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $this->facade->saveExtendedAttributes($request->getPost()->toArray());

            }
        }

        return $this->getAjaxView(array(
            'form' => $form
            //'title' => $this->translate('Personenanzeige', 'FSW'),
        ));

    }

    protected function getEntityName () {
        return 'Person';
    }


    protected function getEntityNames () {
        return 'Personen';
    }


    public function deleteBeziehungPersonRolleAction() {


        $relationId = $this->params()->fromPost("relationID", 0);

        if ((int)$relationId  > 0) {
            $this->facade->loescheBeziehungPersonRolleFSWContent($relationId);

        }


    }

    public function editCoverLinkAction() {

        $request = $this->getRequest();
        $modus = $this->params()->fromPost('modus', null);
        $templateDaten = array();
        //
        if ($request->isPost() && is_null($modus)) {

            $postData = $this->params()->fromPost();
            $form  = new CoverlinkForm();
            $form->setData($postData);
            if ($form->isValid()) {
                $this->facade->updateCoverlink($postData);

            } else

                $templateDaten = array(
                    'form' => $form
                );


        } elseif ($request->isPost() && !is_null($modus) && $modus == 'show'){
            //hier noch Pruefung einbauen
            $oai_identifier = $this->params()->fromPost('oai_identifier', 0);
            try {
                $coverlinkEntity = $this->facade->getCoverlinkEntity($oai_identifier);

                $form  = new CoverlinkForm();
                $form->bind($coverlinkEntity);
            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('kolloquien', array(
                    'action' => 'index'
                ));
            }


            $templateDaten = array(
                'form' => $form
                //'id'    =>  $oai_identifier,
            );

        }
        return $this->getAjaxView(
            $templateDaten
        );

    }

    public function deleteZoraAuthorAction () {

        $zoraAuthorId = $this->params()->fromQuery('id');
        if (isset($zoraAuthorId)) {
            $this->facade->deleteZoraAuthor($zoraAuthorId);
            $jsonResponse = array(
                'status' => 'ok',
            );


            return new JsonModel(
                $jsonResponse
            );

        }

    }

    public function deleteZoraDocAction () {

        $zoraDocId = $this->params()->fromQuery('id');
        $pers_id = $this->params()->fromQuery('pers_id');
        if (isset($zoraDocId) && isset($pers_id)) {
            $this->facade->deleteZoraDoc($zoraDocId,$pers_id);
            $jsonResponse = array(
                'status' => 'ok',
            );


            return new JsonModel(
                $jsonResponse
            );

        } else {
            $jsonResponse = array(
                'status' => 'notok',
            );

            return new JsonModel(
                $jsonResponse
            );
        }

    }






}