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

class VeranstaltungenFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('Veranstaltungen');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new VeranstaltungKolloquium());

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'vortragend',
            'options' => array(
                'label' => 'Vortragende',
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
            'pers_id' => array(
                'required' => true,
            )
        );
    }
}