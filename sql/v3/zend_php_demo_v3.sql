-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2014 a las 16:26:14
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `zend_php_demo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
`id` int(11) NOT NULL,
  `codigo` char(4) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` char(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`id`, `codigo`, `nombre`) VALUES
(1, 'A001', 'Empresa 1'),
(2, 'A002', 'Empresa 2'),
(3, 'A003', 'Empresa 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_usuario`
--

CREATE TABLE IF NOT EXISTS `empresa_usuario` (
`id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `empresa_usuario`
--

INSERT INTO `empresa_usuario` (`id`, `usuario_id`, `empresa_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_menu_general`
--

CREATE TABLE IF NOT EXISTS `n7_menu_general` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `id_padre` int(11) unsigned NOT NULL,
  `nivel` int(11) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `n7_menu_general`
--

INSERT INTO `n7_menu_general` (`id`, `descripcion`, `id_padre`, `nivel`, `url`) VALUES
(1, 'Entidades', 0, 0, ''),
(2, 'empresas', 1, 1, ''),
(3, 'legajo', 1, 1, ''),
(4, 'Definiciones', 0, 0, ''),
(5, 'Datos', 4, 1, ''),
(6, 'de empresa', 5, 2, 'datosempresas/index'),
(7, 'de legajos', 5, 2, 'datoslegajos/index'),
(8, 'de familiares', 5, 2, 'datosfamiliares/index'),
(9, 'Vistas', 4, 1, ''),
(10, 'de empresas', 9, 2, ''),
(11, 'de legajos', 9, 2, ''),
(12, 'de familiares', 9, 2, ''),
(13, 'Conceptos', 4, 1, ''),
(14, 'tipos de conceptos', 13, 2, ''),
(15, 'conceptos', 13, 2, ''),
(16, 'Liquidacion', 4, 1, ''),
(17, 'Eventos', 16, 2, ''),
(18, 'Formulas', 16, 2, ''),
(19, 'Procesos', 0, 0, ''),
(20, 'Utiles', 0, 0, ''),
(21, 'Cambio de Empresa o Salir', 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_e`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_e` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=163 ;

--
-- Volcado de datos para la tabla `n7_propiedades_e`
--

INSERT INTO `n7_propiedades_e` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(157, 'prueba 0', 'N'),
(158, 'prueba 1', 'F'),
(159, 'prueba 2', 'F'),
(160, 'prueba 3', 'C'),
(161, 'prueba 4', 'C'),
(162, 'prueba 5', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_f`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_f` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `n7_propiedades_f`
--

INSERT INTO `n7_propiedades_f` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(1, 'prueba 0', 'C'),
(2, 'prueba 1', 'N'),
(3, 'prueba 2', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_l`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_l` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `n7_propiedades_l`
--

INSERT INTO `n7_propiedades_l` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(1, 'prueba 0', 'C'),
(2, 'prueba 1', 'N'),
(3, 'prueba 2', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_empresas`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_empresas` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `n7_valores_posibles_empresas`
--

INSERT INTO `n7_valores_posibles_empresas` (`id`, `propiedad_id`, `valor_posible`, `significado`) VALUES
(1, 157, '1', '1'),
(2, 157, '2', '1'),
(3, 157, '3', '1'),
(4, 157, '4', '1'),
(6, 157, '5', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_familiares`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_familiares` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `n7_valores_posibles_familiares`
--

INSERT INTO `n7_valores_posibles_familiares` (`id`, `propiedad_id`, `valor_posible`, `significado`) VALUES
(1, 1, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_legajos`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_legajos` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `n7_valores_posibles_legajos`
--

INSERT INTO `n7_valores_posibles_legajos` (`id`, `propiedad_id`, `valor_posible`, `significado`) VALUES
(2, 1, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `usuario` char(20) COLLATE utf8_spanish_ci NOT NULL,
  `clave` char(32) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`) VALUES
(1, 'test', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'test2', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_usuario`
--
ALTER TABLE `empresa_usuario`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`), ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `n7_menu_general`
--
ALTER TABLE `n7_menu_general`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_propiedades_e`
--
ALTER TABLE `n7_propiedades_e`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`descripcion`);

--
-- Indices de la tabla `n7_propiedades_f`
--
ALTER TABLE `n7_propiedades_f`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`descripcion`);

--
-- Indices de la tabla `n7_propiedades_l`
--
ALTER TABLE `n7_propiedades_l`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`descripcion`);

--
-- Indices de la tabla `n7_valores_posibles_empresas`
--
ALTER TABLE `n7_valores_posibles_empresas`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`);

--
-- Indices de la tabla `n7_valores_posibles_familiares`
--
ALTER TABLE `n7_valores_posibles_familiares`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`);

--
-- Indices de la tabla `n7_valores_posibles_legajos`
--
ALTER TABLE `n7_valores_posibles_legajos`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `empresa_usuario`
--
ALTER TABLE `empresa_usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `n7_menu_general`
--
ALTER TABLE `n7_menu_general`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_e`
--
ALTER TABLE `n7_propiedades_e`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=163;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_f`
--
ALTER TABLE `n7_propiedades_f`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_l`
--
ALTER TABLE `n7_propiedades_l`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_empresas`
--
ALTER TABLE `n7_valores_posibles_empresas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_familiares`
--
ALTER TABLE `n7_valores_posibles_familiares`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_legajos`
--
ALTER TABLE `n7_valores_posibles_legajos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empresa_usuario`
--
ALTER TABLE `empresa_usuario`
ADD CONSTRAINT `empresa_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `empresa_usuario_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `n7_valores_posibles_empresas`
--
ALTER TABLE `n7_valores_posibles_empresas`
ADD CONSTRAINT `FK_Propiedades_Id` FOREIGN KEY (`propiedad_id`) REFERENCES `n7_propiedades_e` (`id`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `n7_valores_posibles_familiares`
--
ALTER TABLE `n7_valores_posibles_familiares`
ADD CONSTRAINT `FK_Familiares_Propiedades_Id` FOREIGN KEY (`propiedad_id`) REFERENCES `n7_propiedades_f` (`id`) ON UPDATE NO ACTION;

--
-- Filtros para la tabla `n7_valores_posibles_legajos`
--
ALTER TABLE `n7_valores_posibles_legajos`
ADD CONSTRAINT `FK_Legajos_Propiedades_Id` FOREIGN KEY (`propiedad_id`) REFERENCES `n7_propiedades_l` (`id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
