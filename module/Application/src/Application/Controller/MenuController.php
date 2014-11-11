<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MenuController extends AbstractActionController {

    public function __construct() {
        
    }

    /**
     *
     * @var DoctrineORMEntityManager
     */
    protected $em;

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction() {
         return new ViewModel(array(
             'menu' => $this->getEntityManager()->getRepository('Application\Entity\N7Menu')->findAll()
         ));
    }

}
