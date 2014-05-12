<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Medium;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class MedienDisplayFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('medienDisplay');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Medium());

        $this->add(array(
            'name' => 'id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'gespraechstitel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'gespraechstitel'
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
            'id' => array(
                'required' => true,
            )
        );
    }
}