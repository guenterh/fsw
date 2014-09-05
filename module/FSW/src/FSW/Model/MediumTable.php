<?php
namespace FSW\Model;

use Zend\Db\TableGateway\TableGateway;

class MediumTable extends BaseTable
{


    protected $searchFields = array(
        'gespraechstitel',
        'sendetitel',
    );


    //protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        parent::__construct($tableGateway);
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getMedium($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveMedium(Medium $medium)
    {
        $test = "";
        $data = array(
            'mit_id_per_extended' => $medium->getMit_id_per_extended(),

            'sendetitel'  => $medium->getSendetitel(),
            'datum'  => $medium->getDatum(),
            'gespraechstitel'  => $medium->getGespraechstitel(),
            'icon'  => $medium->getIcon(),
            'link'  => $medium->getLink(),
            'medientyp'  => $medium->getMedientyp()
        );

        $id = (int)$medium->getId();
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
        $this->tableGateway->delete(array('id' => $id));
    }

    /**
     * Find institutions
     *
     * @param    String            $searchString
     * @param    Integer            $limit
     * @param    String            $order
     * @return    BaseModel[]
     */
    public function find($searchString, $limit = 30, $order = 'gespraechstitel')
    {
        return $this->findFulltext($searchString, $order, $limit);
    }

}

