CREATE TABLE `n7_propiedades_e` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_valores_posibles_empresas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `zend_php_demo`.`n7_valores_posibles_empresas` 
ADD CONSTRAINT `FK_Propiedades_Id`
  FOREIGN KEY (`propiedad_id`)
  REFERENCES `zend_php_demo`.`n7_propiedades_e` (`id`)
  ON DELETE RESTRICT
  ON UPDATE NO ACTION;