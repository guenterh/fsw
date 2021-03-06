<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;



class PersonAktivitaetenFacade extends PersonFacade {



    public function getMedien($pers_id) {

        $medienTable = $this->histSemDBService->getMedienGateway();
        $select = $medienTable->getSql()->select();
        $select->where(array('mit_id_per_extended' => $pers_id));
        $resultSet = $medienTable->selectWith($select);

        $medien = array();

        foreach($resultSet as $medium) {
            $medien[] = $medium;
        }


        return $medien;

    }



    public function getCoverlinkEntity($oaiIdenifier) {

        $coverOnlyGateway = $this->histSemDBService->getCoverOnlyTableGateway();

        $result = $coverOnlyGateway->select(array(
            'oai_identifier' => $oaiIdenifier
        ));

        return $result->current();


    }



    public function updateCoverlink($postData) {
        $coverOnlyGateway = $this->histSemDBService->getCoverOnlyTableGateway();

        $coverOnlyGateway->update(array(
                'coverlink' =>  $postData['coverlink'],
                'oai_identifier'    =>  $postData['oai_identifier'],
                'frontpage'  =>  $postData['frontpage']
            ),
        array(
            'id'    => $postData['id']
            )
        );

    }

}