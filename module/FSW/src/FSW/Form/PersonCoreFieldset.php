<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Person;
use Zend\Form\Fieldset;

use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PersonCoreFieldset extends Fieldset implements InputFilterProviderInterface {


    protected $inputFilter;

    public function __construct() {

        parent::__construct('PersonCore');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Person());


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
            'name' => 'pers_uzhshortname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_uzhshortname'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'pers_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_name'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));



        $this->add(array(
            'name' => 'pers_midname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_midname'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'pers_vorname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_vorname'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'type' => 'FSW\Form\PersonExtendedFieldset',

            'name' => 'personExtended',
            'options' => array(
                'label' => 'Personenattribute FSW'
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


        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'zoraAuthors',
            'options' => array(
                'label' => 'ZoraNamen der Person',
                'count' => 2,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\PersonZoraFieldset'
                )
            )
        ));



    }


    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterConfig()
    {
        return array(
            'pers_name' => array(
                'required' => true,
            )
        );
    }
}