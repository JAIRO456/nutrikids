-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2025 a las 09:21:56
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
-- Base de datos: `nutrikids2`
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
(2, 1122778899, 1),
(3, 1122778888, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_menu`
--

CREATE TABLE `detalles_menu` (
  `id_det_menu` int(11) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
  `id_producto` bigint(13) NOT NULL,
  `id_estado` smallint(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_menu`
--

INSERT INTO `detalles_menu` (`id_det_menu`, `cantidad`, `id_menu`, `id_producto`, `id_estado`, `subtotal`) VALUES
(4, 2, 8, 1775599331, 2, 3000.00);

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
(8, 19, 1122778899, 8, 1775599331, 2, 3000.00),
(9, 20, 1122778888, 8, 1775599331, 2, 3000.00);

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
(5, 1234567882, 1),
(6, 1073155246, 1);

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
(1122331122, 'Alejandra', 'Barrero', 'aleja@example.com', 11334455, '', 1073155246, 1),
(1122778888, 'Stefani', 'Álvarez', 'stefani@example.com', 1122667788, 'unnamed.jpg', 1234567882, 2),
(1122778899, 'Nazli', 'Serna', 'nazli@example.com', 1147483648, 'sodapdf-converted.png', 1234567882, 2);

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
(1, 1775599331, 60.00, 4.00, 5.50, 1.50, 3.50, 45.00),
(2, 321634361878, 1.00, 2.00, 4.00, 0.00, 7.00, 5.00);

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
  `marca` set('Colombina','Alpina','Zenú','Quala','Noel') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'Colombina'),
(2, 'Alpina'),
(3, 'Zenú'),
(4, 'Quala'),
(5, 'Noel');

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
(8, 'Menú de mi Amor', '', 3000.00, 1234567882);

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
  `fecha_ini` date NOT NULL DEFAULT current_timestamp(),
  `fecha_fin` date NOT NULL DEFAULT current_timestamp(),
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedidos`, `dia`, `documento`, `total_pedido`, `id_met_pago`, `fecha_ini`, `fecha_fin`, `id_estado`) VALUES
(1, 'lunes', 1073155246, 15000.00, 2, '2025-05-08', '2025-05-31', 1),
(2, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(3, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(4, 'martes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(5, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(6, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(7, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(8, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(9, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(10, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(11, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(12, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(13, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(14, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(15, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(16, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(17, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(18, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(19, 'lunes,viernes', 1234567882, 3000.00, 1, '2025-05-25', '2025-06-07', 1),
(20, 'lunes,miercoles,jueves', 1234567882, 3000.00, 3, '2025-05-25', '2025-06-05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` bigint(13) NOT NULL,
  `nombre_prod` varchar(25) NOT NULL,
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
(1, 'Capuchino', 'Hola mundo...', 5000, 'cafe_capuchino.jpg', 2, 2),
(2, 'Pan Croissant', 'Pan con jamón y queso', 2500, '', 5, 5),
(1775599331, 'Yogur Natural', 'Hola mundo', 1500, 'YOGURT-ORIGINAL-ALPINA-FRUTOS_L.png', 3, 2),
(321634361878, 'Leche Deslactosada', 'Leche Deslactosada Alpina Caja 200 ml', 2200, 'leche-deslactosada-alpina-caja-200-ml-7702001044481-img-2.png', 1, 2);

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
(1073155246, 'Falso', 'Falsedad', 'falsofalseda@gmail.com', 1149483647, '$2y$10$HIsSL/Lzfcr9o7Map32hlOlHI2j7g37JSSm2Vm9un/U1TRYMfW6vK', 'WIN_20240829_09_04_28_Pro.jpg', 2, 1),
(1234567882, 'Katerine', 'Sánchez', 'katerine@example.com', 1100998866, '$2y$10$.GZrMIfTftO3TRUj7l9tvuUbxL46xDLH2ht2Oo5ZPKJTzCA96BcLK', 'gardevoir.png', 4, 1),
(1234567890, 'Kant', 'Arboles', 'kantarboles@example.com', 1122334455, '$2y$10$qXmbbUeOphz2ZG1AAjKjgO6RL.Ld3x7rLq4X1qQCwoIe10Gcd7I9C', 'wallpapersden.com_landscape-pixel-art_1920x1080.png', 1, 1),
(1234567891, 'Fabian', 'Martinez', 'edwinfabian.2006tmpg@gmail.com', 1145483646, '$2y$10$NUZtqMLB27h8Lu8vEOH9cuIL3eq1CmdjPRqaYDFUSgST.HW6xnaXG', 'leche-deslactosada-alpina-caja-200-ml-7702001044481-img-2.png', 2, 1),
(1234567892, 'Anna', 'Victoria', 'falsofalseda@gmail.com', 1147483648, '$2y$10$HIsSL/Lzfcr9o7Map32hlOlHI2j7g37JSSm2Vm9un/U1TRYMfW6vK', 'perro.png', 3, 1);

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
  MODIFY `id_det_students_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  MODIFY `id_det_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
  MODIFY `id_det_ped_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalles_usuarios_escuela`
--
ALTER TABLE `detalles_usuarios_escuela`
  MODIFY `id_det_users_esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
  MODIFY `id_nutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_met_pago` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedidos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
