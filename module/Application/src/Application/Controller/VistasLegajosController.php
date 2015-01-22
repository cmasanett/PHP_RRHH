<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7VistasLegajos;
use Application\Entity\N7VistasPropiedadesL;

class VistasLegajosController extends BaseController {

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
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasLegajos')->findAll();
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7VistasLegajos')->findBy(array(), array($sidx => $sord), $limit, $start);

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
            if ($request->isPost()) {
                $dataJson = $request->getPost('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $query1 = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\N7PropiedadesL u WHERE u.id NOT IN (SELECT p.propiedadId FROM Application\Entity\N7VistasPropiedadesL p WHERE p.formularioId = ?1)');
            $query1->setParameter(1, $id);
            $row = $query1->getResult();

            $response ['rows'] = array();
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
            if ($request->isPost()) {
                $dataJson = $request->getPost('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $query1 = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\N7VistasPropiedadesL u WHERE u.formularioId = ?1 ORDER BY u.orden ASC');
            $query1->setParameter(1, $id);
            $row = $query1->getResult();

            $response ['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $query0 = $this->getEntityManager()->createQuery('SELECT u.descripcion, u.tipoDeCampo FROM Application\Entity\N7PropiedadesL u WHERE u.id = ?1');
                $query0->setParameter(1, $r->getPropiedadId());
                $row1 = $query0->getResult();

                $response ['rows'] [$i] = array(
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
                            $n7VistasLegajos = new N7VistasLegajos ();
                            $n7VistasLegajos = $this->getEntityManager()->find('Application\Entity\N7VistasLegajos', $data['id']);
                            if ($n7VistasLegajos) {
                                $n7VistasLegajos->setDescripcion(utf8_decode($data['descripcion']));
                                $n7VistasLegajos->setExtranetPermitido($data['extranet_permitido']);
                                $this->getEntityManager()->persist($n7VistasLegajos);
                                $this->getEntityManager()->flush();

                                $q = $this->getEntityManager()->createQuery('delete from Application\Entity\N7VistasPropiedadesL m where m.formularioId = ?1');
                                $q->setParameter(1, $data['id']);
                                $numDeleted = $q->execute();

                                $batchSize = 20;
                                $i = 0;
                                foreach ($data['vistas_propiedades'] as $r) {
                                    $n7VistasPropiedadesL = new N7VistasPropiedadesL ();
                                    $n7VistasPropiedadesL->setPropiedadId($r['propiedadId']);
                                    $n7VistasPropiedadesL->setFormularioId($n7VistasLegajos->getId());
                                    $n7VistasPropiedadesL->setOrden($r['orden']);
                                    $n7VistasPropiedadesL->setSoloLectura($r['solo_lectura']);
                                    $this->getEntityManager()->persist($n7VistasPropiedadesL);
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
                            $n7VistasLegajos = new N7VistasLegajos ();
                            $n7VistasLegajos->setDescripcion(utf8_decode($data['descripcion']));
                            $n7VistasLegajos->setExtranetPermitido($data['extranet_permitido']);
                            $this->getEntityManager()->persist($n7VistasLegajos);
                            $this->getEntityManager()->flush();

                            $batchSize = 20;
                            $i = 0;
                            foreach ($data['vistas_propiedades'] as $r) {
                                $n7VistasPropiedadesL = new N7VistasPropiedadesL ();
                                $n7VistasPropiedadesL->setPropiedadId($r['propiedadId']);
                                $n7VistasPropiedadesL->setFormularioId($n7VistasLegajos->getId());
                                $n7VistasPropiedadesL->setOrden($r['orden']);
                                $n7VistasPropiedadesL->setSoloLectura($r['solo_lectura']);
                                $this->getEntityManager()->persist($n7VistasPropiedadesL);
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
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');

                    $q = $this->getEntityManager()->createQuery('delete from Application\Entity\N7VistasPropiedadesL m where m.formularioId = ?1');
                    $q->setParameter(1, $id);
                    $numDeleted = $q->execute();

                    if ($numDeleted >= 0) {
                        $n7VistasLegajos = new N7VistasLegajos ();
                        $n7VistasLegajos = $this->getEntityManager()->find('Application\Entity\N7VistasLegajos', $id);
                        if ($n7VistasLegajos) {
                            $this->getEntityManager()->remove($n7VistasLegajos);
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
