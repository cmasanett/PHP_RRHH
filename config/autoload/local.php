<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    ),
    'db' => array(
        'driver' => 'Mysqli',
        'database' => 'zend_php_demo',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'options' => array(
            'buffer_results' => true
        )
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'root',
                    'password' => '',
                    'dbname' => 'zend_php_demo'
                )
            )
        )
    )
);
