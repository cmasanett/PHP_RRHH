<?php

namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Zend\View\HelperPluginManager;
use Zend\View\Helper\BasePath;

class MenuService {

    protected $repository = null;
    protected $url = null;
    protected $pluginManager = null;

    public function __construct() {
        
    }

    public function setPlugin(BasePath $helper) {
        $this->url = $helper();
    }

    public function setViewHelperManager(HelperPluginManager $vhm) {
        $this->pluginManager = $vhm->get('url');
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->repository = $entityManager->getRepository('Application\Entity\N7MenuGeneral');
    }

    /* public function setRepository(Repository $repository) {
      $repositoryLoad = $repository;
      } */

    public function load() {
        $menu = $this->repository->findAll();
        return $this->generateTreeMenu($menu);
    }

    public function generateTreeMenu($datas, $parent = 0) {
        if ($parent == 0) {
            $tree = '<ul class="active nav nav-sidebar">';
        } else {
            if ($parent == 1) {
                $tree = '<ul class="active1">';
            } else {
                $tree = '<ul class="active2">';
            }
        }
        $urlTemp = "";
        foreach ($datas as $key => $row) {
            if ($row->getIdPadre() == $parent) {
                if ($row->getUrl() != null) {
                    $urlTemp = $this->url . '/' . $row->getUrl();
                    $tree .= '<li><a href = "' . $urlTemp . '">';
                    $tree .= $row->getDescripcion() . '</a>';
                } else {
                    $tree .= '<li>'.$row->getDescripcion();
                }
                $tree .= $this->generateTreeMenu($datas, $row->getId());
                $tree .= '</li>';
            }
        }
        $tree .= '</ul>';
        return $tree;
    }

}
