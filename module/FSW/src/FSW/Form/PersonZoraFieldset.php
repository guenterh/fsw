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

class PersonZoraFieldset extends Fieldset {


    private $readOnly = true;

    public function __construct($readOnly = true) {

        $this->readOnly = $readOnly;

        parent::__construct('PersonZora');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new PersonZoraAuthor());

        $attributesArea = $this->readOnly ? array(
            'rows' => 1,
            'readonly'  => 'readonly'

        ) : array(
            'rows' => 1,

        );


        $attributesDate = $this->readOnly ? array(
            'rows' => 1,
            //'class' => 'datePicker',
            'disabled'  => 'true'

        ) : array(
            'rows' => 1,
            //'class' => 'datePicker',

        );



        $this->add(array(
            'name' => 'id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaVerySmall',
                'readonly'  => 'readonly'

            )
        ));



        $this->add(array(
            'name' => 'fid_personen',
            'type' => 'textarea',
            'options' => array(
                'label' => 'fid_personen'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaVerySmall',
                'readonly'  => 'readonly'

            )
        ));

        $this->add(array(
            'name' => 'pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'pers_id'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaVerySmall',
                'readonly'  => 'readonly'

            )
        ));

        $this->add(array(
            'name' => 'zora_name',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name'
            ),
            'attributes' => $attributesArea
        ));

        $this->add(array(
            'name' => 'zora_name_customized',
            'type' => 'textarea',
            'options' => array(
                'label' => 'zora_name_customized'
            ),
            'attributes' => $attributesArea
        ));



        $years = array();

        for ($i = 1950; $i < 2051 ; $i++) {
            $years ["$i"] = "$i";
        }
        $years["0"] = "0";

        //select ist vom Framework her immer required
        //Stand Version 2.x
        //bug


        $this->add(array(
            'name' => 'year_from',
            'type' => 'select',
            'options' => array(
                'empty_option' => '-',
                'label' => 'datum_von (0 leeres Datum)',
                'value_options' => $years
            ),
            'attributes' => $attributesDate
        ));

        $this->add(array(
            'name' => 'year_until',
            'type' => 'select',
            'options' => array(
                'label' => 'datum_bis (0 leeres Datum)',
                'empty_option' => '-',

                'value_options' => $years
            ),
            'attributes' => $attributesDate
        ));






    }


    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    /*
    public function getInputFilterSpecification()
    {
        return array(
            'zora_name' => array(
                'required' => true,
            )
        );
    }*/
}