<?php
/**
 * Created by PhpStorm.
 * User: guenter
 * Date: 1/7/14
 * Time: 9:37 PM
 */

namespace FSW\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;



class KolloqiumTable {


    /*
     * @var
     */
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;

    }



    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getKolloqium($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('idkolloquium' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find kolloquium row $id");
        }
        return $row;
    }

    public function saveKolloquium(Kolloqium $kolloquium)
    {
    }

    public function deleteKolloquium($id)
    {

        throw new \Exception("more has to be done - delete the dependent Veranstaltungen");

        //$this->tableGateway->delete(array('medienid' => $id));
    }





} 