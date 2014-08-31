<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;


//use Libadmin\Model\BaseModel;
use FSW\Model\Forschung;
use FSW\Model\Person;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ForschungFacade extends BaseFacade {

    /**
     * Constructor
     *
     * @param	 TableGateway	$tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        //$this->defaultTableGateway =  $this->histSemDBService->getForschungenGateway();

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
        $test = $this->getAll(null,$limit);

        return $test;
    }

    /*
    public function getForschungen ($activityType = array(), $mitID = 0)
    {

        $select = $this->tableGateway->getSql()->select();
        $where = $select->where;
        $numberTypes = count($activityType);
        if ($numberTypes > 0) {

            $where = $numberTypes > 1 ? $where->nest() : $where;
            $i=0;
            foreach($activityType as $type) {
                $where = $where->like('qarb_arb_typ',$type);
                $i++;
                if ($i < $numberTypes) {
                    $where->or;
                }
            }
            $where = $numberTypes > 1 ? $where->unnest() : $where;

        }

        if (!$mitID == 0) {
            if ($numberTypes > 0) {
                $where->and;
            }
            $where->equalTo('qarb_arb_autorid',$mitID);
        }

        return  $this->tableGateway->selectWith($select);

    }
    */

    public function getLizzMaster ( $mitID )
    {
        //Masterarbeit
        //Habilitation
        //Lizentiatsarbeit
        //Dissertation
        //SELECT * FROM `Qarb_ArbeitenV2` WHERE `qarb_arb_typ` not in ('Lizentiatsarbeit', 'Dissertation', 'Masterarbeit', 'Habilitation') ORDER BY `qarb_arb_autorid`

        $forschungenTG = $this->histSemDBService->getForschungenGateway();
        $select = $forschungenTG->getSql()->select();
        $select->where->in(
                'qarb_arb_typ', array('Lizentiatsarbeit','Masterarbeit'));
        //)->where(array('qarb_arb_autorid' => $mitID));


        $lizzMaster = $forschungenTG->selectWith($select);

        return $lizzMaster;
    }

    public function getDissertations ( $mitID )
    {
        //Masterarbeit
        //Habilitation
        //Lizentiatsarbeit
        //Dissertation
        //SELECT * FROM `Qarb_ArbeitenV2` WHERE `qarb_arb_typ` not in ('Lizentiatsarbeit', 'Dissertation', 'Masterarbeit', 'Habilitation') ORDER BY `qarb_arb_autorid`

        $forschungenTG = $this->histSemDBService->getForschungenGateway();
        $select = $forschungenTG->getSql()->select();
        $select->where->in(
            'qarb_arb_typ', array('Dissertation'));
        //)->where(array('qarb_arb_autorid' => $mitID));


        $dissertations = $forschungenTG->selectWith($select);

        return $dissertations;
    }

    public function getForschungsarbeitenFSW ( $type = 'all', $abgeschlossen = null, $mitID = null  )
    {

        $sql =  new Sql($this->getAdapter());
        $select = $sql->select();
        $select->from(array('pers' => 'Per_Personen'));
        $select->join(array('rel' => 'fsw_relation_hspersonen_fsw_personen'),
                'pers.pers_id = rel.fper_personen_pers_id',
                array());
        $select->join(array('rolle' => 'Per_Rolle'),
            'rolle.roll_id = rel.fper_rolle_roll_id',
            array());
        $select->join(
                array('fa'    =>  'Qarb_ArbeitenV2'),
                'fa.qarb_arb_autor_rollid = rolle.roll_id'
            ,array('*'));

        if (!is_null($abgeschlossen)) {
            $select->where(array('fa.qarb_arb_istabgeschlossen' => $abgeschlossen));
        }

        if (!is_null($mitID)) {
            $select->where(array('pers.pers_id' => $mitID));
        }

        if (!is_null($type) && strcmp($type,'all') != 0) {
            $select->where(array('fa.qarb_arb_typ' => $type));
        }

        $result = $this->getAdapter()->query($sql->getSqlStringForSqlObject($select), Adapter::QUERY_MODE_EXECUTE);
        //$selectStatement = $sql->prepareStatementForSqlObject($select);
        //$test = $sql->getSqlStringForSqlObject($select);

        $resultObjects = array();
        foreach ($result as $row) {

            $r = $row->getArrayCopy();
            $person = new Person();
            $forschung = new Forschung();

            $person->exchangeArray($r);
            $forschung->exchangeArray($r);

            $resultObjects[] = array($person,$forschung);

        }

        return $resultObjects;


        /*
         * so sieht die Abfrage in SQL aus
        $sql = 'select pers.*, fa.* from Per_Personen pers, fsw_relation_hspersonen_fsw_personen rel, fsw_personen_extended persext,';
        $sql .= ' Per_Rolle rolle, Qarb_ArbeitenV2 fa ';
        $sql .= ' where pers.pers_id = rel.fper_personen_pers_id and rel.fpersonen_extended_id = persext.id ';
        $sql .= ' and rolle.roll_id = rel.fper_rolle_roll_id ';
        $sql .= ' and fa.qarb_arb_autor_rollid = rolle.roll_id ';
        //and fa.qarb_arb_istabgeschlossen = 1 order by pers_name

        $result =  $this->getAdapter()->query($sql,Adapter::QUERY_MODE_EXECUTE);
        */
    }


}