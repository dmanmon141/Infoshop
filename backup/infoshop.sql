-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2025 a las 11:57:30
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
-- Base de datos: `infoshop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `CATCOD` int(5) NOT NULL,
  `CATNOM` varchar(20) NOT NULL,
  `CATDESC` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`CATCOD`, `CATNOM`, `CATDESC`) VALUES(1, 'GPU', 'Tarjetas gráficas chulonas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `USUCOD` int(5) NOT NULL,
  `DATOSNOM` varchar(25) NOT NULL,
  `DATOSAPE` varchar(60) NOT NULL,
  `DATOSTAR` varchar(16) NOT NULL,
  `DATOSCAD` varchar(5) NOT NULL,
  `DATOSCODSEG` int(3) NOT NULL,
  `DATOSCIU` varchar(80) NOT NULL,
  `DATOSDIR` varchar(200) NOT NULL,
  `DATOSCP` int(5) NOT NULL,
  `DATOSPAIS` varchar(60) NOT NULL,
  `DATOSTEL` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `DEVCOD` int(5) NOT NULL,
  `DEVRAZ` varchar(20) NOT NULL,
  `DEVDET` text NOT NULL,
  `PEDCOD` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `devoluciones`
--

INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(0, 'Decepcion', 'Holaaaaaaaa', 0);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(1, 'Decepcion', 'Hola que tal?', 1);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(2, 'Arrepentir', 'Mequivocao jajajja', 2);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(3, 'Defectuoso', 'sadas', 2);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(4, 'Defectuoso', 'dwa', 2);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(5, 'Defectuoso', 'dwasd', 2);
INSERT INTO `devoluciones` (`DEVCOD`, `DEVRAZ`, `DEVDET`, `PEDCOD`) VALUES(6, 'Defectuoso', 'dwada', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `MENID` int(5) NOT NULL,
  `MENCONT` text NOT NULL,
  `MENFEC` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL,
  `TICKID` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`MENID`, `MENCONT`, `MENFEC`, `USUCOD`, `TICKID`) VALUES(3, 'Hola, soy Daniel Manzano, técnico de Infoshop. En qué puedo ayudarle hoy??', '2025-06-03 11:07:36', 2, '5055a9c9906cf8fb66b4bb455804c8ca');
INSERT INTO `mensajes` (`MENID`, `MENCONT`, `MENFEC`, `USUCOD`, `TICKID`) VALUES(4, 'Pues como le comentaba, me duele la barriga y pensé que aquí me podríais ayudar.', '2025-06-03 11:12:11', 1, '5055a9c9906cf8fb66b4bb455804c8ca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `NOTCOD` int(5) NOT NULL,
  `NOTNOM` varchar(30) NOT NULL,
  `NOTDESC` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`NOTCOD`, `NOTNOM`, `NOTDESC`) VALUES(1, 'Devolución', 'Paquete devuelto. Alerta informativa, no es necesaria ninguna acción.');
INSERT INTO `notificaciones` (`NOTCOD`, `NOTNOM`, `NOTDESC`) VALUES(2, 'Reemplazo', 'Producto reemplazado. Alerta informativa, no es necesaria ninguna acción.');
INSERT INTO `notificaciones` (`NOTCOD`, `NOTNOM`, `NOTDESC`) VALUES(3, 'Ticket usuario', 'Ticket de usuario abierto. Atender lo antes posible.');
INSERT INTO `notificaciones` (`NOTCOD`, `NOTNOM`, `NOTDESC`) VALUES(4, 'Reseña reportada', 'Reseña reportada por un usuario. Comprobar y moderar adecuadamente.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paneladmin`
--

