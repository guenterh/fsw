<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use Zend\Form\Fieldset;

class PersonCoreFieldset extends Fieldset{

    public function __construct() {

        parent::__construct('person_extended_data');

        $this->add(array(
            'name' => 'pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_id'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'profilURL',
            'type' => 'textarea',
            'options' => array(
                'label' => 'profilURL'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));



    }



} 