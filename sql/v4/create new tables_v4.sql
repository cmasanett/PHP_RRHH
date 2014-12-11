CREATE TABLE `n7_vistas_empresas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_vistas_familiares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_vistas_legajos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_vistas_propiedades_e` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`),
  KEY `Index_3` (`formulario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_vistas_propiedades_f` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`),
  KEY `Index_3` (`formulario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `n7_vistas_propiedades_l` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`propiedad_id`),
  KEY `Index_3` (`formulario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;