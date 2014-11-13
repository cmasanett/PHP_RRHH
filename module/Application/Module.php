<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'menuWidget' => function ($serviceManager) {
                    // Get the Menu Service
                    $menuService = $serviceManager->getServiceLocator()->get('MenuService');
                    return new \Application\View\Helper\MenuWidget($menuService);
                }
            )
        );
    }

    public function getServiceConfig() {
        return ['factories' => ['menuService' => 'Application\Service\MenuService',
                'menuService' => function ($sl) {
                    $entityManager = $sl->get('doctrine.entitymanager.orm_default');
                    $vhManager = $sl->get('ViewHelperManager');
                    $plugin  = $vhManager->get('basePath');
                    $myService = new Service\MenuService();
                    $myService->setEntityManager($entityManager);
                    $myService->setViewHelperManager($vhManager);
                    $myService->setPlugin($plugin);
                    //or you can set repository
                    //$repository = $entityManager->getRepository('Application\Entity\N7MenuGeneral');
                    //$myService->setRepository($repository);
                    return $myService;
                },
                ]
        ];
    }

}
