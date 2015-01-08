ALTER TABLE `zend_php_demo`.`empresa_usuario` 
DROP FOREIGN KEY `empresa_usuario_ibfk_1`,
DROP FOREIGN KEY `empresa_usuario_ibfk_2`;
ALTER TABLE `zend_php_demo`.`empresa_usuario` 
CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `usuario_id` `usuario_id` INT(11) UNSIGNED NULL ,
CHANGE COLUMN `empresa_id` `empresa_id` INT(11) UNSIGNED NULL DEFAULT NULL , RENAME TO  `zend_php_demo`.`n7_empresa_usuario` ;
ALTER TABLE `zend_php_demo`.`n7_empresa_usuario` 
ADD CONSTRAINT `n7_empresa_usuario_ibfk_1`
  FOREIGN KEY (`usuario_id`)
  REFERENCES `zend_php_demo`.`n7_usuarios` (`id`)
  ON DELETE CASCADE,
ADD CONSTRAINT `n7_empresa_usuario_ibfk_2`
  FOREIGN KEY (`empresa_id`)
  REFERENCES `zend_php_demo`.`n7_empresas` (`id`)
  ON DELETE CASCADE;

ALTER TABLE `zend_php_demo`.`usuarios` 
CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT , RENAME TO  `zend_php_demo`.`n7_usuarios` ;

DROP TABLE `zend_php_demo`.`empresas`;