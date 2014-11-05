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
		return new ViewModel ( array () );
	}
	public function loadDataGridAction() {
// 		$request = $this->getRequest ();
// 		var_dump($request->isPost ());
		// $sidx = $this->getRequest ()->getParam ( 'sidx' );
		// $sord = $this->getRequest ()->getParam ( 'sord' );
		// $page = $this->getRequest ()->getParam ( 'page' );
		// $limit = $this->getRequest ()->getParam ( 'rows' );
		$sidx = "id";
		$sord = "id";
		$page = 1;
		$limit = 10;
		
		// $s = new modelClass($this->db);
		// $count = $s->getNbrContact();
		$data = $this->getEntityManager ()->getRepository ( 'Application\Entity\PropiedadEmpresaLiquidacion' )->findAll ();
		
		$count = count ( $data );
		
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
			
			// $row = $s->getListContact ( $sidx, $sord, $start, $limit );
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
		
		return $this->response->setContent ( Json::encode ( $response ) );
	}
	public function loadDataGridValAction() {
		$request = $this->getRequest ();
		//var_dump($request->isPost ());
		//var_dump($request->getPost());
		//$id = ( int ) $request->getPost ( 'id' );
		$id = $this->params()->fromRoute("id",null);
		//var_dump($id);
		$sidx = "id";
		$sord = "id";
		$page = 1;
		$limit = 10;
	
		// $s = new modelClass($this->db);
		// $count = $s->getNbrContact();
		//$data = $this->getEntityManager ()->getRepository ( 'Application\Entity\PropiedadEmpresaLiquidacionValores' )->findAll ();
		// All users that are 20 years old
		$data = $this->getEntityManager ()->getRepository ( 'Application\Entity\PropiedadEmpresaLiquidacionValores' )->findBy(array('propiedad_id' => $id));
		$count = count ( $data );
	
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
			
		// $row = $s->getListContact ( $sidx, $sord, $start, $limit );
		$row = $data;
		$response ['page'] = $page;
		$response ['total'] = $total_pages;
		$response ['records'] = $count;
		$i = 0;
		foreach ( $row as $r ) {
			$response ['rows'] [$i] ['id'] = $r->id; // id
			$response ['rows'] [$i] ['cell'] = array (
					$r->id,
					$r->propiedad_id,
					$r->valor_posible,
					$r->significado
			);
			$i ++;
		}
	
		return $this->response->setContent ( Json::encode ( $response ) );
	}
	public function editGridItemAction() {
		if ($this->request->isXmlHttpRequest ()) {
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				$data = $request->getPost ('data') ;
				$data = Json::decode($data, true);
				if ($data) {
					if(isset($data['id'])){
						//Edit
						$propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
						$propiedadEmpresaLiquidacion = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $data['id'] );
						if ($propiedadEmpresaLiquidacion) {
							$propiedadEmpresaLiquidacion->setDescripcion ($data['descripcion']);
							$propiedadEmpresaLiquidacion->setTipo ( $data['tipo_de_campo']);
							$statusPersist = $this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacion );
							$statusFlush = $this->getEntityManager ()->flush ();

							$result = new JsonJsonModel ( array (
									'type' => 'edit',
									'success' => true
							) );
							return $result;
						}	
					} else{
						//Add
						$propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
						//$propiedadEmpresaLiquidacion->exchangeArray ( $request->getPost () );
						$propiedadEmpresaLiquidacion->setDescripcion ($data['descripcion']);
						$propiedadEmpresaLiquidacion->setTipo ( $data['tipo_de_campo']);
						$statusPersist = $this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacion );
						$statusFlush = $this->getEntityManager ()->flush ();
						$result = new JsonModel ( array (
								'type' => 'add',
								'success' => true
						) );
						return $result;
					}
				}
			}
		} else {
			return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () );
		}
	}
	public function deleteGridItemAction() {
		if ($this->request->isXmlHttpRequest ()) {
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				$id = ( int ) $request->getPost ( 'id' );
				$propiedadEmpresaLiquidacion = new PropiedadEmpresaLiquidacion ();
				$propiedadEmpresaLiquidacion = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacion', $id );
				if ($propiedadEmpresaLiquidacion) {
					$statusRemove = $this->getEntityManager ()->remove ( $propiedadEmpresaLiquidacion );
					$statusFlush = $this->getEntityManager ()->flush ();
					$result = new JsonModel ( array (
							'type' => 'del',						
							// 'statusRemove' => $statusRemove,
							// 'statusFlush' => $statusFlush,
							'success' => true 
					) );
					return $result;
				}
			}
		} else {
			return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () );
		}
	}
	public function editGridItemValAction() {
		if ($this->request->isXmlHttpRequest ()) {
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				$data = $request->getPost ('data') ;
				$data = Json::decode($data, true);
				if ($data) {
					if(isset($data['propiedad_id'])){
						//Add
						$propiedadEmpresaLiquidacionValores = new PropiedadEmpresaLiquidacionValores ();
						$propiedadEmpresaLiquidacionValores->setPropiedadId (  $data['propiedad_id'] );
						$propiedadEmpresaLiquidacionValores->setValorPosible (  $data['valor_posible'] );
						$propiedadEmpresaLiquidacionValores->setSignificado (  $data['significado'] );
						$statusPersist = $this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacionValores );
						$statusFlush = $this->getEntityManager ()->flush ();
						
						$result = new JsonModel ( array (
								'type' => 'addVal',
								'success' => true
						) );
						return $result;
					} else{
							if(isset($data['id'])){
							//Edit
							$propiedadEmpresaLiquidacionValores = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacionValores', $data['id'] );
							if ($propiedadEmpresaLiquidacionValores) {
								$propiedadEmpresaLiquidacionValores->setValorPosible (  $data['valor_posible'] );
								$propiedadEmpresaLiquidacionValores->setSignificado (  $data['significado'] );
								$statusPersist = $this->getEntityManager ()->persist ( $propiedadEmpresaLiquidacionValores );
								$statusFlush = $this->getEntityManager ()->flush ();
							
								$result = new JsonModel ( array (
										'type' => 'editVal',
										'success' => true
								) );
								return $result;
							}
						}
					}
				}
			}
		} else {
			echo "Error";
			//return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () );
		}
	}
	public function deleteGridItemValAction() {
		if ($this->request->isXmlHttpRequest ()) {
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				$id = ( int ) $request->getPost ( 'id' );
				$propiedadEmpresaLiquidacionValores = new PropiedadEmpresaLiquidacionValores ();
				$propiedadEmpresaLiquidacionValores = $this->getEntityManager ()->find ( 'Application\Entity\PropiedadEmpresaLiquidacionValores', $id );
				if ($propiedadEmpresaLiquidacionValores) {
					$statusRemove = $this->getEntityManager ()->remove ( $propiedadEmpresaLiquidacionValores );
					$statusFlush = $this->getEntityManager ()->flush ();
					$result = new JsonModel ( array (
							'type' => 'delVal',
							// 'statusRemove' => $statusRemove,
							// 'statusFlush' => $statusFlush,
							'success' => true
					) );
					return $result;
				}
			}
		} else {
			return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () );
		}
	}
}