<?php
namespace FSW\Services\Facade;

use FSW\Services\HistSemDBService;
use FSW\Services\HistSemDBServiceAwareInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Adapter\Adapter;

use FSW\Model\BaseModel;

/**
 * [Description]
 *
 */
abstract class BaseFacade implements HistSemDBServiceAwareInterface
{

	/**
	 * @var    String[]    Fulltext search fields
	 */
	protected $searchFields = array();

	/**
	 * @var    TableGateway    Fulltext search fields
	 */
	protected $tableGateway;

    protected $histSemDBService;

    private $adapater;
    private $oldFSWadapater;

    protected $defaultTableGateway;



	/**
	 * @param	String        $searchString
	 * @return  PredicateSet
	 */
	public function getSearchFieldsLikeCondition($searchString)
	{
		$searchString = trim($searchString);
		$searchWords = explode(' ', $searchString);
		$searchWords = array_map('trim', $searchWords);
		$predicateSet = new PredicateSet();

		foreach ($searchWords as $searchWord) {
			$likeWhere = new Where(null, Where::COMBINED_BY_OR);

			foreach ($this->searchFields as $searchField) {
				$likeWhere->like($searchField, '%' . $searchWord . '%');
			}

			$predicateSet->addPredicate($likeWhere);
		}

		return $predicateSet;
	}



	/**
	 * Find records
	 *
	 * @param    String            $searchString
	 * @param    String            $order
	 * @param    Integer            $limit
	 * @return    ResultSet
	 */
	protected function findFulltext($searchString, $order,$tableGatewayToUse = null, $limit = 30)
	{
		$select = new Select();
		$likeCondition = $this->getSearchFieldsLikeCondition($searchString);


        $targetGateway = is_null($tableGatewayToUse)? $this->defaultTableGateway : $tableGatewayToUse;

		$select->from($targetGateway->getTable())
				->order($order)
				->limit($limit)
				->where($likeCondition);


		//$sql = new Sql($this->tableGateway->getAdapter(), $this->getTable());
        //$test = $sql->getSqlStringForSqlObject($select);
		//var_dump($sql->getSqlStringForSqlObject($select));

		return $targetGateway->selectWith($select);
	}



	/**
	 * Get table name (shortcut)
	 *
	 * @return    String
	 */
	protected function getTable()
	{
		return $this->tableGateway->getTable();
	}



	/**
	 * Find elements
	 *
	 * @param    String        $searchString
	 * @param    Integer        $limit
	 * @return    BaseModel[]
	 */
	abstract public function find($searchString, $limit = 30);



	/**
	 *
	 * @param    Integer        $idRecord
	 * @return    BaseModel
	 * @throws    \Exception
	 */
	public function getRecord($idRecord)
	{
		$record = $this->tableGateway->select(array('id' => $idRecord))->current();

		if (!$record) {
			throw new \Exception("Could not find record $idRecord in table " . $this->getTable());
		}

		return $record;
	}



	/**
	 * @param    BaseModel    $record
	 * @return    Integer        (New) object ID
	 * @throws    \Exception
	 */
	public function save(BaseModel $record)
	{
		$idRecord = $record->getId();
		$data = $record->getBaseData();

		if ($idRecord == 0) {
			$numRows = $this->tableGateway->insert($data);

			if ($numRows == 1) {
				$idRecord = $this->tableGateway->getLastInsertValue();
			}
		} else {
			if ($this->getRecord($idRecord)) {
				$this->tableGateway->update($data, array('id' => $idRecord));
			} else {
				throw new \Exception(get_class($record) . ' [' . $idRecord . '] does not exist');
			}
		}

		return $idRecord;
	}



	/**
	 * Delete record
	 *
	 * @param    Integer        $idRecord
	 */
	public function delete($idRecord)
	{
		$this->tableGateway->delete(array('id' => $idRecord));
	}



	/**
	 * Get all records from table
	 *
	 * @param   String         $order
	 * @param   Integer        $limit
	 * @return	ResultSetInterface
	 */
	protected function getAll($order, $limit = 30)
	{
		$select = new Select();
		$select->from($this->getTable());

		if (!is_null($order)) {
			$select->order($order);
		}

		if ($limit) {
			$select->limit($limit);
		}

		return $this->tableGateway->selectWith($select);
	}


    public function setHistSemDBService(HistSemDBService $dbService)
    {
        $this->histSemDBService = $dbService;

    }



    protected function getAdapter() {


        if (is_null($this->adapater)) {
            $this->adapater = $this->histSemDBService->getAdapter();
        }
        return $this->adapater;
    }

    protected function getOldAdapter() {


        if (is_null($this->oldFSWadapater)) {
            $this->oldFSWadapater = $this->histSemDBService->getOldFSWAdapter();
        }
        return $this->oldFSWadapater;
    }



    protected function runSelect($where = array(), $gateway = null, $single = true) {

        $tGateway = $gateway;
        if (is_null($gateway )) {
            $tGateway = $this->tableGateway;
        }

        return  $single ?  $tGateway->select($where)->current() : $tGateway->select($where);
    }

    /**
     * @param $value
     * @return string
     * Each value inserted into DB has to be quoted and escaped
     * for the target storage (in our case MySQL)
     */
    protected function qV ($value) {

        return $this->getAdapter()->getPlatform()->quoteValue($value);

    }




