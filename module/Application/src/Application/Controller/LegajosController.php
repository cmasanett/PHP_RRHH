<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7Legajos;
use Application\Entity\N7PpdL;
use Application\Entity\N7PropiedadesL;
use Application\Entity\N7VistasLegajos;
use Application\Entity\N7VistasPropiedadesL;
use Application\Entity\N7ValoresPosiblesLegajos;

class LegajosController extends BaseController {

    public function __construct() {
        
    }

    public function indexAction() {
        return new ViewModel(array());
    }

    public function loadLegajosGridAction() {
        $request = $this->getRequest();

        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7Legajos')->findAll();
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7Legajos')->findBy(array(), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); //id
                $response['rows'][$i]['cell'] = array(
                    $r->getId(),
                    $r->getEmpresaId(),
                    $r->getLegajo(),
                    utf8_encode($r->getApellidoYNombre()),
                    $r->getFoto()
                );
                $i ++;
            }

            return $this->response->setContent(Json::encode($response));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function loadPpdLegajoGridAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $dataJson = $request->getPost('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $dataPpdL = $this->getEntityManager()->getRepository('Application\Entity\N7PpdL')->findBy(array('objetoId' => $id));
            $qb0 = $this->getEntityManager()->createQueryBuilder();
            $qb0->select('p.id', 'p.descripcion','','','','cp.solo_lectura','p.tipo_de_campo')
                    ->from('Application\Entity\N7EmpresaUsuario', 'p')
                    ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
                    ->where('p.usuario = ?1');
            $qb0->setParameter(1, $authAdapter->getResultRowObject('id')->id);
            $query0 = $qb0->getQuery();
            $result = $query0->getArrayResult();
            $cantEmpresasAsociadas = count($result);
//SELECT 
//    p.id,
//    p.descripcion,
//    SPACE(120) AS contenido,
//    SPACE(120) AS contant,
//    000000000.00 AS pp_id,
//    vp.solo_lectura,
//    p.tipo_de_campo
//FROM
//    zend_php_demo.n7_propiedades_l p,
//    zend_php_demo.n7_vistas_propiedades_l vp,
//    zend_php_demo.n7_vistas_legajos v
//WHERE
//    p.id = vp.propiedad_id
//        AND vp.formulario_id = v.id
//		AND v.descripcion = "Alta de Legajo"
//ORDER BY vp.orden
            $query1->setParameter(1, $id);
            $row = $query1->getResult();

            $response['rows'] = array();
            $i = 0;

            colNames: ["Id", "Descripcion", "Contenido", "Contant", "PPId", "Solo Lectura", "Tipo"],
            foreach ($row as $r) {
                $response['rows'][$i] = array(
                    $r->getId(),
                    $r->getObjetoId,
                    $r->getPropiedadId,
                    utf8_encode($r->getValor())
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
            $row = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesLegajos')->findBy(array('propiedad' => $id));

            $response['rows'] = array();
            $i = 0;

            foreach ($row as $r) {
                $response['rows'][$i] = array(
                    $r->getId(),
                    $r->getPropiedad()->getId(),
                    utf8_encode($r->getValorPosible()),
                    utf8_encode($r->getSignificado())
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
                                $n7VistasLegajos->setDescripcion($data['descripcion']);
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
                                        $this->getEntityManager()->clear();
                                    }
                                    $i++;
                                }
                                $this->getEntityManager()->flush();
                                $this->getEntityManager()->clear();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editVista',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $n7VistasLegajos = new N7VistasLegajos ();
                            $n7VistasLegajos->setDescripcion($data['descripcion']);
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
                                    $this->getEntityManager()->clear();
                                }
                                $i++;
                            }
                            $this->getEntityManager()->flush();
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

    public function loadSelectViewAction() {
        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasLegajos')->findAll();
            $selectData = array();

            foreach ($data as $res) {
                //echo '<option value="'.$row['drink_name'].'">' . $row['drink_name'] . "</option>";
                $selectData [$res->getId()] = $res->getDescripcion();
            }

            return $this->response->setContent(Json::encode(array('type' => 'success', 'data' => $selectData)));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

}
