<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:40
 */

namespace FSWPresentation\Services;

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





class Factory {

    public static function getPublicationsFacade(ServiceManager $sm) {

        $facade = new \FSWPresentation\Services\Facade\PublicationsFacade();
        return $facade;

    }


} 