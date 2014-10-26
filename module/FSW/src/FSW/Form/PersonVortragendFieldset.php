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
use Zend\Stdlib\Hydrator\ArraySerializable;



class PersonVortragendFieldset extends Fieldset implements InputFilterProviderInterface{

    public function __construct() {

        parent::__construct('vortragend');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new VeranstaltungKolloquiumPerson());
        //$this->setHydrator(new ArraySerializable())->setObject(new VeranstaltungKolloquiumPerson());




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
            'name' => 'id_kolloquium_veranstaltung',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id_kolloquium_veranstaltung'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'id_personen_extended',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id_personen_extended'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'nach_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'nach_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'vor_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'vor_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'personeninformation',
            'type' => 'textarea',
            'options' => array(
                'label' => 'personeninformation'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'person_link',
            'type' => 'textarea',
            'options' => array(
                'label' => 'person_link'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'institution_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'institution_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'institution_link',
            'type' => 'textarea',
            'options' => array(
                'label' => 'institution_link'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'institution_link_bild',
            'type' => 'textarea',
            'options' => array(
                'label' => 'institution_link_bild'
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