<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use FSW\Model\ZoraDocOnlyCover;
use Zend\Form\Form;

use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CoverlinkForm extends Form {


    public function __construct($name = 'Coverlink')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new ZoraDocOnlyCover());

        $this->add(array(
            'name' => 'id',
            'type' => 'textarea',
            'options' => array(
                'label' => 'id'
            ),
            'attributes' => array(
                'rows' => 1,
            )
        ));


        $this->add(array(
            'name' => 'coverlink',
            'type' => 'textarea',
            'options' => array(
                'label' => 'coverlink'
            ),
            'attributes' => array(
                'rows' => 1,
            )
        ));

        $this->add(array(
            'name' => 'oai_identifier',
            'type' => 'textarea',
            'options' => array(
                'label' => 'oai_identifier'
            ),
            'attributes' => array(
                'rows' => 1,
            )
        ));

        $this->add(array(
            'name' => 'frontpage',
            'type' => 'textarea',
            'options' => array(
                'label' => 'frontpage'
            ),
            'attributes' => array(
                'rows' => 1,
            )
        ));
    }

} 