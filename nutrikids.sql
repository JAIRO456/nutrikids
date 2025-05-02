-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-01-2025 a las 06:02:49
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
  `categoria` set('BEBIDAS FRIAS','BEBIDAS CALIENTES','POSTRES','FRUTAS','PANES') NOT NULL,
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
(5, 'PANES', 'panes.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles ventas`
--

CREATE TABLE `detalles ventas` (
  `id_det_vent` int(8) NOT NULL,
  `cantidad` bigint(10) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_menu`
--

CREATE TABLE `detalles_menu` (
  `id_det_menu` int(11) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `documento_est` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
  `id_pedidos` int(11) NOT NULL,
  `id_estado` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` smallint(3) NOT NULL,
  `nombre_escuela` set('Colegio Santa Teresa De Jesús','Colegio ExAlumnas de la Presentación','Institución Educativa Juan Lozano y Lozano Sección Secundaria','Colegio Americano de Ibagué','Colegio Franciscano Jiménez de Cisneros','Colegio Cristiano La Sabiduria','Colegio San Simón','Colegio Champagnat','Colegio Charles Dickens','Institución Educativa Tecnica La Sagrada Familia','Colegio Liceo Nacional','Colegio Maria Montessori sede Primaria','C-F-J') NOT NULL,
  `imagen_esc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id_escuela`, `nombre_escuela`, `imagen_esc`) VALUES
(1, 'C-F-J', 'logo-remove.png'),
(2, 'Colegio ExAlumnas de la Presentación', ''),
(3, 'Institución Educativa Juan Lozano y Lozano Sección Secundaria', ''),
(4, 'Colegio Americano de Ibagué', ''),
(5, 'Colegio Franciscano Jiménez de Cisneros', ''),
(6, 'Colegio Cristiano La Sabiduria', ''),
(7, 'Colegio San Simón', ''),
(8, 'Colegio Champagnat', ''),
(9, 'Colegio Charles Dickens', ''),
(10, 'Institución Educativa Tecnica La Sagrada Familia', ''),
(11, 'Colegio Liceo Nacional', ''),
(12, 'Colegio Maria Montessori sede Primaria', ''),
(13, 'Colegio Santa Teresa De Jesús', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` smallint(4) NOT NULL,
  `estado` set('pendiente','entregado','activo','inactivo','no entregado') NOT NULL,
  `fechas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`, `fechas`) VALUES
(1, 'activo', '0000-00-00 00:00:00'),
(2, 'inactivo', '0000-00-00 00:00:00'),
(3, 'pendiente', '0000-00-00 00:00:00'),
(4, 'entregado', '0000-00-00 00:00:00'),
(5, 'no entregado', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(4) NOT NULL,
  `cantidad_fact` int(11) NOT NULL,
  `fecha_fact` datetime NOT NULL,
  `valor_fact` decimal(10,5) NOT NULL,
  `id_met_pago` smallint(4) NOT NULL,
  `id_producto` bigint(10) NOT NULL,
  `id_documento` int(11) NOT NULL,
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marcas` smallint(6) NOT NULL,
  `marca` set('Kant1','Kantt2','Kanttt3','Kantttt4','Kanttttt5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marcas`, `marca`) VALUES
(1, 'Kant1'),
(2, 'Kantt2'),
(3, 'Kanttt3'),
(4, 'Kantttt4'),
(5, 'Kanttttt5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `nombre_men` varchar(25) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `nombre_men`, `precio`) VALUES
(1, 'menu_Alex', 15500.00),
(2, 'menu_Juliana', 55000.00),
(3, 'menu_Laura', 25400.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos de pago`
--

CREATE TABLE `metodos de pago` (
  `id_met_pago` smallint(4) NOT NULL,
  `met_pago` set('tarjeta credito','tarjeta debido','billetera digital','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos de pago`
--

INSERT INTO `metodos de pago` (`id_met_pago`, `met_pago`) VALUES
(1, 'tarjeta credito'),
(2, 'tarjeta debido'),
(3, 'billetera digital'),
(4, 'tarjeta credito'),
(5, 'tarjeta debido'),
(6, 'billetera digital');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedidos` int(11) NOT NULL,
  `dias_sem` set('lunes','martes','miercoles','jueves','viernes') NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedidos`, `dias_sem`, `fecha`) VALUES
(1, 'lunes', '2025-01-06 16:32:17'),
(2, 'martes', '2025-01-06 16:32:17'),
(3, 'miercoles', '2025-01-06 16:32:17'),
(4, 'jueves', '2025-01-09 19:30:51'),
(5, 'viernes', '2025-01-09 19:30:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` bigint(10) NOT NULL,
  `nombre_prod` varchar(25) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen` varchar(500) NOT NULL,
  `cantidad_alm` bigint(8) NOT NULL,
  `id_categoria` smallint(4) NOT NULL,
  `id_marca` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_prod`, `descripcion`, `precio`, `imagen`, `cantidad_alm`, `id_categoria`, `id_marca`) VALUES
(1, 'Café Espresso', 'Café intenso y concentrado', 1000, 'cafe_espresso.jpg', 100, 2, 1),
(2, 'Café Americano', 'Café suave con agua caliente', 1500, 'cafe_americano.jpg', 150, 2, 1),
(3, 'Café Capuchino', 'Café con leche espumosa y cacao', 2000, 'cafe_capuchino.jpg', 120, 2, 1),
(4, 'Yogur', 'Yogur de fresa', 2500, 'latte_macchiato.jpg', 80, 3, 2),
(5, 'Leche', 'Leche con chocolate', 3000, 'mocha.jpg', 60, 3, 2),
(6, 'Tarta de Manzana', 'Tarta de manzana con canela y masa crujiente', 3500, 'tarta_manzana.jpg', 50, 3, 3),
(7, 'Croissant de Chocolate', 'Croissant relleno de chocolate', 4000, 'croissant_chocolate.jpg', 200, 5, 3),
(8, 'Pan de Jamón y Queso', 'Baguette con jamón y queso fundido', 4500, 'baguette_jamon_queso.jpg', 30, 5, 4),
(9, 'Sándwich Vegetariano', 'Sándwich con verduras frescas y hummus', 5000, 'sandwich_vegetariano.jpg', 40, 5, 4),
(10, 'Café Frappuccino', 'Café helado con crema y sirope', 5500, 'cafe_frappuccino.jpg', 70, 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` smallint(5) NOT NULL,
  `rol` set('administrador','vendedor','acudiente','director','estudiante') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'administrador'),
(2, 'director'),
(3, 'vendedor'),
(4, 'acudiente'),
(5, 'estudiante');

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
  `imagen` varchar(500) NOT NULL,
  `id_escuela` smallint(3) NOT NULL,
  `id_rol` smallint(5) NOT NULL,
  `id_estado` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documento`, `nombre`, `apellido`, `email`, `telefono`, `imagen`, `id_escuela`, `id_rol`, `id_estado`) VALUES
(123, 'Kant', 'Arboles', 'kantarboles@example.com', 321, '', 1, 1, 1),
(124, 'Fabian', 'nosexd', 'fabian@example.com', 323, '', 1, 3, 2),
(125, 'Ana', 'Victoria', 'anavictoria@example.com', 325, '', 2, 3, 1),
(126, 'Andres', 'Pendejo', 'andrespendejo@example.com', 326, '', 11, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(8) NOT NULL,
  `fecha_vent` datetime NOT NULL,
  `valor_vent` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `id_documento` int(8) NOT NULL,
  `id_met_pago` smallint(6) NOT NULL,
  `id_estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalles ventas`
--
ALTER TABLE `detalles ventas`
  ADD PRIMARY KEY (`id_det_vent`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  ADD PRIMARY KEY (`id_det_menu`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `documento` (`documento_est`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_pedidos` (`id_pedidos`),
  ADD KEY `id_estado` (`id_estado`);

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
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_documento` (`id_documento`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_met_pago` (`id_met_pago`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marcas`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `metodos de pago`
--
ALTER TABLE `metodos de pago`
  ADD PRIMARY KEY (`id_met_pago`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedidos`);

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `usuarios_ibfk_3` (`id_escuela`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_documento` (`id_documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalles ventas`
--
ALTER TABLE `detalles ventas`
  MODIFY `id_det_vent` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marcas` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `metodos de pago`
--
ALTER TABLE `metodos de pago`
  MODIFY `id_met_pago` smallint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles ventas`
--
ALTER TABLE `detalles ventas`
  ADD CONSTRAINT `detalles ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `detalles_menu`
--
ALTER TABLE `detalles_menu`
  ADD CONSTRAINT `detalles_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_2` FOREIGN KEY (`documento_est`) REFERENCES `estudiantes` (`documento_est`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_4` FOREIGN KEY (`id_pedidos`) REFERENCES `pedidos` (`id_pedidos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalles_menu_ibfk_5` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `usuarios` (`documento`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`id_met_pago`) REFERENCES `metodos de pago` (`id_met_pago`),
  ADD CONSTRAINT `factura_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marcas`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_documento`) REFERENCES `usuarios` (`documento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
