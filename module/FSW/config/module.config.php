<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use FSW\Model\Veranstaltungen as ModelVeranstaltungen;
use FSW\View\Helper\Veranstaltungen as HelperVeranstaltungen;


return array(
    'router' => array(
        'routes' => array(
            'medien' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/medien[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Medien',
                        'action'     => 'index',
                    ),
                ),
            ),
            'kolloquien' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/kolloquien[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Kolloquien',
                        'action'     => 'index',
                    ),
                ),
            ),
            'lehrveranstaltung' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/lehrveranstaltung[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Lehrveranstaltungen',
                        'action'     => 'index'
                    ),
                ),
            ),
            'personen' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/personen[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Personen',
                        'action'     => 'index',
                    ),
                ),
            ),


            'personenaktivitaet' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/personenaktivitaet[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\PersonenAktivitaeten',
                        'action'     => 'index',
                    ),
                ),
            ),

            'forschungAdmin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/forschungAdmin[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Forschung',
                        'action'     => 'index',
                    ),
                ),
            ),
            'forschungPresent' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/forschungPresent[/][:action][/:type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'type'     => '[a-zA-Z][a-zA-Z]*',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Forschung',
                        'action'     => 'present',
                    ),
                ),
            ),
            'harvest' => array(
                'type'  =>  'segment',
                'options' => array(
                    'route'    => '/harvest[/][:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Harvest',
                        'action'    =>  'index'

                    ),
                ),

            ),
            'backendlogin' => array(
                'type'  =>  'segment',
                'options' => array(
                    //'route'    => '/medien[/][:action][/:id]',
                    'route'    => '/login[/][:action]',
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Login',
                        'action'     => 'login',
                    ),
                ),

            ),
            'authentication' => array(
                'type'  =>  'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/authenticate',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),

                    'defaults' => array(
                        'controller' => 'FSW\Controller\Authentication',
                        'action'     => 'process',
                    ),
                ),

            )




            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action

        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'personen-insertExtendedMAFSW' => array(
                    'options' => array(
                        'route' => 'personen',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Personen',
                            'action' => 'insertExtendedMAFSW'
                        )
                    )
                ),
                'zoradoc-insert' => array(
                    'options' => array(

                        'route' => 'zoraconsole oaiconsole <from> [<until>]',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Consolenharvest',
                            'action' => 'oaiconsole'
                        )
                    )
                ),
                'zoradoc-delta' => array(
                    'options' => array(

                        'route' => 'zoraconsole zoradelta',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Consolenharvest',
                            'action' => 'zoradelta'
                        )
                    )
                ),
                'zoradoc-delta-insert' => array(
                    'options' => array(

                        'route' => 'zoraconsoleinsert getOldZoraIds',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Consolenharvest',
                            'action' => 'getOldZoraIds'
                        )
                    )
                ),
                'medien-insert' => array(
                    'options' => array(
                        'route' => 'medien',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Medien',
                            'action' => 'insertMedienFSW'
                        )
                    )
                ),
                'kolloquien-insert' => array(
                    'options' => array(
                        'route' => 'kolloquien',
                        'defaults' => array(
                            'controller' => 'FSW\Controller\Kolloquien',
                            'action' => 'insertKolloquienFSW'
                        )
                    )
                ),

                'lehrveranstaltungen-insert' => array(
                    'options'   =>  array(
                        'route' =>  'lehrveranstaltungen',
                        'defaults'  =>  array(
                            'controller'    =>  'FSW\Controller\Lehrveranstaltungen',
                            'action'    =>  'insertLehrveranstaltungenFromOldFSW'
                        )
                    )
                )



            )

        ),
    ),

    /*
     * doesn't work....
    */

    /*

    'form_elements' => array(
        'factories' => array(
            'fswformlehrveranstaltungpersonfieldset' => function($sm) {
                $serviceLocator = $sm->getServiceLocator();
                $personLehrvG = $serviceLocator->get('HistSemDBService')->getRelationPersonenLehrveranstaltungGateway();
                return  new \FSW\Form\LehrveranstaltungPersonFieldset('lehrveranstaltungPerson', $personLehrvG);
            }
        ),
        'invokables' => array(
            'FSW\Form\LehrveranstaltungForm' => 'FSW\Form\LehrveranstaltungForm'
        )

    ),
    */

    'service_manager' => array(
        'allow_override' => true,
        'factories' => array(
            'FSW\Model\Veranstaltungen' => 'FSW\Model\Factories\VeranstaltungenFactory',
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'VuFind\Http' => 'FSW\Services\Factory::getHttp',


            'FSW\Table\PersonTable' => 'FSW\Services\Factory::getPersonFacade',
            'PersonTableGateway' => 'FSW\Services\Factory::getPersonTableGateway',
            'PersonExtendedTableGateway' => 'FSW\Services\Factory::getPersonExtendedTableGateway',
            'PersonZoraAuthorTableGateway' => 'FSW\Services\Factory::getPersonZoraAuthorTableGateway',

            'MediumTableGateway' => 'FSW\Services\Factory::getMedienTableGateway',

            'KolloquiumTableGateway' => 'FSW\Services\Factory::getKolloquienTableGateway',
            'RelationHSPersonFSWPersonTableGateway' => 'FSW\Services\Factory::getRelationHSFSWPersonTableGateway',


            //'FSW\Model\KolloqiumVeranstaltungTable' =>  'FSW\Model\Factories\KolloqiumVeranstaltungTableFactory',
            'KolloquiumVeranstaltungTableGateway' => 'FSW\Services\Factory::getKolloquiumVeranstaltungenTableGateway',
            'KolloquiumVeranstaltungPersonTableGateway' => 'FSW\Services\Factory::getKolloquiumVeranstaltungenPersonTableGateway',
            'FSWPersonenExtendedAdapter' => 'FSW\Model\Factories\DB\PersonenExtendedAdapterFactory',
            'HistSemDBService'          =>  'FSW\Model\Factories\HistSemDBServiceFactory',
            'HistSemDBAdapter'          =>  'FSW\Model\Factories\DB\HistSemDBAdapterFactory',


            'FSW\Services\Facade\ForschungFacade'    =>  'FSW\Services\Factory::getForschungFacade',
            'FSW\Services\Facade\PersonenFacade'    =>  'FSW\Services\Factory::getPersonFacade',
            'FSW\Services\Facade\PersonenAktivitaetFacade'    =>  'FSW\Services\Factory::getPersonAktivitaetFacade',
            'FSW\Services\Facade\MedienFacade'    =>  'FSW\Services\Factory::getMedienFacade',

            'ForschungTableGateway'          =>  'FSW\Services\Factory::getForschungTableGateway',

            'HSAbteilungGateway'        =>  'FSW\Services\Factory::getHSAbteilungTableGateway',

            'HSFunktionGateway'         =>  'FSW\Services\Factory::getHSFunktionTableGateway',

            'ZoraDocTableGateway'          =>  'FSW\Services\Factory::getZoraDocTableGateway',
            'ZoraDocWithCoverTabeGateway'          =>  'FSW\Services\Factory::getZoraDocWithCoverTableGateway',
            'CoverOnlyTableGateway'          =>  'FSW\Services\Factory::getCoverOnlyTableGateway',



            'RollenTableGateway'          =>  'FSW\Services\Factory::getRollenTableGateway',
            'LehrveranstaltungenTableGateway'   =>  'FSW\Services\Factory::getLehrveranstaltungenTableGateway',
            'RelationPersonLehrveranstaltungeTableGateway'   =>  'FSW\Services\Factory::getRelationPersonLehrveranstaltungTableGateway',
            'ZoraAuthorTableGateway'          =>  'FSW\Services\Factory::getZoraAuthorTableGateway',
            'ZoraDocTypeTableGateway'          =>  'FSW\Services\Factory::getZoraDocTypeTableGateway',
            'CoverTableGateway'          =>  'FSW\Services\Factory::getCoverTableGateway',
            'FSW\Services\Facade\ZoraFacade'    =>  'FSW\Services\Factory::getZoraFacade',
            //'AuthenticationFacade'    =>  'FSW\Services\Factory::getAuthenticationFacade',
            'oaiClient'                     =>      'FSW\Services\Factory::getOAIClient',
            'FSW\SessionPluginManager' => 'FSW\Services\Factory::getSessionPluginManager',
            'FSW\DbTablePluginManager' => 'FSW\Services\Factory::getDbTablePluginManager',
            'FSW\AuthManager' => 'FSW\Auth\Factory::getManager',
            'FSW\AuthPluginManager' => 'FSW\Services\Factory::getAuthPluginManager',








        ),
        'invokables' => array(
            'KolloquienFacade' => 'FSW\Services\Facade\KolloquienFacade',
            'LehrveranstaltungenFacade' =>  'FSW\Services\Facade\LehrveranstaltungFacade',
            'FSW\SessionManager' => 'Zend\Session\SessionManager',

        ),
        'initializers' => array(
            'FSW\Services\Initializer\Initializer::initInstance',
        )

    ),


    'controllers' => array(
        'factories' => array(
            'FSW\Controller\Personen' => 'FSW\Controller\Factory::getPersonenController',
            'FSW\Controller\Medien' => 'FSW\Controller\Factory::getMedienController',
            'FSW\Controller\Kolloquien' => 'FSW\Controller\Factory::getKolloquienController',
            'FSW\Controller\Forschung' => 'FSW\Controller\Factory::getForschungController',
            'FSW\Controller\PersonenAktivitaeten' => 'FSW\Controller\Factory::getPersonAktivitaetController',
            //'FSW\Controller\Publications' => 'FSW\Controller\Factory::getPublicationsController',
            'FSW\Controller\Lehrveranstaltungen'    =>  'FSW\Controller\Factory::getLehrveranstaltungenController',
            'FSW\Controller\Authentication' => 'FSW\Controller\Factory::getAuthenticationController',
            'FSW\Controller\Login'  =>  'FSW\Controller\Factory::getBackendLoginController',
            'FSW\Controller\Harvest' => 'FSW\Controller\Factory::getHarvesterController',
            'FSW\Controller\Consolenharvest' => 'FSW\Controller\Factory::getHarvesterConsoleController',

        )
        //'factories' => array(
        //    'FSW\Controller\Personen' => 'FSW\Controller\Factories\PersonenControllerFactory'
        //)

    ),
    'controller_plugins' => array(
        'invokables' => array(
            'followup' => 'FSW\Controller\Plugin\Followup',
        )
    ),

    'view_helpers'    => array(
        'factories' => array(
            'Veranstaltungen'   => 'FSW\View\Helper\Factory::getVeranstaltungsHelper',
            //'Veranstaltungen' => 'FSW\View\Helper\Factories\VeranstaltungenHelperFactory',
            'UrlToHSForms'  => 'FSW\View\Helper\Factory::getHsFormsUrlHelper'

        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'login/layout' => __DIR__ . '/../view/fsw/layout/loginlayout.phtml',


        ),

    ),
    'navigation' => array(
        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(
            // And finally, here is where we define our page hierarchy
            //'home' => array(
            //    'label' => 'navigation_home',
            //    'route' => 'home'
            //),
            'medien' => array(
                'label' => 'Medien',
                'route' => 'medien'
            ),
            'kolloquien' => array(
                'label' => 'Kolloquien',
                'route' => 'kolloquien'
            ),
            'personen' => array(
                'label' => 'Personen',
                'route' => 'personen'
            ),
            'lehrveranstaltung' => array(
                'label' => 'Lehrveranstaltungen',
                'route' => 'lehrveranstaltung'
            ),
            'zoraharvest' => array(
                'label' => 'Zora Harvesting',
                'route' => 'harvest'
            ),

            'logout' => array(
                'label' => 'Logout',
                'route' => 'backendlogin',
                'params'     => array('action' => 'logout')
            )
        ),

    ),
    'fsw'       =>  array(

        'config_reader' => array(
            'abstract_factories' => array('FSW\Services\Config\PluginFactory'),
        ),
        // This section contains service manager configurations for all VuFind
        // pluggable components:
        'plugin_managers' => array(
            'auth' => array(
                'abstract_factories' => array('FSW\Auth\PluginFactory'),
                'invokables' => array(
                    'database' => 'FSW\Auth\Database',
                ),
            ),
                'db_table' => array(
                'abstract_factories' => array('FSW\Db\Table\PluginFactory'),
                'invokables' => array(
                    'fsw_session' => 'FSW\Db\Table\Session',
                    'fsw_user' => 'FSW\Db\Table\User',
                ),
            ),
            'session' => array(
                'abstract_factories' => array('FSW\Session\PluginFactory'),
                'invokables' => array(
                    'database' => 'FSW\Session\Database'
                    //'file' => 'VuFind\Session\File',
                )
            )

        )


    )




);
