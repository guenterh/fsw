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

class HarvestFieldsetEntities extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('harvest_entities');

        //$this->setHydrator(new ClassMethodsHydrator(false))
        //    ->setObject(new Medium());

        $this->add(array(
            'name' => 'entities',
            'type' => 'textarea',
            'options' => array(
                'label' => 'single Entities'
            ),
            'attributes' => array(
                'rows' => 5,
                'class' => 'fswTextAreaMiddle',
                'value' =>  'oai:www.zora.uzh.ch:xxxx##oai:www.zora.uzh.ch:yyyy'
            )
        ));

        //'value' =>  'oai:www.zora.uzh.ch:xxxx##oai:www.zora.uzh.ch:yyyy'



        $this->add(array(
            'name' => 'submitEntities',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'start Harvesting Entities',
                'id' => 'harvestButtonEntities',
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
            'entities' => array(
                'required' => true,
            )
        );
    }


}