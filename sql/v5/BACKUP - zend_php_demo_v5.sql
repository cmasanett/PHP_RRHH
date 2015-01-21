-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2015 a las 03:03:44
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
-- Estructura de tabla para la tabla `n7_empresas`
--

CREATE TABLE IF NOT EXISTS `n7_empresas` (
`id` int(11) unsigned NOT NULL,
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
  `valor_dato_baja` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `n7_empresas`
--

INSERT INTO `n7_empresas` (`id`, `codigo`, `nombre`, `domicilio`, `localidad`, `codigo_postal`, `provincia`, `email_administrador`, `inactiva`, `v1`, `v2`, `v3`, `v4`, `v5`, `v6`, `v7`, `v8`, `v9`, `v10`, `v11`, `v12`, `v13`, `v14`, `v15`, `v16`, `v17`, `v18`, `v19`, `v20`, `dato_legajo_baja`, `comparacion`, `valor_dato_baja`) VALUES
(1, 'PRUE', 'PARA PRUEBAS', 'MORAN 1111', 'CABA', '1111', 'CABA', 'admin@nominasrh.com', 'N', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 3, 'en', '2,3,4,5,6,8,9'),
(3, 'YCRT', 'INTERVENCION YCRT (DTO. 1034/02)', 'CABILDO 65', 'CAPITAL FEDERAL', '', '', '', '', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 3, 'en', '2,3,4,5,6,8,9');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_empresa_usuario`
--

CREATE TABLE IF NOT EXISTS `n7_empresa_usuario` (
`id` int(11) unsigned NOT NULL,
  `usuario_id` int(11) unsigned DEFAULT NULL,
  `empresa_id` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `n7_empresa_usuario`
--

INSERT INTO `n7_empresa_usuario` (`id`, `usuario_id`, `empresa_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_legajos`
--

CREATE TABLE IF NOT EXISTS `n7_legajos` (
`id` int(11) unsigned NOT NULL,
  `empresa_id` int(11) unsigned NOT NULL,
  `legajo` decimal(15,0) NOT NULL,
  `apellido_y_nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(240) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `n7_legajos`
--

INSERT INTO `n7_legajos` (`id`, `empresa_id`, `legajo`, `apellido_y_nombre`, `foto`) VALUES
(1, 1, '140', 'PEREZ JUAN', '');

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
(3, 'legajos', 1, 1, 'legajos/index'),
(4, 'Definiciones', 0, 0, ''),
(5, 'Datos', 4, 1, ''),
(6, 'de empresa', 5, 2, 'datosempresas/index'),
(7, 'de legajos', 5, 2, 'datoslegajos/index'),
(8, 'de familiares', 5, 2, 'datosfamiliares/index'),
(9, 'Vistas', 4, 1, ''),
(10, 'de empresas', 9, 2, 'vistasempresas/index'),
(11, 'de legajos', 9, 2, 'vistaslegajos/index'),
(12, 'de familiares', 9, 2, 'vistasfamiliares/index'),
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
-- Estructura de tabla para la tabla `n7_ppd_l`
--

CREATE TABLE IF NOT EXISTS `n7_ppd_l` (
`id` int(11) unsigned NOT NULL,
  `objeto_id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `n7_ppd_l`
--

INSERT INTO `n7_ppd_l` (`id`, `objeto_id`, `propiedad_id`, `valor`) VALUES
(1, 1, 3, '4'),
(2, 2, 4, '1'),
(3, 1, 120, '01/01/2015'),
(4, 1, 52, ''),
(5, 1, 46, ''),
(6, 1, 68, ''),
(7, 1, 37, ''),
(8, 1, 72, ''),
(9, 1, 88, ''),
(11, 1, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_e`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_e` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=112 ;

--
-- Volcado de datos para la tabla `n7_propiedades_e`
--

INSERT INTO `n7_propiedades_e` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(1, 'FECHA PROCESO', 'F'),
(2, 'HS.TRABAJO MENSUAL', 'N'),
(3, 'FERIADOS TRABAJADOS MENSUALES', 'N'),
(4, 'TOPE AMPO', 'N'),
(5, 'ULTIMO PROCESO DEL MES', 'N'),
(6, 'O.S. %1 SINDICAL', 'N'),
(7, 'O.S.%2 SINDICAL', 'N'),
(8, 'O.S.%1 NO SINDICAL', 'N'),
(9, 'O.S.%2 NO SINDICAL', 'N'),
(10, 'O.S.TOPE COMPARACION', 'N'),
(11, 'RET. OBRA SOCIAL', 'N'),
(12, 'RET. LEY 19032', 'N'),
(13, 'RET.JUBILACION REPARTO', 'N'),
(14, 'RET.JUBILACION CAPITALIZACION', 'N'),
(15, 'RET.O.SOCIAL ADIC.FAMILIAR', 'N'),
(16, 'APO % ART', 'N'),
(17, 'APO VALOR FIJO ART', 'N'),
(18, 'GAN.% TOPE CUOTAS MEDICAS', 'N'),
(19, 'GAN % TOPE DONACIONES', 'N'),
(20, 'APO SEGURO DE RETIRO', 'N'),
(21, 'TOPE INDEMN.COMERCIO', 'N'),
(22, 'MINIMO VITAL Y MOVIL', 'N'),
(23, 'REDONDEA A $', 'N'),
(24, 'QUINCENA', 'N'),
(25, 'SFA COEF DESCUENTO', 'N'),
(26, 'SFA MINIMO REMUNER.', 'N'),
(27, 'FECHA DE PAGO', 'F'),
(28, 'PERIODO DE DEPOSITO', 'C'),
(29, 'FECHA DEPOSITO CARGAS SOCIALES', 'F'),
(30, 'BANCO DEPOSITO CARGAS SOCIALES', 'C'),
(31, 'FECHA_MOD_CONTRATACION', 'F'),
(32, 'APO VALES ALIMENTARIOS', 'N'),
(33, 'SAC FORMA DE PAGO', 'N'),
(34, 'FECHA PARA VACACIONES', 'F'),
(35, 'CONCEPTO ABONADO', 'C'),
(36, 'PAGO AYUDA ESCOLAR', 'N'),
(37, 'GASTOS TRANSPORTE', 'N'),
(38, 'GAN % TOPE DONACIONES', 'N'),
(39, 'GRUPO DE LIQUIDACION', 'N'),
(40, 'CONCEPTO A LISTAR', 'N'),
(41, 'CUIT EMPRESA', 'C'),
(42, 'TOPE AMPO CONTRIBUCIONES', 'N'),
(43, 'FECHA DE VACACIONES - HASTA', 'F'),
(44, 'FECHA DE VACACIONES - DESDE', 'F'),
(45, 'FECHA TABLAS DE GCIAS', 'F'),
(46, 'DIA DEL GREMIO', 'N'),
(47, 'TOPE HORAS EXTRAS MENSUAL', 'N'),
(48, 'SEGURO DE VIDA - OBLIGATORIO', 'N'),
(49, 'LUGAR PAGO', 'C'),
(50, 'FECHA TABLAS DE GCIAS', 'F'),
(51, 'GCIAS - A GANANCIA NETA ART 23 1', 'N'),
(52, 'GCIAS - A GANANCIA NETA ART 23 2', 'N'),
(53, 'GCIAS - A GANANCIA NETA ART 23 3', 'N'),
(54, 'GCIAS - A GANANCIA NETA ART 23 4', 'N'),
(55, 'GCIAS - A GANANCIA NETA ART 23 5', 'N'),
(56, 'GCIAS - A GANANCIA NETA ART 23 6', 'N'),
(57, 'GCIAS - A GANANCIA NETA ART 23 7', 'N'),
(58, 'GCIAS - B ART 23 % APLICABLE 1', 'N'),
(59, 'GCIAS - B ART 23 % APLICABLE 2', 'N'),
(60, 'GCIAS - B ART 23 % APLICABLE 3', 'N'),
(61, 'GCIAS - B ART 23 % APLICABLE 4', 'N'),
(62, 'GCIAS - B ART 23 % APLICABLE 5', 'N'),
(63, 'GCIAS - B ART 23 % APLICABLE 6', 'N'),
(64, 'GCIAS - B ART 23 % APLICABLE 7', 'N'),
(65, 'GCIAS 2 - CONYUGE', 'N'),
(66, 'GCIAS 3 - HIJOS', 'N'),
(67, 'GCIAS 4 - OTRAS CARGAS', 'N'),
(68, 'GCIAS 5 - DEDUCCION ESPECIAL', 'N'),
(69, 'GCIAS 6 - PRIMAS DE SEGURO', 'N'),
(70, 'GCIAS 7 - GASTOS DE SEPELIO', 'N'),
(71, 'GCIAS 8 - SEGURO DE RETIRO', 'N'),
(72, 'GCIAS 1 - GANANCIAS NO IMPONIBLES', 'N'),
(73, 'GCIAS - A GANANCIA NETA 1', 'N'),
(74, 'GCIAS - A GANANCIA NETA 2', 'N'),
(75, 'GCIAS - A GANANCIA NETA 3', 'N'),
(76, 'GCIAS - A GANANCIA NETA 4', 'N'),
(77, 'GCIAS - A GANANCIA NETA 5', 'N'),
(78, 'GCIAS - A GANANCIA NETA 6', 'N'),
(79, 'GCIAS - A GANANCIA NETA 7', 'N'),
(80, 'GCIAS - B PAGARAN $ 1', 'N'),
(81, 'GCIAS - B PAGARAN $ 2', 'N'),
(82, 'GCIAS - B PAGARAN $ 3', 'N'),
(83, 'GCIAS - B PAGARAN $ 4', 'N'),
(84, 'GCIAS - B PAGARAN $ 5', 'N'),
(85, 'GCIAS - B PAGARAN $ 6', 'N'),
(86, 'GCIAS - B PAGARAN $ 7', 'N'),
(87, 'GCIAS - C MAS EL % 1', 'N'),
(88, 'GCIAS - C MAS EL % 2', 'N'),
(89, 'GCIAS - C MAS EL % 3', 'N'),
(90, 'GCIAS - C MAS EL % 4', 'N'),
(91, 'GCIAS - C MAS EL % 5', 'N'),
(92, 'GCIAS - C MAS EL % 6', 'N'),
(93, 'GCIAS - C MAS EL % 7', 'N'),
(94, 'TOPE AMPO SEGURIDAD SOCIAL', 'N'),
(95, 'SINDICATO AOMA', 'N'),
(96, 'LEGAJO A LISTAR', 'N'),
(97, 'GCIAS 9 - PERSONAL DOMESTICO', 'N'),
(98, 'GCIAS 10 - INTERESES HIPOTECARIOS', 'N'),
(99, 'TOPE SEGURO DE VIDA GENERAL', 'N'),
(100, 'SEGURO DE VIDA (ALICUOTA X MIL)', 'N'),
(101, 'PREMIO PRESENTISMO', 'N'),
(102, 'GRUPO DE LIQUIDACION A LISTAR', 'N'),
(103, 'ART 44. AOMA', 'N'),
(104, 'INTERESES PRESTAMOS PERSONALES', 'N'),
(105, 'SUBSIDIO POR FALLECIMIENTO', 'N'),
(106, 'SUBS. RECREACION Y TURISMO', 'N'),
(107, 'MUTUAL - PASTELEROS', 'N'),
(108, 'ANTICIPO REMUNERACIONES - VALOR', 'N'),
(109, 'ANTICIPO REMUNERACIONES % PARTE 3', 'N'),
(110, 'GRATIFICACION INDICADOR DE PAGO', 'N'),
(111, 'TIPO DE EMPLEADOR - SICOSS', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_f`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_f` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `n7_propiedades_f`
--

INSERT INTO `n7_propiedades_f` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(1, 'PARENTESCO', 'C'),
(2, 'CUIL', 'N'),
(3, 'FECHA_NACIMIENTO', 'F'),
(4, 'TIPO_DOCUMENTO', 'C'),
(5, 'NUMERO_DOCUMENTO', 'C'),
(6, 'EXPEDIDO_POR', 'N'),
(7, 'SEXO', 'C'),
(8, 'FECHA_ALTA', 'F'),
(9, 'FECHA_BAJA', 'F'),
(10, 'MOTIVO_BAJA', 'N'),
(11, 'ESTUDIOS', 'C'),
(12, 'APELLIDO DE SOLTERO', 'C'),
(13, 'OBRA_SOCIAL', 'C'),
(14, 'IMPUESTO_GANANCIAS', 'C'),
(15, 'ESTADO_FAMILIAR', 'C'),
(16, 'FECHA BAJA GCIAS', 'F'),
(17, 'NACIONALIDAD', 'C'),
(18, 'ESTADO CIVIL', 'C'),
(19, 'GENERA ASIG.FAMILIAR', 'N'),
(20, 'CERTIFICADO ENTREGO', 'N'),
(21, 'APELLIDO DE CASADO', 'C'),
(22, 'FECHA_MATRIMONIO', 'F'),
(23, 'FECHA ALTA GCIAS', 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_propiedades_l`
--

CREATE TABLE IF NOT EXISTS `n7_propiedades_l` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_de_campo` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=256 ;

--
-- Volcado de datos para la tabla `n7_propiedades_l`
--

INSERT INTO `n7_propiedades_l` (`id`, `descripcion`, `tipo_de_campo`) VALUES
(1, 'MOTIVO DE BAJA', 'N'),
(2, 'SUELDO BASICO', 'N'),
(3, 'ESTADO DEL LEGAJO', 'C'),
(4, 'BASE CUSS VACACIONES', 'N'),
(5, 'BASE CUSS MENSUAL', 'N'),
(6, 'BASE CUSS AGUINALDO', 'N'),
(7, 'DIAS TRAB. PARA SAC', 'N'),
(8, 'MEJOR HABER PARA SAC', 'N'),
(9, 'DIAS DE VACACIONES', 'N'),
(10, 'DGI CUOTAS MEDICAS', 'N'),
(11, 'DGI DONACIONES', 'N'),
(12, 'DGI REM.BRUTA', 'N'),
(13, 'DGI NETO ACUMULADO', 'N'),
(14, 'DGI CPTOS NO REMUNERATIVOS', 'N'),
(15, 'DGI APORTE AUTONOMOS', 'N'),
(16, 'DGI RETENCION GANANCIA', 'N'),
(17, 'DGI SEGURO DE VIDA', 'N'),
(18, 'DGI O.SOCIALES PERSONALES', 'N'),
(19, 'DGI SEGURO DE RETIRO', 'N'),
(20, 'DGI SEPELIO', 'N'),
(21, 'DGI CONYUGE', 'N'),
(22, 'DGI CONYUGE MESES', 'N'),
(23, 'DGI HIJOS', 'N'),
(24, 'DGI HIJOS MESES', 'N'),
(25, 'DGI OTRAS CARGAS', 'N'),
(26, 'DGI OTRAS CARGAS MES', 'N'),
(27, 'DGI REMUN.NETAS DE TERCEROS', 'N'),
(28, 'DGI OTRAS DEDUCCIONES', 'N'),
(29, 'DGI RETENCION JUBILACION', 'N'),
(30, 'DGI RET. LEY 19032', 'N'),
(31, 'DGI RETENCION O.SOCIAL', 'N'),
(32, 'DGI REMUNER. A DIFERIR', 'N'),
(33, 'DGI RETENC.A DIFERIR', 'N'),
(34, 'DGI MESES PROCESADOS', 'N'),
(35, 'SUELDO EMPRESA', 'N'),
(36, 'CENTRO DE COSTO', 'C'),
(37, 'COD.OBRA SOCIAL', 'N'),
(38, 'OBRA SOCIAL % ANSSAL', 'N'),
(39, 'OBRA SOCIAL ACUM.REMUNERATIVO', 'N'),
(40, 'DIAS ASISTENCIA SEMESTRE ANTERIOR', 'N'),
(41, 'MEJOR HABER SEMESTRE', 'N'),
(42, 'CODIGO DE AFJP', 'C'),
(43, 'CONDICION DEL EMPLEADO', 'N'),
(44, 'FAMILIAR ADIC.O.SOCIAL', 'N'),
(45, 'OBRA SOCIAL VALOR PLAN', 'N'),
(46, 'COD.CONVENIO', 'C'),
(47, 'AFILIADO AL SINDICATO', 'N'),
(48, 'MATERNIDAD FECHA DE INICIO', 'F'),
(49, 'MATERNIDAD DIAS TOMADOS', 'N'),
(50, 'DIAS VACACIONES LEY', 'N'),
(51, 'DIAS TRAB. PARA VACACIONES', 'N'),
(52, 'FECHA DE EGRESO', 'F'),
(53, 'ANTIG.LIQUIDAC.FINAL', 'N'),
(54, 'EMBARGO JUDICIAL', 'N'),
(55, 'CUOTA ALIMENTARIA', 'N'),
(56, 'SAC PAGADO', 'N'),
(57, 'HIJOS SAL.FAMILIAR', 'N'),
(58, 'HIJOS INCAPACITADOS', 'N'),
(59, 'BASE SALARIO FAMILIAR', 'N'),
(60, 'PRENATAL PAGADOS', 'N'),
(61, 'PRENATAL', 'N'),
(62, 'BASE PARA INDEMNIZACIONES', 'N'),
(63, 'PROM.REM.VARIABLES 6', 'N'),
(64, 'REDONDEO ANTERIOR', 'N'),
(65, 'EDAD', 'N'),
(66, 'ANTIGUEDAD EN AÑOS', 'N'),
(67, 'CATEGORIA', 'C'),
(68, 'COD.PLAN OSOCIAL', 'N'),
(69, 'ANTIGUEDAD ANTERIOR', 'N'),
(70, 'FORMA DE PAGO', 'N'),
(71, 'TIPO CUENTA BANCARIA', 'C'),
(72, 'CODIGO DE BANCO', 'C'),
(73, 'NUMERO CUENTA BANCARIA', 'C'),
(74, 'SIJP - OBRA SOCIAL', 'N'),
(75, 'SIJP - SITUACION REVISTA', 'N'),
(76, 'SIJP - CONDICION', 'N'),
(77, 'SIJP - ACTIVIDAD', 'N'),
(78, 'SIJP - ZONA', 'N'),
(79, 'SIJP - MOD.CONTRATACION', 'N'),
(80, 'SIJP - CANTIDAD ADHERENTES', 'N'),
(81, 'SIJP - PROVINCIA LOCALIDAD', 'N'),
(82, 'SIJP - CODIGO SINIESTRO', 'N'),
(83, 'SJIP - SITUACION REVISTA', 'N'),
(84, 'SIJP - DIA INICIO SITUACION REVISTA', 'N'),
(85, 'SFA COBRA HIJOS', 'N'),
(86, 'SFA COBRA PRENATAL', 'N'),
(87, 'LUGAR DE PAGO', 'N'),
(88, 'SUCURSAL CTA BANCARIA', 'C'),
(89, 'SIJP - REGIMEN', 'N'),
(90, 'ANT.LIQUID.FINAL MES', 'N'),
(91, 'TELEFONO', 'C'),
(92, 'PROVISION SAC', 'N'),
(93, 'PROVISION VACACIONES', 'N'),
(94, 'PROVISION SAC CARGAS SOCIALES', 'N'),
(95, 'PROVISION VAC - CARGAS SOCIALES', 'N'),
(96, 'ANTICIPOS REMUNERACIONES', 'N'),
(97, 'ANTICIPOS VACACIONES', 'N'),
(98, 'PRESTAMO MONTO TOTAL', 'N'),
(99, 'PRESTAMO FECHA DE INICIO', 'F'),
(100, 'CUOTA MUTUAL PAGAS', 'N'),
(101, 'TOTAL CUOTAS A PAGAR MUTUAL', 'N'),
(102, 'CUOTA MUTUAL - VALOR IMPORTE', 'N'),
(103, 'PRESTAMO SUSPENSION', 'N'),
(104, 'APO_JUBILACION', 'N'),
(105, 'APO_INSSJP', 'N'),
(106, 'APO_ASIG_FAMIL', 'N'),
(107, 'APO_FNE', 'N'),
(108, 'APO_OBRA_SOCIAL', 'N'),
(109, 'DOMICILIO NRO PISO DTO', 'C'),
(110, 'DOMICILIO CALLE', 'C'),
(111, 'DOMICILIO LOCALIDAD', 'C'),
(112, 'DOMICILIO PROVINCIA', 'C'),
(113, 'DOMICILIO COD POSTAL', 'C'),
(114, 'CUIL', 'C'),
(115, 'ESTADO CIVIL', 'C'),
(116, 'FECHA NACIMIENTO', 'F'),
(117, 'NUMERO DE DOCUMENTO', 'N'),
(118, 'TIPO DOCUMENTO', 'C'),
(119, 'SEXO', 'C'),
(120, 'FECHA DE INGRESO', 'F'),
(121, 'TIPO DE LIQUIDACION', 'N'),
(122, 'COBRA PRODUCTIVIDAD', 'N'),
(123, 'VACAC.IMP PAGADO', 'N'),
(124, 'VACACIONES - PAGA', 'N'),
(125, 'SINDICATO', 'N'),
(126, 'SEGURO DE VIDA', 'N'),
(127, 'ANTICIPO AGUINALDO', 'N'),
(128, 'EMBARGO TIPO', 'N'),
(129, 'EMBARGO IMPORTE', 'N'),
(130, 'EMBARGO % DESCUENTO', 'N'),
(131, 'TIPO DE PRESTAMO', 'N'),
(132, 'TIPO DE PRESTAMO 1', 'N'),
(133, 'PREST. 1 MONTO TOTAL', 'N'),
(134, 'PREST. 1 CANT.CUOTAS', 'N'),
(135, 'PREST. 1 CUOTA PAGAS', 'N'),
(136, 'PREST.1 FECHA DE UNICIO', 'F'),
(137, 'NACIONALIDAD', 'C'),
(138, 'PLAN MEDICO O.SOCIAL', 'C'),
(139, 'VACACIONES FECHA DE SALIDA', 'F'),
(140, 'VACACIONES FECHA DE REGRESO', 'F'),
(141, 'VACACIONES FECHA DE REINGRESO', 'F'),
(142, 'VACACIONES DIAS A DESCONTAR MES 2', 'N'),
(143, 'VACACIONES DIAS A DESCONTAR MES 1', 'N'),
(144, 'VACACIONES DIAS A DESCONTAR MES 3', 'N'),
(145, 'VAC DIAS TOMADOS', 'N'),
(146, 'PREST.1 MONTO CUOTA', 'N'),
(147, 'MODALIDAD DE CONTRATACION', 'N'),
(148, 'CARGO', 'C'),
(149, 'BASE CUSS MENSUAL CONTRIBUCIONES', 'N'),
(150, 'BASE CUSS VACACIONES CONTRIBUCIONES', 'N'),
(151, 'BASE CUSS AGUINALDO CONTRIBUCIONES', 'N'),
(152, 'CENTRO DE COSTO - CONTABILIDAD', 'N'),
(153, 'HABERES 1RA.QUINCENA', 'N'),
(154, 'TICKET CANASTA - EXCEPCION', 'N'),
(155, 'EXCEPCION PAGO FERIADO', 'N'),
(156, 'DIA DEL GREMIO EXCEPCION', 'N'),
(157, 'TICKET PLUS - EXCEPCION', 'N'),
(158, 'CATEGORIA PROFESIONAL', 'C'),
(159, 'GROSSING UP GANANCIAS', 'N'),
(160, 'TICKET PLUS - VALOR INFORMADO', 'N'),
(161, 'DGI PERIODO DE GANANCIAS', 'N'),
(162, 'TICKET CANASTA - VALOR INFORMADO', 'N'),
(163, 'TICKET RESTAURANT - EXCEPCION', 'N'),
(164, 'TICKET RESTAURANT - VALOR INFORMADO', 'N'),
(165, 'A CUENTA FUTUROS AUMENTOS', 'N'),
(166, 'PREMIO PRESENTISMO - EXCEPCION', 'N'),
(167, 'PREMIO PRODUCTIVIDAD', 'N'),
(168, 'SFA AYUDA ESCOLAR - CANTIDAD', 'N'),
(169, 'BASE CUSS SEGURIDAD SOCIAL MES', 'N'),
(170, 'BASE CUSS SEGURIDAD SOCIAL VAC', 'N'),
(171, 'BASE CUSS SEGURIDAD SOCIAL SAC', 'N'),
(172, 'DGI IMPUESTO A LAS GANANCIAS', 'N'),
(173, 'PREAVISO INFORMADO', 'N'),
(174, 'DOMICILIO PARTIDO', 'C'),
(175, 'VIATICOS', 'N'),
(176, 'PREMIO ASISTENCIA - EXCEPCION', 'N'),
(177, 'FECHA DE INGRESO ANTERIOR', 'F'),
(178, 'PROMEDIO COMISIONES', 'N'),
(179, 'CATEGORIA DE CONVENIO', 'N'),
(180, 'DIAS DE VACACIONES A GOZAR', 'N'),
(181, 'VAC- DIAS DE VACACIONES - EJERC.ACTUAL', 'N'),
(182, 'VAC- DIAS DE VACACIONES - EJERC.ANTERIOR', 'N'),
(183, 'VAC - DIAS PENDIENTES - EJERC.ACTUAL', 'N'),
(184, 'VAC - DIAS PENDIENTES - EJERC.ANTERIOR', 'N'),
(185, 'VAC - AÑO VACACIONES - EJERC.ACTUAL', 'N'),
(186, 'VAC - AÑO VACACIONES - EJERC.ANTERIOR', 'N'),
(187, 'FECHA SALIDA DE VACACIONES 1', 'F'),
(188, 'FECHA SALIDA DE VACACIONES 2', 'F'),
(189, 'FECHA SALIDA DE VACACIONES 3', 'F'),
(190, 'FECHA SALIDA DE VACACIONES 4', 'F'),
(191, 'DIAS DE VACACIONES TOMADOS SALIDA 1', 'N'),
(192, 'DIAS DE VACACIONES TOMADOS SALIDA 2', 'N'),
(193, 'DIAS DE VACACIONES TOMADOS SALIDA 3', 'N'),
(194, 'DIAS DE VACACIONES TOMADOS SALIDA 4', 'N'),
(195, 'FECHA SALIDA DE VACACIONES', 'F'),
(196, 'AREA', 'N'),
(197, 'SUELDO NETO PROPUESTO', 'N'),
(198, 'FECHA ACUERDO ANTIGUEDAD', 'F'),
(199, 'GRUPO', 'N'),
(200, 'SUELDO PROPUESTO DISTINTO A CONVENIO', 'N'),
(201, 'DGI RETENCION SINDICAL', 'N'),
(202, 'DGI PERSONAL DOMESTICO', 'N'),
(203, 'DGI INTERESES HIPOTECARIOS', 'N'),
(204, 'DGI DEVOLUCION DE GANANCIAS', 'N'),
(205, 'CORREO ELECTRONICO', 'C'),
(206, 'OBRA SOCIAL - NRO. AFILIADO -', 'C'),
(207, 'TOPE SEGURO DE VIDA INDIVIDUAL', 'N'),
(208, 'DIAS ADICIONALES VACACIONES', 'N'),
(209, 'DGI REMUNERACION DIFERENCIA PLAN', 'N'),
(210, 'DGI REMUNERACIONES SEGURO', 'N'),
(211, 'DGI CUOTAS MEDICAS MENSUAL', 'N'),
(212, 'COMPLEMENTO OBRA SOCIAL', 'N'),
(213, 'LUGAR DE TRABAJO', 'C'),
(214, 'PREMIO PRESENTISMO', 'N'),
(215, 'UNIDAD DE NEGOCIOS', 'C'),
(216, 'SECTOR', 'C'),
(217, 'GRADOS', 'C'),
(218, 'GRUPO DE RECIBOS', 'N'),
(219, 'COMENTARIOS', 'C'),
(220, 'DGI SEGURO DE VIDA DEDUCIDO', 'N'),
(221, 'DGI DONACIONES DEDUCIDO', 'N'),
(222, 'DGI GASTOS DE SEPELIO DEDUCIDO', 'N'),
(223, 'DGI CREDITOS HIPOTECARIOS DEDUCIDOS', 'N'),
(224, 'DGI PERSONAL DOMESTICO DEDUCIDO', 'N'),
(225, 'DGI CUOTAS MEDICAS DEDUCIDO', 'N'),
(226, 'DGI SEGURO DE RETIRO DEDUCIDO', 'N'),
(227, 'PROVISION TRASLADA SALDOS', 'N'),
(228, 'DGI HONORARIOS MEDICOS', 'N'),
(229, 'DGI HONORARIOS MEDICOS DEDUCIDOS', 'N'),
(230, 'DGI APORTES JUBILATORIOS TERCEROS', 'N'),
(231, 'DGI APORTES OBRA SOCIAL TERCEROS', 'N'),
(232, 'DGI APORTES SINDICALES TERCEROS', 'N'),
(233, 'DGI REMUNERACION BRUTA TERCEROS', 'N'),
(234, 'DIFERENCIA GANANCIAS 2191', 'N'),
(235, 'VAC - DIAS - TRASPASO AÑO SIGUIENTE', 'N'),
(236, 'PERCEPCIONES', 'N'),
(237, 'DGI REM.EXCENTA PET JERAR', 'N'),
(238, 'NRO DE CBU PARTE 1', 'C'),
(239, 'NRO DE CBU PARTE 2', 'C'),
(240, 'TURNO ROTATIVO', 'N'),
(241, 'JORNADA DE TRABAJO', 'N'),
(242, 'RELOJ', 'N'),
(243, 'PLUS FIJO', 'N'),
(244, 'CODIGO 1 - PLUS FIJO', 'N'),
(245, 'CODIGO 2 - FRANCO TRABAJADOS', 'N'),
(246, 'CODIGO 3 - VACACIONES TRABAJADAS', 'N'),
(247, 'CODIGO 4 - HORAS EXTRAS', 'N'),
(248, 'CODIGO 5 - PLUS NOCTURNO', 'N'),
(249, 'CODIGO 6 - GRATIFICACIONES', 'N'),
(250, 'ANTICIPO REMUNERACIONES - PAGO', 'N'),
(251, 'ANTICIPOS REMUNERACIONES PARTE 3', 'N'),
(252, 'GRATIFICACION - INDICADOR', 'N'),
(253, 'NIVEL DE ESTUDIOS', 'N'),
(254, 'SINDICATO - FUERA DE CONVENIO', 'N'),
(255, 'DECRETO 1242 BASE DE CALCULO', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_usuarios`
--

CREATE TABLE IF NOT EXISTS `n7_usuarios` (
`id` int(11) unsigned NOT NULL,
  `usuario` char(20) COLLATE utf8_spanish_ci NOT NULL,
  `clave` char(32) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `n7_usuarios`
--

INSERT INTO `n7_usuarios` (`id`, `usuario`, `clave`) VALUES
(1, 'test', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'test2', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_empresas`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_empresas` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_familiares`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_familiares` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_valores_posibles_legajos`
--

CREATE TABLE IF NOT EXISTS `n7_valores_posibles_legajos` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `valor_posible` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `significado` varchar(120) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `n7_valores_posibles_legajos`
--

INSERT INTO `n7_valores_posibles_legajos` (`id`, `propiedad_id`, `valor_posible`, `significado`) VALUES
(1, 3, '1', 'ALTA'),
(2, 3, '2', 'NO LIQUIDA MES'),
(4, 3, '3', 'SUSPENSION DE PAGO'),
(5, 3, '4', 'PREAVISO'),
(6, 120, '01/01/2015', '-'),
(7, 177, '31/12/2099', '-'),
(8, 1, '1', 'DESPIDO'),
(9, 120, '31/12/2099', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_empresas`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_empresas` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `n7_vistas_empresas`
--

INSERT INTO `n7_vistas_empresas` (`id`, `descripcion`, `extranet_permitido`) VALUES
(1, 'LIQUIDACIÓN', 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_familiares`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_familiares` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_legajos`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_legajos` (
`id` int(11) unsigned NOT NULL,
  `descripcion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `extranet_permitido` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `n7_vistas_legajos`
--

INSERT INTO `n7_vistas_legajos` (`id`, `descripcion`, `extranet_permitido`) VALUES
(1, 'Datos Generales', 'N'),
(2, 'Domicilios', 'N'),
(3, 'Fechas', 'N'),
(4, 'Alta de Legajo', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_propiedades_e`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_propiedades_e` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `n7_vistas_propiedades_e`
--

INSERT INTO `n7_vistas_propiedades_e` (`id`, `propiedad_id`, `formulario_id`, `orden`, `solo_lectura`) VALUES
(17, 1, 1, 1, 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_propiedades_f`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_propiedades_f` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `n7_vistas_propiedades_f`
--

INSERT INTO `n7_vistas_propiedades_f` (`id`, `propiedad_id`, `formulario_id`, `orden`, `solo_lectura`) VALUES
(1, 1, 1, 1, 'S'),
(2, 2, 1, 2, 'S'),
(3, 3, 1, 3, 'S'),
(4, 4, 1, 4, 'S'),
(5, 5, 1, 5, 'S'),
(6, 6, 1, 6, 'S'),
(7, 7, 1, 7, 'S'),
(8, 8, 1, 8, 'S'),
(9, 9, 1, 9, 'S'),
(10, 10, 1, 10, 'S'),
(11, 11, 1, 11, 'S'),
(12, 12, 1, 12, 'S'),
(13, 13, 1, 13, 'S'),
(14, 14, 1, 14, 'S'),
(15, 15, 1, 15, 'S'),
(16, 16, 1, 16, 'S'),
(17, 17, 1, 17, 'S'),
(18, 18, 1, 18, 'S'),
(19, 19, 1, 19, 'S'),
(20, 20, 1, 20, 'S'),
(21, 21, 1, 21, 'S'),
(22, 22, 1, 22, 'S'),
(23, 23, 1, 23, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `n7_vistas_propiedades_l`
--

CREATE TABLE IF NOT EXISTS `n7_vistas_propiedades_l` (
`id` int(11) unsigned NOT NULL,
  `propiedad_id` int(11) unsigned NOT NULL,
  `formulario_id` int(11) unsigned NOT NULL,
  `orden` smallint(5) unsigned NOT NULL,
  `solo_lectura` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=76 ;

--
-- Volcado de datos para la tabla `n7_vistas_propiedades_l`
--

INSERT INTO `n7_vistas_propiedades_l` (`id`, `propiedad_id`, `formulario_id`, `orden`, `solo_lectura`) VALUES
(1, 175, 3, 10, 'N'),
(2, 174, 3, 20, 'N'),
(3, 169, 1, 10, 'N'),
(4, 174, 1, 20, 'N'),
(67, 1, 4, 1, 'N'),
(68, 3, 4, 2, 'N'),
(69, 120, 4, 3, 'N'),
(70, 52, 4, 4, 'S'),
(71, 46, 4, 5, 'N'),
(72, 68, 4, 6, 'N'),
(73, 37, 4, 7, 'N'),
(74, 72, 4, 8, 'N'),
(75, 88, 4, 9, 'N');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `n7_empresas`
--
ALTER TABLE `n7_empresas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_empresa_usuario`
--
ALTER TABLE `n7_empresa_usuario`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario_id` (`usuario_id`), ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `n7_legajos`
--
ALTER TABLE `n7_legajos`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_1` (`empresa_id`);

--
-- Indices de la tabla `n7_menu_general`
--
ALTER TABLE `n7_menu_general`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_ppd_l`
--
ALTER TABLE `n7_ppd_l`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_3` (`propiedad_id`), ADD KEY `Index_2` (`objeto_id`) USING BTREE, ADD KEY `Index_4` (`objeto_id`,`propiedad_id`) USING BTREE;

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
-- Indices de la tabla `n7_usuarios`
--
ALTER TABLE `n7_usuarios`
 ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `n7_vistas_empresas`
--
ALTER TABLE `n7_vistas_empresas`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_vistas_familiares`
--
ALTER TABLE `n7_vistas_familiares`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_vistas_legajos`
--
ALTER TABLE `n7_vistas_legajos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `n7_vistas_propiedades_e`
--
ALTER TABLE `n7_vistas_propiedades_e`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`), ADD KEY `Index_3` (`formulario_id`);

--
-- Indices de la tabla `n7_vistas_propiedades_f`
--
ALTER TABLE `n7_vistas_propiedades_f`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`), ADD KEY `Index_3` (`formulario_id`);

--
-- Indices de la tabla `n7_vistas_propiedades_l`
--
ALTER TABLE `n7_vistas_propiedades_l`
 ADD PRIMARY KEY (`id`), ADD KEY `Index_2` (`propiedad_id`), ADD KEY `Index_3` (`formulario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `n7_empresas`
--
ALTER TABLE `n7_empresas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `n7_empresa_usuario`
--
ALTER TABLE `n7_empresa_usuario`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `n7_legajos`
--
ALTER TABLE `n7_legajos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `n7_menu_general`
--
ALTER TABLE `n7_menu_general`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `n7_ppd_l`
--
ALTER TABLE `n7_ppd_l`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_e`
--
ALTER TABLE `n7_propiedades_e`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_f`
--
ALTER TABLE `n7_propiedades_f`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `n7_propiedades_l`
--
ALTER TABLE `n7_propiedades_l`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=256;
--
-- AUTO_INCREMENT de la tabla `n7_usuarios`
--
ALTER TABLE `n7_usuarios`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_empresas`
--
ALTER TABLE `n7_valores_posibles_empresas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_familiares`
--
ALTER TABLE `n7_valores_posibles_familiares`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `n7_valores_posibles_legajos`
--
ALTER TABLE `n7_valores_posibles_legajos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_empresas`
--
ALTER TABLE `n7_vistas_empresas`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_familiares`
--
ALTER TABLE `n7_vistas_familiares`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_legajos`
--
ALTER TABLE `n7_vistas_legajos`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_propiedades_e`
--
ALTER TABLE `n7_vistas_propiedades_e`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_propiedades_f`
--
ALTER TABLE `n7_vistas_propiedades_f`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `n7_vistas_propiedades_l`
--
ALTER TABLE `n7_vistas_propiedades_l`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `n7_empresa_usuario`
--
ALTER TABLE `n7_empresa_usuario`
ADD CONSTRAINT `n7_empresa_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `n7_usuarios` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `n7_empresa_usuario_ibfk_2` FOREIGN KEY (`empresa_id`) REFERENCES `n7_empresas` (`id`) ON DELETE CASCADE;

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
