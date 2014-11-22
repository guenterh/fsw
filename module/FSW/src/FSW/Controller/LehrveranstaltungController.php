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
use FSW\Form\LehrveranstaltungOnlyForm;
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

    public function editLvModalAction () {

        $id = (int) $this->params()->fromRoute('id', 0);
        $form = null;
        $request = $this->getRequest();
        if ($id && $id > 0 && $request->isGet()) {
            //in diesem Fall haben soll eine einzelne LV (ohne Personen) zum Update angezeigt werden

            try {
                $lehrveranstaltung = $this->facade->getLehrveranstaltungOnly($id);

                $form = new LehrveranstaltungOnlyForm('lehrveranstaltung');
                $form->bind($lehrveranstaltung);

            } catch (\Exception $ex) {
                return $this->redirect()->toRoute('lehrveranstaltung', array(
                    'action' => 'index'
                ));
            }

        } elseif ($id == 0 && $request->isGet()) {
            // new Lehrveranstaltung fuer den insert als Form bereitstellen

            $lv = $this->facade->getEmptyLehrveranstaltung();
            $form = new LehrveranstaltungOnlyForm('lehrveranstaltung');
            $form->bind($lv);



        } elseif ($id == 0 && $request->isPost()) {
            //save new Lehrveranstaltung
            $form = new LehrveranstaltungOnlyForm('lehrveranstaltung');
            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $lastValue = $this->facade->insertLehrveranstaltung($request->getPost()->toArray());
                $lehrveranstaltung = $this->facade->getLehrveranstaltungOnly($lastValue);
                $form = new LehrveranstaltungOnlyForm('lehrveranstaltung');
                $form->bind($lehrveranstaltung);

            }



        }elseif ($id > 0 && $request->isPost()) {


            $form = new LehrveranstaltungOnlyForm('lehrveranstaltung');
            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $this->facade->saveLehrveranstaltung($request->getPost()->toArray());

            }


        }


        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('lehrveranstaltung_edit', 'FSW'),
        ));



    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('lehrveranstaltung', array(
                'action' => 'add'
            ));
        }

        $request = $this->getRequest();
        $form = null;

        if ($request->isPost()) {

            //folgendes Problem:
            //rufe ich hier valid auf, tritt folegdner Fall ein:
            //- auch wenn die LV als valid erkannt wird (aufgrund der Definitionen im Modell)
            //erhalte ich not valid, jedoch keine messages
            //das Problem wird sein:
            //ich habe die collection der Personen auf der Ebene der Form definiert.
            //Modellmaessig gehoert sie jedoch in die Lehrverastaltung, das der Modelltyp Lehrveranstaltung
            //auch ein array fuer Personen hat.
            //bei der Pruefung kann der Mechanismus die Collection (auf der Ebene der Form) also nicht validieren
            //da er auf keine daten zugreifen kann. Deswegen not valid jedoch ohne messages
            //dies umzubauen möchte ich jetzt nicht machen. Ich arbeite jetzt mit Ajax um vornazukommen um den Preis
            //Forms und snippets und damit code verdoppeln zu müssen.
            //Wenn die Sache mal steht, kann ich in einer nächsten Version das ganze verschlanken und vereinfachen

            $form  = new LehrveranstaltungForm('lehrveranstaltung');

            //$entity = $this->facade->getEmptyLehrveranstaltung();
            //$f = $entity->getInputFilter();
            //$f->setData($request->getPost()->toArray()['lehrveranstaltung']);
            //if (!$f->isValid()) {
            //    $m = $f->getMessages();
            //}

            //$form->setInputFilter($entity->getInputFilter());
            //$form->setData($request->getPost()->toArray()['lehrveranstaltung']);
            //$form->setData($request->getPost()->toArray()['lehrveranstaltung']);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //$this->facade->saveLehrveranstaltung($request->getPost());
            }
        } else {

            try {
                $lehrveranstaltung = $this->facade->getLehrveranstaltung($id);

                $form  = new LehrveranstaltungForm('lehrveranstaltung');
                $form->bind($lehrveranstaltung);

            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('lehrveranstaltung', array(
                    'action' => 'index'
                ));
            }


        }


        $isCompleteView = $this->params()->fromQuery('completeView',false);
        if ($this->getRequest()->isGet() && $isCompleteView) {
            $lehrveranstaltungen = $this->facade->getAllLehrveranstaltungen();
            return new ViewModel(
                array(
                    'lehrveranstaltung' => $lehrveranstaltungen,
                    'form' => $form,
                    'title' => $this->translate('lehrveranstaltung_edit', 'FSW'),
                    'complete' => true
                )
            );
        } else {
            return $this->getAjaxView(array(
                'form' => $form,
                'title' => $this->translate('lehrveranstaltung_edit', 'FSW'),
                'complete' => false
            ));

        }


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

    public function deleteLehrveranstaltungAction() {

        $idLV = $this->params()->fromQuery('id', null);


        $this->facade->deleteLehrveranstaltung($idLV);

        $jsonResponse = array(
            'status' => 'ok',
        );


        return new JsonModel(
            $jsonResponse
        );
    }


} 