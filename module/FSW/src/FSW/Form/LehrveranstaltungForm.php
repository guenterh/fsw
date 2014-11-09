<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use Zend\Form\Form;

class LehrveranstaltungForm extends Form {


    public function __construct($name = 'lehrveranstaltung')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'type' => 'FSW\Form\LehrveranstaltungFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'personenLehrveranstaltung',
            'options' => array(
                'label' => 'Person der Lehrveranstaltung',
                'target_element' => array(
                    'type' => 'FSW\Form\LehrveranstaltungPersonFieldset'
                    //'type' => 'fswformlehrveranstaltungpersonfieldset'

                )
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