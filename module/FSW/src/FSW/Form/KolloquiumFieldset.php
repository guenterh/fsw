<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Kolloqium;

use Zend\Form\Fieldset;

use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class KolloquiumFieldset extends Fieldset implements InputFilterProviderInterface {



    protected $inputFilter;

    public function __construct() {

        parent::__construct('Kolloqium');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Kolloqium());


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

        /*

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'veranstaltungen',
            'options' => array(
                'label' => 'Veranstaltungen des Kolloqiums',
                'count' => 2,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'FSW\Form\VeranstaltungenFieldset'
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
    public function getInputFilterConfig()
    {
        return array(
            'titel' => array(
                'required' => true,
            )
        );
    }
}