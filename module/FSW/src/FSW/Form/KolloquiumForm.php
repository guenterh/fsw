<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use Zend\Form\Form;
use Zend\Form\Fieldset;

class KolloquiumForm extends Form {


    public function __construct($name = 'kolloquium')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'type' => 'FSW\Form\KolloquiumFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));


    }

} 