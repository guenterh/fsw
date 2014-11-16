<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/19/13
 * Time: 11:59 PM
 */

namespace FSWPresentation\Controller;

use Zend\Mvc\Controller\AbstractActionController;





//bisher nur als Platzhalter verwendet
class IndexController extends AbstractActionController {


    protected $mediumTable;
    protected $personTable;

    public function indexAction()
    {

        

        $type = $this->params('type');


    }

}