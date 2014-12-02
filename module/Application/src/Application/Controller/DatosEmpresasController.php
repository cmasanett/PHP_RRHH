<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Request;
use Zend\Json\Json;
// Componentes de validaci�n
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;
// Adaptador de la db
use Zend\Db\Adapter\Adapter;
// Incluir entidades
//use Application\Entity\PropiedadEmpresaLiquidacion;
//use Application\Entity\PropiedadEmpresaLiquidacionValores;
use Application\Entity\N7PropiedadesE;
use Application\Entity\N7ValoresPosiblesEmpresas;

// Doctrine ORM
use Doctrine\ORM\EntityManager;

class DatosEmpresasController extends AbstractActionController {

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
        return new ViewModel(array());
    }

    public function loadDataGridAction() {
        $request = $this->getRequest();

        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        /*$wh = "";
        $searchOn = $request->getPost('_search');
        if ($searchOn == 'true') {
        }*/

        $data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findAll();

        $count = count($data);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $start = $limit * $page - $limit;
        if ($start < 0) {
            $start = 0;
        }
        
        //$row = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacion')->findBy(array(), array($sidx => $sord));
        $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findBy(array(), array($sidx => $sord), $limit, $start);

        $response ['page'] = $page;
        $response ['total'] = $total_pages;
        $response ['records'] = $count;
        $i = 0;

        foreach ($row as $r) {
            $response ['rows'] [$i] ['id'] = $r->getId(); // id
            $response ['rows'] [$i] ['cell'] = array(
                $r->getId(),
                $r->getDescripcion(),
                $r->getTipoDeCampo()
            );
            $i ++;
        }

        return $this->response->setContent(Json::encode($response));
    }

    public function loadDataGridValAction() {
        $request = $this->getRequest();

        $id = $this->params()->fromRoute("id", null);

        $sidx = $request->getPost('sidx', 'propiedad');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        $data = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesEmpresas')->findBy(array('propiedad' => $id));
        $count = count($data);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $start = $limit * $page - $limit;
        if ($start < 0) {
            $start = 0;
        }

        $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesEmpresas')->findBy(['propiedad' => $id], array($sidx => $sord), $limit, $start);

        $response ['page'] = $page;
        $response ['total'] = $total_pages;
        $response ['records'] = $count;
        $i = 0;

        foreach ($row as $r) {
            $response ['rows'] [$i] ['id'] = $r->getId(); // id
            $response ['rows'] [$i] ['cell'] = array(
                $r->getId(),
                $r->getPropiedad()->getId(),
                $r->getValorPosible(),
                $r->getSignificado()
            );
            $i ++;
        }

        return $this->response->setContent(Json::encode($response));
    }

    public function editGridItemAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = Json::decode($request->getPost('data'), true);
                if ($data) {
                    if (isset($data['id'])) {
                        //Edit
                        $n7PropiedadesE = new N7PropiedadesE ();
                        $n7PropiedadesE = $this->getEntityManager()->find('Application\Entity\N7PropiedadesE', $data['id']);
                        if ($n7PropiedadesE) {
                            $n7PropiedadesE->setDescripcion($data['descripcion']);
                            $n7PropiedadesE->setTipoDeCampo($data['tipo_de_campo']);
                            $this->getEntityManager()->persist($n7PropiedadesE);
                            $this->getEntityManager()->flush();

                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'editProp',
                                                'success' => true
                            )));
                        }
                    } else {
                        //Add
                        $n7PropiedadesE = new N7PropiedadesE ();
                        //$propiedadEmpresaLiquidacion->exchangeArray ( $request->getPost () );
                        $n7PropiedadesE->setDescripcion($data['descripcion']);
                        $n7PropiedadesE->setTipoDeCampo($data['tipo_de_campo']);
                        $this->getEntityManager()->persist($n7PropiedadesE);
                        $this->getEntityManager()->flush();

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'addProp',
                                            'success' => true
                        )));
                    }
                }
            }
        } else {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
    }

    public function deleteGridItemAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $n7PropiedadesE = new N7PropiedadesE ();
                $n7PropiedadesE = $this->getEntityManager()->find('Application\Entity\N7PropiedadesE', $id);
                if ($n7PropiedadesE) {
                    $this->getEntityManager()->remove($n7PropiedadesE);
                    $this->getEntityManager()->flush();

                    return $this->response->setContent(Json::encode(array(
                                        'type' => 'delProp',
                                        'success' => true
                    )));
                }
            } else {
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
            }
        } else {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
    }

    public function editGridItemValAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = Json::decode($request->getPost('data'), true);
                if ($data) {
                    if (isset($data['propiedad'])) {
                        //Add
                        $n7PropiedadesE = new N7PropiedadesE ();
                        $n7PropiedadesE = $this->getEntityManager()->find('Application\Entity\N7PropiedadesE', $data['propiedad']);
                        if ($n7PropiedadesE) {
                            $n7ValoresPosiblesEmpresas = new N7ValoresPosiblesEmpresas ();
                            $n7ValoresPosiblesEmpresas->setPropiedad($n7PropiedadesE);
                            $n7ValoresPosiblesEmpresas->setValorPosible($data['valor_posible']);
                            $n7ValoresPosiblesEmpresas->setSignificado($data['significado']);
                            $this->getEntityManager()->persist($n7ValoresPosiblesEmpresas);
                            $this->getEntityManager()->flush();
                        }

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'addVal',
                                            'success' => true
                        )));
                    } else {
                        if (isset($data['id'])) {
                            //Edit
                            $n7ValoresPosiblesEmpresas = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesEmpresas', $data['id']);
                            if ($n7ValoresPosiblesEmpresas) {
                                $n7ValoresPosiblesEmpresas->setValorPosible($data['valor_posible']);
                                $n7ValoresPosiblesEmpresas->setSignificado($data['significado']);
                                $this->getEntityManager()->persist($n7ValoresPosiblesEmpresas);
                                $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editVal',
                                                    'success' => true
                                )));
                            }
                        }
                    }
                }
            }
        } else {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
    }

    public function deleteGridItemValAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $n7ValoresPosiblesEmpresas = new N7ValoresPosiblesEmpresas ();
                $n7ValoresPosiblesEmpresas = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesEmpresas', $id);
                if ($n7ValoresPosiblesEmpresas) {
                    $this->getEntityManager()->remove($n7ValoresPosiblesEmpresas);
                    $this->getEntityManager()->flush();

                    return $this->response->setContent(Json::encode(array(
                                        'type' => 'delVal',
                                        'success' => true
                    )));
                }
            }
        } else {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
    }

}
