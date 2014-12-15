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

class HarvestFieldsetFromUntil extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('harvest_from_until');

        //$this->setHydrator(new ClassMethodsHydrator(false))
        //    ->setObject(new Medium());

        $this->add(array(
            'name' => 'from',
            'type' => 'textarea',
            'options' => array(
                'label' => 'from'
            ),
            'attributes' => array(
                'rows' => 1 ,
            )
        ));


        $this->add(array(
            'name' => 'until',
            'type' => 'textarea',
            'options' => array(
                'label' => 'until'
            ),
            'attributes' => array(
                'rows' => 1 ,
            )
        ));


        $this->add(array(
            'name' => 'submitFromUntil',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'start Harvesting',
                'id' => 'harvestButtonFromUntil',
            ),
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
            'from' => array(
                'required' => true,
            )
        );
    }


}