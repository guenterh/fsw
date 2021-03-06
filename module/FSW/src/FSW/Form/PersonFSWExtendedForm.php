<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use FSW\Model\ZoraDocOnlyCover;
use Zend\Form\Form;

use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PersonFSWExtendedForm extends Form {


    public function __construct($name = 'FSWPersonExtended', $persExtendedFieldset)
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add($persExtendedFieldset);

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