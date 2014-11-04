<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Json\Json;

// Componentes de validaci�n
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;

// Adaptador de la db
use Zend\Db\Adapter\Adapter;

// Incluir modelos
use Application\Model\PropiedadEmpresaLiquidacionModel;

// Incluir entidades
use Application\Entity\PropiedadEmpresaLiquidacion;

// Incluir formularios
use Application\Form\AddPropiedadEmpresaLiquidacionForm;

// Doctrine ORM
use Doctrine\ORM\EntityManager;

// SynergyDataGrid (ZF2 module)
use SynergyDataGrid\Grid\JqGrid;
use Zend\View\Model\JsonModel;

class PropEmpLiqController extends AbstractActionController {
	public function __construct() {
	}
	/**
	 *
	 * @var DoctrineORMEntityManager
	 */
	protected $em;
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
		}
		return $this->em;
	}
	public function indexAction() {
		return new ViewModel ( array (
				//'propiedades' => $this->getEntityManager ()->getRepository ( 'Application\Entity\PropiedadEmpresaLiquidacion' )->findAll () 
		) );
	}
	public function gridAction() {
		// replace {Entity_Name} with your entity name e.g. 'Application\Entity\User'
		$serviceManager = $this->getServiceLocator ();
		$grid = $serviceManager->get ( 'jqgrid' )->setGridIdentity ( 'Application\Entity\PropiedadEmpresaLiquidacion' );
		
		$grid->setUrl ( 'your_custom_crun_url' ); // optional, if not set the default CRUD controller would be used
		
		return array (
				'grid' => $grid 
		);
	}
	public function loadDataGridAction() {
// 		$sidx = $this->getRequest ()->getParam ( 'sidx' );
// 		$sord = $this->getRequest ()->getParam ( 'sord' );
// 		$page = $this->getRequest ()->getParam ( 'page' );
// 		$limit = $this->getRequest ()->getParam ( 'rows' ); 
		
		$sidx = "id";
		$sord = "id";
		$page = 1;
		$limit = 10;
	
		//$s = new modelClass($this->db);
		//$count =  $s->getNbrContact();
		$data = $this->getEntityManager ()->getRepository ( 'Application\Entity\PropiedadEmpresaLiquidacion' )->findAll ();
		
		$count = count($data);
		
		if ($count > 0) {
			$total_pages = ceil ( $count / $limit );
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages)
			$page = $total_pages;
		
		$start = $limit * $page - $limit;
		if ($start < 0)
			$start = 0;
		
		//$row = $s->getListContact ( $sidx, $sord, $start, $limit );
		$row = $data;
		$response ['page'] = $page;
		$response ['total'] = $total_pages;
		$response ['records'] = $count;
		$i = 0;
		foreach ( $row as $r ) {
			$response ['rows'] [$i] ['id'] = $r->id; // id
			$response ['rows'] [$i] ['cell'] = array (
					$r->id,
					$r->descripcion,
					$r->tipo_de_campo
			);
			$i ++;
		}
		
		return $this->response->setContent(Json::encode($response));
	}
	public function addAction() {
		if($this->getRequest()->isXmlHttpRequest()) {
			$this->layout('application/prop-emp-liq/add');
		}
		
		$form = new AddPropiedadEmpresaLiquidacionForm ();
		$form->get ( 'submit' )->setValue ( 'Add' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
			$form->setInputFilter ( $propiedadEmpresaLiquidacion->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$propiedadEmpresaLiquidacion->exchangeArray ( $form->getData () );
				$this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacion );
				$this->getEntityManager ()->flush ();
				
				// Redirect to list of albums
				return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion' );
			}
		}
		return array (
				'form' => $form 
		);
	}
	public function addGridItemAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
			$propiedadEmpresaLiquidacion->exchangeArray ( $request->getPost () );
			$this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacion );
			$this->getEntityManager ()->flush ();
			}
		return new ViewModel();
	}
	public function editAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion', array (
					'action' => 'add' 
			) );
		}
		
		$propiedadEmpresaLiquidacion = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $id );
		if (! $propiedadEmpresaLiquidacion) {
			return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion', array (
					'action' => 'index' 
			) );
		}
		
		$form = new AddPropiedadEmpresaLiquidacionForm ();
		$form->bind ( $propiedadEmpresaLiquidacion );
		$form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $propiedadEmpresaLiquidacion->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$this->getEntityManager ()->flush ();
				
				// Redirect to list of albums
				return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion' );
			}
		}
		
		return array (
				'id' => $id,
				'form' => $form 
		);
	}
	public function deleteAction() {
		$id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
		if (! $id) {
			return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion' );
		}
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$del = $request->getPost ( 'del', 'No' );
			
			if ($del == 'Yes') {
				$id = ( int ) $request->getPost ( 'id' );
				$propiedadEmpresaLiquidacion = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $id );
				if ($propiedadEmpresaLiquidacion) {
					$this->getEntityManager ()->remove ( $propiedadEmpresaLiquidacion );
					$this->getEntityManager ()->flush ();
				}
			}
			
			// Redirect to list of albums
			return $this->redirect ()->toRoute ( 'propiedadEmpresaLiquidacion' );
		}
		
		return array (
				'id' => $id,
				'propiedadEmpresaLiquidacion' => $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $id ) 
		);
	}
	public function deleteGridItemAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
				$id = ( int ) $request->getPost ( 'id' );
				$propiedadEmpresaLiquidacion = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $id );
				if ($propiedadEmpresaLiquidacion) {
					$this->getEntityManager ()->remove ( $propiedadEmpresaLiquidacion );
					$this->getEntityManager ()->flush ();
				}
		}
		return new ViewModel();
	}
}