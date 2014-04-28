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

class PersonForm extends Form {


    public function __construct($name = 'person',
                                    Fieldset $personCoreFieldset,
                                    Fieldset $personExtendedFieldset,
                                    Fieldset $personZoraFieldset)
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add($personCoreFieldset);
        $this->add($personExtendedFieldset);
        $this->add($personZoraFieldset);
    }

} 