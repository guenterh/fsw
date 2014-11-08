<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 06.04.14
 * Time: 16:15
 */

namespace FSW\Controller;


use FSW\Form\ForschungForm;
use FSW\Model\PersonForschungUebersicht;

use Zend\Stdlib\ArrayObject;
use Zend\View\Model\ViewModel;

class LehrveranstaltungController extends BaseController {



    /**
     * @return ViewModel
     */
    public function indexAction() {



    }

    public function editAction()
    {



    }

    /**
     * Search matching records
     *
     * @param	Integer		$limit        Search result limit
     * @return	ViewModel
     **/
    public function searchAction()
    {
    }

    public function presentAction()
    {


    }


    public function insertLehrveranstaltungenFromOldFSWAction() {

        $this->facade->insertLehrveranstaltungFromOldDB();


    }

} 