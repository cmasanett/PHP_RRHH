<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
// Incluir entidades
use Application\Entity\N7VistasEmpresas;
use Application\Entity\N7PropiedadesE;
use Application\Entity\N7VistasPropiedadesE;

class VistasEmpresasController extends AbstractActionController {

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

    public function loadViewGridAction() {
        $request = $this->getRequest();

        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasEmpresas')->findAll();
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7VistasEmpresas')->findBy(array(), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); // id
                $response['rows'][$i]['cell'] = array(
                    $r->getId(),
                    $r->getDescripcion(),
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
        $request = $this->getRequest();

        //$id = $this->params()->fromRoute("id", 1);
        
        $sidx = $request->getPost('sidx', 'id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        
        //propiedadId
        
        try {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('N7VistasPropiedadesE.propiedadId')
                ->from('Application\Entity\N7VistasPropiedadesE', 'N7VistasPropiedadesE')
                ->orderBy('N7VistasPropiedadesE.id', 'ASC');
            $query = $qb->getQuery();
            $r1 = $query->getScalarResult();
            $ids = array_map('current', $r1);
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findBy(array('id' => array("1","2","3")));
            
            //$ids = $this->getEntityManager()->getRepository('Application\Entity\N7VistasPropiedadesE')->findAll();  
            //$data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findBy(array('id' => array($ids)));
//            if (!is_array($ids)) $ids = array($ids);
//            $qb = $this->getEntityManager()->createQueryBuilder();
//            $qb->add('select', $qb->expr()->count('r.id'))
//                ->add('from', '\My\Entity\Rating r');
//            if ($outcome === 'wins') $qb->add('where', $qb->expr()->in('r.winner', array('?1')));
//            if ($outcome === 'fails') $qb->add('where', $qb->expr()->in('r.loser', array('?1')));
//            $qb->select(array('vp')) // string 'u' is converted to array internally
//                ->from('User', 'vp')
//                ->where($qb->expr()->orX(
//                    $qb->expr()->eq('vp.id', '?1'),
//                    $qb->expr()->like('vp.nickname', '?2')
//                ))
//                ->orderBy('u.surname', 'ASC'));
//            $qb->add('where', $qb->expr()->in('r.winner', '?1'));
//            $qb->setParameter(1, $ids);
//            $query = $qb->getQuery();
//            //die('q = ' . $qb);
//            $data = $query->getSingleScalarResult();
            
            //$data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasPropiedadesE')->findBy(array('formulario' => $id));
            //$data = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findBy(array('formulario' => $id));
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7PropiedadesE')->findBy(array('id' => array($ids)), array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); // id
                $response['rows'][$i]['cell'] = array(
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
    
    public function loadDataGridAction() {
        $request = $this->getRequest();

        $id = $this->params()->fromRoute("id", null);

        $sidx = $request->getPost('sidx', 'propiedad');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        try {
            $data = $this->getEntityManager()->getRepository('Application\Entity\N7VistasPropiedadesE')->findBy(array('formularioId' => $id));
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

            $row = $this->getEntityManager()->getRepository('Application\Entity\N7VistasPropiedadesE')->findBy([ 'formularioId' => $id], array($sidx => $sord), $limit, $start);

            $response ['page'] = $page;
            $response ['total'] = $total_pages;
            $response ['records'] = $count;
            $i = 0;

            foreach ($row as $r) {
                $response ['rows'][$i]['id'] = $r->getId(); // id
                $response['rows'][$i]['cell'] = array(
                    $r->getId(),
                    $r->getPropiedadId(),
                    $r->getFormularioId(),
                    $r->getOrden(),
                    $r->getSoloLectura()
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
                            $n7VistasEmpresas = new N7VistasEmpresas ();
                            $n7VistasEmpresas = $this->getEntityManager()->find('Application\Entity\N7VistasEmpresas', $data['id']);
                            if ($n7VistasEmpresas) {
                                $n7VistasEmpresas->setDescripcion($data['descripcion']);
                                $n7VistasEmpresas->setExtranetPermitido($data['extranet_permitido']);
                                $this->getEntityManager()->persist($n7VistasEmpresas);
                                $this->getEntityManager()->flush();

                                return $this->response->setContent(Json::encode(array(
                                                    'type' => 'editVista',
                                                    'success' => true
                                )));
                            }
                        } else {
                            //Add
                            $n7VistasEmpresas = new N7VistasEmpresas ();
                            $n7VistasEmpresas->setDescripcion($data['descripcion']);
                            $n7VistasEmpresas->setExtranetPermitido($data['extranet_permitido']);
                            $this->getEntityManager()->persist(
                                    $n7VistasEmpresas);
                            $this->getEntityManager()->flush();

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

                    $n7VistasEmpresas = new N7VistasEmpresas ();
                    $n7VistasEmpresas = $this->getEntityManager()->find(
                            'Application\Entity\N7VistasEmpresas', $id);
                    if ($n7VistasEmpresas) {
                        $this->getEntityManager()->remove($n7VistasEmpresas);
                        $this->getEntityManager()->flush();

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'delVista',
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

}
