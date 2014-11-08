<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use Zend\Form\Form;

class MediumForm extends Form {


    public function __construct($name = 'medium', $personen = array())
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'gespraechstitel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'gespraechstitel'
            ),
            'attributes' => array(
                'rows' => 5,
                'class' => 'fswTextArea'
            )
        ));


        $this->add(array(
            'name' => 'link',
            'type' => 'textarea',
            'options' => array(
                'label' => 'link'
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextArea'
            )
        ));





        $selectarray = array();
        foreach ($personen as $key => $person) {

            $selectarray[$key] = $person->getPers_name()  . " " . $person->getPers_vorname();
        }

        $this->add(array(
            'name' => 'mit_id_per_extended',
            'type' => 'select',
            'options' => array(
                'empty_option' => '- Kein Mitarbeiter -',
                'label' => 'Mitarbeiter',
                'value_options' => $selectarray
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextArea'
            )

        ));
        /*
         * 				'empty_option' => '- Kein Kanton -',
				'value_options' => array(
					'ag' => 'Aargau',
					'ai' => 'Appenzell Innerrhoden',
					'ar' => 'Appenzell Ausserrhoden',

         */


        $this->add(array(
            'name' => 'icon',
            'type' => 'select',
            'options' => array(
                'empty_option' => '- Kein Icon -',
                'label' => 'Icon',
                'value_options' => array(
                    'woz.gif' => 'woz.gif',
                    'drs.gif' => 'drs.gif',
                    'zeit.gif' => 'zeit.gif',
                    'ta.gif' => 'ta.gif',
                    'nzz.gif' => 'nzz.gif',
                    'magazin.gif' => 'magazin.gif',
                    'migros.gif'    =>  'migros.gif',
                    'ceo.gif'   =>  'ceo.gif',
                    'baz.gif'   =>  'baz.gif',
                    'handelszeitung.gif' => 'handelszeitung.gif',
                    'st-galler-tagblatt.gif' => 'st-galler-tagblatt.gif',
                    'bund.gif'  =>  'bund.gif'



                )
            ),
            'attributes' => array(
                'class' => 'fswTextArea'
            )

        ));

        $this->add(array(
            'name' => 'sendetitel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'sendetitel'
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextArea'
            )
        ));


        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

} 