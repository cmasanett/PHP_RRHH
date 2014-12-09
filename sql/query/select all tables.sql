SELECT `usuarios`.`id`,
    `usuarios`.`usuario`,
    `usuarios`.`clave`
FROM `zend_php_demo`.`usuarios`;

SELECT `empresas`.`id`,
    `empresas`.`codigo`,
    `empresas`.`nombre`
FROM `zend_php_demo`.`empresas`;

SELECT `empresa_usuario`.`id`,
    `empresa_usuario`.`usuario_id`,
    `empresa_usuario`.`empresa_id`
FROM `zend_php_demo`.`empresa_usuario`;

SELECT `n7_propiedades_e`.`id`,
    `n7_propiedades_e`.`descripcion`,
    `n7_propiedades_e`.`tipo_de_campo`
FROM `zend_php_demo`.`n7_propiedades_e`;

SELECT `n7_valores_posibles_empresas`.`id`,
    `n7_valores_posibles_empresas`.`propiedad_id`,
    `n7_valores_posibles_empresas`.`valor_posible`,
    `n7_valores_posibles_empresas`.`significado`
FROM `zend_php_demo`.`n7_valores_posibles_empresas`;



