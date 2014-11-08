<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Lehrveranstaltung;

use Zend\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LehrveranstaltungFieldset extends Fieldset implements InputFilterProviderInterface {


    protected $inputFilter;

    public function __construct() {

        parent::__construct('lehrveranstaltung');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Lehrveranstaltung());


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
            'name' => 'bis_zeit',
            'type' => 'textarea',
            'options' => array(
                'label' => 'bis_zeit'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'olatlink',
            'type' => 'textarea',
            'options' => array(
                'label' => 'olatlink'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));



        $this->add(array(
            'name' => 'semester',
            'type' => 'textarea',
            'options' => array(
                'label' => 'semester'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'tag',
            'type' => 'textarea',
            'options' => array(
                'label' => 'tag'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'titel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'titel'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'von_zeit',
            'type' => 'textarea',
            'options' => array(
                'label' => 'von_zeit'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'vvzlink',
            'type' => 'textarea',
            'options' => array(
                'label' => 'vvzlink'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        /*
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'personExtended',
            'options' => array(
                'label' => 'extended Attributes FSW',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\PersonExtendedFieldset'
                )
            )
        ));

        */

    }



    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterSpecification()
    {
        return array(
            'titel' => array(
                'required' => true,
            ),
            'id' => array(
                'required' => true,
            ),


        );
    }


}