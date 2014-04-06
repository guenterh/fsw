<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;


//use Libadmin\Model\BaseModel;

class AktivitaetFacade extends BaseFacade {
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

    public function getActivities ($activityType = array(), $mitID = 0)
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


} 