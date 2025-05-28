-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2025 a las 00:55:01
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
-- Base de datos: `nutrikids`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` smallint(4) NOT NULL,
  `categoria` set('BEBIDAS FRIAS','BEBIDAS CALIENTES','POSTRES','FRUTAS','PANES','PANADERIA','SNACKS') NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `imagen`) VALUES
(1, 'BEBIDAS FRIAS', 'bebidas.jpg'),
(2, 'BEBIDAS CALIENTES', 'cafes.jpg'),
(3, 'POSTRES', 'postres.png'),
(4, 'FRUTAS', 'frutas.png'),
(5, 'PANADERIA', 'panaderia.jpg'),
(6, 'SNACKS', 'snack.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_estudiantes_escuela`
--

CREATE TABLE `detalles_estudiantes_escuela` (
  `id_det_students_esc` int(11) NOT NULL,
  `documento` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos_producto`
--

CREATE TABLE `detalles_pedidos_producto` (
  `id_det_ped_prod` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `documento_est` int(11) NOT NULL,
  `id_menu` smallint(4) NOT NULL,
  `id_producto` bigint(20) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` smallint(3) NOT NULL,
  `nombre_escuela` varchar(255) NOT NULL,
  `imagen_esc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id_escuela`, `nombre_escuela`, `imagen_esc`) VALUES
(1, 'Escuela Primaria San José', 'san_jose.jpg'),
(2, 'Colegio Santa María', 'santa_maria.jpg'),
(3, 'Instituto Técnico del Valle', 'tecnico_valle.jpg');

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
(2, 'inactivo'),
(3, 'entregado'),
(4, 'pendiente');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_nutricional`
--

CREATE TABLE `informacion_nutricional` (
  `id_nutricion` int(11) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
  `calorias` decimal(6,2) NOT NULL,
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
(1, 2025, 10.00, 90.00, 40.00, 2.00, 30.00, 20.00),
(2, 30, 10.00, 10.00, 10.00, 10.00, 10.00, 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `id_licencia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_escuela` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `nombre`, `precio`, `fecha_inicio`, `fecha_fin`, `id_tipo`, `id_escuela`) VALUES
(1, 'Licencia Básica', 100.00, '2025-01-01', '2025-06-30', 1, 1),
(2, 'Licencia Estándar', 200.00, '2025-01-01', '2025-12-31', 2, 2),
(3, 'Licencia Premium', 300.00, '2025-01-01', '2026-12-31', 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` smallint(6) NOT NULL,
  `marca` set('Colombina','Alpina','Zenú','Quala','Noel','Postobón','Nestlé') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `marca`) VALUES
(1, 'Colombina'),
(2, 'Alpina'),
(3, 'Zenú'),
(4, 'Quala'),
(5, 'Noel'),
(6, 'Postobón'),
(7, 'Nestlé');

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

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedidos`, `dia`, `documento`, `total_pedido`, `id_met_pago`, `fecha_ini`, `fecha_fin`, `id_estado`) VALUES
(11, 'lunes', 1073155246, 10000.00, 1, '2025-05-22 12:40:09', '2025-05-22 12:40:09', 1),
(12, 'martes', 1073155246, 15000.00, 1, '2025-05-22 12:40:09', '2025-05-22 12:40:09', 1),
(13, 'miercoles', 1073155246, 8000.00, 1, '2025-05-22 12:40:09', '2025-05-22 12:40:09', 1),
(14, 'jueves', 1073155246, 12000.00, 1, '2025-05-22 12:40:09', '2025-05-22 12:40:09', 1),
(15, 'viernes', 1073155246, 5000.00, 1, '2025-05-22 12:40:09', '2025-05-22 12:40:09', 1),
(50, 'viernes', 1234567890, 120000.00, 1, '2025-06-30 12:42:02', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` bigint(20) NOT NULL,
  `nombre_prod` varchar(25) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen_prod` varchar(500) NOT NULL,
  `cantidad_alm` bigint(8) NOT NULL,
  `id_categoria` smallint(4) NOT NULL,
  `id_marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `descripcion`, `precio`, `imagen_prod`, `cantidad_alm`, `id_categoria`, `id_marca`) VALUES
