SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for n7_empresas
-- ----------------------------
-- DROP TABLE IF EXISTS `n7_empresas`;
CREATE TABLE `n7_empresas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` char(4) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` char(120) COLLATE utf8_spanish_ci NOT NULL,
  `domicilio` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `localidad` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `codigo_postal` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `email_administrador` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `inactiva` char(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `v1` decimal(12,4) NOT NULL,
  `v2` decimal(12,4) NOT NULL,
  `v3` decimal(12,4) NOT NULL,
  `v4` decimal(12,4) NOT NULL,
  `v5` decimal(12,4) NOT NULL,
  `v6` decimal(12,4) NOT NULL,
  `v7` decimal(12,4) NOT NULL,
  `v8` decimal(12,4) NOT NULL,
  `v9` decimal(12,4) NOT NULL,
  `v10` decimal(12,4) NOT NULL,
  `v11` decimal(12,4) NOT NULL,
  `v12` decimal(12,4) NOT NULL,
  `v13` decimal(12,4) NOT NULL,
  `v14` decimal(12,4) NOT NULL,
  `v15` decimal(12,4) NOT NULL,
  `v16` decimal(12,4) NOT NULL,
  `v17` decimal(12,4) NOT NULL,
  `v18` decimal(12,4) NOT NULL,
  `v19` decimal(12,4) NOT NULL,
  `v20` decimal(12,4) NOT NULL,
  `dato_legajo_baja` int(11) unsigned NOT NULL,
  `comparacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `valor_dato_baja` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Table structure for n7_ppd_l
-- ----------------------------
CREATE TABLE `n7_ppd_l` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `objeto_id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_3` (`propiedad_id`),
  KEY `Index_2` (`objeto_id`) USING BTREE,
  KEY `Index_4` (`objeto_id`,`propiedad_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ------------------------------
-- Table structure for n7_legajos
-- ------------------------------
CREATE TABLE `n7_legajos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) unsigned NOT NULL,
  `legajo` decimal (15,0) NOT NULL,
  `apellido_y_nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(240) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`empresa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
