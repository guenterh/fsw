<?php
namespace FSW\Controller;


use FSW\Services\Facade\BaseFacade;
use FSW\Services\Facade\FacadeAwareInterface;
use Zend\Db\ResultSet\ResultSetInterface;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;



/**
 * [Description]
 *
 */
abstract class BaseController extends AbstractActionController implements FacadeAwareInterface
{

	/**
	 * @var BaseTable
	 */
	protected $table;
	protected $translator;
    protected  $histSemDBService;

    protected $facade;



    /**
     * Extract all result items from a result set to work with a simple list
     *
     * @param    ResultSetInterface $set
     * @param    Boolean $idAsIndex
     * @return    BaseModel[]
     */
    protected function toList(ResultSetInterface $set, $idAsIndex = false)
    {
        $list = array();

        /** @var BaseModel $item */
        foreach ($set as $item) {
            if ($idAsIndex) {
                $list[$item->getId()] = $item;
            } else {
                $list[] = $item;
            }
        }

        return $list;
    }

	/**
	 * Get terminal view model for ajax
	 *
	 * @param    Array $variables
	 * @param    String $template
	 * @return    ViewModel
	 */
	protected function getAjaxView($variables = array(), $template = '')
	{
		$viewModel = new ViewModel($variables);
		$viewModel->setTerminal(true);

		if ($template) {
			$viewModel->setTemplate($template);
		}

		return $viewModel;
	}




	/**
	 * Translate key
	 *
	 * @param    String $key
	 * @param    String $domain
	 * @return    String
	 */
	protected function translate($key, $domain = 'Libadmin')
	{
		if (null == $this->translator) {
			$this->translator = $this->getServiceLocator()->get('translator');
		}

		return $this->translator->translate($key, $domain);
	}

    /**
     * Search matching records
     *
     * @param	Integer		$limit        Search result limit
     * @return	ViewModel
     **/
    public function searchAction($limit = 15)
    {
        $query = $this->params()->fromQuery('query', '');
        $data = array(
            'route' => strtolower($this->getTypeName()),
            'listItems' => $this->getTable()->find($query, $limit)
        );

        return $this->getAjaxView($data, 'fsw/global/search');
    }

    /**
     * Get type name of class from the class name
     *
     * @return    String
     */
    protected function getTypeName()
    {
        $nameParts = explode('\\', get_class($this));

        return str_replace('Controller', '', array_pop($nameParts));
    }


    /**
     * Get table
     *
     * @param    String|Null $type
     * @return
     */
    protected function getTable($type = null)
    {
        if (!is_null($type)) {
            return $this->getServiceLocator()->get('FSW\Model\\' . ucfirst($type) . 'Table');
        }

        if (!$this->table) {
            $type = $this->getTypeName();
            $test = 'FSW\Model\\' . $type . 'Table';
            $this->table = $this->getServiceLocator()->get('FSW\Model\\' . $type . 'Table');
        }
        return $this->table;
    }

    public function setFacadeService(BaseFacade $facadeService)
    {
        $this->facade = $facadeService;
    }

    /**
     * Make url based on route
     * Add action and element id to route if specified
     *
     * @param    String $route
     * @param    String $action
     * @param    Integer $idElement
     * @param    Array $additionalParams
     * @return    String
     */
    protected function makeUrl($route, $action, $idElement = 0, array $additionalParams = array())
    {
        $params = array(
            'action' => $action
        );

        if ($idElement) {
            $params['id'] = $idElement;
        }
        $params = array_merge($params, $additionalParams);

        $test = $this->url()->fromRoute($route, $params);

        return $this->url()->fromRoute($route, $params);
    }



}
