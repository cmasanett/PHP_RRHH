<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
// Forms
use Application\Form\LoginForm;
use Application\Form\EmpresaForm;

class UsuariosController extends BaseController {

    public function __construct() {
        
    }

    public function loginAction() {
        $this->layout('layout/layout_login');

        if ($this->getAuthService()->getIdentity()) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/index');
        }

        $form = new LoginForm("form");
        $redirect = 'login';
        $request = $this->getRequest();

        if ($request->isPost()) {

            $this->getAuthService()->getAdapter()
                    ->setIdentityValue($request->getPost('usuario'))
                    ->setCredentialValue($request->getPost('clave'));

            $authResult = $this->getAuthService()->authenticate();
//            foreach ($authResult->getMessages() as $message) {
//                $this->flashmessenger()->addMessage($message);
//            }

            if ($authResult->isValid()) {
                $redirect = 'index';
                $qb0 = $this->getEntityManager()->createQueryBuilder();
                $qb0->select('l.id', 'l.nombre')
                        ->from('Application\Entity\N7EmpresaUsuario', 'p')
                        ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
                        ->where('p.usuario = ?1');
                $qb0->setParameter(1, $authResult->getIdentity()->getId());
                $query0 = $qb0->getQuery();
                $result = $query0->getArrayResult();
                $cantEmpresasAsociadas = count($result);

                if ($cantEmpresasAsociadas == 0) {
                    $this->flashMessenger()->addMessage("Usted no tiene una empresa asociada para acceder al sistema.");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/' . $redirect);
                } elseif ($cantEmpresasAsociadas == 1) {
                    $this->getAuthService()->getStorage()->write(
                            array('userInfo' => $authResult->getIdentity(),
                                'empresaCorrienteId' => $result[0]["id"],
                                'empresaCorriente' => $result[0]["nombre"])
                    );
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/' . $redirect);
                } elseif ($cantEmpresasAsociadas > 1) {
                    $redirect = 'empresa';
                    $this->getAuthService()->getStorage()->write(
                            array('userInfo' => $authResult->getIdentity())
                    );
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/' . $redirect);
                }
            } else {
                $this->flashMessenger()->addMessage("Credenciales incorrectas, intente de nuevo.");
                return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/' . $redirect);
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'messages' => $this->flashmessenger()->getMessages())
        );
    }

    public function indexAction() {
        $loggedUser = $this->getAuthService()->getIdentity();

        if (!$loggedUser) {
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }

        if ($this->request->getPost("submit")) {
            $empresa_seleccionada = $this->request->getPost();
            if ($empresa_seleccionada) {
                if ($loggedUser != false && $loggedUser != null) {
                    $result = $this->getEntityManager()->find('Application\Entity\N7Empresas', $empresa_seleccionada->empresa);
                    $this->getAuthService()->getStorage()->write(
                            array('userInfo' => $loggedUser['userInfo'],
                                'empresaCorrienteId' => $empresa_seleccionada->empresa,
                                'empresaCorriente' => $result->getNombre())
                    );
                }
            }
        }

        return new ViewModel(
                array("titulo" => "Bienvenido usuario " . $loggedUser['userInfo']->getUsuario()
        ));
    }

    public function empresaAction() {
        $this->layout('layout/layout_login');
        $loggedUser = $this->getAuthService()->getIdentity();

        if ($loggedUser != false && $loggedUser != null) {

            $form = new EmpresaForm($this->getEntityManager(), intval($loggedUser['userInfo']->getId()));

            return new ViewModel(array(
                "form" => $form,
                "datos" => $loggedUser,
                'url' => $this->getRequest()->getBaseUrl())
            );
        } else {
            $this->authService->clearIdentity();
            return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
        }
    }

    public function cerrarAction() {
        $this->getAuthService()->clearIdentity();
        $this->flashmessenger()->addMessage("Usted ha cerrado la sesión.");
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . '/usuarios/login');
    }

}
