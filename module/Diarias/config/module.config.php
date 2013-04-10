<?php

namespace Diarias;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Document')
            ),
            'odm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Model\Document' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Diarias\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'crud' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/:controller[/:action][?id=:id]',
                    'defaults' => array(
                        'action' => 'index',
                        'id' => null
                    ),
                    'constraints' => array(
                        'id' => '[0-9]+'
                    )
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(

        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Diarias\Controller\Index' => 'Diarias\Controller\Index'
            // 'especie' => 'Clinica\Controller\Especie',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'diarias/index/index' => __DIR__ . '/../view/diarias/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'bootstrapRow' => 'Crud\Form\View\Helper\BootstrapRow',
            'FlashMessages' => 'Crud\View\Helper\FlashMessages',
        )
    )
);
