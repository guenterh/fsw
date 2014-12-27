<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/19/13
 * Time: 11:59 PM
 */

namespace FSWPresentation\Controller;

use Zend\View\Model\ViewModel;
use FSW\Controller\BaseController;



class MedienController extends BaseController {


    protected $mediumTable;
    protected $personTable;

    public function showAction()
    {
        $medientypen =  $this->params()->fromQuery('medientyp',array());
        return new ViewModel(array(
            'medien' => $this->facade->getMedienByTyp( $medientypen)
        ));

    }

    public function showMaAction()
    {

        $mitId = $this->params()->fromRoute('id',0);

        if ($mitId == 0) {
            return $this->forward()->dispatch('FSWPresentation\Controller\Medien', array('action' => 'show' ));
        }

        return new ViewModel(array(
            'medien' => $this->facade->getMedienByMitarbeiter( $mitId)
        ));



    }




}