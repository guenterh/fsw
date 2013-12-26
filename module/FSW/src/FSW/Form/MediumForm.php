<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use Zend\Form\Form;

class MediumForm extends Form {


    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('medium');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'gespraechstitel',
            'type' => 'Text',
            'options' => array(
                'label' => 'gespraechstitel',
            ),
        ));

        $this->add(array(
            'name' => 'mit_id',
            'type' => 'Text',
            'options' => array(
                'label' => 'mit_id',
            ),
        ));
        $this->add(array(
            'name' => 'icon',
            'type' => 'Text',
            'options' => array(
                'label' => 'icon',
            ),
        ));

        $this->add(array(
            'name' => 'sendetitel',
            'type' => 'Text',
            'options' => array(
                'label' => 'sendetitel',
            ),
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