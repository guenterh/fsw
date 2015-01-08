<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\PersonExtended;
use FSW\Model\Rolle;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PersonRolleFieldset extends Fieldset implements InputFilterProviderInterface {



    public function __construct($abteilungen = null, $funktionen = null) {

        parent::__construct('PersonRolle');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new Rolle());

        $this->add(array(
            'name' => 'roll_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_id'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'roll_pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_pers_id'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        if (is_null($abteilungen)) {
            $this->add(array(
                'name' => 'roll_abt_id',
                'type' => 'textarea',
                'options' => array(
                    'label' => 'Abteilung'
                ),
                'attributes' => array(
                    'rows' => 1,
                    'readonly'  => 'readonly'
                )
            ));
        } else {
            $selectarray = array();
            foreach ($abteilungen as $key => $abteilung) {

                $selectarray[$key] = $abteilung->getAbt_name();
            }

            $this->add(array(
                'name' => 'roll_abt_id',
                'type' => 'select',
                'options' => array(
                    'empty_option' => '- Keine Abteilung -',
                    'label' => 'Abteilung',
                    'value_options' => $selectarray
                ),
                'attributes' => array(
                    'rows' => 2,
                    'class' => 'fswTextAreaVerySmall',
                    'disabled'  => 'true'
                )

            ));

        }
        $this->add(array(
            'name' => 'roll_arbe_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_arbe_id'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_skv_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_skv_id'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        if (is_null($funktionen)) {

            $this->add(array(
                'name' => 'roll_funk_id',
                'type' => 'textarea',
                'options' => array(
                    'label' => 'roll_funk_id'
                ),
                'attributes' => array(
                    'rows' => 1,
                    'readonly'  => 'readonly'
                )
            ));
        } else {
            $selectarray = array();
            foreach ($funktionen as $key => $funktion) {

                $selectarray[$key] = $funktion->getFunk_name();
            }

            $this->add(array(
                'name' => 'roll_funk_id',
                'type' => 'select',
                'options' => array(
                    'empty_option' => '- Keine Funktion -',
                    'label' => 'Funktion',
                    'value_options' => $selectarray
                ),
                'attributes' => array(
                    'rows' => 2,
                    'class' => 'fswTextAreaVerySmall',
                    'disabled'  => 'true'
                )

            ));

        }

        $selectarray = array(
            '0' =>  'nein',
            '1 '    =>  'ja'
        );



        $this->add(array(
            'name' => 'roll_istangestellt',
            'type' => 'select',
            'options' => array(
                'empty_option' => '- Keine Angabe -',
                'label' => 'ist angestellt?',
                'value_options' => $selectarray
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextAreaVerySmall',
                'disabled'  => 'true'
            )

        ));


        $this->add(array(
            'name' => 'roll_anstellung',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_anstellung'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'roll_persnr',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_persnr'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_datestart',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_datestart'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_dateend',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_dateend'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_anstellungprozent',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_anstellungprozent'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_befristet',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_befristet'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_email',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_email'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_telg',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_telg'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_url',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_url'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'roll_hs_fsw',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_hs_fsw'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_mund_pruf',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_mund_pruf'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_skeinladung',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_skeinladung'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_mittelbau',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_mittelbau'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'roll_verteiler_skprotokoll',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_skprotokoll'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_profs',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_profs'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_koordag',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_koordag'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_koordma',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_koordma'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_verteiler_koordnz',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_verteiler_koordnz'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_changedate',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_changedate'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_oldid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_oldid'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'roll_fswfunktion',
            'type' => 'textarea',
            'options' => array(
                'label' => 'roll_fswfunktion'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
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