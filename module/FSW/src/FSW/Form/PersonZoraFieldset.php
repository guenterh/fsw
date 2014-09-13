<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\PersonZoraAuthor;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class PersonZoraFieldset extends Fieldset implements InputFilterProviderInterface{

    public function __construct() {

        parent::__construct('PersonZora');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new PersonZoraAuthor());

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
            'name' => 'zora_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'zora_name_customized',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name_customized'
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
            'zora_name' => array(
                'required' => true,
            )
        );    }
}