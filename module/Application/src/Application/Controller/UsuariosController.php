<?php

namespace Application\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
////Componentes de validaci�n
//use Zend\Validator;
//use Zend\I18n\Validator as I18nValidator;
////Adaptador de la db
//use Zend\Db\Adapter\Adapter;
//use Zend\Db\Sql\Sql;
////Componente para cifrar contrase�as
//use Zend\Crypt\Password\Bcrypt;
////Componentes de autenticaci�n
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
//use Zend\Authentication\Storage\Session as SessionStorage;
//use Zend\Session\Container;
//Incluir modelos
//use Application\Model\UsuariosModel;
use Application\Model\EmpresaModel;
// Incluir entidades
//use Application\Entity\N7Usuarios;
//use Application\Entity\N7Empresa;
//use Application\Entity\N7EmpresaUsuario;
//Incluir formularios
use Application\Form\LoginForm;
use Application\Form\EmpresaForm;

class UsuariosController extends BaseController {

    private $dbAdapter;
    private $auth;

//    private $authService;

    public function __construct() {
        $this->auth = new AuthenticationService();
//        $this->authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }

    public function loginAction() {
        $this->layout('layout/layout_login');
        $auth = $this->auth;
//        $authService = $this->authService;
        $identi = $auth->getStorage()->read();
        if ($identi != false && $identi != null) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/index');
        }

        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
//        $db = $this->dbAdapter;

        $form = new LoginForm("form");

        if ($this->getRequest()->isPost()) {
            $authAdapter = new AuthAdapter($this->dbAdapter, 'n7_usuarios', 'usuario', 'clave', 'MD5(?)');
            $authAdapter->setIdentity($this->getRequest()->getPost("usuario"))
                    ->setCredential($this->getRequest()->getPost("clave"));

            $auth->setAdapter($authAdapter);
            $result = $auth->authenticate();

            if ($authAdapter->getResultRowObject() == false) {
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intente de nuevo.");
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
            } else {
                $qb0 = $this->getEntityManager()->createQueryBuilder();
                $qb0->select('p')
                        ->from('Application\Entity\N7EmpresaUsuario', 'p')
                        ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
                        ->where('p.usuario = ?2');
                $qb0->setParameter(2, $authAdapter->getResultRowObject('id')->id);
                $query0 = $qb0->getQuery();
                $result = $query0->getScalarResult();

//                $sql = new Sql($this->dbAdapter);
//                $select = $sql->select();
//                $select->from(array('p' => 'empresa_usuario'), array('*'))
//                        ->join(array('l' => 'empresas'), 'p.empresa_id = l.id', array('*'))
//                        ->where(array('usuario_id' => $authAdapter->getResultRowObject('id')->id));
//                $selectString = $sql->getSqlStringForSqlObject($select);
//                $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
//                $result = $execute->toArray();

                if (count($result) == 0) {
                    $this->flashMessenger()->addMessage("Usted no tiene una empresa asociada para acceder al sistema.");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
                } elseif (count($result) == 1) {
                    $session = new \stdClass();
                    $session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
                    $session->usuarioActual = $authAdapter->getResultRowObject('id')->id;
                    $session->empresaCorrienteId = $result[0]["empresa_id"];
                    $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
                    $result = $this->getEntityManager()->find('Application\Entity\N7Empresas', $result[0]["empresa_id"]);
//                    $empresa = new EmpresaModel($this->dbAdapter);
//                    $result = $empresa->getEmpresaById($result[0]["empresa_id"]);
                    $session->empresaCorriente = $result['nombre'];
                    $auth->getStorage()->write($session);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/index');
                } elseif (count($result) > 1) {
                    $session = new \stdClass();
                    $session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
                    $session->usuarioActual = $authAdapter->getResultRowObject('id')->id;
                    $auth->getStorage()->write($session);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/empresa');
                }
            }
        }

        return new ViewModel(
                array("form" => $form
                )
        );
    }

    public function indexAction() {
        if ($this->request->getPost("submit")) {
            $empresa_seleccionada = $this->request->getPost();
            if ($empresa_seleccionada) {
                $identi = $this->auth->getStorage()->read();
                if ($identi != false && $identi != null) {
                    $session = new \stdClass();
                    $session->userInfo = $identi->userInfo;
                    $session->usuarioActual = $identi->userInfo->id;
                    $session->empresaCorrienteId = $empresa_seleccionada->empresa;
                    $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
                    $empresa = new EmpresaModel($this->dbAdapter);
                    $result = $empresa->getEmpresaById($empresa_seleccionada->empresa);
                    $session->empresaCorriente = $result['nombre'];
                    $this->auth->getStorage()->write($session);
                    return new ViewModel(
                            array("titulo" => "Bienvenido usuario " . $identi->userInfo->usuario
                    ));
                }
            }
        } else {
            $identi = $this->auth->getStorage()->read();
            if ($identi != false && $identi != null) {
                return new ViewModel(
                        array("titulo" => "Bienvenido usuario " . $identi->userInfo->usuario
                ));
            } else {
                $this->auth->clearIdentity();
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
            }
        }
    }

    public function empresaAction() {
        $this->layout('layout/layout_login');
        $identi = $this->auth->getStorage()->read();
        if ($identi != false && $identi != null) {
            $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');

            $form = new EmpresaForm($this->dbAdapter, intval($identi->userInfo->id));

            return new ViewModel(array(
                "form" => $form,
                "datos" => $identi,
                'url' => $this->getRequest()->getBaseUrl())
            );
        } else {
            $this->auth->clearIdentity();
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }
    }

    public function cerrarAction() {
        $this->auth->clearIdentity();
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
    }

}
