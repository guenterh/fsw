<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use FSW\Model\RelationPersonLehrveranstaltung;
use Zend\Db\Sql\Select;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LehrveranstaltungPersonForm extends Form {


    public function __construct($name = 'personenLehrveranstaltung', $relationPersonLVGateway) {

        parent::__construct($name);

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new RelationPersonLehrveranstaltung());


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

        $resultSet = $relationPersonLVGateway->select(function (Select $select) {
            $select->order('pers_name ASC');
        });

        $selectarray = array();
        foreach ($resultSet as $person) {

            $selectarray[$person->getId()] = $person->getPers_name()  . " " . $person->getPers_vorname();
        }



        $this->add(array(
            'name' => 'fper_personen_pers_id',
            'type' => 'select',
            'options' => array(
                'label' => 'HS/FSW Person',
                'empty_option' => '- Kein Mitarbeiter -',
                'value_options' => $selectarray
            ),
            'attributes' => array(
                'rows' => 2,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'ffsw_lehrveranstaltungen_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'LV id'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaVerySmall',
                'readonly'  => 'readonly'

            )
        ));

    }

} 