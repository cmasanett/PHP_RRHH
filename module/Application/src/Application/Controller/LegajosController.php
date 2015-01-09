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
                $data = Json::decode($request->getPost('data'), true);
                if ($data) {
                    if (isset($data['id'])) {
                        $id = $data['id'];
                        $vistaLegajoSel = $data['vistaLegajoSel'];
                    }
                }
            }
        }

        try {
            $row0 = $this->getEntityManager()->getRepository('Application\Entity\N7PpdL')->findBy(array('objetoId' => $id));
            $qb1 = $this->getEntityManager()->createQueryBuilder();
            $qb1->select('p.id', 'p.descripcion', 'vp.soloLectura', 'p.tipoDeCampo')
                    ->from('Application\Entity\N7VistasPropiedadesL', 'vp')
                    ->innerJoin('Application\Entity\N7PropiedadesL', 'p', 'WITH', 'vp.propiedadId = p.id')
                    ->innerJoin('Application\Entity\N7VistasLegajos', 'v', 'WITH', 'vp.formularioId = v.id')
                    ->where('v.id = ?1')
                    ->orderBy('vp.orden', 'ASC');
            $qb1->setParameter(1, $vistaLegajoSel);
            $query1 = $qb1->getQuery();
            $row1 = $query1->getArrayResult();

            $response['rows'] = array();
            $i = 0;

            foreach ($row0 as $r) {
                foreach ($row1 as $j) {
                    if ($r->getPropiedadId() == $j['id']) {
                        $response['rows'][$i] = array(
                            $j['id'],
                            utf8_encode($j['descripcion']),
                            utf8_encode($r->getValor()),
                            utf8_encode($r->getValor()),
                            $r->getId(),
                            $j['soloLectura'],
                            $j['tipoDeCampo']
                        );
                        $i ++;
                    }
                }
            }

//            foreach ($row as $r) {
//                $response['rows'][$i] = array(
//                    $r['id'],
//                    utf8_encode($r['descripcion']),
//                    utf8_encode(""),
//                    utf8_encode(""),
//                    "",
//                    $r['soloLectura'],
//                    $r['tipoDeCampo'],
////                    $r->getId(),
////                    $r->getObjetoId,
////                    $r->getPropiedadId,
////                    utf8_encode(utf8_encode($r->getValor()))
//                );
//                $i ++;
//            }
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
                            $n7Legajos = new N7Legajos ();
                            $n7Legajos = $this->getEntityManager()->find('Application\Entity\N7Legajos', $data['id']);
                            if ($n7Legajos) {
                                //$n7Legajos->setEmpresaId($data['empresaId']);
                                $n7Legajos->setLegajo($data['legajo']);
                                $n7Legajos->setApellidoYNombre($data['apellido_y_nombre']);
                                //$n7Legajos->setFoto($data['foto']);
                                $this->getEntityManager()->persist($n7Legajos);
                                $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editLegajo',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $identi = $this->getAuthenticationService()->getStorage()->read();
                            if ($identi != false && $identi != null) {
                                $n7Legajos = new N7Legajos ();
                                $n7Legajos->setEmpresaId($identi->empresaCorrienteId);
                                //$n7Legajos->setEmpresaId($data['empresaId']);
                                $n7Legajos->setLegajo($data['legajo']);
                                $n7Legajos->setApellidoYNombre($data['apellido_y_nombre']);
                                //$n7Legajos->setFoto($data['foto']);
                                $n7Legajos->setFoto("");
                                $this->getEntityManager()->persist($n7Legajos);
                                $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'addLegajo',
                                                    'success' => true
                                )));
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

    public function deleteGridItemAction() {
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isPost()) {
                    $id = (int) $request->getPost('id');
                    $n7Legajos = new N7Legajos ();
                    $n7Legajos = $this->getEntityManager()->find('Application\Entity\N7Legajos', $id);
                    if ($n7Legajos) {
                        $this->getEntityManager()->remove($n7Legajos);
                        $this->getEntityManager()->flush();

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'delLegajo',
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
