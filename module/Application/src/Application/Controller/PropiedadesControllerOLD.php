<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// Componentes de validaci�n
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;

// Adaptador de la db
use Zend\Db\Adapter\Adapter;

// Incluir modelos
use Application\Model\EmpresaLiquidacionModel;

// Incluir formularios
use Application\Form\AddPropiedad;

// Componentes de ZfcDatagrid
use ZfcDatagrid\Column;

class PropiedadesController extends AbstractActionController {
	private $dbAdapter;
	public function __construct() {
	}
	public function indexAction() {
		/*
		 * Siempre que necesitemos trabajar con el modelo hay que hacer esto
		 * solamente le estamos pasando al modelo la conexión
		 */
		$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
		$empresaLiquidacion = new EmpresaLiquidacionModel ( $this->dbAdapter );
		
		$lista = $empresaLiquidacion->getPropiedades ();
		
		return new ViewModel ( array (
				"lista" => $lista 
		) );
	}
	/**
	 * Simple bootstrap table
	 *
	 * @return \ZfcDatagrid\Controller\ViewModel
	 */
	public function bootstrapAction() {
		// $data = array(
		// array ('displayName' => 'Mohammad ZeinEddin'),
		// array ('displayName' => 'John Wayne'),
		// array ('displayName' => 'Oprah Winfrey')
		// );
		$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
		$empresaLiquidacion = new EmpresaLiquidacionModel ( $this->dbAdapter );
	
		$data = $empresaLiquidacion->getPropiedades ();
	
		var_dump ( $data );
	
		/* @var $grid \ZfcDatagrid\Datagrid */
		$grid = $this->getServiceLocator ()->get ( 'ZfcDatagrid\Datagrid' );
		$grid->setTitle ( 'Minimal grid' );
		$grid->setDataSource ( $data );
	
		// $col = new Column\Select('displayName');
		// $col->setLabel('Name');
		$querySelect = new Expr\Select ( "concat(first_name, ' ', last_name)" );
		$col = new Column\Select ( $querySelect );
		$grid->addColumn ( $col );
	
		$grid->render ();
	
		return $grid->getResponse ();
	}
	public function addAction() {
		$form = new AddPropiedad ( "form" );
		$vista = array (
				"form" => $form 
		);
		if ($this->getRequest ()->isPost ()) {
			$form->setData ( $this->getRequest ()->getPost () );
			if ($form->isValid ()) {
				// Cargamos el modelo
				$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
				$empresaLiquidacion = new EmpresaLiquidacionModel ( $this->dbAdapter );
				
				// Recogemos los datos del formulario
				$descripcion = $this->request->getPost ( "descripcion" );
				$tipoDeCampo = $this->request->getPost ( "tipo_de_campo" );
				
				// Insertamos en la bd
				$insert = $empresaLiquidacion->addPropiedad ( $descripcion, $tipoDeCampo );
				
				// Mensajes flash $this->flashMessenger()->addMenssage("mensaje");
				if ($insert == true) {
					$this->flashMessenger ()->setNamespace ( "add_correcto" )->addMessage ( "Propiedad añadida correctamente" );
					return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () . '/propiedad/' );
				} else {
					$this->flashMessenger ()->setNamespace ( "duplicado" )->addMessage ( "Propiedad duplicada" );
					return $this->redirect ()->refresh ();
				}
			} else {
				$err = $form->getMessages ();
				$vista = array (
						"form" => $form,
						'url' => $this->getRequest ()->getBaseUrl (),
						"error" => $err 
				);
			}
		}
		return new ViewModel ( $vista );
	}
	public function verAction() {
		$id = $this->params ()->fromRoute ( "id", null );
		$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
		$usuarios = new UsuariosModel ( $this->dbAdapter );
		
		$usuario = $usuarios->getUnUsuario ( $id );
		if ($usuario) {
			return new ViewModel ( array (
					"id" => $id,
					"usuario" => $usuario 
			) );
		} else {
			return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () . '/propiedad/' );
		}
	}
	public function modificarAction() {
		$id = $this->params ()->fromRoute ( "id", null );
		$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
		
		$usuarios = new UsuariosModel ( $this->dbAdapter );
		$usuario = $usuarios->getUnUsuario ( $id );
		
		$form = new AddUsuario ( "form" );
		$form->setData ( $usuario );
		
		$vista = array (
				"form" => $form 
		);
		if ($this->getRequest ()->isPost ()) {
			$form->setData ( $this->getRequest ()->getPost () );
			if ($form->isValid ()) {
				// Recogemos los datos del formulario
				$email = $this->request->getPost ( "email" );
				$bcrypt = new Bcrypt ( array (
						'salt' => 'aleatorio_salt_pruebas_victor',
						'cost' => 5 
				) );
				$securePass = $bcrypt->create ( $this->request->getPost ( "password" ) );
				
				$password = $securePass;
				$nombre = $this->request->getPost ( "nombre" );
				$apellido = $this->request->getPost ( "apellido" );
				
				// Insertamos en la bd
				$update = $usuarios->updateUsuario ( $id, $email, $password, $nombre, $apellido );
				if ($update == true) {
					$this->flashMessenger ()->setNamespace ( "add_correcto" )->addMessage ( "Usuario modificado correctamente" );
					return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () . '/propiedad/' );
				} else {
					$this->flashMessenger ()->setNamespace ( "duplicado" )->addMessage ( "El usuario se ha modificado" );
					return $this->redirect ()->refresh ();
				}
			} else {
				$err = $form->getMessages ();
				$vista = array (
						"form" => $form,
						'url' => $this->getRequest ()->getBaseUrl (),
						"error" => $err 
				);
			}
		}
		return new ViewModel ( $vista );
	}
	public function eliminarAction() {
		$id = $this->params ()->fromRoute ( "id", null );
		$this->dbAdapter = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter' );
		$usuarios = new UsuariosModel ( $this->dbAdapter );
		$delete = $usuarios->deleteUsuario ( $id );
		if ($delete == true) {
			$this->flashMessenger ()->setNamespace ( "eliminado" )->addMessage ( "Usuario eliminado correctamente" );
		} else {
			$this->flashMessenger ()->setNamespace ( "eliminado" )->addMessage ( "El usuario no a podido ser eliminado" );
		}
		return $this->redirect ()->toUrl ( $this->getRequest ()->getBaseUrl () . '/propiedad/' );
	}
}