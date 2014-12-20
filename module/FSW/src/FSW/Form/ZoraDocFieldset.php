<?php
/**
 * Created by PhpStorm.
 * User: swissbib
 * Date: 4/28/14
 * Time: 10:20 PM
 */

namespace FSW\Form;

use FSW\Model\Medium;

use FSW\Model\ZoraDoc;
use FSW\Model\ZoraDocWithCover;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ZoraDocFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('zoraDoc');

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new ZoraDocWithCover());

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
            'name' => 'title',
            'type' => 'textarea',
            'options' => array(
                'label' => 'title'
            ),
            'attributes' => array(
                'rows' => 2 ,
                'class' => 'fswTextAreaSmall',
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'author',
            'type' => 'textarea',
            'options' => array(
                'label' => 'author'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'datestamp',
            'type' => 'textarea',
            'options' => array(
                'label' => 'datestamp'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'oai_identifier',
            'type' => 'textarea',
            'options' => array(
                'label' => 'oaiidentifier'
            ),
            'attributes' => array(
                'rows' => 1 ,
                'class' => 'fswTextAreaSmall',
                'readonly'  => 'readonly'
            )
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'textarea',
            'options' => array(
                'label' => 'status'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'xmlrecord',
            'type' => 'textarea',
            'options' => array(
                'label' => 'xmlrecord'
            ),
            'attributes' => array(
                'rows' => 1
            )
        ));

        $this->add(array(
            'name' => 'year',
            'type' => 'textarea',
            'options' => array(
                'label' => 'year'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'date',
            'type' => 'textarea',
            'options' => array(
                'label' => 'date'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
                'readonly'  => 'readonly'
            )
        ));


        $this->add(array(
            'name' => 'coverlink',
            'type' => 'textarea',
            'options' => array(
                'label' => 'coverlink'
            ),
            'attributes' => array(
                'rows' => 2 ,
                'class' => 'fswTextAreaSmall',
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
            'id' => array(
                'required' => true,
            )
        );
    }
}