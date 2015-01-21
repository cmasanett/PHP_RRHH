<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Entities
use Application\Entity\N7Legajos;
use Application\Entity\N7PpdL;

class LegajosController extends BaseController {

    public function __construct() {
        
    }

    public function indexAction() {
        if (!$this->getAuthService()->hasIdentity()) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }
        return new ViewModel();
    }

    public function loadLegajosGridAction() {
        $request = $this->getRequest();

        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 1000);

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

//            $identi = $this->getAuthenticationService()->getStorage()->read();
//            if ($identi != false && $identi != null) {
//                $row0 = $this->getEntityManager()->getRepository('Application\Entity\N7Empresas')->findBy(array('id' => $identi->empresaCorrienteId));
//                $qb1 = $this->getEntityManager()->createQueryBuilder();
//                $qb1->select('p.id', 'p.descripcion', 'vp.soloLectura', 'p.tipoDeCampo')
//                        ->from('Application\Entity\N7Legajos', 'l')
//                        ->innerJoin('Application\Entity\N7PpdL', 'p', 'WITH', 'p.objetoId = l.id AND p.propiedadId = ?1')
//                        ->where('l.empresaId = ?2');
//                $qb1->setParameter(1, $row0->getDatoLegajoBaja());
//                $qb1->setParameter(2, $identi->empresaCorrienteId);
//                $query1 = $qb1->getQuery();
//                $row1 = $query1->getArrayResult();
//            }
            $inactivo = "";

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); //id
                $response['rows'][$i]['cell'] = array(
                    $r->getId(),
                    $r->getEmpresaId(),
                    $r->getLegajo(),
                    utf8_encode($r->getApellidoYNombre()),
                    $r->getFoto(),
                    $inactivo
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
            $x = 0;

            foreach ($row1 as $j) {
                $contenido = "";
                $contant = "";
                $pp_id = "";

                $query2 = $this->getEntityManager()->createQuery('SELECT u FROM Application\Entity\N7ValoresPosiblesLegajos u WHERE u.propiedad = ?1');
                $query2->setParameter(1, $j['id']);
                $row2 = $query2->getResult();

                $lista = "";
                $lista_valorposible = array();
                $d = 0;

                foreach ($row2 as $res) {
                    $lista_valorposible[$d]["value"] = $res->getValorPosible();
                    $lista_valorposible[$d]["desc"] = $res->getValorPosible() . " - " . $res->getSignificado();
                    $d++;
                }

                if (count($lista_valorposible) > 0) {
                    $lista = $lista_valorposible;
                }

                for ($i = 0; $i < count($row0); $i++) {
                    if ($j['id'] == $row0[$i]->getPropiedadId()) {
                        $contenido = utf8_encode($row0[$i]->getValor());
                        $contant = utf8_encode($row0[$i]->getValor());
                        $pp_id = $row0[$i]->getId();
                    }
                }
                $response['rows'][$x] = array(
                    $j['id'],
                    utf8_encode($j['descripcion']),
                    $contenido,
                    $contant,
                    $pp_id,
                    $j['soloLectura'],
                    $j['tipoDeCampo'],
                    $lista
                );
                $x ++;
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
                            $n7Legajos = new N7Legajos ();
                            $n7Legajos = $this->getEntityManager()->find('Application\Entity\N7Legajos', $data['id']);
                            if ($n7Legajos) {
                                //$n7Legajos->setEmpresaId($data['empresaId']);
                                $n7Legajos->setLegajo($data['legajo']);
                                $n7Legajos->setApellidoYNombre(utf8_decode($data['apellido_y_nombre']));
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
                            $identi = $this->getAuthService()->getIdentity();
                            if ($identi != false && $identi != null) {
                                $n7Legajos = new N7Legajos ();
                                $n7Legajos->setEmpresaId($identi['empresaCorrienteId']);
                                //$n7Legajos->setEmpresaId($data['empresaId']);
                                $n7Legajos->setLegajo($data['legajo']);
                                $n7Legajos->setApellidoYNombre(utf8_decode($data['apellido_y_nombre']));
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

    public function loadSelectVistasAction() {
        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasLegajos')->findBy(array(), array('descripcion' => 'ASC'));

            $selectData = array();
            $i = 0;

            foreach ($data as $res) {
//                echo '<option value="'.$row['drink_name'].'">' . $row['drink_name'] . "</option>";
//                $selectData [$res->getId()] = $res->getDescripcion();
                $selectData[$i]["id"] = $res->getId();
                $selectData[$i]["value"] = $res->getDescripcion();
                $i++;
            }

            return $this->response->setContent(Json::encode(array('type' => 'success', 'data' => $selectData)));
        } catch (\Exception $ex) {
            $this->flashMessenger()->addMessage($ex->getMessage());
        }
    }

    public function loadSelectValorPosibleAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $dataJson = $request->getPost('id', 0);
                $id = ($dataJson > 0) ? Json::decode($dataJson, true) : 0;
            }
        }

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7ValoresPosiblesLegajos')->findBy(array('propiedad' => $id), array('valorPosible' => 'ASC'));

            $selectData = array();
            $i = 0;

            foreach ($data as $res) {
                $selectData[$i]["id"] = $res->getValorPosible();
                $selectData[$i]["value"] = utf8_encode($res->getValorPosible() . " - " . $res->getSignificado());
                $i++;
            }

            return $this->response->setContent(Json::encode(array('type' => 'success', 'data' => $selectData)));
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
                        foreach ($data as $r) {
                            if ($r['contant'] != $r['contenido']) {
                                if ($r['pp_id'] != "") {
                                    $n7PpdL = new N7PpdL ();
                                    $n7PpdL = $this->getEntityManager()->find('Application\Entity\N7PpdL', $r['pp_id']);
                                    if ($n7PpdL) {
                                        $n7PpdL->setValor(utf8_decode($r['contenido']));
                                        $this->getEntityManager()->persist($n7PpdL);
                                        $this->getEntityManager()->flush();

                                        return $this->response->setContent(Json::encode(array(
                                                            'type' => 'editPpdLegajo',
                                                            'success' => true
                                        )));
                                    }
                                } else {
                                    $n7PpdL = new N7PpdL ();
                                    $n7PpdL->setObjetoId($r['objetoId']);
                                    $n7PpdL->setPropiedadId($r['id']);
                                    $n7PpdL->setValor(utf8_decode($r['contenido']));
                                    $this->getEntityManager()->persist($n7PpdL);
                                    $this->getEntityManager()->flush();

                                    return $this->response->setContent(Json::encode(array(
                                                        'data' => $n7PpdL->getId(),
                                                        'type' => 'addPpdLegajo',
                                                        'success' => true
                                    )));
                                }
                            } else {
                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'PpdLegajo',
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

}
