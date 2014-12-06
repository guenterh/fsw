<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Medium;

use FSW\Model\RelationHSFSWPersonExtended;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class BeziehungenPersonRolleFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('beziehungenPersonRolle');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new RelationHSFSWPersonExtended());

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
            'name' => 'fper_personen_pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'FKey Person'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'fpersonen_extended_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'FKey FSW-extended'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'fper_rolle_roll_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'FKey Rolle'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'roll_hs_fsw',
            'type' => 'textarea',
            'options' => array(
                'label' => 'FSW Flag'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'roll_abt_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Abt Id'
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
            'id' => array(
                'required' => true,
            )
        );
    }
}