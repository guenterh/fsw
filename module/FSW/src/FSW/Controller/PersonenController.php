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

use FSW\Form\PersonCoreFieldset;
use FSW\Form\PersonForm;
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
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('personen', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {

            //hole das Modell von der Facade
            $person =  $this->facade->getPerson($id);

            $coreFS = new PersonForm('Person');
            $coreFS->bind($person);

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

        $coreFS->setAttribute('action', $this->makeUrl('personen', 'edit', $id));


        return new ViewModel(array(

            'form' => $coreFS,
            'title' => $this->translate('Personenanzeige', 'FSW'),
        ));

        //return $this->getAjaxView(array(
        //    'form' => $coreFS,
        //    'title' => $this->translate('Personenanzeige', 'FSW'),
        //));


    }

    public function insertExtendedMAFSWAction () {


        $this->facade->insertIntoFSWExtended();

    }


    public function editZoraAuthorAction() {

        $modus =  $this->params()->fromPost('mode');
        $personId = null;


        switch ($modus) {

            case 'addAuthor':
                $persExtendedIdFSW =   $this->params()->fromPost('persExtendedIdFSW');
                $personId =            $this->params()->fromPost('persIdHS');
                $zoraAuthorName =      $this->params()->fromPost('zoraAuthorName');
                $zoraAuthorNameCustomized =   $this->params()->fromPost('zoraAuthorNameCustomized');
                if (isset($personId) && isset($persExtendedIdFSW)) {
                    $this->facade->addZoraAuthor($persExtendedIdFSW,
                                                    $personId,
                                                    $zoraAuthorName,
                                                    $zoraAuthorNameCustomized);
                }

                break;
            case 'delAuthor':

                $zoraAuthorId = $this->params()->fromPost('zoraAutorId');
                if (isset($zoraAuthorId)) {
                    $personId =  $this->facade->getPersonFromZoraAuthorId($zoraAuthorId);
                    $this->facade->deleteZoraAuthor($zoraAuthorId);
                }
                break;

            case 'updAuthor';
                //still todo
                break;

        }


        $person =  $this->facade->getPerson($personId);

        $coreFS = new PersonForm('Person');
        $coreFS->bind($person);

        $coreFS->setAttribute('action', $this->makeUrl('personen', 'edit', $personId));

        return $this->getAjaxView(array(
            'form' => $coreFS,
            'title' => $this->translate('Personenanzeige', 'FSW'),
        ));


    }



}