<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;



class PersonFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */

    protected $tableGatewayPersExtended;
    protected $tableGatewayZoraAuthor;

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
        $rollenSelect->where (array('roll_pers_id' => $personType->getID(),
                        'roll_hs_fsw' => 'fsw'));
        $rollen = $tableRollenGateway->selectWith($rollenSelect);
        $rollenIds = array();
        foreach ($rollen as $rolle) {
            $rollenIds[] = $rolle->getID();
        }

        if (count($rollenIds) > 0) {
            $tablePersonenFswExtendedGateway = $this->histSemDBService->getFSWPersonenExtendedGateway();
            $extendedResult = $tablePersonenFswExtendedGateway->select(array('pers_id' => (int)$personType->getID()));
            //$extendedResult = $tablePersonenFswExtendedGateway->select(array('pers_id' => (int)$persID));

            if ($extendedResult->count() == 0) {

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

                $tExtendedPerson = $extendedResult->current();

                foreach ($rollenIds as $rID) {
                    $tableRelationHSFSWPersonen = $this->histSemDBService->getRelationHSFSWPersonGateway();
                    $tRolleCurrent = $tableRelationHSFSWPersonen->select(array('fper_rolle_roll_id' => (int)$rID));

                    if ($tRolleCurrent->count() == 0) {
                        $tableRelationHSFSWPersonen->insert(array(
                            'fpersonen_extended_id' =>  (int)$tExtendedPerson->getID(),
                            'fper_personen_pers_id' => (int)$personType->getID(),
                            'fper_rolle_roll_id' => (int)$rID
                        ));

                    }

                }

                //gibt es noch RollenIDs in der Relationentabelle, die nicht mehr in Per_Rolle eingetragen sind?
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



}