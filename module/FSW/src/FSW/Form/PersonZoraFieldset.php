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

        parent::__construct('person_core_data');

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
            'name' => 'zora_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'zora_name_customized',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name_customized'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));




    }



} 