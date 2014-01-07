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
        $data = array(
            'mit_id' => $medium->mit_id,
            'sendetitel'  => $medium->sendetitel,
            'datum'  => $medium->datum,
            'gespraechstitel'  => $medium->gespraechstitel,
            'icon'  => $medium->icon,
            'link'  => $medium->link,
            'medientyp'  => $medium->medientyp,
        );

        $id = (int)$medium->medienid;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getKolloqium($id)) {
                $this->tableGateway->update($data, array('medienid' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteKolloquium($id)
    {

        throw new \Exception("more has to be done - delete the dependent Veranstaltungen");

        //$this->tableGateway->delete(array('medienid' => $id));
    }





} 