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

    public function __construct($name = 'forschung', $personRolleIDInfo = null) {

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
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_autorid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_autorid'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_autor_rollid',
            'type' => 'textarea',
            'options' => array(
                'label' => 'autor rollid    '
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_titel',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Titel'
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextAreaMiddle',
                'readonly'  => 'readonly'

            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_typ',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Typ'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_betreuer1',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Betreuer 1'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        if (is_null($personRolleIDInfo)) {
            $this->add(array(
                'name' => 'qarb_arb_betreuer1_rollid',
                'type' => 'textarea',
                'options' => array(
                    'label' => 'Betreuer 1'
                ),
                'attributes' => array(
                    'rows' => 1,
                    'readonly'  => 'readonly'
                )
            ));
        } else {
            $selectarray = array();
            foreach ($personRolleIDInfo as $key => $prID) {

                $selectarray[$key] = $prID->getNachName() . ' ' . $prID->getVorName();
            }

            $this->add(array(
                'name' => 'qarb_arb_betreuer1_rollid',
                'type' => 'select',
                'options' => array(
                    'empty_option' => '- kein Name zur Rolle -',
                    'label' => 'Betreuer 1',
                    'value_options' => $selectarray
                ),
                'attributes' => array(
                    'rows' => 2,
                    'class' => 'fswTextAreaSmall',
                    'disabled'  => 'true'
                )

            ));

        }


        $this->add(array(
            'name' => 'qarb_arb_betreuer2',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_betreuer2'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'qarb_arb_istabgeschlossen',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_istabgeschlossen'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_abschlussjahr',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_abschlussjahr'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_semester',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_semester'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_bemerkungen',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_bemerkungen'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_abstract',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Abstract'
            ),
            'attributes' => array(
                'rows' => 8,
                'class' => 'fswTextAreaMiddle',
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_imwebsichtbar',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_imwebsichtbar'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_DOI',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_DOI'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_ISSN',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ISSN'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_ISBN',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ISBN'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_ZORA',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_ZORA'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'qarb_arb_FDB',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_FDB'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_URL',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_URL'
            ),
            'attributes' => array(
                'class' => 'fswTextAreaMiddle',
                'rows' => 1,
                'readonly'  => 'readonly'
            )
        ));
        $this->add(array(
            'name' => 'qarb_arb_changed',
            'type' => 'textarea',
            'options' => array(
                'label' => 'qarb_arb_changed'
            ),
            'attributes' => array(
                'rows' => 1,
                'readonly'  => 'readonly'
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