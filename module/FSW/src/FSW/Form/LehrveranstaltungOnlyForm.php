<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use Zend\Form\Form;

class LehrveranstaltungOnlyForm extends Form {


    public function __construct($name = 'lehrveranstaltung')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'name' => 'lehrveranstaltung',
            'type' => 'FSW\Form\LehrveranstaltungFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));

  }

} 