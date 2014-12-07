<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use FSW\Model\Abteilung;
use FSW\Model\Funktion;
use FSW\Model\PersonenInList;
use FSW\Model\PersonenRolleInfo;
use FSW\Model\RelationHSFSWPersonExtended;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;


class PersonFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */

    //protected $tableGatewayPersExtended;
    //protected $tableGatewayZoraAuthor;

    protected $searchFields = array(
        'pers_name',
        'pers_vorname',
    );

    public function __construct()
    {
        #$this->tableGateway = $tableGatewayPersCore;
        #$this->tableGatewayPersExtended = $tableGatewayPersExtended;
        #$this->tableGatewayZoraAuthor = $tableGatewayZoraAuthor;

    }



    /**
     * Find elements
     *
     * @param    String $searchString
     * @param    Integer $limit
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30)
    {
        //$test = $this->getAll(null,$limit);
        $test = $this->findFulltext($searchString,'pers_name',500);

        return $test;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPersonFromZoraAuthorId($authorId) {

        $select	= new Select();
        $select->from('fsw_zora_author');
        $select->join(array('ext' => 'fsw_personen_extended'),
            'fsw_zora_author.fid_personen = ext.id',
            array());

        $select->where(array('fsw_zora_author.id' => $authorId));

        $results = $this->histSemDBService->getZoraAuthorGateway()->selectWith($select);


        return  $results->current()->getPers_id();

    }

    public function deleteZoraAuthor($authorId) {

        //todo: pruefe ob für die Id nicht bereits Verbindungen vorhanden sind, wenn ja, Mitteilung und kein delete!

        $results = $this->histSemDBService->getZoraAuthorGateway()->delete(array('id' => $authorId));
    }


    public function addZoraAuthor($persExtendedFSW,
                                    $persIdHS,
                                    $zoraName,
                                    $zoraNameCustomized) {

        //todo: pruefe ob persIdHS mitgegeben wird, ansonsten ermittle sie
        //ist zoraname ein gültiger Name?
        //der Name darf nicht bereits in der Datenbank vorhanden sein
        //werfe Exception wenn Fehler vorhanden
        $results = $this->histSemDBService->getZoraAuthorGateway()->insert(
                                    array('fid_personen'            => $persExtendedFSW,
                                            'pers_id'               => $persIdHS,
                                            'zora_name'             =>  $zoraName,
                                            'zora_name_customized'  =>  $zoraNameCustomized));
    }



    public function updateZoraAuthor ($zoraAuthorId,
                                      $zoraAuthorName,
                                      $zoraAuthorNameCustomized) {

        $daten = array('id' => $zoraAuthorId,
            'zora_name' => $zoraAuthorName,
            'zora_name_customized' => $zoraAuthorNameCustomized);

        $results = $this->histSemDBService->getZoraAuthorGateway()->update(

            array(
            'zora_name' => $zoraAuthorName,
            'zora_name_customized' => $zoraAuthorNameCustomized),
            array('id' => $zoraAuthorId)

        );
        $test = "";

    }





    public function getPerson($persID) {



        $persCore =  $this->histSemDBService->getPersonenGateway()->select(array('pers_id' => (int) $persID));

        $persCoreType = $persCore->current();

        if ($persCore->count() != 1)  {
            throw new \Exception("Could not find any person with id:  $persID");
        } else  {


            $this->isPersonFSWRelatedAndCorrectLinked($persCoreType);

            //hat die Person eine FSW Rolle und ist diese mit den FSW Tabellen verlinkt
            $tableRollenGateway = $this->histSemDBService->getRollenGateway();
            $rollen = $tableRollenGateway->select(array('roll_pers_id' => (int)$persID));
            $rollenArray = array();
            foreach ($rollen as $rolle) {
                $rollenArray[] = $rolle;
            }


            $persExtended = $this->runSelect(array('pers_id' => (int)$persID), $this->histSemDBService->getFSWPersonenExtendedGateway());

            if ($persExtended) {

                //sollen die extended Attribute des FSW als collection angezeigt werden
                //(duch die collection erscheinen bei Personen die nicht zur FSW gehören keine Eingabeelemente)
                //muss die gefundene Struktur als array übergeben werden. Ansonsten gibt es ein Problem beim Binden des Modells an die Form
                //dies passiert im Controller, der die Form dann der View übergibt


                $persCoreType->setPersonExtended(array($persExtended));
                $id = (int) $persExtended->getId();
                //$rowExtendedZora = $this->tableGatewayZoraAuthor->select(array('fid_personen' => $id))->current();

                $persExtendedZoraAuthorNames = $this->runSelect(array('fid_personen' => $id), $this->histSemDBService->getZoraAuthorGateway(),false);

                $zoraAuthorNames = array();
                foreach ($persExtendedZoraAuthorNames as  $zoraAuthor) {
                    $zoraAuthorNames[$zoraAuthor->getId()] = $zoraAuthor;
                }

                $persCoreType->setZoraAuthors($zoraAuthorNames);

            }

            $tableRollenGateway = $this->histSemDBService->getRollenGateway();
            $rollen = $tableRollenGateway->select(array('roll_pers_id' => (int)$persID));
            $rollenArray = array();
            foreach ($rollen as $rolle) {
                $rollenArray[] = $rolle;
            }

            $persCoreType->setPersonRollen($rollenArray);





        }
        return $persCoreType;

    }


    private function isPersonFSWRelatedAndCorrectLinked($personType) {

        $tableRollenGateway = $this->histSemDBService->getRollenGateway();
        //suche nach Rollen mit link zu FSW
        $rollenSelect = $tableRollenGateway->getSql()->select();

        //ich suche nach Rollen, die mit der aktuelen PersonenID verknüpft sind und das "FSW Flag gesetzt haben"
        $rollenSelect->where (array('roll_pers_id' => $personType->getID(),
                        'roll_hs_fsw' => 'fsw'));
        $rollen = $tableRollenGateway->selectWith($rollenSelect);
        $rollenIds = array();
        foreach ($rollen as $rolle) {
            $rollenIds[] = $rolle->getID();
        }

        //habe ich solche Rollen mit FSW flag gefunden?
        if (count($rollenIds) > 0) {

            //nun prüfe ich, ob ich zu den Rollen mit FSW flag Einträge in den Tabellen fsw_personen:extended und
            //fsw_realtion_hsPersonen_fsw_personen bestehen
            //ich benutze dazu Per_Personen.pers_id (diese ist sowohl in Per_Rolle als auch fsw_personen_extended
            $tablePersonenFswExtendedGateway = $this->histSemDBService->getFSWPersonenExtendedGateway();
            $extendedResult = $tablePersonenFswExtendedGateway->select(array('pers_id' => (int)$personType->getID()));
            //$extendedResult = $tablePersonenFswExtendedGateway->select(array('pers_id' => (int)$persID));

            if ($extendedResult->count() == 0) {
                //ich habe noch keinen Eintrag in fsw_personen:extended, also  müssen sowohl dort als auch der
                //Verknüpfungsttabelle Einträge gesetzt werden.
                $tablePersonenFswExtendedGateway->insert(array('pers_id' => (int)(int)$personType->getID(),
                          'fullname' => $this->qV($personType->getPers_name() . ', ' . $personType->getPers_vorname())));

                $idExtendedperson= $tablePersonenFswExtendedGateway->lastInsertValue;

                $tableRelationHSFSWPersonen = $this->histSemDBService->getRelationHSFSWPersonGateway();

                foreach ($rollenIds as $rID) {
                    $tableRelationHSFSWPersonen->insert(array(
                       'fpersonen_extended_id' =>  $idExtendedperson,
                        'fper_personen_pers_id' => (int)$personType->getID(),
                        'fper_rolle_roll_id' => (int)$rID
                    ));

                }

            } else {
                //in fsw_personen_extended ist ein Eintrag vorhanden (da es vom Design nur einen einzigen geben kann,
                //beziehe ich mich auf current
                $tExtendedPerson = $extendedResult->current();

                foreach ($rollenIds as $rID) {
                    $tableRelationHSFSWPersonen = $this->histSemDBService->getRelationHSFSWPersonGateway();
                    $tRolleCurrent = $tableRelationHSFSWPersonen->select(array('fper_rolle_roll_id' => (int)$rID));
                    //trage Verknüpfungen zu einen Rolle mit FSW flag ein, wenn sie noch nicht vorhanden sind
                    if ($tRolleCurrent->count() == 0) {
                        $tableRelationHSFSWPersonen->insert(array(
                            'fpersonen_extended_id' =>  (int)$tExtendedPerson->getID(),
                            'fper_personen_pers_id' => (int)$personType->getID(),
                            'fper_rolle_roll_id' => (int)$rID
                        ));

                    }

                }

                //gibt es noch RollenIDs in der Relationentabelle, die nicht mehr in Per_Rolle eingetragen sind?
                //Ich kann dies hier automatisch machen, da ja alle anderen Beziehungen zu Rollen mit FSW flags erhalten bleiben
                //Es kann hier nicht vorkommen, dass wir sämtliche Beziehungen zu einem Eintrag in der Tabelle fsw_personen_extended loeschen
                //Es kann immer noch der Fall vorkommen, dass alle Rollen in Per_Rolle kein fsw_flag mehr haben aber immer noch Beziehungen vorhanden sind
                //dies muss im Dialog angezeigt werden un der Benutzer muss dann explizit angeben, dass die Beziehung und aller comtent dahinter (potentiell
                //Medien, Zora und andere geloescht werden
                $tableRelationHSFSWPersonen = $this->histSemDBService->getRelationHSFSWPersonGateway();

                $rS = $tableRelationHSFSWPersonen->select(array(
                    'fpersonen_extended_id' =>  (int)$tExtendedPerson->getID(),
                ));



                $rollenIDSToDelete = array();
                foreach ($rS as $tR) {
                    if (!in_array($tR->getFper_rolle_roll_id(),$rollenIds)) {

                        $rollenIDSToDelete[] = $tR->getID();
                    }

                }

                if (count($rollenIDSToDelete) > 0) {

                    foreach ($rollenIDSToDelete as $tID) {
                        $tableRelationHSFSWPersonen->delete(array('id' => (int)$tID));
                    }
                }




                //array_map (function ($tRID));
            }
        }



    }

    public function getBeziehunhenPersonRolleExtended($params = array()) {

        $beziehungen = array();
        if (isset($params['pers_id'])) {
            $sql = "select rel.fpersonen_extended_id, rel.fper_personen_pers_id, rel.fper_rolle_roll_id, ";
            $sql .= " rel.id, r.roll_abt_id, r.roll_hs_fsw from fsw_relation_hspersonen_fsw_personen rel join ";
            $sql .= " Per_Rolle r on (r.roll_id = rel.fper_rolle_roll_id) where ";
            $sql .= " rel.fper_personen_pers_id = " . $params['pers_id'];

            $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


            foreach ($result as $row) {

                $beziehung = new RelationHSFSWPersonExtended();
                $beziehung->exchangeArray($row->getArrayCopy());

                $beziehungen[$beziehung->getId()] = $beziehung;


            }
        }

        return $beziehungen;

    }


    public function insertIntoFSWExtended() {

        //zuerst: loesche die bereits vorhandenen items in den Tabellen die ich befuellen moeche

        $sql = 'delete from fsw_personen_extended';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_zora_author';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $sql = 'delete from fsw_relation_hspersonen_fsw_personen';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $sql = 'delete from fsw_medien';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        //Jetzt die Zora-Beziehungen und Dokumente loeschen (durch den Neuaufbau von Personen sollten auch diese angepasst werden
        $sql = 'delete from fsw_zora_author';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $sql = 'delete from fsw_zora_doc';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $sql = 'delete from fsw_relation_zora_author_zora_doc';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);



        //$sql = 'select * from Per_Personen';
        //$sql = 'select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion, r.roll_hs_fsw, r.roll_funk_id, r.roll_istangestellt from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = \'fsw\' and p.pers_id NOT IN (select p.pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = \'fsw\' group by p.pers_name,p.pers_vorname having count(p.pers_name) > 1) order by p.pers_name, p.pers_vorname  ;';
        $sql = 'select p.pers_id, p.pers_name, p.pers_vorname, r.roll_id,r.roll_fswfunktion, r.roll_hs_fsw, r.roll_funk_id, r.roll_istangestellt from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = \'fsw\'  order by p.pers_name, p.pers_vorname  ;';

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['pers_name']) || empty ($r['pers_name'])) {
                continue;
            }


            //Pruefe, ob der MA bereits in der Extended Tabelle eingetragen ist (bei n-Roles)

            $tSQL = "select * from fsw_personen_extended where pers_id = " . $this->qV($r['pers_id']);
            $tResult =  $this->getAdapter()->query($tSQL,Adapter::QUERY_MODE_EXECUTE);

            if ($tResult->count() > 0) {

                $tExendedType = $genIdPersonenExtended = $tResult->current();
                $genIdPersonenExtended = $tExendedType['id'];

            } else {

                $oldMitarbeiterValues = $this->getOldMitarbeiter($r['pers_name'], $r['pers_vorname']);

                $sql = "insert into fsw_personen_extended (pers_id,fullname,profilURL) ";
                $sql = $sql .  "values (" . $this->qV($r['pers_id']) . ',';
                $sql = $sql .  $this->qV($r['pers_name'] . ', ' . $r['pers_vorname']) . ',';
                $sql =   (count($oldMitarbeiterValues > 0) && !empty($oldMitarbeiterValues['profilURL']) &&
                    !is_null($oldMitarbeiterValues['profilURL'])) ? $sql . ($this->qV($oldMitarbeiterValues['profilURL']) . ' )') : $sql . ($this->qV('') . ' )') ;

                $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                $genIdPersonenExtended = $this->getAdapter()->getDriver()->getLastGeneratedValue();

            }




            $sql = "insert into fsw_relation_hspersonen_fsw_personen (fpersonen_extended_id, fper_personen_pers_id, fper_rolle_roll_id) ";
            $sql = $sql .  "values (" . $this->qV($genIdPersonenExtended) . ',';
            $sql = $sql . $this->qV($r['pers_id']) . ',';
            $sql = $sql . $this->qV($r['roll_id']) . ' )';

            $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            //ich habe einen alten Mitarbeiter gefunden, so dass ich seine Zoranamen zuordenn kann falls es welche gibt
            if (count($oldMitarbeiterValues) > 0) {

                $sql = 'select * from mitarbeiterZoraName mz where mz.mit_id = ' . $oldMitarbeiterValues['oldMitId'];
                $resultZoraName =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                foreach ($resultZoraName as $zN) {
                    $z = $zN->getArrayCopy();

                    $sql = "insert into fsw_zora_author (fid_personen,pers_id,zora_name,zora_name_customized) ";
                    $sql = $sql .  "values (" . $this->qV($genIdPersonenExtended) . ',';
                    $sql = $sql .  $this->qV($r['pers_id']) . ',';
                    $sql = $sql .  $this->qV($z['zoraName']) . ',';
                    $sql = $sql .  $this->qV($z['zoraNameCustomized']) . ' )';

                    $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                }

                //gibt es noch Medien zum einfügen?
                $sql = 'select * from medien where mit_id = ' . $oldMitarbeiterValues['oldMitId'];

                $result =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                foreach ($result as $row) {

                    $mRow = $row->getArrayCopy();
                    if (is_null($mRow['mit_id']) || empty ($mRow['mit_id'])) {
                        continue;
                    }

                    $sql = "insert into fsw_medien (datum, gespraechstitel, icon, link , medientyp, mit_id_per_extended, sendetitel) ";
                    $sql = $sql .  "values (" . $this->qV($mRow['datum']) . ',';
                    $sql = $sql .  $this->qV($mRow['gespraechstitel']) . ',';
                    $sql = $sql .  $this->qV($mRow['icon']) . ',';
                    $sql = $sql .  $this->qV($mRow['link']) . ',';
                    $sql = $sql .  $this->qV($mRow['medientyp']) . ',';
                    $sql = $sql .  $this->qV($r['pers_id']) . ',';
                    $sql = $sql .  $this->qV($mRow['sendetitel']) . ')';

                    $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                }

            }
        }


    }

    public function insertIntoFSWExtendedNRoles() {


        $sql = 'select p.pers_name, p.pers_vorname, r.roll_fswfunktion, roll_funk_id  from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = \'fsw\'  and p.pers_id in (select r.roll_pers_id from Per_Personen p, Per_Rolle r where p.pers_id = r.roll_pers_id and roll_hs_fsw = \'fsw\' group by p.pers_name,p.pers_vorname having count(p.pers_name) > 1)  order by p.pers_name, p.pers_id';

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $persname = '';

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['pers_name']) || empty ($r['pers_name'])) {
                continue;
            }



            $this->processInsertFSWMitarbeiter($r);
        }



    }

    private function processInsertFSWMitarbeiter(array $r) {











    }


    private function getOldMitarbeiter ($name, $vorname) {

        $sql = 'select * from mitarbeiter m ' ;
        $sql = $sql . ' where  m.name like "%' . $name . '%" and m.name like "%' . $vorname . '%";';
        $resultFSW =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $rValues = array();
        $i = 0;
        foreach ($resultFSW as $rowFSW) {

            //only one persone from old mitarbeiter table even it might be wrong
            if ($i > 0) continue;
            $i++;
            $f = $rowFSW->getArrayCopy();

            $rValues['oldMitId'] = $f['mit_id'];
            $rValues['profilURL'] = $f['profilURL'];

        }

        return $rValues;
    }


    public function savePersonEdit($personData) {

        $idRecord = $personData->getId();
        $personExtended = $personData->getPersonExtended();
        $zoraAuthors = $personData->getZoraAuthors();
        $data = $personData->getBaseData();
        unset($data["personExtended"]);
        unset($data["zoraAuthors"]);

        $personenGateway = $this->histSemDBService->getPersonenGateway();
        if ($idRecord == 0) {
            //sollte nicht vorkommen da ich es (bis jetzt) trenne

            $numRows = $personenGateway->insert($data);

            if ($numRows == 1) {
                $idRecord = $this->tableGateway->getLastInsertValue();
            }
        } else {
            //if ($this->getRecord($idRecord)) {
                //todo: vorher noch versuchen den record zu lesen -> siehe libadmin
                $personenGateway->update($data, array('pers_id' => $idRecord));
                if (count($personExtended) == 1) {
                    $extendedGateway = $this->histSemDBService->getFSWPersonenExtendedGateway();
                    $extendedData = $personExtended[0];
                    $extendedRow = $extendedGateway->select(array("pers_id" => $extendedData->getPers_id));
                    if ($extendedRow->count() > 0) {
                        // run an update
                        $extendedGateway->update(array($extendedData, array("pers_id" => $extendedData->getPers_id)));
                    } else {
                        //run insert
                        //$personData->getPers_vorname();
                        //$personData->getPers_name();
                        $extendedData->setFullname($personData->getPers_name() . ', ' . $personData->getPers_vorname());
                        $extendedArray = $extendedData->getBaseData();
                        $extendedGateway->insert($extendedArray);
                        $idExtended =  $extendedGateway->getLastInsertValue();
                        $test = "";



                    }

                    $test = "";

                }

            //} else {
            //    throw new \Exception(get_class($record) . ' [' . $idRecord . '] does not exist');
            //}
        }

        return $idRecord;

    }


    public function getExtendedFSWPersonAttributes($persIDExtended) {

        $persExtendedGW =  $this->histSemDBService->getFSWPersonenExtendedGateway();
        $result = $persExtendedGW->select(array(

            'id'    =>  $persIDExtended
        ));

        return $result->current();

    }

    public function saveExtendedAttributes($postData = array()) {

        $persExtendedGW =  $this->histSemDBService->getFSWPersonenExtendedGateway();

        //bei den extended Attributen will ich im Moment u einen Update der ProfilURL
        $persExtendedGW->update(array(
                'profilURL'   =>  $postData['PersonExtended']['profilURL']
            ),
            array(
                'id' =>  $postData['PersonExtended']['id']
            ));



    }


    public function getAllPersonen () {


        $sql = "select P.*, Pext.id as pextid, Pext.fullname as pextFullName, Pext.profilURL as pextUrl ";
        $sql .= " from Per_Personen P left join  fsw_personen_extended Pext on (P.pers_id = Pext.pers_id) ";
        $sql .= " order by P.pers_name";

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $personen = array();

        foreach ($result as $row) {
            $personen[] = $this->exchangeIntoPersonInList($row);
        }

        return $personen;


        //$personenTableGateway = $this->histSemDBService->getPersonenGateway();
        //$select = $personenTableGateway->getSql()->select()->order('Per_Personen.pers_name');
        //$rowset =  $personenTableGateway->selectWith($select);

        //return $rowset;

    }

    public function searchPersonen ($query, $limit = 15) {


        $sql = "select P.*, Pext.id as pextid, Pext.fullname as pextFullName, Pext.profilURL as pextUrl ";
        $sql .= " from Per_Personen P left join  fsw_personen_extended Pext on (P.pers_id = Pext.pers_id) ";
        $sql .= " where P.pers_name like '%" . $query . "%' or P.pers_vorname like '%" . $query . "%'";
        $sql .= " order by P.pers_name";

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $personen = array();

        foreach ($result as $row) {
            $personen[] = $this->exchangeIntoPersonInList($row);
        }

        return $personen;



        //$personenTableGateway = $this->histSemDBService->getPersonenGateway();
        //$select = $personenTableGateway->getSql()->select();
        //$select->where->like('Per_Personen.pers_name','%' . $query . '%');
        //$select->order('Per_Personen.pers_name');

        //$rowset =  $personenTableGateway->selectWith($select);

        //return $rowset;

    }


    private function exchangeIntoPersonInList ($row) {
        $p = new PersonenInList();
        $p->setFullname($row['pers_fullname']);
        $p->setPers_anrede($row['pers_anrede']);
        $p->setPers_changedate($row['pers_changedate']);
        $p->setPers_changedby($row['pers_changedby']);
        $p->setPers_changedip($row['pers_changedip']);
        $p->setPers_email($row['pers_email']);
        $p->setPers_fullname($row['pers_fullname']);
        $p->setPers_id($row['pers_id']);
        $p->setPers_land($row['pers_land']);
        $p->setPers_midname($row['pers_midname']);

        $p->setPers_name($row['pers_name']);
        $p->setPers_oldid($row['pers_oldid']);
        $p->setPers_ort($row['pers_ort']);
        $p->setPers_ort($row['pers_ort']);
        $p->setPers_plz($row['pers_plz']);
        $p->setPers_sex($row['pers_sex']);
        $p->setPers_strasse($row['pers_strasse']);
        $p->setPers_tel_mobile($row['pers_tel_mobile']);
        $p->setPers_tel_privat($row['pers_tel_privat']);
        $p->setPers_titel($row['pers_titel']);
        $p->setPers_titel_OLD($row['pers_titel_OLD']);
        $p->setPers_uzhshortname($row['pers_uzhshortname']);
        $p->setPers_verstorben($row['pers_verstorben']);
        $p->setPers_vorname($row['pers_vorname']);
        $p->setFullname($row['pextFullName']);
        $p->setProfilURL($row['pextUrl']);

        $p->setId_extended($row['pextid']);

        return $p;
    }

    public function getAbteilungValues() {
        $HSAbteilungGW =  $this->histSemDBService->getHSAbteilungGateway();

        $result =  $HSAbteilungGW->select();

        $abteilungen = array();
        foreach ($result as $abteilung) {

            $abteilungen[$abteilung->getId()] = $abteilung;
        }

        return $abteilungen;
    }

    public function getFunktionenValues() {

        $HSFunktionenGW =  $this->histSemDBService->getHSFunktionGateway();

        $result =  $HSFunktionenGW->select();
        $funktionen = array();
        foreach ($result as $funktion) {

            $funktionen[$funktion->getId()] = $funktion;

        }

        return $funktionen;

    }


    public function getRollIdPersonenValues () {


        //wenn ich mit extende verknüpfe
        //$sql = 'SELECT p.pers_name as nachName, p.pers_vorname as vorName, p.pers_id as id, pext.profilURL, pext.id as extendedId, ';
        //$sql .= ' r.roll_id as rolleId from Per_Personen p join fsw_personen_extended pext on (p.pers_id = pext.pers_id) ';
        //$sql .= ' join Per_Rolle r on (p.pers_id = r.roll_pers_id)';

        //Verknüpfung Person / Rolle
        $sql = 'SELECT p.pers_name as nachName, p.pers_vorname as vorName, p.pers_id as id, r.roll_id as rolleId from ';
        $sql .= ' Per_Personen p join Per_Rolle r on (p.pers_id = r.roll_pers_id)';


        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $personRolleInfos = array();
        foreach ($result as $row) {
            $prI = new PersonenRolleInfo();
            $prI->exchangeArray($row->getArrayCopy());
            $personRolleInfos[$prI->getRolleId()] = $prI;
        }

        return $personRolleInfos;
    }

    public function loescheBeziehungPersonRolleFSWContent($relationId) {


        $relationGW =  $this->histSemDBService->getRelationHSFSWPersonGateway();
        $relationToDelete = $relationGW->select(array('id' => $relationId))->current();

        if ($relationToDelete) {
            $fpersonen_extended_id =  $relationToDelete->getFpersonen_extended_id();

            if ($relationGW->select(array("fpersonen_extended_id" => $fpersonen_extended_id))->count() > 1) {
                //sollte kaum vorkommen, da diese bereits automatisch passiert
                $relationGW->delete(array( 'id'  =>  $relationId));

            }else {
                //loesche den kompletten Content
                //$idPersonenFSWExtended = $relationToDelete->getFpersonen_extended_id();

                //loesche mit der Person verknüpfe Medien
                $medienGateway = $this->histSemDBService->getMedienGateway();
                $medienGateway->delete(array(
                    'mit_id_per_extended'   => $fpersonen_extended_id
                ));


                //ist die Person mit einer Kolloquiumsveranstaltung verknüpft, dann entferne sie
                $personVeranstaltungKolloquiumGW = $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();
                $personVeranstaltungKolloquiumGW->delete(
                    array(
                        'id_personen_extended'  =>  $fpersonen_extended_id
                    )
                );

                $zoraAuthorGW = $this->histSemDBService->getZoraAuthorGateway();

                $resultZoraAuthors = $zoraAuthorGW->select (
                    array('fid_personen'    =>  $fpersonen_extended_id)
                );


                $zoraAuthorsIds = array();
                foreach ($resultZoraAuthors as $zoraAuthor) {
                    $zaID = $zoraAuthor->getId();
                    $zoraAuthorsIds[] = $zoraAuthor->getId();

                    $sql = "select zdoctype.id from fsw_zora_doctype zdoctype join fsw_zora_doc zdoc on ";
                    $sql .= " (zdoctype.oai_identifier = zdoc.oai_identifier) join fsw_relation_zora_author_zora_doc relAuthorDoc on ";
                    $sql .= " (zdoc.id = relAuthorDoc.fid_zora_doc) join fsw_zora_author zA on ( relAuthorDoc.fid_zora_author = zA.id ) ";
                    $sql .= " where zA.id = " . $zaID;

                    //$sql = "select zdoctype.id from fsw_zora_doctype zdoctype, fsw_zora_doc zdoc, ";
                    //$sql .= " fsw_relation_zora_author_zora_doc relAuthorDoc, fsw_zora_author zA ";
                    //$sql .= " where zdoctype.oai_identifier = zdoc.oai_identifier and  zdoc.id = relAuthorDoc.fid_zora_doc and ";
                    //$sql .= " relAuthorDoc.fid_zora_author = zA.id ";
                    //$sql .= " and zA.id = " . $zaID;



                    $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                    foreach ($result as $row) {
                        //todo: GW für zoradoctype
                        $tId = $row['zdoctype.id'];
                        $sql = "delete from fsw_zora_doctype where id = " .  $this->qV ($tId);
                        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                    }

                    $sql = "select cover.id from fsw_cover cover join fsw_zora_doc zdoc on ";
                    $sql .= " (cover.oai_identifier = zdoc.oai_identifier) join fsw_relation_zora_author_zora_doc relAuthorDoc on ";
                    $sql .= " (zdoc.id = relAuthorDoc.fid_zora_doc) join fsw_zora_author zA on ( relAuthorDoc.fid_zora_author = zA.id ) ";
                    $sql .= " where zA.id = " . $zaID;

                    $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                    foreach ($result as $row) {
                        //todo: GW für zoradoctype
                        $tId = $row['cover.id'];
                        $sql = "delete from fsw_cover where id = " .  $this->qV ($tId);
                        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                    }


                    $sql = "select zdoc.id from  fsw_zora_doc zdoc join fsw_relation_zora_author_zora_doc relAuthorDoc on ";
                    $sql .= " (zdoc.id = relAuthorDoc.fid_zora_doc) join fsw_zora_author zA on ( relAuthorDoc.fid_zora_author = zA.id ) ";
                    $sql .= " where zA.id = " . $zaID;

                    $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                    foreach ($result as $row) {
                        //todo: GW für zoradoctype
                        $tId = $row['zdoc.id'];
                        $sql = "delete from fsw_zora_doc where id = " .  $this->qV ($tId);
                        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                    }


                    $sql = "select relAuthorDoc.id from  fsw_relation_zora_author_zora_doc relAuthorDoc join  fsw_zora_author zA ";
                    $sql .= "  on ( relAuthorDoc.fid_zora_author = zA.id ) where zA.id = " . $zaID;

                    $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                    foreach ($result as $row) {
                        //todo: GW für zoradoctype
                        $tId = $row['relAuthorDoc.id'];
                        $sql = "delete from fsw_relation_zora_author_zora_doc where id = " .  $this->qV ($tId);
                        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
                    }

                }

                foreach ($zoraAuthorsIds as $tzID) {

                    $sql = "delete from fsw_zora_author where id = " .  $this->qV ($tzID);
                    $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

                }


                //fuer die Tabellen, in denen content zu loeschen ist, s. Datenbankschema


                $gwPersExtended = $this->histSemDBService->getFSWPersonenExtendedGateway();

                $gwPersExtended->delete(array(
                   'id' =>  $fpersonen_extended_id
                ));

                $relationGW->delete(array( 'id'  =>  $relationId));
                //das war's



            }


        }


    }

}