-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2025 a las 07:07:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutrikids3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` smallint(4) NOT NULL,
  `categoria` set('Bebidas Frías','Bebidas Calientes','Postres','Frutas','Panadería','Snacks') NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `imagen`) VALUES
(1, 'Bebidas Frías', 'bebidas.jpg'),
(2, 'Bebidas Calientes', 'cafes.jpg'),
(3, 'Postres', 'postres.png'),
(4, 'Frutas', 'frutas.png'),
(5, 'Panadería', 'panaderia.jpg'),
(6, 'Snacks', 'snack.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_estudiantes_escuela`
--

CREATE TABLE `detalles_estudiantes_escuela` (
  `id_det_students_esc` int(11) NOT NULL,
  `documento_est` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_estudiantes_escuela`
--

INSERT INTO `detalles_estudiantes_escuela` (`id_det_students_esc`, `documento_est`, `id_escuela`) VALUES
(5, 1234567880, 1),
(6, 1234567881, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_menu`
--

CREATE TABLE `detalles_menu` (
  `id_det_menu` int(11) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `dias` varchar(200) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
  `id_producto` bigint(13) NOT NULL,
  `id_estado` smallint(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_menu`
--

INSERT INTO `detalles_menu` (`id_det_menu`, `cantidad`, `dias`, `id_menu`, `id_producto`, `id_estado`, `subtotal`) VALUES
(14, 1, '', 20, 576724161594, 2, 2500.00),
(15, 2, '', 20, 682256513490, 2, 5200.00),
(16, 1, '', 20, 628469989013, 2, 4100.00),
(17, 2, '', 21, 100870934099, 1, 28800.00),
(18, 1, '', 21, 682256513490, 1, 2600.00),
(19, 1, '', 21, 691950427967, 1, 3200.00),
(20, 2, '', 22, 682256513490, 2, 5200.00),
(21, 1, '', 22, 728046978577, 2, 4100.00),
(22, 2, '', 23, 682256513490, 2, 5200.00),
(23, 1, '', 23, 691950427967, 2, 3200.00),
(24, 1, '', 23, 728046978577, 2, 4100.00),
(25, 2, '', 24, 576724161594, 2, 5000.00),
(26, 1, '', 24, 682256513490, 2, 2600.00),
(27, 1, '', 24, 728046978577, 2, 4100.00),
(28, 1, '', 25, 576724161594, 2, 2500.00),
(29, 2, '', 25, 628469989013, 2, 8200.00),
(30, 1, '', 25, 682256513490, 2, 2600.00),
(31, 2, 'martes', 26, 576724161594, 2, 5000.00),
(32, 2, 'viernes', 26, 576724161594, 2, 5000.00),
(33, 1, 'martes', 26, 628469989013, 2, 4100.00),
(34, 1, 'viernes', 26, 628469989013, 2, 4100.00),
(35, 1, 'martes', 26, 682256513490, 2, 2600.00),
(36, 1, 'viernes', 26, 682256513490, 2, 2600.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos_producto`
--

CREATE TABLE `detalles_pedidos_producto` (
  `id_det_ped_prod` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `documento_est` int(11) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
  `id_producto` bigint(13) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos_producto`
--

INSERT INTO `detalles_pedidos_producto` (`id_det_ped_prod`, `id_pedido`, `documento_est`, `id_menu`, `id_producto`, `cantidad`, `subtotal`) VALUES
(16, 23, 1234567880, 21, 100870934099, 2, 28800.00),
(17, 23, 1234567880, 21, 682256513490, 1, 2600.00),
(18, 23, 1234567880, 21, 691950427967, 1, 3200.00),
(19, 24, 1234567880, 21, 100870934099, 2, 28800.00),
(20, 24, 1234567880, 21, 682256513490, 1, 2600.00),
(21, 24, 1234567880, 21, 691950427967, 1, 3200.00),
(22, 25, 1234567880, 21, 100870934099, 2, 28800.00),
(23, 25, 1234567880, 21, 682256513490, 1, 2600.00),
(24, 25, 1234567880, 21, 691950427967, 1, 3200.00),
(25, 26, 1234567880, 22, 682256513490, 2, 5200.00),
(26, 26, 1234567880, 22, 728046978577, 1, 4100.00),
(27, 27, 1234567880, 22, 682256513490, 2, 5200.00),
(28, 27, 1234567880, 22, 728046978577, 1, 4100.00),
(29, 28, 1234567880, 22, 682256513490, 2, 5200.00),
(30, 28, 1234567880, 22, 728046978577, 1, 4100.00),
(31, 29, 1234567880, 22, 682256513490, 2, 5200.00),
(32, 29, 1234567880, 22, 728046978577, 1, 4100.00),
(33, 30, 1234567880, 22, 682256513490, 2, 5200.00),
(34, 30, 1234567880, 22, 728046978577, 1, 4100.00),
(35, 31, 1234567880, 22, 682256513490, 2, 5200.00),
(36, 31, 1234567880, 22, 728046978577, 1, 4100.00),
(37, 32, 1234567880, 22, 682256513490, 2, 5200.00),
(38, 32, 1234567880, 22, 728046978577, 1, 4100.00),
(39, 33, 1234567880, 22, 682256513490, 2, 5200.00),
(40, 33, 1234567880, 22, 728046978577, 1, 4100.00),
(41, 34, 1234567880, 22, 682256513490, 2, 5200.00),
(42, 34, 1234567880, 22, 728046978577, 1, 4100.00),
(43, 35, 1234567880, 23, 682256513490, 2, 5200.00),
(44, 35, 1234567880, 23, 691950427967, 1, 3200.00),
(45, 35, 1234567880, 23, 728046978577, 1, 4100.00),
(46, 36, 1234567880, 23, 682256513490, 2, 5200.00),
(47, 36, 1234567880, 23, 691950427967, 1, 3200.00),
(48, 36, 1234567880, 23, 728046978577, 1, 4100.00),
(49, 37, 1234567880, 24, 576724161594, 2, 5000.00),
(50, 37, 1234567880, 24, 682256513490, 1, 2600.00),
(51, 37, 1234567880, 24, 728046978577, 1, 4100.00),
(52, 38, 1234567880, 24, 576724161594, 2, 5000.00),
(53, 38, 1234567880, 24, 682256513490, 1, 2600.00),
(54, 38, 1234567880, 24, 728046978577, 1, 4100.00),
(55, 39, 1234567880, 26, 576724161594, 2, 5000.00),
(56, 39, 1234567880, 26, 576724161594, 2, 5000.00),
(57, 39, 1234567880, 26, 628469989013, 1, 4100.00),
(58, 39, 1234567880, 26, 628469989013, 1, 4100.00),
(59, 39, 1234567880, 26, 682256513490, 1, 2600.00),
(60, 39, 1234567880, 26, 682256513490, 1, 2600.00),
(61, 40, 1234567880, 26, 576724161594, 2, 5000.00),
(62, 40, 1234567880, 26, 576724161594, 2, 5000.00),
(63, 40, 1234567880, 26, 628469989013, 1, 4100.00),
(64, 40, 1234567880, 26, 628469989013, 1, 4100.00),
(65, 40, 1234567880, 26, 682256513490, 1, 2600.00),
(66, 40, 1234567880, 26, 682256513490, 1, 2600.00),
(67, 41, 1234567880, 26, 576724161594, 2, 5000.00),
(68, 41, 1234567880, 26, 576724161594, 2, 5000.00),
(69, 41, 1234567880, 26, 628469989013, 1, 4100.00),
(70, 41, 1234567880, 26, 628469989013, 1, 4100.00),
(71, 41, 1234567880, 26, 682256513490, 1, 2600.00),
(72, 41, 1234567880, 26, 682256513490, 1, 2600.00),
(73, 42, 1234567880, 26, 576724161594, 2, 5000.00),
(74, 42, 1234567880, 26, 576724161594, 2, 5000.00),
(75, 42, 1234567880, 26, 628469989013, 1, 4100.00),
(76, 42, 1234567880, 26, 628469989013, 1, 4100.00),
(77, 42, 1234567880, 26, 682256513490, 1, 2600.00),
(78, 42, 1234567880, 26, 682256513490, 1, 2600.00),
(79, 43, 1234567880, 26, 576724161594, 2, 5000.00),
(80, 43, 1234567880, 26, 576724161594, 2, 5000.00),
(81, 43, 1234567880, 26, 628469989013, 1, 4100.00),
(82, 43, 1234567880, 26, 628469989013, 1, 4100.00),
(83, 43, 1234567880, 26, 682256513490, 1, 2600.00),
(84, 43, 1234567880, 26, 682256513490, 1, 2600.00),
(85, 44, 1234567880, 26, 576724161594, 2, 5000.00),
(86, 44, 1234567880, 26, 576724161594, 2, 5000.00),
(87, 44, 1234567880, 26, 628469989013, 1, 4100.00),
(88, 44, 1234567880, 26, 628469989013, 1, 4100.00),
(89, 44, 1234567880, 26, 682256513490, 1, 2600.00),
(90, 44, 1234567880, 26, 682256513490, 1, 2600.00),
(91, 45, 1234567880, 26, 576724161594, 2, 5000.00),
(92, 45, 1234567880, 26, 576724161594, 2, 5000.00),
(93, 45, 1234567880, 26, 628469989013, 1, 4100.00),
(94, 45, 1234567880, 26, 628469989013, 1, 4100.00),
(95, 45, 1234567880, 26, 682256513490, 1, 2600.00),
(96, 45, 1234567880, 26, 682256513490, 1, 2600.00),
(97, 46, 1234567880, 26, 576724161594, 2, 5000.00),
(98, 46, 1234567880, 26, 576724161594, 2, 5000.00),
(99, 46, 1234567880, 26, 628469989013, 1, 4100.00),
(100, 46, 1234567880, 26, 628469989013, 1, 4100.00),
(101, 46, 1234567880, 26, 682256513490, 1, 2600.00),
(102, 46, 1234567880, 26, 682256513490, 1, 2600.00),
(103, 47, 1234567880, 26, 576724161594, 2, 5000.00),
(104, 47, 1234567880, 26, 576724161594, 2, 5000.00),
(105, 47, 1234567880, 26, 628469989013, 1, 4100.00),
(106, 47, 1234567880, 26, 628469989013, 1, 4100.00),
(107, 47, 1234567880, 26, 682256513490, 1, 2600.00),
(108, 47, 1234567880, 26, 682256513490, 1, 2600.00),
(109, 48, 1234567880, 26, 576724161594, 2, 5000.00),
(110, 48, 1234567880, 26, 576724161594, 2, 5000.00),
(111, 48, 1234567880, 26, 628469989013, 1, 4100.00),
(112, 48, 1234567880, 26, 628469989013, 1, 4100.00),
(113, 48, 1234567880, 26, 682256513490, 1, 2600.00),
(114, 48, 1234567880, 26, 682256513490, 1, 2600.00),
(115, 49, 1234567880, 26, 576724161594, 2, 5000.00),
(116, 49, 1234567880, 26, 576724161594, 2, 5000.00),
(117, 49, 1234567880, 26, 628469989013, 1, 4100.00),
(118, 49, 1234567880, 26, 628469989013, 1, 4100.00),
(119, 49, 1234567880, 26, 682256513490, 1, 2600.00),
(120, 49, 1234567880, 26, 682256513490, 1, 2600.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_usuarios_escuela`
--

CREATE TABLE `detalles_usuarios_escuela` (
  `id_det_users_esc` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_usuarios_escuela`
--

INSERT INTO `detalles_usuarios_escuela` (`id_det_users_esc`, `documento`, `id_escuela`) VALUES
(1, 1073155246, 1),
(8, 1234567897, 2),
(13, 1234567891, 1),
(14, 1234567892, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` smallint(3) NOT NULL,
  `nombre_escuela` varchar(255) NOT NULL,
  `email_esc` varchar(100) NOT NULL,
  `telefono_esc` int(12) NOT NULL,
  `imagen_esc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id_escuela`, `nombre_escuela`, `email_esc`, `telefono_esc`, `imagen_esc`) VALUES
(1, 'Escuela Primaria San José', 'escuela1@example.com', 1122331122, 'charmander.png'),
(2, 'Colegio Santa María', 'escuela2@example.com', 1133441133, 'santa_maria.jpg'),
(3, 'Instituto Técnico del Valle', 'escuela3@example.com', 1144551144, 'tecnico_valle.jpg'),
(4, 'Jose Antonio Ricaurte', 'escuela4@example.com', 1155667789, 'unnamed.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` smallint(4) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'activo'),
(2, 'inactivo'),
(3, 'entregado'),
(4, 'no entregado'),
(5, 'pendiente'),
(6, 'Pago Exitoso'),
(7, 'Pago Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `documento_est` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `telefono` int(12) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `documento` int(11) NOT NULL,
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`documento_est`, `nombre`, `apellido`, `email`, `telefono`, `imagen`, `documento`, `id_estado`) VALUES
(1234567880, 'Nazly', 'Serna', 'nazli@example.com', 1234567880, 'default.png', 1234567892, 1),
(1234567881, 'Brandon', 'Valencia', 'brando@example.com', 1234567881, 'default.png', 1234567892, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_nutricional`
--

CREATE TABLE `informacion_nutricional` (
  `id_nutricion` int(11) NOT NULL,
  `id_producto` bigint(13) NOT NULL,
  `calorias` decimal(6,2) DEFAULT NULL,
  `proteinas` decimal(6,2) DEFAULT 0.00,
  `carbohidratos` decimal(6,2) DEFAULT 0.00,
  `grasas` decimal(6,2) DEFAULT 0.00,
  `azucares` decimal(6,2) DEFAULT 0.00,
  `sodio` decimal(6,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `informacion_nutricional`
--

INSERT INTO `informacion_nutricional` (`id_nutricion`, `id_producto`, `calorias`, `proteinas`, `carbohidratos`, `grasas`, `azucares`, `sodio`) VALUES
(2, 321634361878, 1.00, 2.00, 4.00, 0.00, 7.00, 5.00),
(3, 100870934099, 800.00, 26.70, 126.70, 20.00, 100.00, 500.00),
(4, 691950427967, 152.00, 5.20, 24.00, 4.00, 22.00, 98.00),
(5, 728046978577, 187.00, 6.20, 29.00, 5.30, 24.00, 103.00),
(6, 816379379267, 156.00, 5.20, 24.00, 4.40, 20.00, 86.00),
(7, 337113680433, 154.00, 4.80, 24.00, 4.20, 22.00, 84.00),
(8, 895323156515, 154.00, 4.80, 24.00, 4.20, 22.00, 84.00),
(9, 917948271515, 162.00, 5.00, 26.00, 4.20, 22.00, 80.00),
(10, 791010742796, 116.00, 3.60, 18.00, 3.20, 17.00, 63.00),
(11, 797459825311, 156.00, 5.20, 24.00, 4.40, 20.00, 86.00),
(12, 628469989013, 194.00, 6.00, 31.00, 5.00, 26.00, 96.00),
(13, 576724161594, 152.00, 5.20, 24.00, 4.00, 22.00, 98.00),
(14, 682256513490, 162.00, 5.00, 26.00, 4.20, 22.00, 80.00),
(15, 399653948218, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(16, 446581655459, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `id_licencia` varchar(24) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL,
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`id_licencia`, `fecha_inicio`, `fecha_fin`, `id_tipo`, `id_escuela`, `id_estado`) VALUES
('1', '2025-01-01', '2025-09-25', 1, 1, 1),
('2', '2025-01-01', '2025-12-11', 2, 2, 1),
('3', '2025-01-01', '2025-12-31', 3, 3, 1),
('4', '2025-05-08', '2025-06-07', 1, 4, 1),
('52fa-cdd8-9cac-1677-e989', '2025-05-28', '2025-06-07', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` smallint(6) NOT NULL,
  `marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'Sin Marca'),
(2, 'Alpina'),
(3, 'Zenú'),
(4, 'Quala'),
(5, 'Noel'),
(6, 'Tosh'),
(7, 'Ramo'),
(8, 'Manitoba'),
(9, 'Naturaleza Snacks'),
(10, 'Nature Valley'),
(11, 'Quaker'),
(12, 'Colombina'),
(14, 'Brisa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` smallint(4) NOT NULL,
  `nombre_menu` varchar(25) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `documento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `nombre_menu`, `imagen`, `precio`, `documento`) VALUES
(12, 'Menú Prueba', '', 0.00, 1234567892),
(13, 'Menú Prueba', '', 0.00, 1234567892),
(14, 'Menú Prueba', '', 0.00, 1234567892),
(15, 'Menú Prueba', '', 0.00, 1234567892),
(16, 'Menú Prueba', '', 0.00, 1234567892),
(17, 'Menú Prueba', '', 0.00, 1234567892),
(18, 'Menú Prueba', '', 0.00, 1234567892),
(19, 'Menú Prueba', '', 0.00, 1234567892),
(20, 'Hola3', '', 11800.00, 1234567892),
(21, 'Hola4', '', 34600.00, 1234567892),
(22, 'Hola5', '', 9300.00, 1234567892),
(23, 'Hola6', '', 12500.00, 1234567892),
(24, 'Holaq', '', 11700.00, 1234567892),
(25, 'Prueba10', '', 13300.00, 1234567892),
(26, 'Prueba11', '', 11700.00, 1234567892);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_met_pago` smallint(4) NOT NULL,
  `metodo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_met_pago`, `metodo`) VALUES
(1, 'Tarjeta de crédito'),
(2, 'Transacción'),
(3, 'Tarjeta de debito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedidos` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `total_pedido` decimal(10,2) NOT NULL,
  `id_met_pago` smallint(4) NOT NULL,
  `fecha_ini` date NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` date NOT NULL DEFAULT current_timestamp(),
  `id_estado` smallint(4) NOT NULL,
  `archivo` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedidos`, `documento`, `total_pedido`, `id_met_pago`, `fecha_ini`, `fecha_fin`, `id_estado`, `archivo`) VALUES
(23, 1234567892, 34600.00, 2, '2025-06-18', '2025-06-18', 1, NULL),
(24, 1234567892, 34600.00, 2, '2025-06-18', '2025-06-18', 1, NULL),
(25, 1234567892, 34600.00, 2, '2025-06-18', '2025-06-18', 6, 'factura_nutrikids_25_2025-06-19_03-18-52.pdf'),
(26, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_26_2025-06-20_01-17-25.pdf'),
(27, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_27_2025-06-20_01-25-15.pdf'),
(28, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_28_2025-06-20_01-32-26.pdf'),
(29, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_29_2025-06-20_01-33-54.pdf'),
(30, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_30_2025-06-20_01-46-49.pdf'),
(31, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_31_2025-06-20_01-53-43.pdf'),
(32, 1234567892, 9300.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_32_2025-06-20_02-24-23.pdf'),
(33, 1234567892, 9300.00, 3, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_33_2025-06-20_02-32-35.pdf'),
(34, 1234567892, 9300.00, 3, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_34_2025-06-20_02-34-28.pdf'),
(35, 1234567892, 12500.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_35_2025-06-20_02-56-33.pdf'),
(36, 1234567892, 12500.00, 2, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_36_2025-06-20_03-05-45.pdf'),
(37, 1234567892, 11700.00, 3, '2025-06-19', '2025-06-19', 1, NULL),
(38, 1234567892, 11700.00, 3, '2025-06-19', '2025-06-19', 1, NULL),
(39, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(40, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(41, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(42, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(43, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(44, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(45, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, NULL),
(46, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_46_2025-06-20_05-51-29.pdf'),
(47, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 6, 'factura_nutrikids_47_2025-06-20_06-01-49.pdf'),
(48, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 6, 'factura_nutrikids_48_2025-06-20_06-11-00.pdf'),
(49, 1234567892, 11700.00, 1, '2025-06-19', '2025-06-19', 1, 'factura_nutrikids_49_2025-06-20_06-29-22.pdf'),
(50, 1234567892, 11700.00, 2, '2025-06-19', '2025-06-19', 6, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` bigint(13) NOT NULL,
  `nombre_prod` varchar(250) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen_prod` varchar(500) NOT NULL,
  `id_categoria` smallint(4) NOT NULL,
  `id_marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `descripcion`, `precio`, `imagen_prod`, `id_categoria`, `id_marca`) VALUES
(100870934099, 'Yogurt Original Alpina Melocotón 1000 g', 'Yogurt Original Alpina Melocotón Botella 1000 g', 14400, 'yogurt_original_alpina_melocot_n_botella_1000_gr_frontal_7702001043941_img1_2.webp', 3, 2),
(321634361878, 'Leche Deslactosada', 'Leche Deslactosada Alpina Caja 200 ml', 2200, 'leche-deslactosada-alpina-caja-200-ml-7702001044481-img-2.png', 1, 2),
(337113680433, 'Yogurt Original Alpina Mora 200 g', 'Yogurt Original Alpina Mora Vaso 200 g', 3200, 'yogurt-original-mora-200g-img-2_1.png', 3, 2),
(399653948218, 'Agua Sin Gas Brisa ', 'Brisa Agua Sin Gas', 1500, 'width1960.png', 1, 14),
(446581655459, 'Agua Con Gas Brisa', 'Brisa Agua Con Gas 600ml', 1500, 'width1960.png', 1, 14),
(576724161594, 'Yogurt Original Frutos Rojos 150 g', 'Yogurt Original Frutos Rojos Vaso 150 g', 2500, 'yogurt_frutos_rojos_150g_frontal_800px_1_1.png', 3, 2),
(628469989013, 'Yogurt Original Fresa 240 g', 'Yogurt Original Fresa Botella 240 g', 4100, 'yogurt-original-botella-fresa-240g-7702001171118-img-2.png', 3, 2),
(682256513490, 'Yogurt Original Fresa 150 g', 'Yogurt Original Fresa Vaso 150 g', 2600, 'yogurt_fresa_150g_frontal_800px_1.png', 3, 2),
(691950427967, 'Yogurt Original Alpina Frutos Rojos 200 g', 'Yogurt Original Alpina Frutos Rojos Vaso 200 g', 3200, 'yogurt-original-frutos-rojos-200g-img-2_1.png', 3, 2),
(728046978577, 'Yogurt Original Melocotón 240 g', 'Yogurt Original Melocotón Botella 240 g', 4100, 'yogurt-original-botella-melocoton-240g-7702001171125-img-2.png', 3, 2),
(791010742796, 'Yogurt Original Mora 150 g', 'Yogurt Original Mora Vaso 150 g', 2600, 'yogurt_mora_150g_frontal_800px_1_1.png', 3, 2),
(797459825311, 'Yogurt Original Alpina Melocotón 200 g', 'Yogurt Original Alpina Melocotón Vaso 200 g', 3200, 'yogurt-original-melocoton-200g-img-2.png', 3, 2),
(816379379267, 'Yogurt Original Melocotón 150 g', 'Yogurt Original Melocotón Vaso 150 g', 2600, 'yogurt_melocot_n_150g_frontal_800px_1.png', 3, 2),
(895323156515, 'Yogurt Original Alpina Mora 200 g', 'Yogurt Original Alpina Mora Vaso 200 g', 3200, 'yogurt-original-mora-200g-img-2_1.png', 3, 2),
(917948271515, 'Yogurt Original Alpina Fresa 200 g', 'Yogurt Original Alpina Fresa Vaso 200 g', 3200, 'yogurt-original-fresa-200g-img-2.png', 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` smallint(5) NOT NULL,
  `rol` set('Administrador','Vendedor','Acudiente','Director') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Director'),
(3, 'Vendedor'),
(4, 'Acudiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_licencia`
--

CREATE TABLE `tipo_licencia` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_licencia`
--

INSERT INTO `tipo_licencia` (`id_tipo`, `tipo`, `precio`) VALUES
(1, 'Básica', 100.00),
(2, 'Estándar', 200.00),
(3, 'Premium', 300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` int(12) NOT NULL,
  `password` varchar(200) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `id_rol` smallint(5) NOT NULL,
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documento`, `nombre`, `apellido`, `email`, `telefono`, `password`, `imagen`, `id_rol`, `id_estado`) VALUES
(123456781, 'Thania', 'Carretero', 'thania@example.com', 1100998877, '$2y$10$D6YscCnoDLS5i.BNQxXuTu8W5.VLU55QOcPQysL822m5N/2GncDSq', 'bulbasaur.png', 3, 2),
(1073155246, 'Fabian', 'Martinez', 'edwinfabian.2006tmpg@gmail.com', 1145483646, '$2y$10$aB59FWrxqIiv4DKjh7SYBOqQxk/GI4o.S6EkRuULtA6EMfXU6jmuu', 'charmander.png', 3, 1),
(1234567890, 'NUTRIKIDS', 'FJ', 'nutrikids.fj@gmail.com', 1234567890, '$2y$10$nhYKt7Urzou1WKPfpysMMOYeSHradvNFeU52LzHneCGPzSpX6w8oi', NULL, 1, 1),
(1234567891, 'Kant', 'Arboles', 'kantarboles@gmail.com', 1234567891, '$2y$10$WSjkSG2h88yGY3u9Oca1vuQOVUclaU8KnLzsUyV/H0Qqg9GXXPCty', 'default.png', 2, 1),
(1234567892, 'Ana', 'Victoria', 'falsofalseda@gmail.com', 1234567892, '$2y$10$bKI12gfqIigWLskDv31d1ebrPFMLPA0suhuZ9mjklFL3s4QI5.28m', 'default.png', 4, 1),
(1234567897, 'Brando', 'Valencia', 'brando@example.com', 1221543254, '$2y$10$a2362.vVo1ydPhYYS0aioO2EVLQncFfSBC0j1EOpisobOFmXi7yLa', NULL, 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalles_estudiantes_escuela`
--
ALTER TABLE `detalles_estudiantes_escuela`
  ADD PRIMARY KEY (`id_det_students_esc`),
  ADD KEY `documento` (`documento_est`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  ADD PRIMARY KEY (`id_det_menu`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
  ADD PRIMARY KEY (`id_det_ped_prod`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `documento_est` (`documento_est`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  ADD PRIMARY KEY (`id_det_users_esc`),
  ADD KEY `documento` (`documento`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id_escuela`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`documento_est`),
  ADD KEY `documento` (`documento`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
  ADD PRIMARY KEY (`id_nutricion`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_escuela` (`id_escuela`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menus_usuarios` (`documento`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_met_pago`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedidos`),
  ADD KEY `documento` (`documento`),
  ADD KEY `id_met_pago` (`id_met_pago`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_marca` (`id_marca`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalles_estudiantes_escuela`
--
ALTER TABLE `detalles_estudiantes_escuela`
  MODIFY `id_det_students_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  MODIFY `id_det_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
  MODIFY `id_det_ped_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  MODIFY `id_det_users_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
  MODIFY `id_nutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_met_pago` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedidos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_licencia`
--
ALTER TABLE `tipo_licencia`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_estudiantes_escuela`
--
ALTER TABLE `detalles_estudiantes_escuela`
  ADD CONSTRAINT `detalles_estudiantes_escuela_ibfk_1` FOREIGN KEY (`documento_est`) REFERENCES `estudiantes` (`documento_est`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_estudiantes_escuela_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  ADD CONSTRAINT `detalles_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
  ADD CONSTRAINT `detalles_pedidos_producto_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedidos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedidos_producto_ibfk_2` FOREIGN KEY (`documento_est`) REFERENCES `estudiantes` (`documento_est`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedidos_producto_ibfk_3` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_pedidos_producto_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  ADD CONSTRAINT `detalles_usuarios_escuela_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_usuarios_escuela_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
  ADD CONSTRAINT `informacion_nutricional_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_licencia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencias_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencias_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menus_usuarios` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_met_pago`) REFERENCES `metodos_pago` (`id_met_pago`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
