<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Lehrveranstaltung;

use FSW\Model\RelationPersonLehrveranstaltung;
use Zend\Db\Sql\Select;
use Zend\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LehrveranstaltungPersonFieldset extends Fieldset implements InputFilterProviderInterface {


    protected $inputFilter;
    protected $sM;


    public function init() {


        /*
        $test = $this->sM->getServiceLocator();
        $formElemenManager = $this->getFormFactory();
        $sl = $formElemenManager->getServiceLocator();

        $personenGateway = $sl->get('HistSemDBService')->getRelationPersonenLehrveranstaltungGateway();
        $resultSet = $personenGateway->select(function (Select $select) {
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
                'class' => 'fswTextAreaSmall'
            )
        ));
        */
    }


    public function __construct($name = 'personenLehrveranstaltung') {

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
                'class' => 'fswTextAreaSmall'
            )
        ));

        $this->add(array(
            'name' => 'fper_personen_pers_id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'personen id'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall'
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
                'class' => 'fswTextAreaSmall'
            )
        ));






    }



    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getInputFilterSpecification()
    {
        return array(
            'titel' => array(
                'required' => true,
            ),
            'id' => array(
                'required' => true,
            ),


        );
    }

    public function getInputFilter()
    {

        return array();
    }



}