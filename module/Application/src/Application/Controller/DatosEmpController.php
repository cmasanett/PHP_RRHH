<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Http\Request;
use Zend\Json\Json;
// Componentes de validaci�n
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;
// Adaptador de la db
use Zend\Db\Adapter\Adapter;
// Incluir entidades
use Application\Entity\PropiedadEmpresaLiquidacion;
use Application\Entity\PropiedadEmpresaLiquidacionValores;
// Doctrine ORM
use Doctrine\ORM\EntityManager;

class DatosEmpController extends AbstractActionController {

    public function __construct() {
        
    }

    /**
     *
     * @var DoctrineORMEntityManager
     */
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

        /*$wh = "";
        $searchOn = $request->getPost('_search');
        if ($searchOn == 'true') {
        }*/

        $data = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacion')->findAll();

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
        
        //$row = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacion')->findBy(array(), array($sidx => $sord));
        $row = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacion')->findBy(array(), array($sidx => $sord), $limit, $start);

        $response ['page'] = $page;
        $response ['total'] = $total_pages;
        $response ['records'] = $count;
        $i = 0;

        foreach ($row as $r) {
            $response ['rows'] [$i] ['id'] = $r->id; // id
            $response ['rows'] [$i] ['cell'] = array(
                $r->id,
                $r->descripcion,
                $r->tipo_de_campo
            );
            $i ++;
        }

        return $this->response->setContent(Json::encode($response));
    }

    public function loadDataGridValAction() {
        $request = $this->getRequest();

        $id = $this->params()->fromRoute("id", null);

        $sidx = $request->getPost('sidx', 'propiedad_id');
        $sord = $request->getPost('sord', 'ASC');
        $page = $request->getPost('page', 1);
        $limit = $request->getPost('rows', 10);

        $data = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacionValores')->findBy(array('propiedad_id' => $id));
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

        $row = $this->getEntityManager()->getRepository('Application\Entity\PropiedadEmpresaLiquidacionValores')->findBy(['propiedad_id' => $id], array($sidx => $sord), $limit, $start);

        $response ['page'] = $page;
        $response ['total'] = $total_pages;
        $response ['records'] = $count;
        $i = 0;

        foreach ($row as $r) {
            $response ['rows'] [$i] ['id'] = $r->id; // id
            $response ['rows'] [$i] ['cell'] = array(
                $r->id,
                $r->propiedad_id,
                $r->valor_posible,
                $r->significado
            );
            $i ++;
        }

        return $this->response->setContent(Json::encode($response));
    }

    public function editGridItemAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = Json::decode($request->getPost('data'), true);
                if ($data) {
                    if (isset($data['id'])) {
                        //Edit
                        $propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
                        $propiedadEmpresaLiquidacion = $this->getEntityManager()->find('Application\Entity\PropiedadEmpresaLiquidacion', $data['id']);
                        if ($propiedadEmpresaLiquidacion) {
                            $propiedadEmpresaLiquidacion->setDescripcion($data['descripcion']);
                            $propiedadEmpresaLiquidacion->setTipo($data['tipo_de_campo']);
                            $statusPersist = $this->getEntityManager()->persist($propiedadEmpresaLiquidacion);
                            $statusFlush = $this->getEntityManager()->flush();

                            return $this->response->setContent(Json::encode(array(
                                                'type' => 'editProp',
                                                'success' => true
                            )));
                        }
                    } else {
                        //Add
                        $propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
                        //$propiedadEmpresaLiquidacion->exchangeArray ( $request->getPost () );
                        $propiedadEmpresaLiquidacion->setDescripcion($data['descripcion']);
                        $propiedadEmpresaLiquidacion->setTipo($data['tipo_de_campo']);
                        $statusPersist = $this->getEntityManager()->persist($propiedadEmpresaLiquidacion);
                        $statusFlush = $this->getEntityManager()->flush();

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
    }

    public function deleteGridItemAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
                $propiedadEmpresaLiquidacion = $this->getEntityManager()->find('Application\Entity\PropiedadEmpresaLiquidacion', $id);
                if ($propiedadEmpresaLiquidacion) {
                    $statusRemove = $this->getEntityManager()->remove($propiedadEmpresaLiquidacion);
                    $statusFlush = $this->getEntityManager()->flush();

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
    }

    public function editGridItemValAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $data = $request->getPost('data');
                $data = Json::decode($data, true);
                if ($data) {
                    if (isset($data['propiedad_id'])) {
                        //Add
                        $propiedadEmpresaLiquidacionValores = new PropiedadEmpresaLiquidacionValores ();
                        $propiedadEmpresaLiquidacionValores->setPropiedadId($data['propiedad_id']);
                        $propiedadEmpresaLiquidacionValores->setValorPosible($data['valor_posible']);
                        $propiedadEmpresaLiquidacionValores->setSignificado($data['significado']);
                        $statusPersist = $this->getEntityManager()->persist($propiedadEmpresaLiquidacionValores);
                        $statusFlush = $this->getEntityManager()->flush();

                        return $this->response->setContent(Json::encode(array(
                                            'type' => 'addVal',
                                            'success' => true
                        )));
                    } else {
                        if (isset($data['id'])) {
                            //Edit
                            $propiedadEmpresaLiquidacionValores = $this->getEntityManager()->find('Application\Entity\PropiedadEmpresaLiquidacionValores', $data['id']);
                            if ($propiedadEmpresaLiquidacionValores) {
                                $propiedadEmpresaLiquidacionValores->setValorPosible($data['valor_posible']);
                                $propiedadEmpresaLiquidacionValores->setSignificado($data['significado']);
                                $statusPersist = $this->getEntityManager()->persist($propiedadEmpresaLiquidacionValores);
                                $statusFlush = $this->getEntityManager()->flush();

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
    }

    public function deleteGridItemValAction() {
        if ($this->request->isXmlHttpRequest()) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $id = (int) $request->getPost('id');
                $propiedadEmpresaLiquidacionValores = new PropiedadEmpresaLiquidacionValores ();
                $propiedadEmpresaLiquidacionValores = $this->getEntityManager()->find('Application\Entity\PropiedadEmpresaLiquidacionValores', $id);
                if ($propiedadEmpresaLiquidacionValores) {
                    $statusRemove = $this->getEntityManager()->remove($propiedadEmpresaLiquidacionValores);
                    $statusFlush = $this->getEntityManager()->flush();

                    return $this->response->setContent(Json::encode(array(
                                        'type' => 'delVal',
                                        'success' => true
                    )));
                }
            }
        } else {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl());
        }
    }

}
