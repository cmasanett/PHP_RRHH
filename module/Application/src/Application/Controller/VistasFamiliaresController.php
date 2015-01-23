<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7VistasFamiliares;
use Application\Entity\N7VistasPropiedadesF;

class VistasFamiliaresController extends BaseController {

    public function __construct() {
        
    }

    public function indexAction() {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }
        return new ViewModel();
    }

    public function loadViewGridAction() {
        $request = $this->getRequest();

        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 1000);

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasFamiliares')->findAll();
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7VistasFamiliares')->findBy(array(), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); //id
                $response ['rows'][$i]['cell'] = array(
                    $r->getId(),
                    utf8_encode($r->getDescripcion()),
                    $r->getExtranetPermitido()
                );
                $i ++;
            }

            return $this->response->setContent(Json::encode($response));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function loadPropGridAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isGet()) {
                $dataJson = $request->getQuery('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $query1 = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\N7PropiedadesF u WHERE u.id NOT IN (SELECT p.propiedadId FROM Application\Entity\N7VistasPropiedadesF p WHERE p.formularioId = ?1)');
            $query1->setParameter(1, $id);
            $row = $query1->getResult();

            $response['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i] = array(
                    $r->getId(),
                    utf8_encode($r->getDescripcion()),
                    $r->getTipoDeCampo()
                );
                $i ++;
            }
            return $this->response->setContent(Json::encode(array('type' => 'success', 'data' => $response['rows'])));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function loadDataGridAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isGet()) {
                $dataJson = $request->getQuery('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $query1 = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\N7VistasPropiedadesF u WHERE u.formularioId = ?1 ORDER BY u.orden ASC');
            $query1->setParameter(1, $id);
            $row = $query1->getResult();

            $response ['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $query0 = $this->getEntityManager()->createQuery('SELECT u.descripcion, u.tipoDeCampo FROM Application\Entity\N7PropiedadesF u WHERE u.id = ?1');
                $query0->setParameter(1, $r->getPropiedadId());
                $row1 = $query0->getResult();

                $response ['rows'][$i] = array(
                    $r->getId(),
                    $r->getPropiedadId(),
                    utf8_encode($row1[0]['descripcion']),
                    utf8_encode($row1[0]['tipoDeCampo']),
                    $r->getFormularioId(),
                    $r->getOrden(),
                    $r->getSoloLectura()
                );
                $i ++;
            }

            return $this->response->setContent(Json::encode(array('type' => 'success', 'data' => $response['rows'])));
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
                        if ($data['id'] != "") {
                            //Edit
                            $n7VistasFamiliares = new N7VistasFamiliares ();
                            $n7VistasFamiliares = $this->getEntityManager()->find('Application\Entity\N7VistasFamiliares', $data['id']);
                            if ($n7VistasFamiliares) {
                                $n7VistasFamiliares->setDescripcion(utf8_decode($data['descripcion']));
                                $n7VistasFamiliares->setExtranetPermitido($data['extranet_permitido']);
                                $this->getEntityManager()->persist($n7VistasFamiliares);
                                $this->getEntityManager()->flush();

                                $q = $this->getEntityManager()->createQuery('delete from Application\Entity\N7VistasPropiedadesF m where m.formularioId = ?1');
                                $q->setParameter(1, $data['id']);
                                $numDeleted = $q->execute();

                                $batchSize = 20;
                                $i = 0;
                                foreach ($data['vistas_propiedades'] as $r) {
                                    $n7VistasPropiedadesF = new N7VistasPropiedadesF ();
                                    $n7VistasPropiedadesF->setPropiedadId($r['propiedadId']);
                                    $n7VistasPropiedadesF->setFormularioId($n7VistasFamiliares->getId());
                                    $n7VistasPropiedadesF->setOrden($r['orden']);
                                    $n7VistasPropiedadesF->setSoloLectura($r['solo_lectura']);
                                    $this->getEntityManager()->persist($n7VistasPropiedadesF);
                                    if (($i % $batchSize) === 0) {
                                        $this->getEntityManager()->flush();
                                        $this->getEntityManager()->clear(); // Detaches all objects from Doctrine!
                                    }
                                    $i++;
                                }
                                $this->getEntityManager()->flush(); //Persist objects that did not make up an entire batch
                                $this->getEntityManager()->clear();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editVista',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $n7VistasFamiliares = new N7VistasFamiliares ();
                            $n7VistasFamiliares->setDescripcion(utf8_decode($data['descripcion']));
                            $n7VistasFamiliares->setExtranetPermitido($data['extranet_permitido']);
                            $this->getEntityManager()->persist($n7VistasFamiliares);
                            $this->getEntityManager()->flush();

                            $batchSize = 20;
                            $i = 0;
                            foreach ($data['vistas_propiedades'] as $r) {
                                $n7VistasPropiedadesF = new N7VistasPropiedadesF ();
                                $n7VistasPropiedadesF->setPropiedadId($r['propiedadId']);
                                $n7VistasPropiedadesF->setFormularioId($n7VistasFamiliares->getId());
                                $n7VistasPropiedadesF->setOrden($r['orden']);
                                $n7VistasPropiedadesF->setSoloLectura($r['solo_lectura']);
                                $this->getEntityManager()->persist($n7VistasPropiedadesF);
                                if (($i % $batchSize) === 0) {
                                    $this->getEntityManager()->flush();
                                    $this->getEntityManager()->clear(); // Detaches all objects from Doctrine!
                                }
                                $i++;
                            }
                            $this->getEntityManager()->flush(); //Persist objects that did not make up an entire batch
                            $this->getEntityManager()->clear();

                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'addVista',
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

                    $q = $this->getEntityManager()->createQuery('delete from Application\Entity\N7VistasPropiedadesF m where m.formularioId = ?1');
                    $q->setParameter(1, $id);
                    $numDeleted = $q->execute();

                    if ($numDeleted >= 0) {
                        $n7VistasFamiliares = new N7VistasFamiliares ();
                        $n7VistasFamiliares = $this->getEntityManager()->find('Application\Entity\N7VistasFamiliares', $id);
                        if ($n7VistasFamiliares) {
                            $this->getEntityManager()->remove($n7VistasFamiliares);
                            $this->getEntityManager()->flush();

                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'delVista',
                                                'success' => true
                            )));
                        }
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

}
