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
            'aktivitaeten' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/aktivitaeten[/][/:mitid]',
                    'constraints' => array(
                        //'aktivitaetentyp' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'mitid'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Aktivitaeten',
                        'action'     => 'index',
                    ),
                ),
            ),
            'harvest' => array(
                'type'  =>  'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/harvest',
                    'defaults' => array(
                        'controller' => 'FSW\Controller\Harvest',
                        'action'     => 'oai',
                    ),
                ),

            )

            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action

        ),
    ),

    'service_manager' => array(
        'allow_override' => true,
        'factories' => array(
            'FSW\Model\Veranstaltungen' => 'FSW\Model\Factories\VeranstaltungenFactory',
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'VuFind\Http' => 'FSW\Services\Factory::getHttp',

            'FSW\Model\MediumTable' =>  'FSW\Model\Factories\MediumTableFactory',
            //todo bessere namensgebung
            'FSW\Model\MedienTable' =>  'FSW\Model\Factories\MediumTableFactory',
            'MediumTableGateway' => 'FSW\Model\Factories\MediumTableGatewayFactory',

            'FSW\Table\PersonTable' => 'FSW\Services\Factory::getPersonFacade',
            'PersonTableGateway' => 'FSW\Services\Factory::getPersonTableGateway',
            'PersonExtendedTableGateway' => 'FSW\Services\Factory::getPersonExtendedTableGateway',
            'PersonZoraAuthorTableGateway' => 'FSW\Services\Factory::getPersonZoraAuthorTableGateway',



            'FSW\Model\KolloquiumTable' =>  'FSW\Model\Factories\KolloquiumTableFactory',
            'KolloquiumTableGateway' => 'FSW\Model\Factories\KolloquiumTableGatewayFactory',
            'FSW\Model\KolloqiumVeranstaltungTable' =>  'FSW\Model\Factories\KolloqiumVeranstaltungTableFactory',
            'KolloquiumVeranstaltungTableGateway' => 'FSW\Model\Factories\KolloquiumVeranstaltungTableGatewayFactory',
            'FSWPersonenExtendedAdapter' => 'FSW\Model\Factories\DB\PersonenExtendedAdapterFactory',
            'HistSemDBService'          =>  'FSW\Model\Factories\HistSemDBServiceFactory',
            'HistSemDBAdapter'          =>  'FSW\Model\Factories\DB\HistSemDBAdapterFactory',


            'FSW\Services\Facade\AktivitaetFacade'    =>  'FSW\Services\Factory::getAktivitaetFassade',
            'FSW\Services\Facade\PersonenFacade'    =>  'FSW\Services\Factory::getPersonFacade',
            'AktivitaetTableGateway'          =>  'FSW\Services\Factory::getAktivitaetTableGateway',

            'ZoraDocTableGateway'          =>  'FSW\Services\Factory::getZoraDocTableGateway',
            'ZoraAuthorTableGateway'          =>  'FSW\Services\Factory::getZoraAuthorTableGateway',
            'ZoraDocTypeTableGateway'          =>  'FSW\Services\Factory::getZoraDocTypeTableGateway',
            'CoverTableGateway'          =>  'FSW\Services\Factory::getCoverTableGateway',
            'FSW\Services\Facade\ZoraFacade'    =>  'FSW\Services\Factory::getZoraFacade',
            'oaiClient'                     =>      'FSW\Services\Factory::getOAIClient',





        ),
        'initializers' => array(
            'FSW\Services\Initializer\Initializer::initInstance',
        )

    ),


    'controllers' => array(
        'invokables' => array(
            'FSW\Controller\Medien' => 'FSW\Controller\MedienController',
            'FSW\Controller\Kolloquien' => 'FSW\Controller\KolloquienController',
            'FSW\Controller\Aktivitaeten' => 'FSW\Controller\AktivitaetenController',

            'FSW\Controller\Harvest' => 'FSW\Controller\HarvestController',


        ),
        'factories' => array(
            'FSW\Controller\Personen' => 'FSW\Controller\Factory::getPersonenController',
        )
        //'factories' => array(
        //    'FSW\Controller\Personen' => 'FSW\Controller\Factories\PersonenControllerFactory'
        //)

    ),
    'view_helpers'    => array(
        'factories' => array(
            'Veranstaltungen' => 'FSW\View\Helper\Factories\VeranstaltungenHelperFactory'
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(
            // And finally, here is where we define our page hierarchy
            'home' => array(
                'label' => 'navigation_home',
                'route' => 'home'
            ),
            'medien' => array(
                'label' => 'navigation_medien',
                'route' => 'medien'
            ),
            'kolloquien' => array(
                'label' => 'navigation_kolloquien',
                'route' => 'kolloquien'
            ),
            'personen' => array(
                'label' => 'navigation_personen',
                'route' => 'personen'
            ),
            'master_lizz_diss' => array(
                'label' => 'master_lizz_diss',
                'route' => 'aktivitaeten'
            )

        ),
    ),
    'fsw'       =>  array(

        'config_reader' => array(
            'abstract_factories' => array('FSW\Services\Config\PluginFactory'),
        ),


    )




);
