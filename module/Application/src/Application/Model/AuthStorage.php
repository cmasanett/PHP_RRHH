<?php

namespace Application\Model;

use Zend\Authentication\Storage;

class AuthStorage extends Storage\Session {

    public function setRememberMe($rememberMe = 0, $time = 1209600) {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }

    public function setAuthData($authData) {
        parent::write($authData);
        /**
          when $this->authService->authenticate(); is valid, the session
          automatically called write('username')
          in this case, i want to save data like
          $this->getAuthService()->getStorage()->write(
          array('userInfo' => $loggedUser->userInfo,
          'empresaCorrienteId' => $empresa_seleccionada->empresa,
          'empresaCorriente' => $result->getNombre())
          );
         */
        if (is_array($authData) && !empty($authData)) {
            $this->getSessionManager()
                    ->getSaveHandler()
                    ->write($this->getSessionId(), \Zend\Json\Json::encode($authData));
        }
    }

}
