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
use FSW\Model\ZoraDoc;
use FSW\Model\ZoraDocType;
use FSW\Model\ZoraAuthor;
use FSW\Model\Cover;
use FSW\Model\Aktivitaet;
use FSW\Services\Facade\PersonFacade;
use FSW\Services\Facade\AktivitaetFacade;
use FSW\Services\Facade\ZoraFacade;
use FSW\Services\OAI;





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

    public static function getZoraFacade (ServiceManager $sm)
    {

        $tGZoraDoc = $sm->get('ZoraDocTableGateway');
        $tGZoraDocType = $sm->get('ZoraDocTypeTableGateway');
        $tGZoraAuthor = $sm->get('ZoraAuthorTableGateway');
        $tGCover = $sm->get('CoverTableGateway');

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();

        $zF = new ZoraFacade($tGZoraDoc,$tGZoraAuthor,$tGZoraDocType,$tGCover,$sm,$dbAdapter);

        return $zF;


    }




    public static function getZoraDocTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraDoc());
        return new TableGateway('fsw_zora_doc', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getZoraAuthorTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraAuthor());
        return new TableGateway('fsw_zora_author', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getZoraDocTypeTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraDocType());
        return new TableGateway('fsw_zora_doctype', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getCoverTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Cover());
        return new TableGateway('fsw_cover', $dbAdapter, null, $resultSetPrototype);
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

    /**
     * Construct the HTTP service.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \VuFindHttp\HttpService
     */
    public static function getHttp(ServiceManager $sm)
    {
        //$config = $sm->get('VuFind\Config')->get('config');
        $options = array();
        /*
        if (isset($config->Proxy->host)) {
            $options['proxy_host'] = $config->Proxy->host;
            if (isset($config->Proxy->port)) {
                $options['proxy_port'] = $config->Proxy->port;
            }
        }
        $defaults = isset($config->Http)
            ? $config->Http->toArray() : array();
        */
        $defaults = array();

        return new \VuFindHttp\HttpService($options, $defaults);
    }


    public static function getOAIClient(ServiceManager $sm)
    {
        $client = $sm->get('VuFind\Http')->createClient();
        $oaiConfig = $sm->get('FSW\Config')->get('oai');
        $oaiClient =  new OAI($client);;
        foreach ($oaiConfig as $sectionName => $oaiSection) {

            if (isset($oaiSection->active) && $oaiSection->active && $sectionName == 'Zora') {
                $oaiClient->setConfig($sectionName,$oaiSection->toArray());
            }
         }

        return $oaiClient;

    }




} 