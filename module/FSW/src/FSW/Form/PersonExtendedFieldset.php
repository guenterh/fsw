<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\PersonExtended;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class PersonExtendedFieldset extends Fieldset  {


    protected $readOnly;

    public function __construct($readonly = true) {

        $this->readOnly = $readonly;

        parent::__construct('PersonExtended');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new PersonExtended());

        $attributesArea = $this->readOnly ? array(
            'rows' => 3,
            'class' => 'fswTextAreaSmall',
            'readonly'  => 'readonly'

        ) : array(
            'rows' => 3,
            'class' => 'fswTextAreaSmall'

        );




        $this->add(array(
            'name' => 'id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id'
            ),
            'attributes' => array(
                'rows' => 1,
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
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'profilURL',
            'type' => 'textarea',
            'options' => array(
                'label' => 'profilURL'
            ),
            'attributes' => $attributesArea
        ));


        $this->add(array(
            'name' => 'fullname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'fullname'
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
    /*
    public function getInputFilterSpecification()
    {
        return array(
            'pers_id' => array(
                'required' => true,
            )
        );
    }
    */
}