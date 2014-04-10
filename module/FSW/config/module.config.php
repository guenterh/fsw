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
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'


        )
    ),


    'controllers' => array(
        'invokables' => array(
            'FSW\Controller\Medien' => 'FSW\Controller\MedienController',
            'FSW\Controller\Kolloquien' => 'FSW\Controller\KolloquienController',
            'FSW\Controller\Aktivitaeten' => 'FSW\Controller\AktivitaetenController',
            'FSW\Controller\Personen' => 'FSW\Controller\PersonenController'

        ),
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




);
