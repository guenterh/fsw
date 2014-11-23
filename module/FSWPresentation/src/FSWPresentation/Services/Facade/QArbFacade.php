<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSWPresentation\Services\Facade;


use FSW\Model\PersonenInfo;
use FSW\Model\Qualitaetsarbeit;
use FSW\Model\ZoraRecord;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use FSW\Services\Facade\BaseFacade;



class QArbFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */


    protected $searchFields = array(
    );



    public function getQArbeiten($qParams) {

        $configBetreuer = $this->fswConfigPlugin->get('config')->QarbBetreuer->toArray();
        $configTypen = $this->fswConfigPlugin->get('config')->QarbTypen->toArray();
        $configStatus = $this->fswConfigPlugin->get('config')->QarbStatus->toArray();

        //$sql = 'select p.*, a.*,pext.profilURL from Per_Personen p, Per_Rolle r, Qarb_ArbeitenV2 a, fsw_personen_extended pext ';
        //$sql .= ' where p.pers_id = pext.pers_id and  p.pers_id = r.roll_pers_id and r.roll_id = a.qarb_arb_betreuer1_rollid';

        $sql = 'select p.*, a.*,pext.profilURL from Per_Personen p join Per_Rolle r on (p.pers_id = r.roll_pers_id) ';
        $sql .= ' join  Qarb_ArbeitenV2 a on (r.roll_id = a.qarb_arb_betreuer1_rollid)  left join fsw_personen_extended pext  ';
        $sql .= ' on (p.pers_id = pext.pers_id)';




        //in qParams werden folgende Parameter erwartet:
        //betreuer  =>  mappt auf QarbBetreuer
        //status    =>  mappt auf QarbStatus
        //typ       =>  mappt auf QarbTypen
        //ferner wird für jeden Parametertyp ein Array erwartet. Das heisst immer Angabe mit
        //betreuer[]=straumann&betreuer[]=goltermann&status[]=laufend&status[]=abgeschlossen&typ[]=diss&typ[]=habil
        //auch wenn man nur einen einzigen Parameter mitschicken möchte.
        //Beispiel: http://localhost:30000/presentation/qarb/show?betreuer[]=straumann&betreuer[]=goltermann&status[]=laufend&status[]=abgeschlossen&typ[]=diss&typ[]=habil

        $betreuerIDs = array();
        $statiIDs = array();
        $typenStrings = array();

        if (array_key_exists('betreuer',$qParams) && is_array($qParams['betreuer'])) {
            foreach ($qParams['betreuer'] as $requestedBetreuer) {
                if (array_key_exists($requestedBetreuer,$configBetreuer)) {
                    $betreuerIDs[] = $configBetreuer[$requestedBetreuer];
                }
            }
        } else {
            //gebe ich keine Betreuer an, werden alle konfigurierten und damit alle mit der FSW verbundenen Arbeiten selektiert
            $betreuerIDs = array_values($configBetreuer);
        }
        if (array_key_exists('status',$qParams) && is_array($qParams['status'])) {
            foreach ($qParams['status'] as $requestedStatus) {
                if (array_key_exists($requestedStatus,$configStatus)) {
                    $statiIDs[] = $configStatus[$requestedStatus];
                }
            }

        }
        if (array_key_exists('typ',$qParams) && is_array($qParams['typ'])) {
            foreach ($qParams['typ'] as $requestedTyp) {
                if (array_key_exists($requestedTyp,$configTypen)) {
                    $typenStrings[] = $configTypen[$requestedTyp];
                }
            }

        }

        //ohne left join
        //if (count($betreuerIDs) > 0) {
        //    $sql .= ' and  p.pers_id in (' .   implode (',', $betreuerIDs)   .    ') ';
        //}

        //mit left join
        if (count($betreuerIDs) > 0) {
            $sql .= ' where  p.pers_id in (' .   implode (',', $betreuerIDs)   .    ') ';
        }

        if (count($statiIDs) > 0) {
            $sql .= ' and a.qarb_arb_istabgeschlossen in (' .   implode (',', $statiIDs)   .    ') ';
        }

        if (count($typenStrings) > 0) {
            $sql .= ' and a.qarb_arb_typ in (' .   implode(',', array_map(function ($value){

                    return '\'' . $value . '\'';

                }, $typenStrings))   .    ') ';
        }

        $sql .= ' order by a.qarb_arb_abschlussjahr';



        $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);

        $qualitaetsarbeiten = array();

        foreach ($result as $row) {

            $qa = new Qualitaetsarbeit();
            $qa->exchangeArray($row->getArrayCopy());

            $t = $qa->getQarbArbAutorRollid();
            if (!is_null($qa->getQarbArbAutorRollid()) && ((int)$qa->getQarbArbAutorRollid()) > 0) {

                $pi = $this->getAutorenInfo($qa->getQarbArbAutorRollid());
                if ($pi instanceof PersonenInfo) {
                    $qa->addPersonenInfo($pi);
                }

            }

            if (!is_null($qa->getQarbArbAutor2Rollid()) && ((int)$qa->getQarbArbAutor2Rollid()) > 0) {

                $pi = $this->getAutorenInfo($qa->getQarbArbAutor2Rollid());
                if ($pi instanceof PersonenInfo) {
                    $qa->addPersonenInfo($pi);
                }
            }
            $qualitaetsarbeiten[] = $qa;
        }

        return $qualitaetsarbeiten;
    }


    private function getAutorenInfo($id) {

        $info = null;

        $sql = 'select p.pers_name as nachName, p.pers_vorname as vorName, p.pers_id as id, pext.profilURL ';
        $sql .= 'from Per_Personen as p left join fsw_personen_extended as pext on (p.pers_id = pext.pers_id) ';
        $sql .= 'join Per_Rolle as r on (p.pers_id = r.roll_pers_id) ';
        $sql .= 'where r.roll_id = ' . $id;

        $result = $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        $row = $result->current();
        if ($row) {
            $info = new PersonenInfo();
            $info->exchangeArray($row->getArrayCopy());

        }

        return $info;


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
    }

    public function fetchAll()
    {
    }



}