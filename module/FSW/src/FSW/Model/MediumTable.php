<?php
namespace FSW\Model;

use Zend\Db\TableGateway\TableGateway;

class MediumTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMedium($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('medienid' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveMedium(Medium $medium)
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
            if ($this->getMedium($id)) {
                $this->tableGateway->update($data, array('medienid' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteMedium($id)
    {
        $this->tableGateway->delete(array('medienid' => $id));
    }
}
