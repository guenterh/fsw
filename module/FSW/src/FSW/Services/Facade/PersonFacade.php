<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 04.04.14
 * Time: 20:22
 */

namespace FSW\Services\Facade;


//use Libadmin\Model\BaseModel;

class PersonFacade extends BaseFacade {
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


} 