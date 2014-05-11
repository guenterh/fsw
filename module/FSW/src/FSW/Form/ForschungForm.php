<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use FSW\Model\Forschung;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ForschungForm extends Form {


    public function __construct($name = 'forschung')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'lizentiatmaster',
            'options' => array(
                'label' => 'lizz master',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\ForschungFieldset'
                )
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'dissertation',
            'options' => array(
                'label' => 'dissertation',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\ForschungFieldset'
                )
            )
        ));


        /*
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'dissForschung',
            'options' => array(
                'label' => 'Forschung Dissertationen',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\ForschungFieldset'
                )
            )
        ));
        */



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