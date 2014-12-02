<?php

namespace Application;

return ['router' => ['routes' => ['home' => ['type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => ['route' => '/',
                    'defaults' => ['controller' => 'Application\Controller\Usuarios',
                        'action' => 'login'
                    ]
                ]
            ],
            'application' => ['type' => 'Literal',
                'options' => ['route' => '/application',
                    'defaults' => ['__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => ['default' => ['type' => 'Segment',
                        'options' => ['route' => '/[:controller[/:action]]',
                            'constraints' => ['controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => array()
                        ]
                    ]
                ]
            ],
            'login' => ['type' => 'Literal',
                'options' => ['route' => '/usuarios',
                    'defaults' => ['__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Usuarios',
                        'action' => 'login'
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => ['default' => ['type' => 'Segment',
                        'options' => ['route' => '/[:action]',
                            'constraints' => ['controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ],
                            'defaults' => array()
                        ]
                    ]
                ]
            ],
            'datosempresas' => ['type' => 'Segment',
                'options' => ['route' => '/datosempresas[/[:action][/:id]]',
                    'constraints' => ['action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => ['controller' => 'Application\Controller\DatosEmpresas',
                        'action' => 'index'
                    ]
                ]
            ],
            'datoslegajos' => ['type' => 'Segment',
                'options' => ['route' => '/datoslegajos[/[:action][/:id]]',
                    'constraints' => ['action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => ['controller' => 'Application\Controller\DatosLegajos',
                        'action' => 'index'
                    ]
                ]
            ],
            'datosfamiliares' => ['type' => 'Segment',
                'options' => ['route' => '/datosfamiliares[/[:action][/:id]]',
                    'constraints' => ['action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => ['controller' => 'Application\Controller\DatosFamiliares',
                        'action' => 'index'
                    ]
                ]
            ],
        ]
    ],
    'service_manager' => ['abstract_factories' => ['Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ],
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ],
    'translator' => ['locale' => 'en_US',
        'translation_file_patterns' => [['type' => 'gettext',
        'base_dir' => __DIR__ . '/../language',
        'pattern' => '%s.mo'
            ]
        ]
    ],
    'controllers' => ['invokables' => ['Application\Controller\Usuarios' => 'Application\Controller\UsuariosController',
            'Application\Controller\DatosEmpresas' => 'Application\Controller\DatosEmpresasController',
            'Application\Controller\DatosLegajos' => 'Application\Controller\DatosLegajosController',
            'Application\Controller\DatosFamiliares' => 'Application\Controller\DatosFamiliaresController'
        ]
    ],
    'view_manager' => ['display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => ['layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/usuarios/login' => __DIR__ . '/../view/application/usuarios/login.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [__DIR__ . '/../view'
        ]
    ],
    // Placeholder for console routes
    'console' => ['router' => ['routes' => array()
        ]
    ],
    // Doctrine config
    'doctrine' => ['driver' => [__NAMESPACE__ . '_driver' => ['class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ]
            ],
            'orm_default' => ['drivers' => [__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
