<?php
namespace FSW\Model;

use FSW\Model\PersonenInfo;
use Zend\InputFilter\InputFilter;

/**
 * [Description]
 *
 */
abstract class BaseModel
{

	/**
	 * @var InputFilter
	 */
	protected $inputFilter;


    protected $personenInfo = array();



	/**
	 * Get all object vars as array
	 *
	 * @return    Array
	 */
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}



	/**
	 * Get data for record without relations
	 *
	 * @return    Array
	 */
	public function getBaseData()
	{
		$data = $this->getArrayCopy();

		unset($data['id']);
		unset($data['inputFilter']);

		return $data;
	}



	public function exchangeArray($data)
	{
		if (is_object($data)) {
			$data = $data->getArrayCopy();
		}

		$this->initLocalVariables($data);
	}



	/**
	 * Get record ID
	 *
	 * @return    Integer
	 */
	public abstract function getId();



	/**
	 * Initialize local variables if present
	 *
	 * @param    Array    $data
	 */
	protected function initLocalVariables(array $data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
	}



	/**
	 * Get list label key
	 *
	 * @return    String
	 */
	public abstract function getListLabel();



	/**
	 * Get type label key
	 *
	 * @return    String
	 */
	public function getTypeLabel()
	{
		return get_class($this);
	}

    /**
     * @return array
     */
    public function getPersonenInfo()
    {
        return $this->personenInfo;
    }

    /**
     * @param array $personenInfo
     */
    public function setPersonenInfo($personenInfo)
    {
        $this->personenInfo = $personenInfo;
    }

    public function addPersonenInfo(PersonenInfo $personenInfo)
    {
        $this->personenInfo[] = $personenInfo;
    }


    public function markListItem() {
        return false;
    }





}
