<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:40
 */

namespace FSW\Table;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use FSW\Model\Person;

class Factory {


    public static function getPersonTable(ServiceManager $sm) {


        $tableGateway = $sm->get('PersonTableGateway');
        $table = new PersonTable($tableGateway);
        return $table;


    }


    public static function getPersonTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Person());
        return new TableGateway('mitarbeiter', $dbAdapter, null, $resultSetPrototype);



    }


} 