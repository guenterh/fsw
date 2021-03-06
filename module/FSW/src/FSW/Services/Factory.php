<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:40
 */

namespace FSW\Services;

use FSW\Model\Funktion;
use FSW\Model\Lehrveranstaltung;
use FSW\Model\Medium;
use FSW\Model\RelationPersonLehrveranstaltung;
use FSW\Model\VeranstaltungKolloquium;
use FSW\Model\VeranstaltungKolloquiumPerson;
use FSW\Model\ZoraDocOnlyCover;
use FSW\Model\ZoraDocWithCover;
use FSW\Services\Facade\MedienFacade;
use FSW\Services\Facade\PersonAktivitaetenFacade;
use Zend\ServiceManager\ServiceManager;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use FSW\Model\Person;
use FSW\Model\PersonExtended;
use FSW\Model\PersonZoraAuthor;
use FSW\Model\ZoraDoc;
use FSW\Model\ZoraDocType;
use FSW\Model\ZoraAuthor;
use FSW\Model\Cover;
use FSW\Model\Rolle;
use FSW\Model\RelationHSFSWPerson;
use FSW\Model\Forschung;
use FSW\Services\Facade\PersonFacade;
use FSW\Services\Facade\ForschungFacade;
use FSW\Services\Facade\ZoraFacade;
use FSW\Services\OAI;
use FSW\Model\Kolloqium;
use FSW\Model\Abteilung;





class Factory {



    /**
     * Generic plugin manager factory (support method).
     *
     * @param ServiceManager $sm Service manager.
     * @param string         $ns VuFind namespace containing plugin manager
     *
     * @return object
     */
    public static function getGenericPluginManager(ServiceManager $sm, $ns)
    {
        $className = 'FSW\\' . $ns . '\PluginManager';
        $configKey = strtolower(str_replace('\\', '_', $ns));
        $config = $sm->get('Config');
        return new $className(
            new \Zend\ServiceManager\Config(
                $config['fsw']['plugin_managers'][$configKey]
            )
        );
    }




    public static function getPersonFacade(ServiceManager $sm) {
        //aktuell würd ein invokable ausreichen. (Früher habe ich in dieser factory noch spezielle TableGateways erstellt)
        //vielleicht brauchen wir sie noch
        return new PersonFacade();

    }

    public static function getPersonAktivitaetFacade(ServiceManager $sm) {

        return new PersonAktivitaetenFacade();

    }





    //getForschungFassade
    public static function getForschungFacade(ServiceManager $sm) {

        $tableGateway = $sm->get('ForschungTableGateway');
        $facade = new ForschungFacade($tableGateway);
        return $facade;

    }

    public static function getZoraFacade (ServiceManager $sm)
    {

        //$tGZoraDoc = $sm->get('ZoraDocTableGateway');
        //$tGZoraDocType = $sm->get('ZoraDocTypeTableGateway');
        //$tGZoraAuthor = $sm->get('ZoraAuthorTableGateway');
        //$tGCover = $sm->get('CoverTableGateway');

        //$histSemDBService = $sm->get('HistSemDBService');
        //$dbAdapter = $histSemDBService->getAdapter();
        //es sollte der OAI client injiziert werden

        //$zF = new ZoraFacade($tGZoraDoc,$tGZoraAuthor,$tGZoraDocType,$tGCover,$sm);

        return new ZoraFacade($sm);


    }




    public static function getZoraDocTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraDoc());
        return new TableGateway('fsw_zora_doc', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getZoraDocWithCoverTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraDocWithCover());
        return new TableGateway('fsw_zora_doc', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getCoverOnlyTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new ZoraDocOnlyCover());

        return new TableGateway('fsw_cover', $dbAdapter, null, $resultSetPrototype);
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


    public static function getRollenTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Rolle());
        return new TableGateway('Per_Rolle', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getLehrveranstaltungenTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Lehrveranstaltung());
        return new TableGateway('fsw_lehrveranstaltung', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getRelationPersonLehrveranstaltungTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new RelationPersonLehrveranstaltung());
        return new TableGateway('fsw_relation_personen_fsw_lehrveranstaltung', $dbAdapter, null, $resultSetPrototype);
    }





    public static function getPersonTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Person());
        return new TableGateway('Per_Personen', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getHSAbteilungTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Abteilung());
        return new TableGateway('Per_Abteilung', $dbAdapter, null, $resultSetPrototype);

    }

    public static function getHSFunktionTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Funktion());
        return new TableGateway('Per_Funktion', $dbAdapter, null, $resultSetPrototype);

    }


    public static function getKolloquienTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Kolloqium());
        return new TableGateway('fsw_kolloquium', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getKolloquiumVeranstaltungenTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new VeranstaltungKolloquium());
        return new TableGateway('fsw_kolloquium_veranstaltung', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getKolloquiumVeranstaltungenPersonTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new VeranstaltungKolloquiumPerson());
        return new TableGateway('fsw_kolloquium_veranstaltung_person', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getRelationHSFSWPersonTableGateway (ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBAdapter');
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new RelationHSFSWPerson());
        return new TableGateway('fsw_relation_hspersonen_fsw_personen', $dbAdapter, null, $resultSetPrototype);

    }


    public static function getMedienTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Medium());
        return new TableGateway('fsw_medien', $dbAdapter, null, $resultSetPrototype);
    }


    public static function getPersonExtendedTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PersonExtended());
        return new TableGateway('fsw_personen_extended', $dbAdapter, null, $resultSetPrototype);
    }



    public static function getPersonZoraAuthorTableGateway(ServiceManager $sm) {

        $dbAdapter = $sm->get('HistSemDBService')->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new PersonZoraAuthor());
        return new TableGateway('fsw_zora_author', $dbAdapter, null, $resultSetPrototype);
    }

    public static function getForschungTableGateway(ServiceManager $sm) {

        $histSemDBService = $sm->get('HistSemDBService');
        $dbAdapter = $histSemDBService->getAdapter();
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Forschung());
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

    public static function getMedienFacade(ServiceManager $sm) {


        //$tableGatewayMedien = $sm->get('MediumTableGateway');

        $facade = new MedienFacade();
        return $facade;


    }


    /**
     * Construct the Session Plugin Manager.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \FSW\Session\PluginManager
     */
    public static function getSessionPluginManager(ServiceManager $sm)
    {
        return static::getGenericPluginManager($sm, 'Session');
    }

    /**
     * Construct the Db\Table Plugin Manager.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \FSW\Db\Table\PluginManager
     */
    public static function getDbTablePluginManager(ServiceManager $sm)
    {
        return static::getGenericPluginManager($sm, 'Db\Table');
    }

    /**
     * Construct the Auth Plugin Manager.
     *
     * @param ServiceManager $sm Service manager.
     *
     * @return \FSW\Auth\PluginManager
     */
    public static function getAuthPluginManager(ServiceManager $sm)
    {
        return static::getGenericPluginManager($sm, 'Auth');
    }






} 