<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 17.11.14
 * Time: 20:44
 */

namespace FSWPresentation\View\Helper;


use Zend\Form\Element\DateTime;
use Zend\View\Helper\AbstractHelper;



class SortSwitcher extends AbstractHelper{

    public function __invoke($sentParams = array()) {

        if (isset($sentParams['sort'])) {
            $sentParams['sort'] = $sentParams['sort'] == 'name' ? 'abschluss' : 'name';
        }
        return $sentParams;


    }


} 