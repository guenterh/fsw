<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:40
 */

namespace FSW\Services;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use FSW\Model\Person;
use FSW\Model\Aktivitaet;
use FSW\Services\Facade\PersonFacade;
use FSW\Services\Facade\AktivitaetFacade;




class Factory {


    public static function getPersonFacade(ServiceManager $sm) {


        $tableGateway = $sm->get('PersonTableGateway');
        $table = new PersonFacade($tableGateway);
        return $table;


    }
    //getAktivitaetFassade
    public static function getAktivitaetFassade(ServiceManager $sm) {

        $tableGateway = $sm->get('AktivitaetTableGateway');
        $facade = new AktivitaetFacade($tableGateway);
        return $facade;

    }


    public static function getPersonTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Person());
        return new TableGateway('mitarbeiter', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getAktivitaetTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Aktivitaet());
        return new TableGateway('Qarb_ArbeitenV2', $dbAdapter, null, $resultSetPrototype);
    }



} 