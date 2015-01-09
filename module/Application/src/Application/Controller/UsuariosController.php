<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
// Forms
use Application\Form\LoginForm;
use Application\Form\EmpresaForm;

class UsuariosController extends BaseController {

//    private $dbAdapter;
//    private $auth;

//    private $authService;

    public function __construct() {
        $this->auth = $this->getAuthenticationService();
//        $this->auth = new AuthenticationService();
//        $this->authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }

    public function loginAction() {
        $this->layout('layout/layout_login');
//        $auth = $this->getAuthenticationService();
//        $auth = $this->auth;
//        $authService = $this->authService;
        $identi = $this->auth->getStorage()->read();
        if ($identi != false && $identi != null) {
            //return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/index');
        }

        $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
//        $db = $this->dbAdapter;

        $form = new LoginForm("form");

        if ($this->getRequest()->isPost()) {
            $authAdapter = new AuthAdapter($this->dbAdapter, 'n7_usuarios', 'usuario', 'clave', 'MD5(?)');
            $authAdapter->setIdentity($this->getRequest()->getPost("usuario"))
                    ->setCredential($this->getRequest()->getPost("clave"));

            $this->auth->setAdapter($authAdapter);
            $authResult = $this->auth->authenticate();

//            if ($authAdapter->getResultRowObject() == false) {
            if ($authResult->isValid()) {
                $qb0 = $this->getEntityManager()->createQueryBuilder();
                $qb0->select('l.id', 'l.nombre')
                        ->from('Application\Entity\N7EmpresaUsuario', 'p')
                        ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
                        ->where('p.usuario = ?1');
                $qb0->setParameter(1, $authAdapter->getResultRowObject('id')->id);
                $query0 = $qb0->getQuery();
                $result = $query0->getArrayResult();
                $cantEmpresasAsociadas = count($result);

                if ($cantEmpresasAsociadas == 0) {
                    $this->flashMessenger()->addMessage("Usted no tiene una empresa asociada para acceder al sistema.");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
                } elseif ($cantEmpresasAsociadas == 1) {
                    $session = new \stdClass();
                    $session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
                    $session->usuarioActual = $authAdapter->getResultRowObject('id')->id;
                    $session->empresaCorrienteId = $result[0]["id"];
                    $session->empresaCorriente = $result[0]['nombre'];
                    $this->auth->getStorage()->write($session);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/index');
                } elseif ($cantEmpresasAsociadas > 1) {
                    $session = new \stdClass();
                    $session->userInfo = $authAdapter->getResultRowObject(null, 'clave');
                    $session->usuarioActual = $authAdapter->getResultRowObject('id')->id;
                    $this->auth->getStorage()->write($session);
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/empresa');
                }
            } else {
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intente de nuevo.");
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
            }
        }

        return new ViewModel(array(
//            'error' => 'Credenciales incorrectas, intente de nuevo',
            'form' => $form,
//            'messages' => $messages,
        ));
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
                    $result = $this->getEntityManager()->find('Application\Entity\N7Empresas', $empresa_seleccionada->empresa);
//                    $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
//                    $empresa = new EmpresaModel($this->dbAdapter);
//                    $result = $empresa->getEmpresaById($empresa_seleccionada->empresa);
                    $session->empresaCorriente = $result->getNombre(); //$result['nombre'];
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
//            $this->dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter');
//            $form = new EmpresaForm($this->dbAdapter, intval($identi->userInfo->id));
            $form = new EmpresaForm($this->getEntityManager(), intval($identi->userInfo->id));

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
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        //return $this->redirect()->toRoute('application/default', array('controller' => 'usuarios', 'action' => 'login'));
    }

}
