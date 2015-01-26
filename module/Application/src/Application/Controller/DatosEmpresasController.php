<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7PropiedadesE;
use Application\Entity\N7ValoresPosiblesEmpresas;

class DatosEmpresasController extends BaseController {

    public function __construct() {
        
    }

    public function indexAction() {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }
        return new ViewModel();
    }

    public function loadDataGridAction() {
        try {
            $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findAll();

            $response['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $response['rows'][$i]['id'] = $r->getId(); // id
                $response['rows'][$i]['cell'] = array(
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
        try {
            $id = $this->params()->fromRoute("id", null);
            $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesEmpresas')->findBy(array('propiedad' => $id));

            $response['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $response['rows'] [$i] ['id'] = $r->getId(); // id
                $response['rows'] [$i] ['cell'] = array(
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
                            $n7PropiedadesE = new N7PropiedadesE ();
                            $n7PropiedadesE = $this->getEntityManager()->find('Application\Entity\N7PropiedadesE', $data['id']);
                            if ($n7PropiedadesE) {
                                $n7PropiedadesE->setDescripcion(utf8_decode($data['descripcion']));
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
                            $n7PropiedadesE->setDescripcion(utf8_decode($data['descripcion']));
                            $n7PropiedadesE->setTipoDeCampo($data['tipo_de_campo']);
                            $this->getEntityManager()->persist(
                                    $n7PropiedadesE);
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function deleteGridItemAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isGet()) {
                    $id = (int) $request->getQuery('id');

                    $n7PropiedadesE = new N7PropiedadesE ();
                    $n7PropiedadesE = $this->getEntityManager()->find(
                            'Application\Entity\N7PropiedadesE', $id);
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
                            $n7PropiedadesE = new N7PropiedadesE ();
                            $n7PropiedadesE = $this->getEntityManager()->find('Application\Entity\N7PropiedadesE', $data['propiedad']);
                            if ($n7PropiedadesE) {
                                $n7ValoresPosiblesEmpresas = new N7ValoresPosiblesEmpresas ();
                                $n7ValoresPosiblesEmpresas->setPropiedad($n7PropiedadesE);
                                $n7ValoresPosiblesEmpresas->setValorPosible(utf8_decode($data['valor_posible']));
                                $n7ValoresPosiblesEmpresas->setSignificado(utf8_decode($data['significado']));
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
                                $n7ValoresPosiblesEmpresas = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesEmpresas'
                                        , $data['id']);
                                if ($n7ValoresPosiblesEmpresas) {
                                    $n7ValoresPosiblesEmpresas->setValorPosible(utf8_decode($data['valor_posible']));
                                    $n7ValoresPosiblesEmpresas->setSignificado(utf8_decode($data['significado']));
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function deleteGridItemValAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isGet()) {
                    $id = (int) $request->getQuery('id');
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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

}
