<?php

namespace Application;

//use Zend\Mvc\ModuleRouteListener;
//use Zend\Mvc\MvcEvent;

class Module {

//    public function onBootstrap(MvcEvent $e) {
//        $eventManager = $e->getApplication()->getEventManager();
//        $moduleRouteListener = new ModuleRouteListener();
//        $moduleRouteListener->attach($eventManager);
//    }

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
                    $menuService = $serviceManager->getServiceLocator()->get('MenuService');
                    return new \Application\View\Helper\MenuWidget($menuService);
                }
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
//                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
//                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
//                },
                'menuService' => 'Application\Service\MenuService',
                'menuService' => function ($serviceManager) {
                    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');
                    $vhManager = $serviceManager->get('ViewHelperManager');
                    $plugin = $vhManager->get('basePath');
                    $menuService = new Service\MenuService();
                    $menuService->setEntityManager($entityManager);
                    //$menuService->setViewHelperManager($vhManager);
                    $menuService->setPlugin($plugin);
                    return $menuService;
                },
            ),
        );
    }

}
