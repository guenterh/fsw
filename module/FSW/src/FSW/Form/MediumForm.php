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
                    'zeit.gif' => 'Die Zeit',
                    'drs.gif' => 'DRS',
                    'sf.gif' => 'Fernsehen SF',
                    'nzz.gif' => 'Zeitung NZZ',
                    'woz.gif' => 'Zeitung WOZ',
                    'ta.gif' => 'Zeitung Tagesanzeiger',
                    'lora.gif'    =>  'Radio Lora',
                    'orf.gif'   =>  'Oesterreichischer Rundfunk',
                    'baz.gif'   =>  'Basler Zeitung',
                    'bund.gif'  =>  'Der Bund',
                    'srf.gif'  =>  'Fernsehen / Radio SRF',
                    'magazin.gif'  =>  'Magazin uzh',
                    'ceo.gif'  =>  'CEO Magazin',
                    'horizonte.gif'  =>  'horizonte snf',
                    '3sat.gif'  =>  '3 SAT',
                    'suedostschweiz.gif'  =>  'Südostschweiz',
                    'migros.gif'  =>  'Migros Magazin',
                    'handelszeitung.gif'  =>  'Handelszeitung',
                    'jahresspiegel.gif'  =>  'Jahresspiegel',
                    'st_galler_tagblatt.gif'  =>  'ST. Galler Tagblatt',
                    'rts.gif'   =>  'RTS'

                )
            ),
            'attributes' => array(
                'class' => 'fswTextArea'
            )

        ));


        $this->add(array(
            'name' => 'medientyp',
            'type' => 'select',
            'options' => array(
                'empty_option' => '- Kein Icon -',
                'label' => 'Medientyp',
                'value_options' => array(
                    '1' => 'Zeitung',
                    '2' => 'Radio',
                    '3' => 'Fernsehen',
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
            'name' => 'datum',
            'type' => 'text',
            'options' => array(
                'label' => 'Datum'
            ),
            'attributes' => array(

                'class' => 'datePicker'
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