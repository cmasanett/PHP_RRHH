SELECT 
    *
FROM
    zend_php_demo.n7_propiedades_e
WHERE
    zend_php_demo.n7_propiedades_e.id NOT IN (SELECT 
            zend_php_demo.n7_vistas_propiedades_e.propiedad_id
        FROM
            zend_php_demo.n7_vistas_propiedades_e
        WHERE
            zend_php_demo.n7_vistas_propiedades_e.formulario_id = 0);