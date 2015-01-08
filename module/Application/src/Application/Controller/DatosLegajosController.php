<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7PropiedadesL;
use Application\Entity\N7ValoresPosiblesLegajos;

class DatosLegajosController extends BaseController {

    public function __construct() {
        
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

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesL')->findAll();

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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesL')->findBy(array(), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'] [$i] ['id'] = $r->getId(); // id
                $response ['rows'] [$i] ['cell'] = array(
                    $r->getId(),
                    utf8_encode($r->getDescripcion()),
                    $r->getTipoDeCampo()
                );
                $i ++;
            }

            return $this->response->setContent(Json::encode($response));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function loadDataGridValAction() {
        $request = $this->getRequest();

        $id = $this->params()->fromRoute("id", null);

        $sidx = $request->getPost('sidx', 'propiedad');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesLegajos')->findBy(array('propiedad' => $id));
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesLegajos')->findBy(['propiedad' => $id], array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'] [$i] ['id'] = $r->getId(); // id
                $response ['rows'] [$i] ['cell'] = array(
                    $r->getId(),
                    $r->getPropiedad()->getId(),
                    utf8_encode($r->getValorPosible()),
                    utf8_encode($r->getSignificado())
                );
                $i ++;
            }

            return $this->response->setContent(Json::encode($response));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function editGridItemAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $data = Json::decode($request->getPost('data'), true);
                    if ($data) {
                        if (isset($data['id'])) {
                            //Edit
                            $n7PropiedadesL = new N7PropiedadesL();
                            $n7PropiedadesL = $this->getEntityManager()->find('Application\Entity\N7PropiedadesL', $data['id']);
                            if ($n7PropiedadesL) {
                                $n7PropiedadesL->setDescripcion($data['descripcion']);
                                $n7PropiedadesL->setTipoDeCampo($data['tipo_de_campo']);
                                $statusPersist = $this->getEntityManager()->persist($n7PropiedadesL);
                                $statusFlush = $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editProp',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $n7PropiedadesL = new N7PropiedadesL ();
                            $n7PropiedadesL->setDescripcion($data['descripcion']);
                            $n7PropiedadesL->setTipoDeCampo($data['tipo_de_campo']);
                            $statusPersist = $this->getEntityManager()->persist($n7PropiedadesL);
                            $statusFlush = $this->getEntityManager()->flush();

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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function deleteGridItemAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');
                    $n7PropiedadesL = new N7PropiedadesL ();
                    $n7PropiedadesL = $this->getEntityManager()->find('Application\Entity\N7PropiedadesL', $id);
                    if ($n7PropiedadesL) {
                        $statusRemove = $this->getEntityManager()->remove($n7PropiedadesL);
                        $statusFlush = $this->getEntityManager()->flush();

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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function editGridItemValAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $data = Json::decode($request->getPost('data'), true);
                    if ($data) {
                        if (isset($data['propiedad'])) {
                            //Add
                            $n7PropiedadesL = new N7PropiedadesL ();
                            $n7PropiedadesL = $this->getEntityManager()->find('Application\Entity\N7PropiedadesL', $data['propiedad']);
                            if ($n7PropiedadesL) {
                                $n7ValoresPosiblesLegajos = new N7ValoresPosiblesLegajos ();
                                $n7ValoresPosiblesLegajos->setPropiedad($n7PropiedadesL);
                                $n7ValoresPosiblesLegajos->setValorPosible($data['valor_posible']);
                                $n7ValoresPosiblesLegajos->setSignificado($data['significado']);
                                $this->getEntityManager()->persist($n7ValoresPosiblesLegajos);
                                $this->getEntityManager()->flush();
                            }
                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'addVal',
                                                'success' => true
                            )));
                        } else {
                            if (isset($data['id'])) {
                                //Edit
                                $n7ValoresPosiblesLegajos = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesLegajos', $data['id']);
                                if ($n7ValoresPosiblesLegajos) {
                                    $n7ValoresPosiblesLegajos->setValorPosible($data['valor_posible']);
                                    $n7ValoresPosiblesLegajos->setSignificado($data['significado']);
                                    $this->getEntityManager()->persist($n7ValoresPosiblesLegajos);
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function deleteGridItemValAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');
                    $n7ValoresPosiblesLegajos = new N7ValoresPosiblesLegajos ();
                    $n7ValoresPosiblesLegajos = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesLegajos', $id);
                    if ($n7ValoresPosiblesLegajos) {
                        $this->getEntityManager()->remove($n7ValoresPosiblesLegajos);
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

}
