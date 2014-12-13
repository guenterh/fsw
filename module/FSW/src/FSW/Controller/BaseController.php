<?php
namespace FSW\Controller;


use FSW\Services\Config\PluginManager;
use FSW\Services\Facade\BaseFacade;
use FSW\Services\Facade\FacadeAwareInterface;
use Zend\Db\ResultSet\ResultSetInterface;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Response;

use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;




/**
 * [Description]
 *
 */
abstract class BaseController extends AbstractActionController
                                implements FacadeAwareInterface, \FSW\Services\FSWConfigAwareInterface
{

	/**
	 * @var BaseTable
	 */
	protected $table;
	protected $translator;
    protected  $histSemDBService;

    protected $facade;
    protected $fswConfig;



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


        return $this->url()->fromRoute($route, $params);
    }

    protected function getEntityName () {
        return 'defaultEntityName';
    }


    protected function getEntityNames () {
        return 'defaultEntityNames';
    }


    public function closeContentAction () {

        return $this->getAjaxView(array(

            'entityName' => $this->getEntityName(),
            'entityNamePlural' => $this->getEntityNames(),

            'route' => $this->getEvent()->getRouteMatch()->getMatchedRouteName(),
            'listItems' => null),'fsw/global/home-crud');

    }

    public function onDispatch(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if (!$routeMatch) {
            /**
             * @todo Determine requirements for when route match is missing.
             *       Potentially allow pulling directly from request metadata?
             */
            throw new Exception\DomainException('Missing route matches; unsure how to retrieve action');
        }

        $action = $routeMatch->getParam('action', 'not-found');
        $method = static::getMethodFromAction($action);

        if (!method_exists($this, $method)) {
            $method = 'notFoundAction';
        }



        $currentController = get_class($this);
        $config = $this->fswConfig->get('config');
        $restrictedController = $config->LimitedController->restricted->toArray();

        $restricted = false;
        array_map(function($value) use ($currentController,&$restricted ){
            if (strcmp($value,$currentController) == 0) {
                $restricted = true;
            }
        } , $restrictedController);

        if ($restricted) {
            $account = $this->getAuthManager();
            if ($account->isLoggedIn() == false) {
                // If we got this far, we want to store the referer:
                $referer = $this->getRequest()->getServer()->get('HTTP_REFERER');
                if (empty($referer)) {
                    $referer = "/static/zf2/public/index.php/personen/";
                }


                $this->followup()->store(array(), $referer);

                return $this->forceLogin('melde Dich an',array(),false);
            }


        }


        $actionResponse = $this->$method();

        $e->setResult($actionResponse);

        return $actionResponse;
    }

    public function forwardTo($controller, $action, $params = array())
    {
        // Inject action into the RouteMatch parameters
        $params['action'] = $action;

        // Dispatch the requested controller/action:
        return $this->forward()->dispatch($controller, $params);
    }

    public function setFSWConfigService(PluginManager $fswConfigPlugin) {

        $this->fswConfig = $fswConfigPlugin;

    }

    protected function getAuthManager()
    {
        return $this->getServiceLocator()->get('FSW\AuthManager');
    }

    protected function forceLogin($msg = null, $extras = array(), $forward = true)
    {
        // Set default message if necessary.
        if (is_null($msg)) {
            $msg = 'You must be logged in first';
        }

        // Store the current URL as a login followup action unless we are in a
        // lightbox (since lightboxes use a different followup mechanism).
        $this->followup()->store($extras);
        if (!empty($msg)) {
            $this->flashMessenger()->setNamespace('error')->addMessage($msg);
        }

        // Set a flag indicating that we are forcing login:
        $this->getRequest()->getPost()->set('forcingLogin', true);

        if ($forward) {
            return $this->forwardTo('Login', 'login');
        }
        return $this->redirect()->toRoute('backendlogin');
    }


    /**
     * Get the full URL to one of VuFind's routes.
     *
     * @param bool|string $route Boolean true for current URL, otherwise name of
     * route to render as URL
     *
     * @return string
     */
    public function getServerUrl($route = true)
    {
        $serverHelper = $this->getViewRenderer()->plugin('serverurl');
        return $serverHelper(
            $route === true ? true : $this->url()->fromRoute($route)
        );
    }

    protected function getViewRenderer()
    {
        return $this->getServiceLocator()->get('viewmanager')->getRenderer();
    }


}
