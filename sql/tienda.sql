-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-01-2020 a las 01:13:18
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda`
--
CREATE DATABASE IF NOT EXISTS `tienda` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tienda`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captcha`
--
-- Creación: 15-01-2020 a las 14:16:21
-- Última actualización: 15-01-2020 a las 14:16:21
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE `captcha` (
  `ID` int(3) NOT NULL,
  `PREGUNTA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `RESPUESTA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `captcha`:
--

--
-- Volcado de datos para la tabla `captcha`
--

INSERT INTO `captcha` (`ID`, `PREGUNTA`, `RESPUESTA`) VALUES
(10, '¿Cuantos lados tiene un triangulo?', '3'),
(11, '¿Que fruta es el logo de Apple?', 'MANZANA'),
(12, '¿Dale a tu cuerpo alegria...?', 'MACARENA'),
(13, '(Darkvader) Yo soy tu...', 'PADRE'),
(14, 'El patio de mi casa es...', 'PARTICULAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasventas`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `lineasventas`;
CREATE TABLE `lineasventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idProducto` int(11) NOT NULL,
  `marca` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `lineasventas`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--
-- Creación: 15-01-2020 a las 14:16:21
-- Última actualización: 15-01-2020 a las 14:16:21
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `ID` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `USUARIO` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CODPRODUCTO` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `CANTIDAD` int(5) DEFAULT NULL,
  `FECHA` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `pedidos`:
--

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID`, `USUARIO`, `CODPRODUCTO`, `CANTIDAD`, `FECHA`) VALUES
('MARIA475956', 'MARIA', 'DI261172', 1, '23/10/2015');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `TIPO` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'OTROS',
  `MARCA` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `MODELO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DESCRIPCION` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `PRECIO` float NOT NULL,
  `STOCK` int(5) NOT NULL,
  `OFERTA` tinyint(1) NOT NULL,
  `FOTO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `productos`:
--

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `TIPO`, `MARCA`, `MODELO`, `DESCRIPCION`, `PRECIO`, `STOCK`, `OFERTA`, `FOTO`) VALUES
(1, 'Disco Duro', 'Seagate', 'BarraCuda', 'Capacidad de disco duro: 3000 GB\r\nInterfaz del disco duro: Serial ATA III\r\nVelocidad de rotación de disco duro: 7200 RPM\r\nTamaño de disco duro: 3.5', 80.2, 0, 0, '8f0dde4b587babdcf255396e4392e0e3.png'),
(2, 'Disco Duro', 'Seagate', 'BarraCuda', 'Capacidad de disco duro: 2000 GB.\r\n Interfaz del disco duro: Serial ATA III.\r\n Velocidad de rotación de disco duro: 7200 RPM.\r\n Tamaño de disco duro: 3.5.\r\n', 69.59, 5, 1, '59d776f0685c719b3e58a24f1e91f5e8.png'),
(3, 'Disco Duro', 'Wenster Digital', 'Blue', 'Capacidad de disco duro: 2000 GB.\r\n Interfaz del disco duro: Serial ATA III.\r\n Velocidad de rotación de disco duro: 7200 RPM.\r\n Tamaño de disco duro: 3.5.\r\n', 60, 3, 0, 'ebfe560e85e2d92ede1399b89dfef0cf.png'),
(4, 'Disco Duro', 'Samsung', '860 EVO', 'Capacidad de disco duro: 256 GB.\r\nTecnología: SSD.\r\nInterfaz del disco duro: Serial ATA III.\r\nVelocidad de rotación de disco duro: 7200 RPM.\r\nTamaño de disco duro: 2.5.\r\n', 84.99, 4, 0, 'b0b3aa649cad3a1e3f8a488426d8b3c3.png'),
(5, 'Monitor', 'Lacie', 'E2470SWH', 'General.\r\nLínea monitor Value-line.\r\nTamaño monitor 23.6 Inch.\r\nTamaño visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResolución Resolución máxima 1920x1080@60Hz.\r\nResolución recomendada 1920x1080@60Hz.\r\nColores 16.7 Million', 125, 5, 0, '60039c903096049e9a6d318051251207.png'),
(6, 'Monitor', 'Quatto', 'Q2765AV', 'General.\r\nLínea monitor Value-line.\r\nTamaño monitor 27.2 Inch.\r\nFormato de pantalla 16:9.\r\nResolución Resolución máxima  2560 x 1440@60Hz.\r\nResolución recomendada  2560 x 1440@60Hz.\r\nColores 13Million', 451, 5, 1, 'c0316d3a124eca393507adb9ee31f9c4.png'),
(7, 'Monitor', 'Barco', 'B123DERHD', 'General.\r\nLínea monitor Value-line.\r\nTamaño monitor 23.6 Inch.\r\nTamaño visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResolución Resolución máxima 1920x1080@60Hz.\r\nResolución recomendada 1920x1080@60Hz.\r\nColores 16.7 Million', 154.99, 5, 1, 'fe6c6b3ca76d81a3b3ff3f7b24a86764.png'),
(8, 'Monitor', 'Dell', 'U2715', 'General.\r\nLínea monitor Value-line.\r\nTamaño monitor 27.2 Inch.\r\nFormato de pantalla 16:9.\r\nResolución Resolución máxima  2560 x 1440@60Hz.\r\nResolución recomendada  2560 x 1440@60Hz.\r\nColores 13Million', 450, 5, 1, 'a2e8681f10a32932c476b79e2ba56931.png'),
(9, 'Portatil', 'ASUS', 'D540NA-GQ059T', 'Con Windows 10.\r\nPantalla HD de 15,6\" - 39,62 cm.\r\nProcesador Intel Celeron N3350.\r\n4 GB de memoria RAM LPDDR3.\r\nAlmacenamiento 500 GB HDD', 339, 10, 0, '9852134efc456262206bdaf1d72f3b01.png'),
(10, 'Portatil', 'Acer', 'Predator Helios 300', 'Procesador Intel Core i7-8750H (6 núcleos, 2.2GHz - 4.1GHz, 9MB).\r\nMemoria 16 GB DDR4 Memory.\r\nAlmacenamiento 1000 GB HDD + 256GB SSD.\r\nDisplay 17.3\" FHD Acer ComfyView IPS LCD 16:9 FHD IPS (1920 x 1080).\r\nControlador gráfico NVIDIA GeForce GTX 1050Ti.\r\nConectividad 802.11ac Bluetooth 5.0', 1079.01, 2, 0, 'bb064b4f61f6e66b8776894c8a3ec2c1.png'),
(11, 'Portatil', 'HP', 'Notebook 250 G6', 'Procesador Intel Core i5-7200U (2 Núcleos, 3M Cache, 2.5GHz hasta 3.1GHz).\r\nMemoria RAM SDRAM DDR4-2133 de 8 GB.\r\nDisco duro 256 GB SSD.\r\nAlmacenamiento Óptico Grabadora de DVD SuperMulti.\r\nDisplay Pantalla fina FHD SVA eDP de 39,6 cm (15,6 pulg.) en diagonal, antirreflejo, WLED (1920 x 1080).\r\nControlador gráfico Intel HD 620 Conectividad 10/100/1000 Gigabit Combo de Intel Dual Band Wireless-AC 3168 802.11 a/b/g/n/ac (1x1) Wi-Fi y Bluetooth 4.2 (no vPro)', 559, 5, 1, '0624f58af16cce5616ee3c7291bd7859.png'),
(12, 'Portatil', 'DELL', 'Vostro 5568', 'Procesador Intel Core i5-7200U (2.5 GHz, 3 MB).\r\nMemoria RAM 8GB DDR4 SODIMM.\r\nDisco duro 256 GB SSD.\r\nDisplay 15.6\" LED FullHD (1920 x 1080) 16:9 Mate.\r\nControlador gráfico Intel HD Graphics620.\r\nConectividad LAN 10/100/1000 WiFi 802.11 ac Bluetooth V4.2 High Speed', 769.69, 3, 1, '0693a3b823f9005071fc8603dc75a6bf.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tipo`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `producto_tipo`;
CREATE TABLE `producto_tipo` (
  `TIPO` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `producto_tipo`:
--

--
-- Volcado de datos para la tabla `producto_tipo`
--

INSERT INTO `producto_tipo` (`TIPO`) VALUES
('Monitor'),
('Otros'),
('Portatil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 15-01-2020 a las 14:16:22
-- Última actualización: 15-01-2020 a las 23:10:56
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `ALIAS` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `PASS` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `EMAIL` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECCION` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FOTO` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ADMIN` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `ALIAS`, `PASS`, `EMAIL`, `DIRECCION`, `FOTO`, `ADMIN`) VALUES
(1, 'pepe', 'pepe', '926e27eecdbc7a18858b3798ba99bddd', 'pepe@pepe.com', 'pepilandia2', '27f07ce08ad6d47ffc5694bec8319bcb.jpeg', 1),
(10, 'Prueba', 'prueba', 'c893bad68927b457dbed39460e6afd62', 'prueba@prueba.com', 'prueba44', 'fcca0c9e6d311123ea8c7cef8cc708da.jpeg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `total` float NOT NULL,
  `subtotal` float NOT NULL,
  `iva` float NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombreTarjeta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `numTarejta` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- RELACIONES PARA LA TABLA `ventas`:
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lineasventas`
--
ALTER TABLE `lineasventas`
  ADD PRIMARY KEY (`idVenta`,`idProducto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_pro_tipo` (`TIPO`);

--
-- Indices de la tabla `producto_tipo`
--
ALTER TABLE `producto_tipo`
  ADD PRIMARY KEY (`TIPO`),
  ADD UNIQUE KEY `TIPO` (`TIPO`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
