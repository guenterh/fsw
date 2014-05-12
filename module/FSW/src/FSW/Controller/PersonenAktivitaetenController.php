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

use FSW\Form\AktivitaetenForm;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\ArrayObject;


class PersonenAktivitaetenController extends BaseController{




    public function indexAction() {


        $personen = $this->facade->getFSWPersonen();
        return new ViewModel(array('personen' => $personen));

    }


    public function editAction() {


        $pers_id = (int)$this->params()->fromRoute('id', 0);
        $flashMessenger = $this->flashMessenger();

        if (!$pers_id) {
            return $this->redirect()->toRoute('personenaktivitaet');
        }

        $forschungstypen = array('Lizentiatsarbeit','Masterarbeit','Dissertation','Habilitation');
        $params = compact('pers_id','forschungstypen');

        $forschungsarbeiten = $this->facade->getForschungen($params);


        $medien = $this->facade->getMedien($pers_id);



        $bindObject = new ArrayObject();
        $bindObject['forschungsarbeiten'] = $forschungsarbeiten;
        $bindObject['medien'] = $medien;




        $form = new AktivitaetenForm('aktivitaeteten');
        $form->bind($bindObject);


        return $this->getAjaxView(array(
            'form' => $form,
            'title' => $this->translate('aktivitaeten_edit', 'FSW'),
        ));




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
            'route' => 'personenaktivitaet',
            'listItems' => $this->facade->searchFSWPersonen($query, 15)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }



}