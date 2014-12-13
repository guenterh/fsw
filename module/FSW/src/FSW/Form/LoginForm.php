<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 12/26/13
 * Time: 8:55 PM
 */

namespace FSW\Form;


use FSW\Model\User;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LoginForm extends Form {


    public function __construct($name = 'fswlogin')
    {
        // we want to ignore the name passed
        parent::__construct($name);

        $this->setHydrator(new ClassMethodsHydrator(false))
            ->setObject(new User());


        $this->add(array(
            'name' => 'id',
            'type' => 'hidden',
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'textarea',
            'options' => array(
                'label' => 'email'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'firstname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'firstname'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'password'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'lastname',
            'type' => 'textarea',
            'options' => array(
                'label' => 'lastname'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'username',
            'type' => 'textarea',
            'options' => array(
                'label' => 'username'
            ),
            'attributes' => array(
                'rows' => 1,
                'class' => 'fswTextAreaSmall',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'login',
                'id' => 'submitbutton',
            ),
        ));




  }

} 