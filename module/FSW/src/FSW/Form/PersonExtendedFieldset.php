<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\PersonExtended;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PersonExtendedFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('PersonExtended');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new PersonExtended());

        $this->add(array(
            'name' => 'pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_id'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'profilURL',
            'type' => 'textarea',
            'options' => array(
                'label' => 'profilURL'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));



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
            'pers_id' => array(
                'required' => true,
            )
        );
    }
}