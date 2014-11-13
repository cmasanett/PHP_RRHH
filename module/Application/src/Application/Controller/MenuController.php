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
        $menu = $this->getEntityManager()->getRepository('Application\Entity\N7MenuGeneral')->findAll();
        return new ViewModel(array(
            'menu' => $this->generateTreeMenu($menu)
        ));
    }

    public function generateTreeMenu($datas, $parent = 0) {
        $tree = '<ul>';
        foreach ($datas as $key => $row) {
            if ($row->getIdPadre() == $parent) {
                $tree .= '<li><a href = "' . $row->getUrl() . '">';
                $tree .= $row->getDescripcion() . '</a>';
                $tree .= $this->generateTreeMenu($datas, $row->getId());
                $tree .= '</li>';
            }
        }
        $tree .= '</ul>';
        return $tree;
    }

}
