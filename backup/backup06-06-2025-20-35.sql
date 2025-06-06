-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: infoshop
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `CATCOD` int(5) NOT NULL,
  `CATNOM` varchar(40) NOT NULL,
  `CATDESC` text NOT NULL,
  PRIMARY KEY (`CATCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Placas Base','Construye tu PC sobre una base sólida. Nuestras placas base ofrecen compatibilidad con las últimas generaciones de procesadores, soporte para overclocking, almacenamiento ultrarrápido y conexiones avanzadas. Elige la columna vertebral ideal para tu setup, con diseños pensados tanto para el rendimiento como para la estética gamer.'),(2,'GPU','Prepárate para jugar en ultra. Las tarjetas gráficas que encontrarás en Infoshop te permiten experimentar juegos con ray tracing, resoluciones 2K/4K y altísimos FPS. Ya seas competitivo o amante de los gráficos, tenemos la GPU que desatará el verdadero potencial de tu equipo.'),(3,'Memoria RAM','Acelera tu sistema con memorias RAM de alto rendimiento. Desde módulos básicos hasta kits de gama alta con iluminación RGB y capacidad para overclocking, nuestra selección está diseñada para que tu PC responda con velocidad y estabilidad, incluso en las tareas más intensas.'),(4,'CPU','El cerebro de tu máquina, optimizado para la acción. Encuentra procesadores de última generación con múltiples núcleos, velocidades turbo impresionantes y eficiencia energética. Perfectos para gaming, streaming, edición de vídeo o multitarea avanzada.'),(5,'Fuente de Alimentación','Potencia sin riesgos. Las fuentes de alimentación de nuestra tienda ofrecen eficiencia certificada (80 PLUS), protección contra picos de tensión y modelos totalmente modulares. Silenciosas, fiables y con potencia de sobra para equipos de alto rendimiento.'),(6,'Almacenamiento','Rendimiento, capacidad y velocidad en un solo lugar. Ya sea que busques la inmensidad de un HDD, la rapidez de un SSD o la eficiencia compacta de un M.2 NVMe, en Infoshop tenemos la solución de almacenamiento perfecta para tu equipo. Carga tus juegos en segundos, guarda todos tus archivos y disfruta de una experiencia sin cuellos de botella. Porque cada segundo cuenta, y tu PC lo sabe.'),(7,'Ratones','Precisión milimétrica al alcance de tu mano. Descubre ratones diseñados para la victoria, con sensores ópticos de alta resolución, ergonomía avanzada y botones personalizables. Desde shooters hasta MOBAs, mejora tu rendimiento en cada clic.'),(8,'Teclados','Responde más rápido, juega mejor. Teclados mecánicos con switches de alta calidad, iluminación RGB y funciones programables. Diseñados para jugadores que exigen precisión, velocidad y una experiencia táctil superior en cada partida.'),(9,'Monitores','Cada detalle, cada frame. Encuentra monitores con tasas de refresco ultra rápidas (144Hz, 240Hz), tiempos de respuesta mínimos y paneles IPS o VA para colores vibrantes. Porque la diferencia entre ganar o perder está en lo que ves.'),(10,'Auriculares','Escucha la diferencia. Cascos gaming con sonido envolvente, micrófonos con cancelación de ruido y diseño ergonómico para largas sesiones. Siente cada explosión, paso y efecto como si estuvieras dentro del juego.');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datos`
--

DROP TABLE IF EXISTS `datos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `DATOSTEL` varchar(15) NOT NULL,
  KEY `FK_USUCOD_DAT` (`USUCOD`),
  CONSTRAINT `FK_USUCOD_DAT` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos`
--

LOCK TABLES `datos` WRITE;
/*!40000 ALTER TABLE `datos` DISABLE KEYS */;
INSERT INTO `datos` VALUES (1,'Daniel','Manzano Montes','1234123412341234','03/27',123,'Algeciras','Calle de las Palmas 23',11203,'España','689023123');
/*!40000 ALTER TABLE `datos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devoluciones` (
  `DEVCOD` int(5) NOT NULL,
  `DEVRAZ` varchar(20) NOT NULL,
  `DEVDET` text NOT NULL,
  `PEDCOD` int(5) NOT NULL,
  PRIMARY KEY (`DEVCOD`),
  KEY `FK_PEDCOD` (`PEDCOD`),
  CONSTRAINT `FK_PEDCOD` FOREIGN KEY (`PEDCOD`) REFERENCES `pedidos` (`PEDCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devoluciones`
--

LOCK TABLES `devoluciones` WRITE;
/*!40000 ALTER TABLE `devoluciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `devoluciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes` (
  `MENID` int(5) NOT NULL,
  `MENCONT` text NOT NULL,
  `MENFEC` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL,
  `TICKID` varchar(64) NOT NULL,
  PRIMARY KEY (`MENID`),
  KEY `FK_USUCOD_MEN` (`USUCOD`),
  KEY `FK_TICKID_MEN` (`TICKID`),
  CONSTRAINT `FK_TICKID_MEN` FOREIGN KEY (`TICKID`) REFERENCES `tickets` (`TICKID`),
  CONSTRAINT `FK_USUCOD_MEN` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes`
--

LOCK TABLES `mensajes` WRITE;
/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
INSERT INTO `mensajes` VALUES (3,'Hola, soy Daniel Manzano, técnico de Infoshop. En qué puedo ayudarle hoy??','2025-06-03 11:07:36',2,'5055a9c9906cf8fb66b4bb455804c8ca'),(4,'Pues como le comentaba, me duele la barriga y pensé que aquí me podríais ayudar.','2025-06-03 11:12:11',1,'5055a9c9906cf8fb66b4bb455804c8ca'),(5,'Buenas, silencio tio.','2025-06-06 20:21:32',2,'5055a9c9906cf8fb66b4bb455804c8ca'),(6,'ok','2025-06-06 20:23:11',1,'5055a9c9906cf8fb66b4bb455804c8ca'),(7,'va','2025-06-06 20:23:25',2,'5055a9c9906cf8fb66b4bb455804c8ca');
/*!40000 ALTER TABLE `mensajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `NOTCOD` int(5) NOT NULL,
  `NOTNOM` varchar(30) NOT NULL,
  `NOTDESC` varchar(120) NOT NULL,
  PRIMARY KEY (`NOTCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,'Devolución','Paquete devuelto. Alerta informativa, no es necesaria ninguna acción.'),(2,'Reemplazo','Producto reemplazado. Alerta informativa, no es necesaria ninguna acción.'),(3,'Ticket usuario','Ticket de usuario abierto. Atender lo antes posible.'),(4,'Reseña reportada','Reseña reportada por un usuario. Comprobar y moderar adecuadamente.');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paneladmin`
--

DROP TABLE IF EXISTS `paneladmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paneladmin` (
  `ADMCOD` int(5) NOT NULL,
  `ADMCONT` varchar(120) NOT NULL,
  `NOTCOD` int(1) NOT NULL,
  PRIMARY KEY (`ADMCOD`),
  KEY `FK_NOTCOD_ADM` (`NOTCOD`),
  CONSTRAINT `FK_NOTCOD_ADM` FOREIGN KEY (`NOTCOD`) REFERENCES `notificaciones` (`NOTCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paneladmin`
--

LOCK TABLES `paneladmin` WRITE;
/*!40000 ALTER TABLE `paneladmin` DISABLE KEYS */;
/*!40000 ALTER TABLE `paneladmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `PEDTEL` varchar(15) NOT NULL,
  PRIMARY KEY (`PEDCOD`),
  KEY `FK_USUCOD_PED` (`USUCOD`),
  KEY `FK_PRODCOD_PED` (`PRODCOD`),
  CONSTRAINT `FK_PRODCOD_PED` FOREIGN KEY (`PRODCOD`) REFERENCES `productos` (`PRODCOD`),
  CONSTRAINT `FK_USUCOD_PED` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (0,'2025-06-06','2025-07-06',1,9,'En envío','1234123412341234','03/27',123,'Algeciras','Calle de las Palmas 23',11203,'España','689023123'),(1,'2025-06-06','2025-07-06',1,16,'En envío','1234123412341234','03/27',123,'Algeciras','Calle de las Palmas 23',11203,'España','689023123');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `PROCOD` int(11) NOT NULL,
  PRIMARY KEY (`PRODCOD`),
  KEY `CATCOD` (`CATCOD`),
  KEY `PROCOD` (`PROCOD`),
  KEY `CATCOD_2` (`CATCOD`,`PROCOD`),
  CONSTRAINT `FK_CATCOD` FOREIGN KEY (`CATCOD`) REFERENCES `categorias` (`CATCOD`),
  CONSTRAINT `FK_PROCOD` FOREIGN KEY (`PROCOD`) REFERENCES `proveedores` (`PROCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'img/productos/auriculares1.png','Cascos LOGITECH G305 Gaming','Sumérgete en la acción con estos cascos gaming de alta fidelidad. Con sonido 7.1 surround, cancelación de ruido y micrófono ajustable, estarás listo para coordinar cada movimiento como un pro.',65,120,18,15,80,3,10,6),(2,'img/productos/auriculares2.png','Mars Gaming Auriculares 250MG','Diseñados para largas sesiones, estos auriculares ofrecen comodidad superior y una experiencia sonora inmersiva. Siente cada disparo, paso y efecto como si estuvieras dentro del juego.',44,18,10,68,49,2,10,8),(3,'img/productos/cpu1.png','AMD Ryzen 5700RX','Con arquitectura de última generación y múltiples núcleos, esta CPU ofrece eficiencia energética y velocidad demoledora. Ideal para gamers y profesionales.',249.99,12,17,89,299.99,5,4,4),(4,'img/productos/grafica1.png','NVIDIA Geforce GTX 1650','Experimenta la máxima calidad visual con esta GPU, preparada para ray tracing y altos FPS en 1440p y 4K. Todo lo que ves, fluye.',319.99,56,20,38,399.99,4,2,3),(5,'img/productos/grafica2.png','AMD Radeon 6500 RX','Con arquitectura de vanguardia y refrigeración avanzada, esta tarjeta gráfica lleva tu experiencia gaming al siguiente nivel. Nada de lag, todo rendimiento.',449.9,6,18,105,549.9,5,2,4),(6,'img/productos/monitor1.png','MSI Monitor Gaming M245 165Hz','Monitor con alta tasa de refresco (144Hz), respuesta rápida y panel IPS. Perfecto para juegos competitivos donde cada milisegundo importa.',279.99,59,20,163,349.99,4,9,2),(7,'img/productos/monitor2.png','Gigabyte G309 Monitor Gaming 27\"','Disfruta de imágenes nítidas, colores vibrantes y gran amplitud visual en este monitor diseñado para gamers exigentes y creativos.',189.9,78,24,24,249.9,3,9,1),(8,'img/productos/placabase1.png','Gigabyte B360M H Placa Base','Compatibilidad total, robustez y capacidad de expansión. Esta placa base está lista para construir el equipo de tus sueños.',139.9,54,22,29,179.9,4,1,1),(9,'img/productos/placabase2.png','Gigabyte H410M H V3 Placa Base','Con soporte para las últimas tecnologías, overclocking seguro y una estética imponente, esta motherboard es la base perfecta para gamers y entusiastas.',89.9,11,10,93,99.9,5,1,1),(10,'img/productos/psu1.png','Corsair RM 850X','Fuente de alimentación certificada 80 PLUS para eficiencia superior y protección completa. Tu hardware seguro, tu mente tranquila.\r\n\r\n',109,55,21,72,139,5,5,7),(11,'img/productos/psu2.png','MSI A850GF Fuente de Alimentación','Diseñada para configuraciones exigentes, esta PSU modular combina fiabilidad, silencio y potencia continua. Rendimiento sin interrupciones.',74.9,41,16,15,89.9,3,5,2),(12,'img/productos/ram1.png','Corsair VENGEANCE 2x16GB 3200Mhz','Memoria RAM DDR4/DDR5 de alto rendimiento, ideal para gaming fluido, multitarea y productividad. Overclock estable y latencias ajustadas.',79.9,64,11,39,89.9,4,3,7),(13,'img/productos/ram2.png','Kingston FURY BEAST 2x16GB 3200 Mhz','Mejora el rendimiento general de tu PC con esta RAM de baja latencia y disipación térmica optimizada. Rápida, eficiente, esencial.',124.9,18,17,98,149.9,5,3,5),(14,'img/productos/raton1.png','Corsair A321 Ratón Wireless Gaming Ultra Lightweig','Sensor óptico de alta resolución, DPI ajustable y diseño ergonómico. Este ratón es tu arma secreta en cualquier batalla.',49.99,6,16,62,59.99,5,7,7),(15,'img/productos/raton2.png','MSI M322 Ratón Gaming 1600DPI','Ligero, personalizable y con switches de alta durabilidad, este mouse está hecho para dominar cada partida.',29.9,28,25,15,39.9,3,7,2),(16,'img/productos/raton3.png','Logitech G201 Ratón Gaming Ligero RGB','Lleva tu experiencia de juego al siguiente nivel con el Logitech G201, un ratón gaming diseñado para ofrecer precisión, ligereza y estilo. Con un sensor óptico avanzado de hasta 8.000 DPI y un diseño ultraligero, es perfecto para movimientos rápidos y precisos en cualquier tipo de juego.\r\n\r\nDisfruta de una iluminación RGB personalizable con más de 16,8 millones de colores, que puedes ajustar desde el software Logitech G HUB. Además, sus 6 botones programables te permiten configurar accesos directos y macros para una ventaja competitiva real.\r\n\r\nCaracterísticas destacadas:\r\n\r\nSensor óptico de hasta 8.000 DPI para precisión milimétrica\r\n\r\nDiseño ultraligero y ergonómico (solo 85 g)\r\n\r\nIluminación RGB LIGHTSYNC totalmente personalizable\r\n\r\n6 botones programables para un control total\r\n\r\nCompatible con Windows y macOS mediante Logitech G HUB',59.99,2,15,512,69.99,5,7,6),(17,'img/productos/ssd1.png','Kingston 1TB SSD','SSD NVMe ultrarrápido con velocidades que transforman tu sistema. Ideal para gaming, edición y arranque veloz.',94.9,15,24,197,124.9,5,6,5),(18,'img/productos/teclado1.png','MARS GAMING Teclado Mecánico RGB MG301','Teclado mecánico con switches precisos, retroiluminación RGB y construcción sólida. Para escribir, jugar y destacar.',54.9,70,21,32,69.9,2,8,8),(19,'img/productos/teclado2.png','Corsair C355 Teclado Gaming RGB Mecánico','Con respuesta ultra rápida, teclas anti-ghosting y diseño gamer, este teclado se convierte en una extensión de tus reflejos.',79.99,27,11,101,89.99,5,8,7),(20,'img/productos/teclado3.png','Logitech G355 Teclado RGB Gaming','El Logitech G355 combina estética, rendimiento y comodidad en un teclado RGB diseñado para los jugadores más exigentes. Con tecnología anti-ghosting, teclas de respuesta rápida y una estructura resistente, te ofrece una experiencia de juego fluida y precisa.\r\n\r\nSus efectos de iluminación RGB LIGHTSYNC personalizables permiten sincronizar con tu setup y crear un ambiente inmersivo. Ideal tanto para gaming como para escribir con velocidad y precisión.\r\n\r\nCaracterísticas destacadas:\r\n\r\nIluminación RGB LIGHTSYNC con múltiples efectos dinámicos\r\n\r\nTeclas de respuesta rápida con sensación mecánica mejorada\r\n\r\nAnti-ghosting para un control preciso en cada pulsación\r\n\r\nDiseño duradero con estructura reforzada\r\n\r\nTotalmente configurable desde Logitech G HUB',109.9,0,15,168,129,4,8,6);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores` (
  `PROCOD` int(5) NOT NULL,
  `PRONOM` varchar(20) NOT NULL,
  `PRODESC` text NOT NULL,
  PRIMARY KEY (`PROCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'Gigabyte','Innovación, durabilidad y potencia. Gigabyte se ha consolidado como uno de los líderes en hardware de alto rendimiento, ofreciendo placas base, tarjetas gráficas y más con calidad profesional. Diseñado para gamers exigentes y creadores de contenido.'),(2,'MSI','Tecnología con estilo. MSI combina potencia bruta con diseños agresivos y elegantes. Ya sea en placas base, GPUs o periféricos, cada producto MSI está diseñado para competir al más alto nivel, sin perder personalidad.\r\n\r\n'),(3,'NVIDIA','La revolución gráfica. NVIDIA es sinónimo de rendimiento en videojuegos, IA y creación de contenido. Sus GPUs GeForce RTX lideran la industria con tecnologías como Ray Tracing, DLSS y un ecosistema optimizado para el gaming moderno.'),(4,'AMD','Versatilidad y potencia al mejor precio. AMD ofrece procesadores Ryzen y tarjetas gráficas Radeon que compiten de tú a tú con las grandes ligas. Ideal para usuarios que buscan rendimiento real sin romper su presupuesto.'),(5,'Kingston','Memoria confiable, velocidad garantizada. Kingston es el referente mundial en RAM y almacenamiento. Desde módulos DDR hasta SSDs NVMe, su rendimiento es ideal tanto para entornos profesionales como gaming.'),(6,'Logitech','Precisión suiza al servicio de tu juego. Logitech ofrece periféricos ergonómicos, duraderos y con gran reputación entre gamers, streamers y profesionales. Ratones, teclados y auriculares que marcan la diferencia.'),(7,'Corsair','Rendimiento con estilo. Corsair es uno de los favoritos en fuentes de alimentación, memorias RAM, refrigeración líquida y periféricos RGB. Su fiabilidad y estética hacen que cualquier setup luzca y rinda como debe.'),(8,'Mars Gaming','Estilo gaming sin gastar de más. Mars Gaming ofrece periféricos y componentes pensados para los que quieren empezar en el mundo del gaming o renovar su setup sin comprometer el diseño ni el rendimiento.');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reseñas`
--

DROP TABLE IF EXISTS `reseñas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reseñas` (
  `RESCOD` int(5) NOT NULL,
  `RESVAL` int(1) NOT NULL,
  `RESCONT` varchar(500) NOT NULL,
  `RESFEC` date NOT NULL,
  `USUCOD` int(5) NOT NULL,
  `PRODCOD` int(5) NOT NULL,
  PRIMARY KEY (`RESCOD`),
  KEY `FK_USUCOD` (`USUCOD`),
  KEY `FK_PRODCOD` (`PRODCOD`),
  CONSTRAINT `FK_PRODCOD` FOREIGN KEY (`PRODCOD`) REFERENCES `productos` (`PRODCOD`),
  CONSTRAINT `FK_USUCOD` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reseñas`
--

LOCK TABLES `reseñas` WRITE;
/*!40000 ALTER TABLE `reseñas` DISABLE KEYS */;
/*!40000 ALTER TABLE `reseñas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `TICKID` varchar(64) NOT NULL,
  `TICKCONT` text NOT NULL,
  `TICKEST` varchar(30) NOT NULL,
  `TICKFEC` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL,
  PRIMARY KEY (`TICKID`),
  KEY `FK_USUCOD_TICK` (`USUCOD`),
  CONSTRAINT `FK_USUCOD_TICK` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES ('5055a9c9906cf8fb66b4bb455804c8ca','hola que tal, me duele un poco el estomago','Cerrado','2025-06-02 14:43:22',1);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `USUCOD` int(5) NOT NULL,
  `USUNOM` varchar(20) NOT NULL,
  `USUAPE` varchar(50) NOT NULL,
  `USUIMG` varchar(50) NOT NULL,
  `USUNEWS` tinyint(1) NOT NULL,
  `USUCOR` varchar(60) NOT NULL,
  `USUCONT` varchar(300) NOT NULL,
  `USUADM` tinyint(1) NOT NULL,
  PRIMARY KEY (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (0,'Daniel','Manzano Montes','img/users/latest.png',0,'nigga@fortnite.com','$2y$10$cy/MVErr.IKuoe2Fj/kHterwQGcnlBhhz5Dtkqg2A0PJbpQdSylDm',0),(1,'Daniel','Manzano Montes','img/users/latest.png',1,'dmanmon141@gmail.com','$2y$10$0fggXNy/XgsURek8a93s1.0eGTm6LGaK.mdhvzKWB6b8ZS8BhDG/W',0),(2,'Admin','Istrador','img/users/default.jpg',0,'admin@gmail.com','$2y$10$A1zSeudaZhPuRg3ToegTPu/G6J0JSW0BPiiPori18Ylt2oPz/.yiq',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verificar`
--

DROP TABLE IF EXISTS `verificar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verificar` (
  `VERTOK` varchar(64) NOT NULL,
  `VEREXP` datetime NOT NULL,
  `USUCOD` int(5) NOT NULL,
  PRIMARY KEY (`VERTOK`),
  KEY `FK_USUCOD_VER` (`USUCOD`),
  CONSTRAINT `FK_USUCOD_VER` FOREIGN KEY (`USUCOD`) REFERENCES `usuarios` (`USUCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verificar`
--

LOCK TABLES `verificar` WRITE;
/*!40000 ALTER TABLE `verificar` DISABLE KEYS */;
INSERT INTO `verificar` VALUES ('3f1dda07d791f613d33863dc305b240d','2025-06-02 10:13:33',0);
/*!40000 ALTER TABLE `verificar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-06 20:35:07
