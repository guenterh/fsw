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

class HarvestFormFromUntil extends Form {


    public function __construct($name = 'harvestingFromUntil')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'type' => 'FSW\Form\HarvestFieldsetFromUntil',

            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));



    }

} 