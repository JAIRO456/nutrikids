-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
<<<<<<< HEAD
-- Tiempo de generación: 14-05-2025 a las 03:06:46
=======
<<<<<<< HEAD
-- Tiempo de generación: 08-05-2025 a las 13:56:25
=======
-- Tiempo de generación: 07-05-2025 a las 00:30:34
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
-- Base de datos: `nutrikids2`
=======
-- Base de datos: `nutrikids`
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` smallint(4) NOT NULL,
<<<<<<< HEAD
  `categoria` set('BEBIDAS FRIAS','BEBIDAS CALIENTES','POSTRES','FRUTAS','PANES') NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

=======
  `categoria` set('BEBIDAS FRIAS','BEBIDAS CALIENTES','POSTRES','FRUTAS','PANES','PANADERIA','SNACKS') NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `imagen`) VALUES
<<<<<<< HEAD
(1, 'BEBIDAS FRIAS', ''),
(2, 'BEBIDAS CALIENTES', ''),
(3, 'POSTRES', ''),
(4, 'FRUTAS', ''),
(5, 'PANES', '');

=======
(1, 'BEBIDAS FRIAS', 'bebidas_frias.jpg'),
(2, 'BEBIDAS CALIENTES', 'bebidas_calientes.jpg'),
(3, 'POSTRES', 'postres.jpg'),
(4, 'FRUTAS', 'frutas.jpg'),
(5, 'PANES', 'panes.jpg'),
(6, 'PANADERIA', 'panaderia.jpg'),
(7, 'SNACKS', 'snacks.jpg');

=======
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_estudiantes_escuela`
--

