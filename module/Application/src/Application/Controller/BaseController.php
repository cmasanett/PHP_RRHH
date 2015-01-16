<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

//use Zend\Authentication\AuthenticationService;

class BaseController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
//    protected $auStandar;
//    protected $auDoc;
    protected $auServ;

    /**
     * for managing entities via Doctrine
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

//    public function getAuthenticationService() {
//        if (null === $this->auStandar) {
//            $this->auStandar = new AuthenticationService();
//        }
//        return $this->auStandar;
//    }
//    public function getAuthServiceDoc() {
//        if (null === $this->auDoc) {
//            $this->auDoc = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
//        }
//
//        return $this->auDoc;
//    }

    public function getAuthService() {
        if (null === $this->auServ) {
            $this->auServ = $this->getServiceLocator()->get('authService');
        }

        return $this->auServ;
    }

    public function getSessionStorage() {
        if (null === $this->storage) {
            $this->storage = $this->getServiceLocator()->get('Application\Model\AuthStorage');
        }

        return $this->storage;
    }

}