(1, 'Manzana Roja', 'Manzana fresca rica en vitaminas', 1200, 'manzana_roja.jpg', 200, 4, 2),
(2, 'Banano', 'Banano maduro con potasio', 1000, 'banano.jpg', 180, 4, 2),
(3, 'Uvas Verdes', 'Uvas frescas sin semillas', 3500, 'uvas_verdes.jpg', 150, 4, 2),
(4, 'Pera', 'Pera dulce y jugosa', 1500, 'pera.jpg', 100, 4, 2),
(5, 'Jugo de Naranja', 'Jugo natural rico en vitamina C', 2500, 'jugo_naranja.webp', 100, 1, 6),
(6, 'Agua Cristal', 'Agua pura y saludable', 2000, 'agua_cristal.jpg', 150, 1, 6),
(7, 'Jugo de Mango', 'Jugo natural de mango', 2700, 'jugo_mango.jpg', 120, 1, 6),
(8, 'Leche Alpina', 'Leche entera rica en calcio', 4000, 'leche_alpina.jpg', 120, 2, 2),
(9, 'Chocolate Corona', 'Chocolate en polvo para bebidas', 4500, 'chocolate_corona.jpg', 60, 2, 7),
(10, 'Té Verde', 'Té verde antioxidante', 3000, 'te_verde.jpg', 80, 2, 4),
(11, 'Yogur Alpina', 'Yogur natural bajo en azúcar', 2500, 'yogur_alpina.jpg', 100, 3, 2),
(12, 'Gelatina de Frutas', 'Gelatina con trozos de frutas', 2000, 'gelatina_frutas.jpg', 150, 3, 1),
(13, 'Flan de Caramelo', 'Flan bajo en grasas', 3000, 'flan_caramelo.jpg', 80, 3, 5),
(14, 'Pan Integral', 'Pan integral con fibra', 2500, 'pan_integral.jpg', 50, 5, 3),
(16, 'Pan Aliñado', 'Pan tradicional colombiano', 2000, 'pan_alinado.jpg', 100, 5, 5),
(17, 'Barra de Granola', 'Barra de granola con miel y frutos secos', 3000, 'barra_granola.jpg', 80, 6, 1),
(18, 'Frutos Secos', 'Mezcla de frutos secos naturales', 3500, 'frutos_secos.jpg', 60, 6, 1),
(19, 'Chips de Plátano', 'Chips horneados de plátano', 2500, 'chips_platano.jpg', 100, 6, 1),
(30, 'Festival de chocolate.', 'Galleta de chocolate.', 1200, 'galleta_festival.jpeg', 100, 6, 1),
(2025, 'Agua de coco', 'Es una agua de coco con muchos vitaminas y mineral', 300, 'C:\\xampp\\htdocs\\nutrikids\\img\\products\\Water of coconut.jpeg', 40, 1, 6);

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
  `duracion_licencia` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_licencia`
--

INSERT INTO `tipo_licencia` (`id_tipo`, `tipo`, `duracion_licencia`, `precio`) VALUES
(1, 'Básica', 180, 100.00),
(2, 'Estándar', 365, 200.00),
(3, 'Premium', 730, 300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
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
(1073155246, 'fabian', 'martinez', 'edwinfabian.2006tmpg@gmai', 2147483647, '$2y$10$jfe.veAVOAxduyJ1HE/2zeaSzyRzw3/b1xzPxNh4Uc9uigYBsFqVS', 'WIN_20240829_09_04_28_Pro.jpg', 3, 1),
(1234567890, 'Kant', 'Arboles', 'kant@example.com', 1122334455, '$2y$10$pgTzplGU2AjQ./sHIImuyurpM9xXXlPH/EZmjqusAzpNbQlBkfq/.', NULL, 1, 1);

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
  ADD KEY `documento` (`documento`),
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
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
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
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalles_estudiantes_escuela`
--
ALTER TABLE `detalles_estudiantes_escuela`
  MODIFY `id_det_students_esc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  MODIFY `id_det_menu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_producto`
--
ALTER TABLE `detalles_pedidos_producto`
  MODIFY `id_det_ped_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  MODIFY `id_estado_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `informacion_nutricional`
--
ALTER TABLE `informacion_nutricional`
  MODIFY `id_nutricion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marca` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` smallint(4) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `detalles_estudiantes_escuela_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuarios` (`documento`) ON DELETE CASCADE ON UPDATE CASCADE,
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
-- Filtros para la tabla `estado_licencia`
--
ALTER TABLE `estado_licencia`
  ADD CONSTRAINT `estado_licencia_ibfk_1` FOREIGN KEY (`id_licencia`) REFERENCES `licencia` (`id_licencia`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_licencia` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `licencia_ibfk_2` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

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
