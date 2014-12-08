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

class PersonFormAllHS extends Form {


    public function __construct($name = 'person',$coreFieldset, $forschungFieldset, $personRolleFSWExtendedFieldset)
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add($coreFieldset);

        /*
        $this->add(array(
            'type' => 'FSW\Form\PersonCoreFieldset',
            'name'  => 'PersonCore',
            'options' => array(
                //'use_as_base_fieldset' => true
            )
        ));
        */

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'forschungsarbeiten',
            'options' => array(
                'label' => 'forschungsarbeiten',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' =>  $forschungFieldset
                )
            )
        );

        $this->add(array(
                'type' => 'Zend\Form\Element\Collection',
                'name' => 'BeziehungPersonRolle',
                'options' => array(
                    'label' => 'Relation Person Rolle FSW Extended',
                    'should_create_template' => true,
                    'allow_add' => true,
                    'target_element' =>  $personRolleFSWExtendedFieldset
                )
            )
        );

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'medien',
            'options' => array(
                'label' => 'medien',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\MedienDisplayFieldset'
                )
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'zoradocs',
            'options' => array(
                'label' => 'zoradocs',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\ZoraDocFieldset'
                )
            )
        ));


    }

} 