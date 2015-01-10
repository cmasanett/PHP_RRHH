<?php

return array(
    'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'authService'
        ),
        'invokables' => array(
            'authService' => 'Zend\Authentication\AuthenticationService'
        )
    )
);
