<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 18.04.14
 * Time: 14:57
 */

namespace FSW\Model;

use Zend\Db\TableGateway\TableGateway;


class CoverTable extends BaseTable {

    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
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
        // TODO: Implement find() method.
    }
}