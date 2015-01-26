<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7PropiedadesF;
use Application\Entity\N7ValoresPosiblesFamiliares;

class DatosFamiliaresController extends BaseController {

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
            $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesF')->findAll();
            
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
            $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesFamiliares')->findBy(array('propiedad' => $id));
            
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
                            $n7PropiedadesF = new N7PropiedadesF();
                            $n7PropiedadesF = $this->getEntityManager()->find('Application\Entity\N7PropiedadesF', $data['id']);
                            if ($n7PropiedadesF) {
                                $n7PropiedadesF->setDescripcion(utf8_decode($data['descripcion']));
                                $n7PropiedadesF->setTipoDeCampo($data['tipo_de_campo']);
                                $this->getEntityManager()->persist($n7PropiedadesF);
                                $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editProp',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $n7PropiedadesF = new N7PropiedadesF ();
                            $n7PropiedadesF->setDescripcion(utf8_decode($data['descripcion']));
                            $n7PropiedadesF->setTipoDeCampo($data['tipo_de_campo']);
                            $this->getEntityManager()->persist($n7PropiedadesF);
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
                    $n7PropiedadesF = new N7PropiedadesF ();
                    $n7PropiedadesF = $this->getEntityManager()->find('Application\Entity\N7PropiedadesF', $id);
                    if ($n7PropiedadesF) {
                        $this->getEntityManager()->remove($n7PropiedadesF);
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
                            $n7PropiedadesF = new N7PropiedadesF ();
                            $n7PropiedadesF = $this->getEntityManager()->find('Application\Entity\N7PropiedadesF', $data['propiedad']);
                            if ($n7PropiedadesF) {
                                $n7ValoresPosiblesFamiliares = new N7ValoresPosiblesFamiliares ();
                                $n7ValoresPosiblesFamiliares->setPropiedad($n7PropiedadesF);
                                $n7ValoresPosiblesFamiliares->setValorPosible(utf8_decode($data['valor_posible']));
                                $n7ValoresPosiblesFamiliares->setSignificado(utf8_decode($data['significado']));
                                $this->getEntityManager()->persist($n7ValoresPosiblesFamiliares);
                                $this->getEntityManager()->flush();
                            }

                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'addVal',
                                                'success' => true
                            )));
                        } else {
                            if (isset($data['id'])) {
                                //Edit
                                $n7ValoresPosiblesFamiliares = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesFamiliares', $data['id']);
                                if ($n7ValoresPosiblesFamiliares) {
                                    $n7ValoresPosiblesFamiliares->setValorPosible(utf8_decode($data['valor_posible']));
                                    $n7ValoresPosiblesFamiliares->setSignificado(utf8_decode($data['significado']));
                                    $this->getEntityManager()->persist($n7ValoresPosiblesFamiliares);
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
                    $n7ValoresPosiblesFamiliares = new N7ValoresPosiblesFamiliares ();
                    $n7ValoresPosiblesFamiliares = $this->getEntityManager()->find('Application\Entity\N7ValoresPosiblesFamiliares', $id);
                    if ($n7ValoresPosiblesFamiliares) {
                        $this->getEntityManager()->remove($n7ValoresPosiblesFamiliares);
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
