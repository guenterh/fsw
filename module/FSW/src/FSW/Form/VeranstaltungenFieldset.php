<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\PersonExtended;
use FSW\Model\VeranstaltungKolloquium;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Stdlib\Hydrator\ArraySerializable;

class VeranstaltungenFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('Veranstaltungen');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new VeranstaltungKolloquium());



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
            'name' => 'id_kolloquium',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id_kolloquium'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'datum',
            'type' => 'text',
            'options' => array(
                'label' => 'datum'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'datePicker'
            )
        ));


        $this->add(array(
            'name' => 'veranstaltung_titel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'veranstaltung_titel'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'beschreibung',
            'type' => 'textarea',
            'options' => array(
                'label' => 'beschreibung'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'vortragend',

            'options' => array(
                'label' => 'vortragend',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\PersonVortragendFieldset'
                )
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
            ),

            'id_kolloquium' => array(
                'required' => true,
            ),
            'datum' => array(
                'required' => true,
            ),
            'veranstaltung_titel' => array(
                'required' => true,
            ),

        );
    }
}