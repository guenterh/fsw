<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Forschung;

use FSW\Model\Person;
use Zend\Form\Element\Collection;
use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Zend\InputFilter\InputFilterProviderInterface;

class ForschungFieldset extends Fieldset implements InputFilterProviderInterface{

    public function __construct($name = 'forschung') {

        parent::__construct($name);



        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Forschung());



        //$this->populateValues($forschungen->getArbeiten());
        //$this->bindValues($forschungen);

        $this->add(array(
            'name' => 'qarb_arb_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_id'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_autorid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_autorid'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_autor_rollid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_autor_rollid'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_titel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_titel'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_typ',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_typ'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_betreuer1',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_betreuer1'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_betreuer1_rollid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_betreuer1_rollid'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_betreuer2',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_betreuer2'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_istabgeschlossen',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_istabgeschlossen'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_abschlussjahr',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_abschlussjahr'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_semester',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_semester'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_bemerkungen',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_bemerkungen'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_abstract',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_abstract'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_imwebsichtbar',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_imwebsichtbar'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_DOI',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_DOI'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_ISSN',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ISSN'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_ISBN',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ISBN'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_ZORA',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ZORA'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_FDB',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_FDB'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_URL',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_URL'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_changed',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_changed'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));


        //$this->populateValues($forschungen);

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
            'qarb_arb_titel' => array(
                'required' => true,
            )
        );    }
}