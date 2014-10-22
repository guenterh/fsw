<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\VeranstaltungKolloquiumPerson;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class PersonVortragendFieldset extends Fieldset implements InputFilterProviderInterface{

    public function __construct() {

        parent::__construct('PersonZora');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new VeranstaltungKolloquiumPerson());




    }


    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'zora_name' => array(
                'required' => true,
            )
        );    }
}