<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 06.04.14
 * Time: 16:15
 */

namespace FSW\Controller;


use FSW\Form\ForschungForm;
use FSW\Form\LehrveranstaltungForm;
use FSW\Form\LehrveranstaltungPersonForm;
use FSW\Model\PersonForschungUebersicht;

use Zend\Stdlib\ArrayObject;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class LehrveranstaltungController extends BaseController {



    /**
     * @return ViewModel
     */
    public function indexAction() {

        $lehrveranstaltungen = $this->facade->getAllLehrveranstaltungen();
        return new ViewModel(array('lehrveranstaltung' => $lehrveranstaltungen));


    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('lehrveranstaltung', array(
                'action' => 'add'
            ));
        }

        try {
            $lehrveranstaltung = $this->facade->getLehrveranstaltung($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('lehrveranstaltung', array(
                'action' => 'index'
            ));
        }

        //$eM =  $this->getServiceLocator()->get('\Form\Element\Manager');
        //$form = $eM->get('FSW\Form\LehrveranstaltungForm');
        $form  = new LehrveranstaltungForm('lehrveranstaltung');
        $form->bind($lehrveranstaltung);

        /*
        $request = $this->getRequest();

        if ($request->isPost()) {


            $form->setInputFilter($medium->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->facade->saveMedium($medium);

                // Redirect to list of albums
                //return $this->redirect()->toRoute('medien');
            }
        }
        */

        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('lehrveranstaltung_edit', 'FSW'),
        ));



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
            'route' => 'lehrveranstaltung',
            'listItems' => $this->facade->searchInEntities($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');

    }


    public function insertLehrveranstaltungenFromOldFSWAction() {

        $this->facade->insertLehrveranstaltungFromOldDB();


    }

    public function editPersonAction () {


        $postData = $this->params()->fromPost();
        if (isset($postData['mode']) && strcmp($postData['mode'],'show') == 0) {
            //Anzeige einer vorhandenen Person mit der Möglichkeit zum Update
            $relPerson  = $this->facade->getRelationPersonLehrveranstaltung($postData);
            $form  = new LehrveranstaltungPersonForm('personenLehrveranstaltung', $this->facade->getHSPersonenGateway());
            $form->bind($relPerson);

        } elseif (! isset($postData['mode'])) {

            //nun entweder add oder update

            if (isset($postData['fper_personen_pers_id']) && (int) $postData['fper_personen_pers_id'] > 0 &&
                isset($postData['ffsw_lehrveranstaltungen_id']) && (int) $postData['ffsw_lehrveranstaltungen_id'] > 0 &&
                isset($postData['id']) && (int) $postData['id'] > 0) {
                //es handelt sich um einen Update


                $form  = new LehrveranstaltungPersonForm('personenLehrveranstaltung', $this->facade->getHSPersonenGateway());
                $form->setData($postData);
                if ($form->isValid()) {
                    //so wie die Form aufgebaut ist (auch mit readonly Attributen) kann es bei dieser Abfrage gar kein invalid geben

                    $this->facade->updatePersonLehrveranstaltung($postData);
                }


            } elseif (isset($postData['fper_personen_pers_id']) && (int) $postData['fper_personen_pers_id'] == 0 &&
                isset($postData['id']) && (int) $postData['id'] == 0 &&
                isset($postData['ffsw_lehrveranstaltungen_id']) && (int) $postData['ffsw_lehrveranstaltungen_id'] > 0 ) {
                    //eine "leere" Personenentitaet
                    $relPerson = $this->facade->getEmptyPersonLehrveranstaltung($postData);

                    $form  = new LehrveranstaltungPersonForm('personenLehrveranstaltung', $this->facade->getHSPersonenGateway());
                    $form->bind($relPerson);




            } elseif (isset($postData['fper_personen_pers_id']) && (int) $postData['fper_personen_pers_id'] > 0 &&
                isset($postData['id']) && (int) $postData['id'] == 0 &&
                isset($postData['ffsw_lehrveranstaltungen_id']) && (int) $postData['ffsw_lehrveranstaltungen_id'] > 0 ) {
                //save einer zusaetzlichen Person in Relation zur LV

                $relPerson = $this->facade->insertNewPersonLehrveranstaltung($postData);
                $form  = new LehrveranstaltungPersonForm('personenLehrveranstaltung', $this->facade->getHSPersonenGateway());
                $form->bind($relPerson);


            } else {
                //keine moegliche Kombination
                //implementiere einen forward zu einem Fehlerdialog

            }

        }



        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('person_edit', 'FSW'),
        ));

    }

    public function deletePersonAction() {

        $idRelationPersonLV = (int)$this->params()->fromRoute('id', 0);


        $this->facade->deletePersonRelationLV($idRelationPersonLV);

        $jsonResponse = array(
            'status' => 'ok',
        );


        return new JsonModel(
            $jsonResponse
        );


    }

} 