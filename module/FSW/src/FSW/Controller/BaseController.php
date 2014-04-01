<?php
namespace FSW\Controller;

use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;

use Libadmin\Table\BaseTable;
use Libadmin\Table\GroupTable;
use Libadmin\Table\InstitutionTable;
use Libadmin\Table\ViewTable;
use Libadmin\Model\BaseModel;
use Libadmin\Model\Group;
use Libadmin\Model\View;
use Libadmin\Model\Institution;
use Libadmin\Table\GroupRelationTable;
use Libadmin\Table\InstitutionRelationTable;

/**
 * [Description]
 *
 */
abstract class BaseController extends AbstractActionController
{

	/**
	 * @var BaseTable
	 */
	protected $table;


	protected $translator;























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





}
