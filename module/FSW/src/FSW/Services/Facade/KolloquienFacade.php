<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;
use Zend\Db\Adapter\Adapter;

use FSW\Model\Kolloqium;
use Zend\Db\Sql\Where;


class KolloquienFacade extends BaseFacade {


    protected $searchFields = array(
        'gespraechstitel',
        'sendetitel',
    );

    public function getKolloquien() {

        $kolloquienTableGateway =  $this->histSemDBService->getKolloquienGateway();
        $resultset =  $kolloquienTableGateway->select();
        return $resultset;

    }

    /**
     * Find institutions
     *
     * @param    String            $searchString
     * @param    Integer            $limit
     * @param    String            $order
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30, $order = 'gespraechstitel')
    {
        return $this->findFulltext($searchString, $order, $limit);
    }




    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getKolloquim($id)
    {
        $id  = (int) $id;
        $kolloquienTableGateway =  $this->histSemDBService->getKolloquienGateway();
        $rowset = $kolloquienTableGateway->select(array('id' => $id));
        $kolloquium = $rowset->current();
        if (!$kolloquium) {
            throw new \Exception("Could not find row $id");
        }

        $idKolloquium = $kolloquium->getId();
        $veranstaltungenTableGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();

        $personenVeranstaltungTableGateway =  $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();
        $rowsetVeranstaltungen =  $veranstaltungenTableGateway->select(array('id_kolloquium' => $idKolloquium));



        foreach ($rowsetVeranstaltungen as $veranstaltung) {

            $idVeranstaltung = $veranstaltung->getId();

            $rowsetPersonenVeranstaltung = $personenVeranstaltungTableGateway->select(array('id_kolloquium_veranstaltung' => $idVeranstaltung));

            foreach ($rowsetPersonenVeranstaltung as $personVeranstaltung) {

                $veranstaltung->addVortragend($personVeranstaltung);
            }

            $kolloquium->addVeranstaltung($veranstaltung);

        }



        return $kolloquium;
    }





    public function getVeranstaltung($id)
    {
        $id  = (int) $id;
        $veranstaltungenTableGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();

        $personenVeranstaltungTableGateway =  $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();
        $rowsetVeranstaltungen =  $veranstaltungenTableGateway->select(array('id' => $id));

        $veranstaltungsObject = $rowsetVeranstaltungen->current();




        $idVeranstaltung = $veranstaltungsObject->getId();

        $rowsetPersonenVeranstaltung = $personenVeranstaltungTableGateway->select(array('id_kolloquium_veranstaltung' => $idVeranstaltung));

        foreach ($rowsetPersonenVeranstaltung as $personVeranstaltung) {

            $veranstaltungsObject->addVortragend($personVeranstaltung);
        }





        return $veranstaltungsObject;
    }


    public function getEmptyKolloquium() {


        return new Kolloqium();

    }


    public function insertKolloquienFSW () {


        $sql = 'delete from fsw_kolloquium';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $sql = 'delete from fsw_kolloquium_veranstaltung';
        $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);


        //es fehlt
        //254 FSW (Siegenthaler)
        //in medien (old) gibt es einen Eintrag mit der id 11 für die es keinen Mitarbeiter gibt





        $sql = 'select * from kolloquium';

        $result =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            if (is_null($r['idkolloquium']) || empty ($r['idkolloquium'])) {
                continue;
            }

            $sql = "insert into fsw_kolloquium (id_kolloquium, titel) ";
            $sql = $sql . ' values ('  . $this->qV($r['idkolloquium']) . ',' ;
            $sql = $sql .  $this->qV($r['titel']) . ')';

            $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            $sql = 'select * from kolloquium_veranstaltung where idkolloquium = ' . $this->qV($r['idkolloquium']);

            $resultVeranstaltungen =  $this->getOldAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

            foreach ($resultVeranstaltungen as $rowV) {

                $rV = $rowV->getArrayCopy();

                $sql = "insert into fsw_kolloquium_veranstaltung (id_kolloquium, beschreibung, datum, personenname) ";
                $sql = $sql . ' values ('  . $this->qV($r['idkolloquium']) . ',' ;
                $sql = $sql .  $this->qV($rV['beschreibung']) . ',';
                $sql = $sql .  $this->qV($rV['datum']) . ',';
                $sql = $sql .  $this->qV($rV['personenname']) . ')';

                $resultFSW =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
            }


        }
    }

    public function insertKolloquienFromXMLFile ($url) {



        $kollGateway =  $this->histSemDBService->getKolloquienGateway();
        $kollVeranstaltungGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();
        $kollVeranstaltungPersonGateway = $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();

        $kollGateway->delete();
        $kollVeranstaltungGateway->delete();
        $kollVeranstaltungPersonGateway->delete();



        $content = file_get_contents("http://www.fsw.uzh.ch/static/classes/kolloquien/kolloquien.xml");

        try {
            $sxml = new \SimpleXMLElement($content);


            $kolloquien = array();

            foreach($sxml->children() as $attr=>$val)
            {



                //echo $val;
                switch ($attr) {
                    case "Kolloqium":

                        $oKolloqium = new Kolloqium();

                        $oKolloqium->initFromFile($val);
                        $oKolloqium->parseFromFile();
                        $kolloquien[] = $oKolloqium;

                        break;
                    default:
                        //todo: error logging
                }


            }


            foreach ($kolloquien as $kolloquium) {

                $kollGateway->insert(

                    array(
                        'id_kolloquium' => $kolloquium->getId_kolloquium(),
                        'titel' => $kolloquium->getTitel()

                    )

                );

                $insertValueKolloquium = $kollGateway->getLastInsertValue();

                foreach ($kolloquium->getVeranstaltung() as $veranstaltung){

                    $kollVeranstaltungGateway->insert(

                      array(
                          'id_kolloquium' => $insertValueKolloquium,
                          'beschreibung' => $veranstaltung->getBeschreibung(),
                          'datum'   => $veranstaltung->getDatum(),
                          'veranstaltung_titel' => $veranstaltung->getVeranstaltung_titel()
                      )

                    );

                    $insertValueVeranstaltung = $kollVeranstaltungGateway->getLastInsertValue();

                    foreach($veranstaltung->getVortragend() as $vortragend) {

                        $kollVeranstaltungPersonGateway->insert(

                            array(
                                'id_kolloquium_veranstaltung' => $insertValueVeranstaltung,
                                'institution_link'  => $vortragend->getInstitution_link(),
                                'institution_link_bild' =>  $vortragend->getInstitution_link_bild(),
                                'institution_name'  =>  $vortragend->getInstitution_name(),
                                'nach_name' =>  $vortragend->getNach_name(),
                                'vor_name'  =>  $vortragend->getVor_name()
                            )
                        );

                    }



                }




            }

        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    public function addSaveKolloquim($inputData = array()) {

        $kollGateway =  $this->histSemDBService->getKolloquienGateway();

        $kollGateway->insert(
            array(
                'id_kolloquium' => $inputData['id_kolloquium'],
                'titel' => $inputData['titel']

            )
        );

    }


    public function deleteKolloquim($inputData = array()) {

        $kollGateway =  $this->histSemDBService->getKolloquienGateway();
        $kollVeranstaltungGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();
        $kollVeranstaltungPersonGateway = $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();

        $id = (int) $inputData['id'];
        //$id = 3;

        $rowsVeranstaltungen =  $kollVeranstaltungGateway->select(array('id_kolloquium' =>  $id));

        $veranstaltungenIds = array();
        $personenIds = array();
        foreach ($rowsVeranstaltungen as  $veranstaltung) {
            $veranstaltungenIds[] = $veranstaltung->getId();
            $rowsPersonen =  $kollVeranstaltungPersonGateway->select(array('id_kolloquium_veranstaltung' => (int) $veranstaltung->getId()));
            foreach($rowsPersonen as $person) {
                $personenIds[] = $person->getId();
            }
        }

        if (count($personenIds) > 0) {
            $where = new Where();
            $where->in('id', $personenIds);
            $OkFalse = $kollVeranstaltungPersonGateway->delete($where);
        }
        if (count($veranstaltungenIds)>0) {
            $where = new Where();
            $where->in('id', $veranstaltungenIds);
            $OkFalse = $kollVeranstaltungGateway->delete($where);
        }

        $OkFalse =  $kollGateway->delete(array('id' => $id));



    }


    public function deleteVeranstaltung ($inputData = array()) {

        $kollVeranstaltungGateway = $this->histSemDBService->getKolloquienVeranstaltungenGateway();
        $kollVeranstaltungPersonGateway = $this->histSemDBService->getKolloquienVeranstaltungenPersonGateway();

        $id = (int) $inputData['id'];
        //$id = 3;

        $rowsVeranstaltungen =  $kollVeranstaltungGateway->select(array('id' =>  $id));

        if ($rowsVeranstaltungen->count() == 1) {

            $veranstaltung = $rowsVeranstaltungen->current();

            $personenIds = array();
                $rowsPersonen =  $kollVeranstaltungPersonGateway->select(array('id_kolloquium_veranstaltung' => (int) $veranstaltung->getId()));
                foreach($rowsPersonen as $person) {
                    $personenIds[] = $person->getId();
                }


            if (count($personenIds) > 0) {
                $where = new Where();
                $where->in('id', $personenIds);
                $OkFalse = $kollVeranstaltungPersonGateway->delete($where);
            }

            $OkFalse = $kollVeranstaltungGateway->delete(array('id' => $veranstaltung->getId()));

        }

        $test = "";
    }

}