CREATE TABLE `paneladmin` (
  `ADMCOD` int(5) NOT NULL,
  `ADMCONT` varchar(120) NOT NULL,
  `NOTCOD` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `paneladmin`
--

INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(0, '2147483647', 1);
INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(1, '683', 3);
INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(2, 'Código de pedido: 2', 1);
INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(3, 'Pedido con código 2 reenviado a la dirección: Espa', 2);
INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(4, 'Pedido con código 2 reenviado a la dirección: Espa', 2);
INSERT INTO `paneladmin` (`ADMCOD`, `ADMCONT`, `NOTCOD`) VALUES(5, 'Pedido con código 2 reenviado a la dirección: Espa', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `PEDCOD` int(5) NOT NULL,
  `PEDFECCOMP` date NOT NULL,
  `PEDFECDEV` date NOT NULL,
  `USUCOD` int(5) NOT NULL,
  `PRODCOD` int(5) NOT NULL,
  `PEDEST` varchar(30) NOT NULL,
  `PEDTAR` varchar(16) NOT NULL,
  `PEDCAD` varchar(5) NOT NULL,
  `PEDCODSEG` int(3) NOT NULL,
  `PEDCIU` varchar(40) NOT NULL,
  `PEDDIR` varchar(100) NOT NULL,
  `PEDCP` int(5) NOT NULL,
  `PEDPAIS` varchar(50) NOT NULL,
  `PEDTEL` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(0, '2025-06-02', '2025-07-02', 1, 1, 'Devuelto', '1245243578439481', '51/21', 231, 'Algeciras', 'Avda. Virgen de la macarena 22', 11202, 'España', '657839102');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(1, '2025-06-03', '2025-07-03', 1, 4, 'Devuelto', '4534125676874976', '03/21', 145, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(2, '2025-06-03', '2025-07-03', 1, 3, 'Reemplazado', '4534125676874976', '03/22', 132, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(3, '2025-06-03', '2025-07-03', 1, 3, 'En envío', '4534125676874976', '03/22', 132, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(4, '2025-06-03', '2025-07-03', 1, 3, 'En envío', '4534125676874976', '03/22', 132, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(5, '2025-06-03', '2025-07-03', 1, 3, 'En envío', '4534125676874976', '03/22', 132, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(6, '2025-06-03', '2025-07-03', 1, 3, 'En envío', '4534125676874976', '03/22', 132, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(7, '2025-06-03', '2025-07-03', 1, 1, 'En envío', '4534125676874976', '03/22', 134, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(8, '2025-06-03', '2025-07-03', 1, 2, 'En envío', '4534125676874976', '03/22', 143, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');
INSERT INTO `pedidos` (`PEDCOD`, `PEDFECCOMP`, `PEDFECDEV`, `USUCOD`, `PRODCOD`, `PEDEST`, `PEDTAR`, `PEDCAD`, `PEDCODSEG`, `PEDCIU`, `PEDDIR`, `PEDCP`, `PEDPAIS`, `PEDTEL`) VALUES(9, '2025-06-03', '2025-07-03', 1, 3, 'En envío', '4534125676874976', '02/24', 125, 'Algeciras', 'hOLAAA', 11202, 'España', '656892302');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `PRODCOD` int(5) NOT NULL,
  `PRODIMG` varchar(50) NOT NULL,
  `PRODNOM` varchar(50) NOT NULL,
  `PRODDESC` text NOT NULL,
  `PRODPREC` float NOT NULL,
  `PRODINV` int(11) NOT NULL,
  `PRODOFE` int(11) NOT NULL,
  `PRODNUMVENT` int(11) NOT NULL,
  `PRODPRECORI` float NOT NULL,
  `PRODVAL` float NOT NULL,
  `CATCOD` int(11) NOT NULL,
  `PROCOD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`PRODCOD`, `PRODIMG`, `PRODNOM`, `PRODDESC`, `PRODPREC`, `PRODINV`, `PRODOFE`, `PRODNUMVENT`, `PRODPRECORI`, `PRODVAL`, `CATCOD`, `PROCOD`) VALUES(1, 'img/productos/grafica1.png', 'Gigabyte NVIDIA RTX 3080 Ti 6GB DDR5', 'Potente gráfica RTX 3060 12GB GDDR6 con Ray Tracing y DLSS. Ideal para gaming 1080p/1440p fluido.', 250, 60, 50, 280, 500, 5, 1, 1);
INSERT INTO `productos` (`PRODCOD`, `PRODIMG`, `PRODNOM`, `PRODDESC`, `PRODPREC`, `PRODINV`, `PRODOFE`, `PRODNUMVENT`, `PRODPRECORI`, `PRODVAL`, `CATCOD`, `PROCOD`) VALUES(2, 'img/productos/grafica2.png', 'Gigabyte NVIDIA RTX 3090 Ti 8GB DDR5', 'ASFJSAIGAIGAIGBIAdhola.com.....buenas', 380, 6, 0, 250, 380, 5, 1, 1);
INSERT INTO `productos` (`PRODCOD`, `PRODIMG`, `PRODNOM`, `PRODDESC`, `PRODPREC`, `PRODINV`, `PRODOFE`, `PRODNUMVENT`, `PRODPRECORI`, `PRODVAL`, `CATCOD`, `PROCOD`) VALUES(3, 'img/productos/cpu1.png', 'AMD Ryzen 5700 RX', 'Este procesador es una pasad achavlaesadsadnsapigeiogb', 290, 8, 10, 9875, 322, 5, 1, 1);
INSERT INTO `productos` (`PRODCOD`, `PRODIMG`, `PRODNOM`, `PRODDESC`, `PRODPREC`, `PRODINV`, `PRODOFE`, `PRODNUMVENT`, `PRODPRECORI`, `PRODVAL`, `CATCOD`, `PROCOD`) VALUES(4, 'img/productos/ram1.png', 'HYPERX FURY 16GB 2x8GB RAM', 'Locura de tarjeta, brilla y es blanca como mi pichita', 300, 26, 25, 3600, 400, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `PROCOD` int(5) NOT NULL,
  `PRONOM` varchar(20) NOT NULL,
  `PRODESC` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`PROCOD`, `PRONOM`, `PRODESC`) VALUES(1, 'Gigabyte', 'Amazing brand man');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `RESCOD` int(5) NOT NULL,
  `RESVAL` int(1) NOT NULL,
  `RESCONT` varchar(500) NOT NULL,
  `RESFEC` date NOT NULL,
  `USUCOD` int(5) NOT NULL,
  `PRODCOD` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`RESCOD`, `RESVAL`, `RESCONT`, `RESFEC`, `USUCOD`, `PRODCOD`) VALUES(0, 5, 'Amazing ahh graphics card I love it man man let me just post this', '2025-06-02', 1, 2);
INSERT INTO `reseñas` (`RESCOD`, `RESVAL`, `RESCONT`, `RESFEC`, `USUCOD`, `PRODCOD`) VALUES(1, 5, 'De locos, que locura de grafica LA AMO JODER YAAAAAA', '2025-06-03', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `TICKID` varchar(64) NOT NULL,
  `TICKCONT` text NOT NULL,
  `TICKEST` varchar(30) NOT NULL,
  `TICKFEC` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`TICKID`, `TICKCONT`, `TICKEST`, `TICKFEC`, `USUCOD`) VALUES('5055a9c9906cf8fb66b4bb455804c8ca', 'hola que tal, me duele un poco el estomago', 'Abierto', '2025-06-02 14:43:22', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `USUCOD` int(5) NOT NULL,
  `USUNOM` varchar(20) NOT NULL,
  `USUAPE` varchar(50) NOT NULL,
  `USUIMG` varchar(50) NOT NULL,
  `USUNEWS` tinyint(1) NOT NULL,
  `USUCOR` varchar(60) NOT NULL,
  `USUCONT` varchar(300) NOT NULL,
  `USUADM` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`USUCOD`, `USUNOM`, `USUAPE`, `USUIMG`, `USUNEWS`, `USUCOR`, `USUCONT`, `USUADM`) VALUES(0, 'Daniel', 'Manzano Montes', 'img/users/latest.png', 0, 'nigga@fortnite.com', '$2y$10$cy/MVErr.IKuoe2Fj/kHterwQGcnlBhhz5Dtkqg2A0PJbpQdSylDm', 0);
INSERT INTO `usuarios` (`USUCOD`, `USUNOM`, `USUAPE`, `USUIMG`, `USUNEWS`, `USUCOR`, `USUCONT`, `USUADM`) VALUES(1, 'Daniel', 'Manzano Montes', 'img/users/latest.png', 1, 'dmanmon141@gmail.com', '$2y$10$0fggXNy/XgsURek8a93s1.0eGTm6LGaK.mdhvzKWB6b8ZS8BhDG/W', 0);
INSERT INTO `usuarios` (`USUCOD`, `USUNOM`, `USUAPE`, `USUIMG`, `USUNEWS`, `USUCOR`, `USUCONT`, `USUADM`) VALUES(2, 'Admin', 'Istrador', 'img/users/default.jpg', 0, 'admin@gmail.com', '$2y$10$A1zSeudaZhPuRg3ToegTPu/G6J0JSW0BPiiPori18Ylt2oPz/.yiq', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificar`
--

CREATE TABLE `verificar` (
  `VERTOK` varchar(64) NOT NULL,
  `VEREXP` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `verificar`
--

INSERT INTO `verificar` (`VERTOK`, `VEREXP`, `USUCOD`) VALUES('3f1dda07d791f613d33863dc305b240d', '2025-06-02 10:13:33', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`CATCOD`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD KEY `FK_USUCOD_DAT` (`USUCOD`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`DEVCOD`),
  ADD KEY `FK_PEDCOD` (`PEDCOD`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`MENID`),
  ADD KEY `FK_USUCOD_MEN` (`USUCOD`),
  ADD KEY `FK_TICKID_MEN` (`TICKID`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`NOTCOD`);

--
-- Indices de la tabla `paneladmin`
--
ALTER TABLE `paneladmin`
  ADD PRIMARY KEY (`ADMCOD`),
  ADD KEY `FK_NOTCOD_ADM` (`NOTCOD`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`PEDCOD`),
  ADD KEY `FK_USUCOD_PED` (`USUCOD`),
  ADD KEY `FK_PRODCOD_PED` (`PRODCOD`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`PRODCOD`),
  ADD KEY `CATCOD` (`CATCOD`),
  ADD KEY `PROCOD` (`PROCOD`),
  ADD KEY `CATCOD_2` (`CATCOD`,`PROCOD`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`PROCOD`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`RESCOD`),
  ADD KEY `FK_USUCOD` (`USUCOD`),
  ADD KEY `FK_PRODCOD` (`PRODCOD`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`TICKID`),
  ADD KEY `FK_USUCOD_TICK` (`USUCOD`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`USUCOD`);

--
-- Indices de la tabla `verificar`
--
ALTER TABLE `verificar`
  ADD PRIMARY KEY (`VERTOK`),
  ADD KEY `FK_USUCOD_VER` (`USUCOD`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos`
--
ALTER TABLE `datos`
  ADD CONSTRAINT `FK_USUCOD_DAT` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `FK_PEDCOD` FOREIGN KEY (`PEDCOD`) REFERENCES `pedidos` (`PEDCOD`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `FK_TICKID_MEN` FOREIGN KEY (`TICKID`) REFERENCES `tickets` (`TICKID`),
  ADD CONSTRAINT `FK_USUCOD_MEN` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);

--
-- Filtros para la tabla `paneladmin`
--
ALTER TABLE `paneladmin`
  ADD CONSTRAINT `FK_NOTCOD_ADM` FOREIGN KEY (`NOTCOD`) REFERENCES `notificaciones` (`NOTCOD`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_PRODCOD_PED` FOREIGN KEY (`PRODCOD`) REFERENCES `productos` (`PRODCOD`),
  ADD CONSTRAINT `FK_USUCOD_PED` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_CATCOD` FOREIGN KEY (`CATCOD`) REFERENCES `categorias` (`CATCOD`),
  ADD CONSTRAINT `FK_PROCOD` FOREIGN KEY (`PROCOD`) REFERENCES `proveedores` (`PROCOD`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `FK_PRODCOD` FOREIGN KEY (`PRODCOD`) REFERENCES `productos` (`PRODCOD`),
  ADD CONSTRAINT `FK_USUCOD` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_USUCOD_TICK` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);

--
-- Filtros para la tabla `verificar`
--
ALTER TABLE `verificar`
  ADD CONSTRAINT `FK_USUCOD_VER` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
