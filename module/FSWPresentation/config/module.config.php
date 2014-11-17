<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

//$h = "";

return array(

    'router' => array(
        'routes'    =>  array(
            'presentation'  =>  array(
                'type'  =>  'Literal',
                'options'   =>  array(
                    'route' =>  '/presentation',
                    'defaults'  =>  array(
                        '__NAMESPACE__' =>  'FSWPresentation\Controller',
                        'controller'    =>  'FSWPresentation\Controller\IndexController',
                        'action'    =>  'index'
                    )
                ),
                'may_terminate' =>  true,
                'child_routes'  =>  array(
                    'default'   =>  array(
                        'type'  =>  'Segment',
                        'options'   =>  array(
                            'route' =>  '/[:controller[/:action[/:id]]]'
                        )
                    )
                )
            )
        )
    ),

    'controllers'   =>  array(
        'invokables'    =>  array(
            'FSWPresentation\Controller\IndexController' =>  'FSWPresentation\Controller\IndexController',
            'FSWPresentation\Controller\Test' =>  'FSWPresentation\Controller\TestController'
        ),
        'factories' => array(
            'FSWPresentation\Controller\Publications' => 'FSWPresentation\Controller\Factory::getPublicationsController',
            'FSWPresentation\Controller\Medien' => 'FSWPresentation\Controller\Factory::getMedienController',
            'FSWPresentation\Controller\Kolloquien' => 'FSWPresentation\Controller\Factory::getKolloquienController',

        )

    ),

    'view_helpers'  =>  array(
        'invokables'    =>  array(
            'date'  =>  'FSWPresentation\View\Helper\Date'
        )
    ),

    'view_manager' => array(
        'template_map' => array(
            'presentation/layout' => __DIR__ . '/../view/fsw-presentation/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),


    'service_manager' => array(
        'allow_override' => true,
        'factories' => array(
            'FSWPresentation\Services\Facade\PublicationsFacade'    =>  'FSWPresentation\Services\Factory::getPublicationsFacade',

        )

    ),



);
