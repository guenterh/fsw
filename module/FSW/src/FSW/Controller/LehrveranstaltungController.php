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
use FSW\Model\PersonForschungUebersicht;

use Zend\Stdlib\ArrayObject;
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
            'route' => 'medien',
            'listItems' => $this->facade->searchInEntities($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');

    }


    public function insertLehrveranstaltungenFromOldFSWAction() {

        $this->facade->insertLehrveranstaltungFromOldDB();


    }

} 