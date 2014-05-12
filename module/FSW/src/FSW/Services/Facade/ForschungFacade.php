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



}