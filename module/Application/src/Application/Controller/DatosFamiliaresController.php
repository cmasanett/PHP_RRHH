<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

// Incluir entidades
use Application\Entity\N7PropiedadesF;
use Application\Entity\N7ValoresPosiblesFamiliares;

class DatosFamiliaresController extends AbstractActionController {

    public function __construct() {
        
    }

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

        try{
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesF')->findAll();

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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesF')->findBy(array(), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'] [$i] ['id'] = $r->getId(); // getId()
                $response ['rows'] [$i] ['cell'] = array(
                    $r->getId(),
                    $r->getDescripcion(),
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

        try{
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesFamiliares')->findBy(array('propiedad' => $id));
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesFamiliares')->findBy(['propiedad' => $id], array($sidx => $sord), $limit, $start);

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
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function editGridItemAction() {
        try{
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
                                $n7PropiedadesF->setDescripcion($data['descripcion']);
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
                            $n7PropiedadesF->setDescripcion($data['descripcion']);
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
        try{
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');
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
        try{
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
                                $n7ValoresPosiblesFamiliares->setValorPosible($data['valor_posible']);
                                $n7ValoresPosiblesFamiliares->setSignificado($data['significado']);
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
                                    $n7ValoresPosiblesFamiliares->setValorPosible($data['valor_posible']);
                                    $n7ValoresPosiblesFamiliares->setSignificado($data['significado']);
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
        try{
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');
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
