<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'subscriber' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\NotificationController::class,
                        'action'     => 'subscriber',
                    ],
                ],
            ],
            'notify' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/notify',
                    'defaults' => [
                        'controller' => Controller\NotificationController::class,
                        'action'     => 'notify',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class    => InvokableFactory::class,
            Controller\NotificationController::class => Controller\Factory\NotificationControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\MailSender::class => InvokableFactory::class,
            \Zend\View\Renderer\PhpRenderer::class => InvokableFactory::class,
            \Zend\View\Resolver\TemplateMapResolver::class => InvokableFactory::class,
            \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format' => '<div%s>',
            'message_separator_string' => '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div><div%s>',
            'message_close_string' => '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>'
        ]
    ]
];