CREATE TABLE `detalles_estudiantes_escuela` (
  `id_det_students_esc` int(11) NOT NULL,
<<<<<<< HEAD
  `documento_est` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_estudiantes_escuela`
--

INSERT INTO `detalles_estudiantes_escuela` (`id_det_students_esc`, `documento_est`, `id_escuela`) VALUES
(2, 1122778899, 1);

=======
  `documento` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_menu`
--

CREATE TABLE `detalles_menu` (
  `id_det_menu` int(11) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
  `id_estado` smallint(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `detalles_menu`
--

INSERT INTO `detalles_menu` (`id_det_menu`, `cantidad`, `id_menu`, `id_producto`, `id_estado`, `subtotal`) VALUES
(1, 3, 2, 1, 1, 15000.00),
(2, 5, 2, 2, 1, 12500.00);

=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos_producto`
--

CREATE TABLE `detalles_pedidos_producto` (
  `id_det_ped_prod` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `documento_est` int(11) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
<<<<<<< HEAD
  `id_producto` bigint(10) NOT NULL,
=======
<<<<<<< HEAD
  `id_producto` bigint(20) NOT NULL,
=======
  `id_producto` bigint(10) NOT NULL,
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `cantidad` int(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `detalles_pedidos_producto`
--

INSERT INTO `detalles_pedidos_producto` (`id_det_ped_prod`, `id_pedido`, `documento_est`, `id_menu`, `id_producto`, `cantidad`, `subtotal`) VALUES
(3, 1, 1122331122, 2, 1, 3, 15000.00),
(4, 1, 1122331122, 2, 2, 5, 12500.00);

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
(1, 1234567891, 1),
(2, 1234567892, 1),
(3, 123456781, 1),
(5, 1234567882, 1);

=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` smallint(3) NOT NULL,
  `nombre_escuela` varchar(255) NOT NULL,
<<<<<<< HEAD
  `email_esc` varchar(100) NOT NULL,
  `telefono_esc` int(12) NOT NULL,
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `imagen_esc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

<<<<<<< HEAD
INSERT INTO `escuelas` (`id_escuela`, `nombre_escuela`, `email_esc`, `telefono_esc`, `imagen_esc`) VALUES
(1, 'Escuela Primaria San José', 'escuela1@example.com', 1122331122, 'san_jose.jpg'),
(2, 'Colegio Santa María', 'escuela2@example.com', 1133441133, 'santa_maria.jpg'),
(3, 'Instituto Técnico del Valle', 'escuela3@example.com', 1144551144, 'tecnico_valle.jpg'),
(4, 'Jose Antonio Ricaurte', 'escuela4@example.com', 1155667789, 'unnamed.jpg');
=======
INSERT INTO `escuelas` (`id_escuela`, `nombre_escuela`, `imagen_esc`) VALUES
(1, 'Escuela Primaria San José', 'san_jose.jpg'),
(2, 'Colegio Santa María', 'santa_maria.jpg'),
(3, 'Instituto Técnico del Valle', 'tecnico_valle.jpg');
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` smallint(4) NOT NULL,
  `estado` set('pendiente','entregado','activo','inactivo','no entregado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'activo'),
(2, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_licencia`
--

CREATE TABLE `estado_licencia` (
  `id_estado_licencia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_licencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_licencia`
--

INSERT INTO `estado_licencia` (`id_estado_licencia`, `nombre`, `id_licencia`) VALUES
(1, 'Activa', 1),
(2, 'Activa', 2),
(3, 'Activa', 3);

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

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`documento_est`, `nombre`, `apellido`, `email`, `telefono`, `imagen`, `documento`, `id_estado`) VALUES
(1122331122, 'Alejandra', 'Barrero', 'aleja@example.com', 11334455, '', 1073155246, 1),
(1122778899, 'Nazli', 'Serna', 'nazli@example.com', 1147483648, 'sodapdf-converted.png', 1234567882, 2);

=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_nutricional`
--

CREATE TABLE `informacion_nutricional` (
  `id_nutricion` int(11) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
<<<<<<< HEAD
  `calorias` decimal(6,2) DEFAULT NULL,
=======
  `calorias` decimal(6,2) NOT NULL,
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `proteinas` decimal(6,2) DEFAULT 0.00,
  `carbohidratos` decimal(6,2) DEFAULT 0.00,
  `grasas` decimal(6,2) DEFAULT 0.00,
  `azucares` decimal(6,2) DEFAULT 0.00,
  `sodio` decimal(6,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `informacion_nutricional`
--

INSERT INTO `informacion_nutricional` (`id_nutricion`, `id_producto`, `calorias`, `proteinas`, `carbohidratos`, `grasas`, `azucares`, `sodio`) VALUES
(1, 1775599331, 60.00, 4.00, 5.50, 1.50, 3.50, 45.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `id_licencia` int(11) NOT NULL,
=======
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `id_licencia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
<<<<<<< HEAD
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`id_licencia`, `fecha_inicio`, `fecha_fin`, `id_tipo`, `id_escuela`) VALUES
(1, '2025-01-01', '2025-06-30', 1, 1),
(2, '2025-01-01', '2025-12-11', 2, 2),
(3, '2025-01-01', '2026-12-31', 3, 3),
(4, '2025-05-08', '2025-06-07', 1, 4);
=======
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `nombre`, `precio`, `fecha_inicio`, `fecha_fin`, `id_tipo`, `id_escuela`) VALUES
(1, 'Licencia Básica', 100.00, '2025-01-01', '2025-06-30', 1, 1),
(2, 'Licencia Estándar', 200.00, '2025-01-01', '2025-12-31', 2, 2),
(3, 'Licencia Premium', 300.00, '2025-01-01', '2026-12-31', 3, 3);
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` smallint(6) NOT NULL,
<<<<<<< HEAD
  `marca` set('Colombina','Alpina','Zenú','Quala','Noel') NOT NULL
=======
<<<<<<< HEAD
  `marca` set('Colombina','Alpina','Zenú','Quala','Noel','Postobón','Nestlé') NOT NULL
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'Colombina'),
(2, 'Alpina'),
(3, 'Zenú'),
(4, 'Quala'),
<<<<<<< HEAD
(5, 'Noel');

=======
(5, 'Noel'),
(6, 'Postobón'),
(7, 'Nestlé');

=======
  `marca` set('Colombina','Alpina','Zenú','Quala','Noel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` smallint(4) NOT NULL,
  `nombre_menu` varchar(25) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `nombre_menu`, `imagen`, `precio`) VALUES
(1, 'Nose', '', 15000.00),
(2, 'Menu de Aleja', '', 10000.00);

=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
  `dia` set('lunes','martes','miercoles','jueves','viernes') NOT NULL,
  `documento` int(11) NOT NULL,
  `total_pedido` decimal(10,2) NOT NULL,
  `id_met_pago` smallint(4) NOT NULL,
  `fecha_ini` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedidos`, `dia`, `documento`, `total_pedido`, `id_met_pago`, `fecha_ini`, `fecha_fin`, `id_estado`) VALUES
(1, 'lunes', 1073155246, 15000.00, 2, '2025-05-08 22:30:06', '2025-05-31 22:29:18', 1);

=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
<<<<<<< HEAD
  `id_producto` bigint(10) NOT NULL,
=======
<<<<<<< HEAD
  `id_producto` bigint(20) NOT NULL,
=======
  `id_producto` bigint(10) NOT NULL,
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `nombre_prod` varchar(25) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen_prod` varchar(500) NOT NULL,
  `cantidad_alm` bigint(8) NOT NULL,
  `id_categoria` smallint(4) NOT NULL,
  `id_marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `descripcion`, `precio`, `imagen_prod`, `cantidad_alm`, `id_categoria`, `id_marca`) VALUES
<<<<<<< HEAD
(1, 'Capuchino', 'Hola mundo...', 5000, '', 20, 2, 2),
(2, 'Pan Croissant', 'Pan con jamón y queso', 2500, '', 50, 5, 5),
(1775599331, 'Yogur Natural', 'YOGURT ORIGINAL ALPINA FRUTOS ROJOS', 1500, 'YOGURT-ORIGINAL-ALPINA-FRUTOS_L.webp', 35, 3, 2);

=======
(1, 'Manzana Roja', 'Manzana fresca rica en vitaminas', 1200, 'manzana_roja.jpg', 200, 4, 2),
(2, 'Banano', 'Banano maduro con potasio', 1000, 'banano.jpg', 180, 4, 2),
(3, 'Uvas Verdes', 'Uvas frescas sin semillas', 3500, 'uvas_verdes.jpg', 150, 4, 2),
(4, 'Pera', 'Pera dulce y jugosa', 1500, 'pera.jpg', 100, 4, 2),
(5, 'Jugo de Naranja', 'Jugo natural rico en vitamina C', 2500, 'jugo_naranja.jpg', 100, 1, 6),
(6, 'Agua Cristal', 'Agua pura y saludable', 2000, 'agua_cristal.jpg', 150, 1, 6),
(7, 'Jugo de Mango', 'Jugo natural de mango', 2700, 'jugo_mango.jpg', 120, 1, 6),
(8, 'Leche Alpina', 'Leche entera rica en calcio', 4000, 'leche_alpina.jpg', 120, 2, 2),
(9, 'Chocolate Corona', 'Chocolate en polvo para bebidas', 4500, 'chocolate_corona.jpg', 60, 2, 7),
(10, 'Té Verde', 'Té verde antioxidante', 3000, 'te_verde.jpg', 80, 2, 4),
(11, 'Yogur Alpina', 'Yogur natural bajo en azúcar', 2500, 'yogur_alpina.jpg', 100, 3, 2),
(12, 'Gelatina de Frutas', 'Gelatina con trozos de frutas', 2000, 'gelatina_frutas.jpg', 150, 3, 1),
(13, 'Flan de Caramelo', 'Flan bajo en grasas', 3000, 'flan_caramelo.jpg', 80, 3, 5),
(14, 'Pan Integral', 'Pan integral con fibra', 2500, 'pan_integral.jpg', 50, 6, 3),
(15, 'Pan de Avena', 'Pan saludable con avena', 2700, 'pan_avena.jpg', 60, 6, 3),
(16, 'Pan Aliñado', 'Pan tradicional colombiano', 2000, 'pan_alinado.jpg', 100, 6, 5),
(17, 'Barra de Granola', 'Barra de granola con miel y frutos secos', 3000, 'barra_granola.jpg', 80, 7, 1),
(18, 'Frutos Secos', 'Mezcla de frutos secos naturales', 3500, 'frutos_secos.jpg', 60, 7, 1),
(19, 'Chips de Plátano', 'Chips horneados de plátano', 2500, 'chips_platano.jpg', 100, 7, 1);

=======
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` smallint(5) NOT NULL,
  `rol` set('administrador','vendedor','acudiente','director') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'administrador'),
(2, 'director'),
(3, 'vendedor'),
(4, 'acudiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_licencia`
--

CREATE TABLE `tipo_licencia` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
<<<<<<< HEAD
=======
  `duracion_licencia` int(11) NOT NULL,
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_licencia`
--

<<<<<<< HEAD
INSERT INTO `tipo_licencia` (`id_tipo`, `tipo`, `precio`) VALUES
(1, 'Básica', 100.00),
(2, 'Estándar', 200.00),
(3, 'Premium', 300.00);
=======
INSERT INTO `tipo_licencia` (`id_tipo`, `tipo`, `duracion_licencia`, `precio`) VALUES
(1, 'Básica', 180, 100.00),
(2, 'Estándar', 365, 200.00),
(3, 'Premium', 730, 300.00);
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
<<<<<<< HEAD
  `email` varchar(100) NOT NULL,
=======
  `email` varchar(25) NOT NULL,
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
(123456781, 'Thania', 'Carretero', 'thania@example.com', 1100998877, '$2y$10$D6YscCnoDLS5i.BNQxXuTu8W5.VLU55QOcPQysL822m5N/2GncDSq', 'bulbasaur.png', 3, 2),
(1073155246, 'fabian', 'martinez', 'edwinfabian.2006tmpg@gmai', 1149483647, '$2y$10$jfe.veAVOAxduyJ1HE/2zeaSzyRzw3/b1xzPxNh4Uc9uigYBsFqVS', 'WIN_20240829_09_04_28_Pro.jpg', 3, 1),
(1234567882, 'Katerine', 'Sánchez', 'katerine@example.com', 1100998866, '$2y$10$.GZrMIfTftO3TRUj7l9tvuUbxL46xDLH2ht2Oo5ZPKJTzCA96BcLK', 'charmander.png', 4, 1),
(1234567890, 'Kant', 'Arboles', 'kantarboles@example.com', 1122334455, '$2y$10$qXmbbUeOphz2ZG1AAjKjgO6RL.Ld3x7rLq4X1qQCwoIe10Gcd7I9C', NULL, 1, 1),
(1234567891, 'Fabian', 'Martinez', 'edwinfabian.2006tmpg@gmail.com', 1145483647, '$2y$10$.RyjgDP7pVOmcJSXfHuJvuNMPpLCUWteMVQelzvBRWrmnICuiXl/i', NULL, 2, 1),
(1234567892, 'Anna', 'Victoria', 'anna@example.com', 1147483648, '$2y$10$DaBINhYv9qmIO3tGyAMLlOdMiP5ZeSxpwB5KOYDoct3YVrpk52Ysi', 'perro.png', 3, 2);
=======
<<<<<<< HEAD
(1073155246, 'fabian', 'martinez', 'edwinfabian.2006tmpg@gmai', 2147483647, '$2y$10$jfe.veAVOAxduyJ1HE/2zeaSzyRzw3/b1xzPxNh4Uc9uigYBsFqVS', 'WIN_20240829_09_04_28_Pro.jpg', 3, 1),
(1234567890, 'Kant', 'Arboles', 'kant@example.com', 1122334455, '$2y$10$pgTzplGU2AjQ./sHIImuyurpM9xXXlPH/EZmjqusAzpNbQlBkfq/.', NULL, 1, 1);
=======
(1073155246, 'fabian', 'martinez', 'edwinfabian.2006tmpg@gmai', 2147483647, '$2y$10$jfe.veAVOAxduyJ1HE/2zeaSzyRzw3/b1xzPxNh4Uc9uigYBsFqVS', 'WIN_20240829_09_04_28_Pro.jpg', 3, 1);
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

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
<<<<<<< HEAD
  ADD KEY `documento` (`documento_est`),
=======
  ADD KEY `documento` (`documento`),
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
-- Indices de la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  ADD PRIMARY KEY (`id_det_users_esc`),
  ADD KEY `documento` (`documento`),
  ADD KEY `id_escuela` (`id_escuela`);

--
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
-- Indices de la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  ADD PRIMARY KEY (`id_estado_licencia`),
  ADD KEY `id_licencia` (`id_licencia`);

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
<<<<<<< HEAD
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
=======
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

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
<<<<<<< HEAD
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
<<<<<<< HEAD
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
=======
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT;
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `detalles_estudiantes_escuela`
--
ALTER TABLE `detalles_estudiantes_escuela`
<<<<<<< HEAD
  MODIFY `id_det_students_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id_det_students_esc` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
<<<<<<< HEAD
  MODIFY `id_det_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id_det_menu` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
<<<<<<< HEAD
  MODIFY `id_det_ped_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  MODIFY `id_det_users_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `id_det_ped_prod` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
<<<<<<< HEAD
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  MODIFY `id_estado_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
<<<<<<< HEAD
  MODIFY `id_nutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
  MODIFY `id_nutricion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
<<<<<<< HEAD
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
<<<<<<< HEAD
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
=======
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT;
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
<<<<<<< HEAD
  MODIFY `id_menu` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
=======
  MODIFY `id_menu` smallint(4) NOT NULL AUTO_INCREMENT;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_met_pago` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
<<<<<<< HEAD
  MODIFY `id_pedidos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
=======
  MODIFY `id_pedidos` int(11) NOT NULL AUTO_INCREMENT;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
<<<<<<< HEAD
  MODIFY `id_producto` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1775599332;
=======
<<<<<<< HEAD
  MODIFY `id_producto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
=======
  MODIFY `id_producto` bigint(10) NOT NULL AUTO_INCREMENT;
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
<<<<<<< HEAD
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
=======
<<<<<<< HEAD
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
=======
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

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
<<<<<<< HEAD
  ADD CONSTRAINT `detalles_estudiantes_escuela_ibfk_1` FOREIGN KEY (`documento_est`) REFERENCES `estudiantes` (`documento_est`) ON DELETE CASCADE ON UPDATE CASCADE,
=======
  ADD CONSTRAINT `detalles_estudiantes_escuela_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
-- Filtros para la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  ADD CONSTRAINT `detalles_usuarios_escuela_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_usuarios_escuela_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  ADD CONSTRAINT `estado_licencia_ibfk_1` FOREIGN KEY (`id_licencia`) REFERENCES `licencias` (`id_licencia`) ON DELETE CASCADE ON UPDATE CASCADE;
=======
-- Filtros para la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  ADD CONSTRAINT `estado_licencia_ibfk_1` FOREIGN KEY (`id_licencia`) REFERENCES `licencia` (`id_licencia`) ON DELETE CASCADE ON UPDATE CASCADE;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

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
<<<<<<< HEAD
-- Filtros para la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD CONSTRAINT `licencias_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_licencia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencias_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;
=======
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_licencia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencia_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

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
