CREATE TABLE `n7_propiedades_l` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_valores_posibles_legajos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `n7_valores_posibles_legajos`
	ADD CONSTRAINT `FK_Legajos_Propiedades_Id` 
	FOREIGN KEY (`propiedad_id`) 
	REFERENCES `n7_propiedades_l` (`id`) 
	ON UPDATE NO ACTION;
    
CREATE TABLE `n7_propiedades_f` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_valores_posibles_familiares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `n7_valores_posibles_familiares`
	ADD CONSTRAINT `FK_Familiares_Propiedades_Id` 
	FOREIGN KEY (`propiedad_id`) 
	REFERENCES `n7_propiedades_f` (`id`) 
	ON UPDATE NO ACTION;