    public function searchFSWPersonen ($query, $limit = 15) {

        $personenTableGateway = $this->histSemDBService->getPersonenGateway();
        $select = $personenTableGateway->getSql()->select();
        /*
         * mit mehrfachem join, dann erhält man nur die Persone, die bereits einen MedienEintrag haben
         * wir wollen aber alle FSW Personen
        $select->join(array(
            'pers_extended' => 'fsw_personen_extended'),
             'pers_extended.pers_id = Per_Personen.pers_id'   )->
        join(array(
            'medien' => 'fsw_medien'),
            'pers_extended.pers_id = medien.mit_id_per_extended'   );

        */

        $select->join(array(
                'pers_extended' => 'fsw_personen_extended'),
            'pers_extended.pers_id = Per_Personen.pers_id'   );
        //$select->order($order);
        //$select->limit($limit);
        $select->where->like('pers_extended.fullname','%' . $query . '%');
        $select->order('Per_Personen.pers_name');

        $rowset =  $personenTableGateway->selectWith($select);

        return $rowset;



    }


    public function getAllPersonen () {

        $personenTableGateway = $this->histSemDBService->getPersonenGateway();
        $select = $personenTableGateway->getSql()->select()->order('Per_Personen.pers_name');
        $rowset =  $personenTableGateway->selectWith($select);

        return $rowset;



    }



    public function searchPersonen ($query, $limit = 15) {

        $personenTableGateway = $this->histSemDBService->getPersonenGateway();
        $select = $personenTableGateway->getSql()->select();
        $select->where->like('Per_Personen.pers_name','%' . $query . '%');
        $select->order('Per_Personen.pers_name');

        $rowset =  $personenTableGateway->selectWith($select);

        return $rowset;



    }




    public function getFSWPersonen () {





        $personenTableGateway = $this->histSemDBService->getPersonenGateway();
        $select = $personenTableGateway->getSql()->select();
        /*
         * mit mehrfachem join, dann erhält man nur die Persone, die bereits einen MedienEintrag haben
         * wir wollen aber alle FSW Personen
        $select->join(array(
            'pers_extended' => 'fsw_personen_extended'),
             'pers_extended.pers_id = Per_Personen.pers_id'   )->
        join(array(
            'medien' => 'fsw_medien'),
            'pers_extended.pers_id = medien.mit_id_per_extended'   );

        */

        $select->join(array(
                'pers_extended' => 'fsw_personen_extended'),
            'pers_extended.pers_id = Per_Personen.pers_id'   );
        $select->order('Per_Personen.pers_name');

        $rowset =  $personenTableGateway->selectWith($select);

        return $rowset;


    }

    public function getForschungen ( $params = array())
    {
        //Masterarbeit
        //Habilitation
        //Lizentiatsarbeit
        //Dissertation
        //SELECT * FROM `Qarb_ArbeitenV2` WHERE `qarb_arb_typ` not in ('Lizentiatsarbeit', 'Dissertation', 'Masterarbeit', 'Habilitation') ORDER BY `qarb_arb_autorid`

        $forschungenTG = $this->histSemDBService->getForschungenGateway();
        $select = $forschungenTG->getSql()->select();
        if (array_key_exists('pers_id', $params)) {
            $select->where->equalTo(
                'qarb_arb_autorid',$params['pers_id']);
        }
        if (array_key_exists('forschungstypen', $params) && is_array($params['forschungstypen'])) {

            /*
            $select->where->in(
                'qarb_arb_typ', array('Dissertation'));
            */
            //)->where(array('qarb_arb_autorid' => $mitID));
            $select->where->in(
                'qarb_arb_typ', $params['forschungstypen']);
        }


        $resultset = $forschungenTG->selectWith($select);
        $forschungen = array();
        foreach ($resultset as $arbeit) {
            $forschungen[] = $arbeit;
        }

        return $forschungen;
    }


    public function getZoraDocs ( $params = array())
    {
        //Masterarbeit
        //Habilitation
        //Lizentiatsarbeit
        //Dissertation
        //SELECT * FROM `Qarb_ArbeitenV2` WHERE `qarb_arb_typ` not in ('Lizentiatsarbeit', 'Dissertation', 'Masterarbeit', 'Habilitation') ORDER BY `qarb_arb_autorid`

        $zoraDocTG = $this->histSemDBService->getZoraDocGateway();
        $select = $zoraDocTG->getSql()->select();

        //$select->columns(array('title','oai_identifier'));
        if (array_key_exists('pers_id', $params)) {

            $select->join(array(
                    'zora_author_relation' => 'fsw_relation_zora_author_zora_doc'),
                'zora_author_relation.fid_zora_doc = fsw_zora_doc.id'   );


            $select->join(array(
                    'zora_author' => 'fsw_zora_author'),
                'zora_author.id = zora_author_relation.fid_zora_author'   );


            $select->where->equalTo(
                'zora_author.pers_id',$params['pers_id']);


        }



        $resultset = $zoraDocTG->selectWith($select);
        $zoradocs = array();
        foreach ($resultset as $arbeit) {
            $zoradocs[] = $arbeit;
        }

        return $zoradocs;
    }


    public function getHSPerson($persID) {



        $persCore =  $this->histSemDBService->getPersonenGateway()->select(array('pers_id' => (int) $persID));

        $persCoreType = $persCore->current();

        if ($persCore->count() != 1)  {
            throw new \Exception("Could not find any person with id:  $persID");
        }

        return $persCoreType;

    }






}
