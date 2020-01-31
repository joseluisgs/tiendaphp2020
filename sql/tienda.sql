-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-01-2020 a las 10:29:14
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
-- Estructura de tabla para la tabla `lineasventas`
--
-- Creación: 28-01-2020 a las 12:15:16
-- Última actualización: 31-01-2020 a las 08:58:59
--

DROP TABLE IF EXISTS `lineasventas`;
CREATE TABLE IF NOT EXISTS `lineasventas`
(
    `idVenta`    varchar(20) COLLATE utf8_unicode_ci  NOT NULL,
    `idProducto` int(11)                              NOT NULL,
    `marca`      varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `modelo`     varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `precio`     float                                NOT NULL,
    `cantidad`   int(11)                              NOT NULL,
    PRIMARY KEY (`idVenta`, `idProducto`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineasventas`
--

INSERT INTO `lineasventas` (`idVenta`, `idProducto`, `marca`, `modelo`, `precio`, `cantidad`)
VALUES ('200128-033621', 5, 'Lacie', 'E2470SWH', 125, 1),
       ('200128-033621', 17, 'PS4', 'Dragon Ball Kakarot', 10, 1),
       ('200128-033717', 1, 'Seagate', 'BarraCuda', 72.56, 1),
       ('200128-033717', 17, 'PS4', 'Dragon Ball Kakarot', 10, 1),
       ('200129-095041', 8, 'Dell', 'U2715', 450, 2),
       ('200129-095041', 17, 'PS4', 'Dragon Ball Kakarot', 10.78, 2),
       ('200131-093602', 5, 'Lacie', 'E2470SWH', 125, 1),
       ('200131-093602', 17, 'PS4', 'Dragon Ball Kakarot', 10.78, 2),
       ('200131-094217', 5, 'Lacie', 'E2470SWH', 125, 1),
       ('200131-095859', 5, 'Lacie', 'E2470SWH', 125, 1),
       ('200131-095859', 8, 'Dell', 'U2715', 450, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--
-- Creación: 17-01-2020 a las 16:34:24
-- Última actualización: 31-01-2020 a las 08:58:59
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos`
(
    `ID`          int(11)                                                  NOT NULL AUTO_INCREMENT,
    `TIPO`        varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci   NOT NULL DEFAULT 'OTROS',
    `MARCA`       varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci  NOT NULL,
    `MODELO`      varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci  NOT NULL,
    `DESCRIPCION` varchar(1000) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `PRECIO`      float                                                    NOT NULL,
    `STOCK`       int(11)                                                  NOT NULL,
    `OFERTA`      int(11)                                                  NOT NULL,
    `IMAGEN`      varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci  NOT NULL,
    `DISPONIBLE`  int(11)                                                  NOT NULL,
    `FECHA`       datetime                                                 NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `fk_pro_tipo` (`TIPO`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 19
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `TIPO`, `MARCA`, `MODELO`, `DESCRIPCION`, `PRECIO`, `STOCK`, `OFERTA`, `IMAGEN`,
                         `DISPONIBLE`, `FECHA`)
VALUES (1, 'Otros', 'Seagate', 'BarraCuda',
        'Capacidad de disco duro: 3000 GB\r\nInterfaz del disco duro: Serial ATA III\r\nVelocidad de rotaciÃ³n de disco duro: 7200 RPM\r\nTamaÃ±oo de disco duro: 3.5',
        72.56, 2, 5, '2e888819f42d735177a1dcc39a5e48b.jpg', 1, '2020-01-06 00:00:00'),
       (2, 'Otros', 'Seagate', 'BarraCuda',
        'Capacidad de disco duro: 2000 GB.\r\n Interfaz del disco duro: Serial ATA III.\r\n Velocidad de rotaciÃ³n de disco duro: 7200 RPM.\r\n TamaÃ±oo de disco duro: 3.5.',
        69.59, 0, 10, '3e888819f42d735177a1dcc39a5e48b.jpg', 1, '2020-01-06 00:00:00'),
       (3, 'Otros', 'Wenster Digital', 'Blue',
        'Capacidad de disco duro: 2000 GB.\r\n Interfaz del disco duro: Serial ATA III.\r\n Velocidad de rotaciÃ³n de disco duro: 7200 RPM.\r\n TamaÃ±o de disco duro: 3.5.',
        60, 3, 0, '81INYQ6K4JL._SL1500_.jpg', 1, '2020-01-06 00:00:00'),
       (5, 'Monitor', 'Lacie', 'E2470SWH',
        'General.\r\nLÃ­nea monitor Value-line.\r\nTamaÃ±o monitor 23.6 Inch.\r\nTamaÃ±o visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResoluciÃ³n ResoluciÃ³n mÃ¡xima 1920x1080@60Hz.\r\nResoluciÃ³n recomendada 1920x1080@60Hz.\r\nColores 16.7 Million',
        125, 1, 15, '324i-3Qtr.jpg', 1, '2020-01-06 00:00:00'),
       (6, 'Monitor', 'Quatto', 'Q2765AV',
        'General.\r\nLÃ­nea monitor Value-line.\r\nTamaÃ±o monitor 23.6 Inch.\r\nTamaÃ±o visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResoluciÃ³n ResoluciÃ³n mÃ¡xima 1920x1080@60Hz.\r\nResoluciÃ³n recomendada 1920x1080@60Hz.\r\nColores 16.7 Million',
        451, 0, 10, 'monitor_frontalquato.jpg', 1, '2020-01-06 00:00:00'),
       (7, 'Monitor', 'Barco', 'B123DERHD',
        'General.\r\nLÃ­nea monitor Value-line.\r\nTamaÃ±o monitor 23.6 Inch.\r\nTamaÃ±o visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResoluciÃ³n ResoluciÃ³n mÃ¡xima 1920x1080@60Hz.\r\nResoluciÃ³n recomendada 1920x1080@60Hz.\r\nColores 16.7 Million',
        154.99, 5, 0, 'Barco-MDNC-6121-pair.jpg', 1, '2020-01-06 00:00:00'),
       (8, 'Monitor', 'Dell', 'U2715',
        'General.\r\nLÃ­nea monitor Value-line.\r\nTamaÃ±o monitor 23.6 Inch.\r\nTamaÃ±o visible de pantalla 521.28x293.32.\r\nFormato de pantalla 16:9.\r\nResoluciÃ³n ResoluciÃ³n mÃ¡xima 1920x1080@60Hz.\r\nResoluciÃ³n recomendada 1920x1080@60Hz.\r\nColores 16.7 Million',
        450, 2, 5, 'monitordell.jpg', 1, '2020-01-06 00:00:00'),
       (9, 'Ordenador', 'ASUS', 'D540NA-GQ059T',
        'Con Windows 10.\r\nPantalla HD de 15,6&quot; - 39,62 cm.\r\nProcesador Intel Celeron N3350.\r\n4 GB de memoria RAM LPDDR3.\r\nAlmacenamiento 500 GB HDD',
        339, 10, 0, '717MqexvCQL._SX425_.jpg', 0, '2020-01-06 00:00:00'),
       (10, 'Ordenador', 'Acer', 'Predator Helios 300',
        'Procesador Intel Core i7-8750H (6 nÃºcleos, 2.2GHz - 4.1GHz, 9MB).\r\nMemoria 16 GB DDR4 Memory.\r\nAlmacenamiento 1000 GB HDD + 256GB SSD.\r\nDisplay 17.3&quot; FHD Acer ComfyView IPS LCD 16:9 FHD IPS (1920 x 1080).\r\nControlador grÃ¡fico NVIDIA GeForce GTX 1050Ti.\r\nConectividad 802.11ac Bluetooth 5.0',
        1079.01, 2, 0, '37520.jpg', 1, '2020-01-06 00:00:00'),
       (11, 'Ordenador', 'HP', 'Notebook 250 G6',
        'Procesador Intel Core i5-7200U (2 NÃºcleos, 3M Cache, 2.5GHz hasta 3.1GHz).\r\nMemoria RAM SDRAM DDR4-2133 de 8 GB.\r\nDisco duro 256 GB SSD.\r\nAlmacenamiento Ã³ptico Grabadora de DVD SuperMulti.\r\nDisplay Pantalla fina FHD SVA eDP de 39,6 cm (15,6 pulg.) en diagonal, antirreflejo, WLED (1920 x 1080).\r\nControlador grÃ¡fico Intel HD 620 Conectividad 10/100/1000 Gigabit Combo de Intel Dual Band Wireless-AC 3168 802.11 a/b/g/n/ac (1x1) Wi-Fi y Bluetooth 4.2 (no vPro)',
        559, 5, 0, '71kZvPAj6ZL._SX466_.jpg', 1, '2020-01-06 00:00:00'),
       (12, 'Ordenador', 'DELL', 'Vostro 5568',
        'Procesador Intel Core i5-7200U (2.5 GHz, 3 MB).\r\nMemoria RAM 8GB DDR4 SODIMM.\r\nDisco duro 256 GB SSD.\r\nDisplay 15.6&quot; LED FullHD (1920 x 1080) 16:9 Mate.\r\nControlador grÃ¡fico Intel HD Graphics620.\r\nConectividad LAN 10/100/1000 WiFi 802.11 ac Bluetooth V4.2 High Speed',
        769.69, 3, 10, 'dellvostro.jpg', 1, '2020-01-06 00:00:00'),
       (16, 'Ordenador', 'Prueba', 'Prueba', 'Prueba Ã‘Ã‘', 23, 2, 20, '1e5999919f42d735177a1dcc39a5e48b.jpeg', 1,
        '2020-01-16 00:00:00'),
       (17, 'Otros', 'PS4', 'Dragon Ball Kakarot', 'Videjuego de PS4 y PC', 10.78, 3, 15,
        '866695b6a16d70dbc3c7769c0516d703.jpeg', 1, '2020-01-17 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_tipo`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `producto_tipo`;
CREATE TABLE IF NOT EXISTS `producto_tipo`
(
    `TIPO` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    PRIMARY KEY (`TIPO`),
    UNIQUE KEY `TIPO` (`TIPO`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto_tipo`
--

INSERT INTO `producto_tipo` (`TIPO`) VALUES
('Monitor'),
('Ordenador'),
('Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--
-- Creación: 15-01-2020 a las 14:16:22
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios`
(
    `ID`        int(11)                                                 NOT NULL AUTO_INCREMENT,
    `NOMBRE`    varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
    `ALIAS`     varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
    `PASS`      varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `EMAIL`     varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `DIRECCION` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `FOTO`      varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `ADMIN`     tinyint(1)                                              NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 14
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `ALIAS`, `PASS`, `EMAIL`, `DIRECCION`, `FOTO`, `ADMIN`)
VALUES (1, 'pepe', 'pepe', '926e27eecdbc7a18858b3798ba99bddd', 'pepe@pepe.com', 'pepilandia2',
        '27f07ce08ad6d47ffc5694bec8319bcb.jpeg', 1),
       (10, 'Prueba', 'prueba', 'c893bad68927b457dbed39460e6afd62', 'prueba@prueba.com', 'prueba55',
        'fcca0c9e6d311123ea8c7cef8cc708da.jpeg', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--
-- Creación: 28-01-2020 a las 12:55:11
-- Última actualización: 31-01-2020 a las 08:58:59
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas`
(
    `idVenta`       varchar(20) COLLATE utf8_unicode_ci  NOT NULL,
    `fecha`         datetime                             NOT NULL DEFAULT current_timestamp(),
    `total`         float                                NOT NULL,
    `subtotal`      float                                NOT NULL,
    `iva`           float                                NOT NULL,
    `nombre`        varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `email`         varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `direccion`     varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `nombreTarjeta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `numTarjeta`    varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`idVenta`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `fecha`, `total`, `subtotal`, `iva`, `nombre`, `email`, `direccion`, `nombreTarjeta`,
                      `numTarjeta`)
VALUES ('200128-033621', '2020-01-28 15:36:21', 135, 111.57, 23.43, 'pepe', 'pepe@pepe.com', 'pepilandia2', 'Pepe',
        '1234123412341234'),
       ('200128-033717', '2020-01-28 15:37:17', 82.56, 68.23, 14.33, 'pepe', 'pepe@pepe.com', 'pepilandia2',
        'Pepe Perez', '1234123412341234'),
       ('200129-095041', '2020-01-29 09:50:41', 900, 743.8, 156.2, 'pepe', 'pepe@pepe.com', 'pepilandia2',
        'Pedro perez', '1234123412341234'),
       ('200131-093602', '2020-01-31 09:36:02', 146.56, 121.12, 25.44, 'pepe', 'pepe@pepe.com', 'pepilandia2',
        'Pepe Perez', '1234123412341234'),
       ('200131-094217', '2020-01-31 09:42:17', 125, 103.31, 21.69, 'pepe', 'pepe@pepe.com', 'pepilandia2',
        'Perico Palotes', '1234123412341234'),
       ('200131-095859', '2020-01-31 09:58:59', 575, 475.21, 99.79, 'pepe', 'pepe@pepe.com', 'pepilandia2',
        'Pedro Lopez', '1234567812345678');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
