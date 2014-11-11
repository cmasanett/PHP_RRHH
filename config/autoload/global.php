<?php
return array (
		'service_manager' => array (
				'aliases' => array (
						'Zend\Authentication\AuthenticationService' => 'my_auth_service' 
				),
				'invokables' => array (
						'my_auth_service' => 'Zend\Authentication\AuthenticationService' 
				) 
		) 
);
