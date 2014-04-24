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
use FSW\Services\HistSemDBService;
use Zend\Mvc\Controller\AbstractActionController;
use FSW\Services\HistSemDBServiceAwareInterface;
use Zend\View\Model\ViewModel;


class PersonenController extends BaseController{


    /**
     * @var DBService to access histsem DB
     */


    protected $personenFacade;


    public function indexAction() {


        $this->personenFacade =  $this->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade');
        $personen = $this->personenFacade->fetchAll();
        return new ViewModel(array('personen' => $personen));

    }


    /**
     * Search matching records
     *
     * @param	Integer		$limit        Search result limit
     * @return	ViewModel
     **/
    public function searchAction($limit = 15)
    {
        $this->personenFacade =  $this->getServiceLocator()->get('FSW\Services\Facade\PersonenFacade');


        $query = $this->params()->fromQuery('query', '');
        $data = array(
            'route' => strtolower($this->getTypeName()),
            'listItems' => $this->personenFacade->find($query, $limit)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }

}