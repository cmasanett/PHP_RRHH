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
        try {
            $row = $data = $this->getEntityManager()->getRepository('Application\Entity\N7Legajos')->findAll();
            $response['rows'] = array();
            $i = 0;

            $inactivo = "";

            foreach ($row as $r) {
                $response['rows'][$i]['id'] = $r->getId(); //id
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
        try {
            if ($this->request->isXmlHttpRequest()) {
                $request = $this->getRequest();
                if ($request->isGet()) { //if ($request->isPost()) {
                    $data = Json::decode($request->getQuery('data'), true); //$data = Json::decode($request->getPost('data'), true);
                    if ($data) {
                        if (isset($data['id'])) {
                            $id = $data['id'];
                            $vistaLegajoSel = $data['vistaLegajoSel'];
                        }
                    }
                }
            }

//            $subQuery = $this->getEntityManager()->createQuery("
//                SELECT pp0.valor 
//                FROM Application\Entity\N7PpdL pp0 
//                WHERE pp0.propiedadId = vp.propiedadId AND pp0.objetoId = ?1)
//                SELECT pp.valor
//                FROM Application\Entity\N7PpdL pp
//                WHERE country.id = :country_id AND user.id = u.id
//            ");

//            $subQuery = $this->getEntityManager()->createQuery("
//                SELECT pp.valor
//                FROM Application\Entity\N7PpdL pp
//                WHERE pp.propiedadId = vp.propiedadId AND pp.objetoId = ?1)
//            ");
//
//            $queryBuilder = $this->getEntityManager()->createQueryBuilder('u');
//            $queryBuilder
//                    ->where($queryBuilder->expr()->exists($subQuery->getDql()))
//                    ->setParameter(1, $id);
//
//            return $queryBuilder->getQuery()->getResult();

//            $query = $this->getEntityManager()->createQuery(""
//                    . "SELECT p.id, p.descripcion, "
//                    . "(SELECT pp0.valor FROM Application\Entity\N7PpdL pp0 WHERE pp0.propiedadId = vp.propiedadId AND pp0.objetoId = ?1) contenido, "
//                    . "(SELECT pp1.valor FROM Application\Entity\N7PpdL pp1 WHERE pp1.propiedadId = vp.propiedadId AND pp1.objetoId = ?1) contant, "
//                    . "(SELECT pp2.id FROM Application\Entity\N7PpdL pp2 WHERE pp2.propiedadId = vp.propiedadId AND pp2.objetoId = ?1) pp_id, "
//                    . "vp.soloLectura, p.tipoDeCampo "
//                    . "FROM Application\Entity\N7VistasPropiedadesL vp "
//                    . "LEFT JOIN Application\Entity\N7PropiedadesL p WITH p.id = vp.propiedadId "
//                    . "LEFT JOIN Application\Entity\N7VistasLegajos v WITH v.id = vp.formularioId "
//                    . "WHERE v.descripcion = ?2 "
//                    . "ORDER BY vp.orden");
//            $query->setParameter(1, $id);
//            $query->setParameter(2, $vistaLegajoSel);
//            $row1 = $query->getArrayResult();
//            
            $qb1 = $this->getEntityManager()->createQueryBuilder();
            $qb1->select('p.id', 'p.descripcion', 'vp.soloLectura', 'p.tipoDeCampo')
//                    ->addSelect('pp.valor contenido')
//                    ->addSelect('pp.valor contant')
//                    ->addSelect('pp.id pp_id')
//                    ->from('Application\Entity\N7PpdL', 'pp')
                    ->addSelect('(SELECT pp0.valor FROM Application\Entity\N7PpdL pp0 WHERE pp0.propiedadId = p.id AND pp0.objetoId = ?1) AS contenido')
                    ->addSelect('(SELECT pp1.valor FROM Application\Entity\N7PpdL pp1 WHERE pp1.propiedadId = p.id AND pp1.objetoId = ?1) AS contant')
                    ->addSelect('(SELECT pp2.id FROM Application\Entity\N7PpdL pp2 WHERE pp2.propiedadId = p.id AND pp2.objetoId = ?1) AS pp_id')
                    ->from('Application\Entity\N7VistasPropiedadesL', 'vp')
                    ->leftJoin('Application\Entity\N7PropiedadesL', 'p', 'WITH', 'p.id = vp.propiedadId')
                    ->leftJoin('Application\Entity\N7VistasLegajos', 'v', 'WITH', 'v.id = vp.formularioId')
//                    ->where('pp.propiedadId = vp.propiedadId AND pp.objetoId = ?1')
                    ->where('v.id = ?2')
                    ->orderBy('vp.orden', 'ASC');
            $qb1->setParameter(1, $id);
            $qb1->setParameter(2, $vistaLegajoSel);
            $query1 = $qb1->getQuery();
            $row1 = $query1->getArrayResult();

            $response['rows'] = array();
            $x = 0;

            foreach ($row1 as $j) {
//                $contenido = utf8_encode($j['valor']);
//                $contant =  utf8_encode($j['valor']);
//                $pp_id =  $j['pp.id'];

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

//                for ($i = 0; $i < count($row0); $i++) {
//                    if ($j['id'] == $row0[$i]->getPropiedadId()) {
//                        $contenido = utf8_encode($row0[$i]->getValor());
//                        $contant = utf8_encode($row0[$i]->getValor());
//                        $pp_id = $row0[$i]->getId();
//                    }
//                }
                
                $response['rows'][$x] = array(
                    $j['id'],
                    utf8_encode($j['descripcion']),
                    utf8_encode($j['contenido']),
                    utf8_encode($j['contant']),
                    $j['pp_id'],
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
                if ($request->isGet()) {
                    $id = (int) $request->getQuery('id');
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
                $selectData[$i]["id"] = $res->getId();
                $selectData[$i]["value"] = $res->getDescripcion();
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
                        foreach ($data['dataGridDatosPpdLegajo'] as $r) {
                            if ($r['contant'] != $r['contenido']) {
                                if ($r['pp_id'] != "") {
                                    $n7PpdL = new N7PpdL ();
                                    $n7PpdL = $this->getEntityManager()->find('Application\Entity\N7PpdL', $r['pp_id']);
                                    if ($n7PpdL) {
                                        $n7PpdL->setValor(utf8_decode($r['contenido']));
                                        $this->getEntityManager()->persist($n7PpdL);
                                        $this->getEntityManager()->flush();
                                    }
                                } else {
                                    $n7PpdL = new N7PpdL ();
                                    $n7PpdL->setObjetoId($data['objetoId']);
                                    $n7PpdL->setPropiedadId($r['propiedad_id']);
                                    $n7PpdL->setValor(utf8_decode($r['contenido']));
                                    $this->getEntityManager()->persist($n7PpdL);
                                    $this->getEntityManager()->flush();
                                }
                            }
                        }

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'editPpdLegajo',
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
