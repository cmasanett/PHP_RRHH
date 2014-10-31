<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

//Componentes de validación
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;

//Adaptador de la db
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

//Componente para cifrar contraseñas
use Zend\Crypt\Password\Bcrypt;

//Componentes de autenticación
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;

//Incluir modelos
use Application\Model\UsuariosModel;

//Incluir formularios
use Application\Form\LoginForm;
use Application\Form\EmpresaForm;

class UsuariosController extends AbstractActionController
{
	private $dbAdapter;
	private $auth;
	 
	public function __construct() {
		$this->auth = new AuthenticationService();
	}
	 
	public function loginAction(){
		$auth = $this->auth;
		$identi = $auth->getStorage()->read();
		if($identi!=false && $identi!=null){
			return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/main');
		}

		$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

		$db = $this->dbAdapter;
		
		$form = new LoginForm("form");

		if($this->getRequest()->isPost()){
			$authAdapter = new AuthAdapter($this->dbAdapter,'usuarios', 'usuario', 'clave', 'MD5(?)');
			$authAdapter->setIdentity($this->getRequest()->getPost("usuario"))
				->setCredential($this->getRequest()->getPost("clave"));
			
			$auth->setAdapter($authAdapter);
			$result = $auth->authenticate();
			
			if($authAdapter->getResultRowObject() == false){
				
				$this->flashMessenger()->addMessage("Credenciales incorrectas, intente de nuevo.");
				return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
				
			}else{
				
				$sql = new Sql($this->dbAdapter);
				$select = $sql->select();
				$select->from(array('p' => 'empresa_usuario'), array('*'))
					->join(array('l' => 'empresas'),'p.empresa_id = l.id', array('*') )
					->where(array('usuario_id' => $authAdapter->getResultRowObject('id')->id));
				$selectString = $sql->getSqlStringForSqlObject($select);
				$execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
				$result = $execute->toArray();	

				if(count($result) == 0){
					$this->flashMessenger()->addMessage("Usted no tiene una empresa asociada para acceder al sistema.");
					return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
				}elseif (count($result) == 1)
					{
						$session = new \stdClass();
						$session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
						$session->usuarioActual = $authAdapter->getResultRowObject('id')->id;
						$session->empresaCorriente =  $result[0]["empresa_id"];
						$auth->getStorage()->write($session);
						return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/main');
						
						}elseif (count($result) > 1)
							{
								$session = new \stdClass();
								$session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
								$auth->getStorage()->write($session);
								return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/empresa');
							}		
						}
			}

		return new ViewModel(
				array("form"=>$form//,"datos"=>$datos
				)
		);
	}

	public function mainAction()
	{
		if($this->request->getPost("submit")){
			$empresa_seleccionada = $this->request->getPost();
			if($empresa_seleccionada){
				$identi = $this->auth->getStorage()->read();
				if($identi != false && $identi != null)
				{
					$userInfo['usuario_actual'] = $identi->userInfo->id;
					$userInfo['empresa_corriente'] = $empresa_seleccionada->empresa;
					$this->auth->getStorage()->write($userInfo);
					return new ViewModel(
							array("titulo"=>"Bienvenido usuario ".$identi->userInfo->usuario,
									"datos"=>$identi,
									"empresa"=>$empresa_seleccionada->empresa
							));
				}
			}
		}else{
			$identi = $this->auth->getStorage()->read();
			if($identi != false && $identi != null){
				return new ViewModel(
						array("titulo"=>"Bienvenido usuario ".$identi->userInfo->usuario,
								"datos"=>$identi,
								"empresa"=>$identi->empresaCorriente
						));
			}else{
				$this->auth->clearIdentity();
				return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
			}	
		}
	}
	
	
	public function empresaAction(){
		
		$identi = $this->auth->getStorage()->read();
		if($identi != false && $identi != null){
			$this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

			$form = new EmpresaForm($this->dbAdapter, intval($identi->userInfo->id));
			
			return new ViewModel(array(
					"titulo"=>"Seleccionar empresa",
					"form"=>$form,
					"datos"=>$identi,
					'url'=>$this->getRequest()->getBaseUrl())
			);
		}else{
			$this->auth->clearIdentity();
			return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
		}
	}
	
	public function cerrarAction()
	{
		$this->auth->clearIdentity();
		return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/usuarios/login');
	}
}
