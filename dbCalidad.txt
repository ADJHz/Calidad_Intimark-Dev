-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.2.2-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para calidad_inti
CREATE DATABASE IF NOT EXISTS `calidad_inti` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `calidad_inti`;

-- Volcando estructura para tabla calidad_inti.accioncorrectiva_screenprint
CREATE TABLE IF NOT EXISTS `accioncorrectiva_screenprint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AccionCorrectiva` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.accioncorrectiva_screenprint: ~14 rows (aproximadamente)
INSERT IGNORE INTO `accioncorrectiva_screenprint` (`id`, `AccionCorrectiva`) VALUES
	(1, 'AS.AVISO A SUPERVISOR'),
	(2, 'MA.MAQUINA EN ALTO'),
	(3, 'MO.METODO DE OPERARIO'),
	(4, 'AST.AUTORIZADO SEGUIR TRABAJANDO'),
	(5, 'CPS.CAMBIO DE PERSONAL.'),
	(6, 'CM.CAMBIO DE MATERIAL'),
	(7, 'CA.CAMBIO DE TIPO DE ARTE'),
	(8, 'CDM.CAMBIO DE MARCO'),
	(9, 'CP.CAMBIO DE PAPEL'),
	(10, 'AT.AJUSTE DE TEMPERATURA'),
	(11, 'AT.AJUSTE DE TEMPERATURA'),
	(12, 'PP.PLANCHADO DE PIEZAS'),
	(13, 'RR.RETOQUE/RECUPERADO'),
	(14, 'CA.CORECCION DE ARTE');

-- Volcando estructura para tabla calidad_inti.auditeres_aditoria
CREATE TABLE IF NOT EXISTS `auditeres_aditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Auditor` varchar(50) DEFAULT NULL,
  `Tipo_Auditoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.auditeres_aditoria: ~0 rows (aproximadamente)

-- Volcando estructura para tabla calidad_inti.auditoria_etiquetas
CREATE TABLE IF NOT EXISTS `auditoria_etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(50) DEFAULT NULL,
  `estilo` varchar(50) DEFAULT '0',
  `no_recibo` varchar(50) DEFAULT NULL,
  `talla_cantidad` varchar(50) DEFAULT '0',
  `muestra` varchar(50) DEFAULT NULL,
  `defectos` varchar(50) DEFAULT NULL,
  `tipo_defecto` varchar(250) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.auditoria_etiquetas: ~8 rows (aproximadamente)
INSERT IGNORE INTO `auditoria_etiquetas` (`id`, `cliente`, `estilo`, `no_recibo`, `talla_cantidad`, `muestra`, `defectos`, `tipo_defecto`, `observaciones`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, '111', '222', '33', '44', '55', '66', NULL, NULL, '2024-01-18 03:55:09', '2024-01-18 03:55:09', NULL),
	(2, NULL, '555', '666', '77', '88', '99', '000', NULL, NULL, '2024-01-18 04:00:55', '2024-01-18 04:00:55', NULL),
	(3, '1', '3NCFPP', '74923', 'OP-300', '50', NULL, 'NINUGNO', NULL, NULL, '2024-01-18 04:02:05', '2024-01-18 04:02:05', NULL),
	(4, NULL, '3NCFPP', '74923', 'OP-300', '50', '-', 'NINGUNO', NULL, NULL, '2024-01-18 04:05:38', '2024-01-18 04:05:38', NULL),
	(5, NULL, '3NCFPP', '74923', 'OP-300', '50', NULL, 'NINGUNO', 'se aprueba con medida de 14mm por ing Sandra Ordaz', NULL, '2024-01-18 04:07:39', '2024-01-18 04:07:39', NULL),
	(6, NULL, '3NCFPP', '74923', 'OP-300', '50', NULL, 'NINGUNO', 'se aprobo con medida 14mm por ing Sandra Ordaz', 1, '2024-01-18 04:12:27', '2024-01-18 04:12:27', NULL),
	(7, '1', '3NCFPP', '74923', 'OP-300', '50', NULL, 'NINGUNO', 'se aprobo con medida 14mm por ing Sandra Ordaz', 1, '2024-01-18 04:13:06', '2024-01-18 04:13:06', NULL),
	(8, '1', '3NCFPP', '74923', 'OP-300', '50', NULL, 'NINGUNO', 'se aprobo con medida 14mm por ing Sandra Ordaz', 1, '2024-01-18 04:18:07', '2024-01-18 04:18:07', NULL);

-- Volcando estructura para tabla calidad_inti.auditoria_marcadas
CREATE TABLE IF NOT EXISTS `auditoria_marcadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dato_ax_id` int(11) DEFAULT NULL,
  `orden_id` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `yarda_orden` float DEFAULT NULL,
  `yarda_orden_estatus` int(11) DEFAULT NULL,
  `yarda_marcada` float DEFAULT NULL,
  `yarda_marcada_estatus` int(11) DEFAULT NULL,
  `yarda_tendido` float DEFAULT NULL,
  `yarda_tendido_estatus` int(11) DEFAULT NULL,
  `talla1` float DEFAULT NULL,
  `talla2` float DEFAULT NULL,
  `talla3` float DEFAULT NULL,
  `talla4` float DEFAULT NULL,
  `talla5` float DEFAULT NULL,
  `talla6` float DEFAULT NULL,
  `talla7` float DEFAULT NULL,
  `talla8` float DEFAULT NULL,
  `talla9` float DEFAULT NULL,
  `talla10` float DEFAULT NULL,
  `bulto1` float DEFAULT NULL,
  `bulto2` float DEFAULT NULL,
  `bulto3` float DEFAULT NULL,
  `bulto4` float DEFAULT NULL,
  `bulto5` float DEFAULT NULL,
  `bulto6` float DEFAULT NULL,
  `bulto7` float DEFAULT NULL,
  `bulto8` float DEFAULT NULL,
  `bulto9` float DEFAULT NULL,
  `bulto10` float DEFAULT NULL,
  `total_pieza1` float DEFAULT NULL,
  `total_pieza2` float DEFAULT NULL,
  `total_pieza3` float DEFAULT NULL,
  `total_pieza4` float DEFAULT NULL,
  `total_pieza5` float DEFAULT NULL,
  `total_pieza6` float DEFAULT NULL,
  `total_pieza7` float DEFAULT NULL,
  `total_pieza8` float DEFAULT NULL,
  `total_pieza9` float DEFAULT NULL,
  `total_pieza10` float DEFAULT NULL,
  `largo_trazo` float DEFAULT NULL,
  `ancho_trazo` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.auditoria_marcadas: ~2 rows (aproximadamente)
INSERT IGNORE INTO `auditoria_marcadas` (`id`, `dato_ax_id`, `orden_id`, `estatus`, `yarda_orden`, `yarda_orden_estatus`, `yarda_marcada`, `yarda_marcada_estatus`, `yarda_tendido`, `yarda_tendido_estatus`, `talla1`, `talla2`, `talla3`, `talla4`, `talla5`, `talla6`, `talla7`, `talla8`, `talla9`, `talla10`, `bulto1`, `bulto2`, `bulto3`, `bulto4`, `bulto5`, `bulto6`, `bulto7`, `bulto8`, `bulto9`, `bulto10`, `total_pieza1`, `total_pieza2`, `total_pieza3`, `total_pieza4`, `total_pieza5`, `total_pieza6`, `total_pieza7`, `total_pieza8`, `total_pieza9`, `total_pieza10`, `largo_trazo`, `ancho_trazo`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 7, NULL, 'proceso', 234, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-08 22:21:54', '2024-02-08 22:21:54', NULL),
	(2, 7, 'OP0043079', 'proceso', 324.365, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-08 22:39:21', '2024-02-08 22:39:21', NULL);

-- Volcando estructura para tabla calidad_inti.categoria_auditores
CREATE TABLE IF NOT EXISTS `categoria_auditores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `Num_Empleado` varchar(50) DEFAULT NULL,
  `Num_Tag` varchar(50) DEFAULT NULL,
  `Planta` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_auditores: ~51 rows (aproximadamente)
INSERT IGNORE INTO `categoria_auditores` (`id`, `nombre`, `Num_Empleado`, `Num_Tag`, `Planta`, `estado`) VALUES
	(1, 'MARIA ISABEL MARTINEZ JIMENEZ', '0005909', '50691575\r\n', 'Planta1', 1),
	(2, 'AMERICA ADELA HUERTA CARREON', '0016582', '51008423\r\n', 'Planta1', 1),
	(3, 'ANA MARIA ROBLEDO GONZALEZ', '0004157', '595098124\r\n', 'Planta1', 1),
	(4, 'OLGA CRESCENCIO MARCELO', '0003581', '595922796', 'Planta1', 1),
	(5, 'CIRILA MORENO TRINIDAD\r\n', '0010505', '595848428\r\n', 'Planta1', 1),
	(6, 'DENNIS RAMIREZ OSORNIO\r\n', '0003309', '424789853\r\n', 'Planta1', 1),
	(7, 'LILIANA HERNANDEZ HERNANDEZ\r\n', '0021676', '600520860\r\n', 'Planta1', 1),
	(8, 'BEATRIZ MARTINEZ GONZALEZ\r\n', '0003441', '134844042\r\n', 'Planta1', 1),
	(9, 'VICENTE MARTINEZ JIMENEZ\r\n', '0006993', '600463628\r\n', 'Planta1', 1),
	(10, 'MARICELA MARTINEZ  GONZALEZ\r\n', '0015910\r\n', '424605453\r\n', 'Planta1', 1),
	(11, 'DAISY MARTINEZ ROMERO\r\n', '0022670', '423532781\r\n', 'Planta1', 1),
	(12, 'CRISTINA RAMON AMADO\r\n', '0023317\r\n', '423901725\r\n', 'Planta1', 1),
	(13, 'MAGNOLIA HERNANDEZ RIVERA\r\n', '0023508', '409370541\r\n', 'Planta1', 1),
	(14, 'MERCEDES NARCISO ANGELES\r\n', '0011484\r\n', '232766653\r\n', 'Planta1', 1),
	(15, 'ABRAHAM  GARCIA DOMINGUEZ\r\n', '0023572\r\n', '409363389\r\n', 'Planta1', 1),
	(16, 'JOANA DOMINGUEZ ANTONIO\r\n', '0021907', '600821900\r\n', 'Planta1', 1),
	(17, 'KAREN RAFAEL GALICIA\r\n', '0022608', '50420023\r\n', 'Planta1', 1),
	(18, 'MARICELA ZOZAYA  FLORES\r\n', '0021931\r\n', '602299692\r\n', 'Planta1', 1),
	(19, 'MIRIAM FIGUEROA RAMIREZ\r\n', '0013299\r\n', '596104764\r\n', 'Planta1', 1),
	(20, 'ALAN SANCHEZ SANTANA\r\n', '0016287\r\n', '407136557\r\n', 'Planta1', 1),
	(21, 'ARIANA HERNANDEZ ASCENCION \r\n', '0002752\r\n', '595736492\r\n', 'Planta1', 1),
	(22, 'CESAR PAULINO ROMERO\r\n', '0019240\r\n', '423764957\r\n', 'Planta1', 1),
	(23, 'NOEMI SAMANO DE JESUS\r\n', '0017384\r\n', '595562172\r\n', 'Planta1', 1),
	(24, 'KARLA MARIA PICHARDO GARIBALDI\r\n', '0020530\r\n', '215071277\r\n', 'Planta1', 1),
	(25, 'PABLO  RAMIREZ CRUZ\r\n', '0023556\r\n', '406883021\r\n', 'Planta1', 1),
	(26, 'NOHEMI ROLANDA SALINAS TEJEDA\r\n', '0001044\r\n', '601250556\r\n', 'Planta1', 1),
	(27, 'GUSTAVO SANCHEZ  AGUIRRE\r\n', '0021187\r\n', '304494698\r\n', 'Planta1', 1),
	(28, 'BLANCA PATRICIA PALACIOS SAGRERO\r\n', '0000788\r\n', '599961148\r\n', 'Planta1', 1),
	(29, 'MARIO ANTONIO SANTOS  SANTIAGO\r\n', '0019715', '600055420\r\n', 'Planta1', 1),
	(30, 'VICTOR HUGO SANCHEZ NARCIZO\r\n', '0020870', '135250490\r\n', 'Planta1', 1),
	(31, 'ROXANA MARMOLEJO PASTRANA\r\n', '0022559', '51018855\r\n', 'Planta1', 1),
	(32, 'MARIA DE LOURDES  CHAVARRIA  GARCIA\r\n', '0012575', '423850109\r\n', 'Planta2', 1),
	(33, 'SILVIA  DAVILA  SALAZAR', '0012273', '50645111\r\n', 'Planta2', 1),
	(34, 'NEFTALI GUADALUPE  CHAVEZ  SAMANIEGO', '0022596', '68044871\r\n', 'Planta2', 1),
	(35, 'OMAR  JIMENEZ  GONZALEZ\r\n', '0006100', '134891210\r\n', 'Planta2', 1),
	(36, 'ANABEL  PEREZ  LUNA\r\n', '0014291', '605890444\r\n', 'Planta2', 1),
	(37, 'VICTORIA  MORALES  LARA\r\n', '0011752', '134434474\r\n', 'Planta2', 1),
	(38, 'MARIA DEL CARMEN  GUDIÑO  CRESENCIANO', '0006239', '601269180\r\n', 'Planta2', 1),
	(39, 'JOSE LUIS  TELLEZ  GONZALEZ\r\n', '0014586', '68344487\r\n', 'Planta2', 1),
	(40, 'ERIKA CITLALI  ANGELES  ROMERO\r\n', '0022112', '636134586\r\n', 'Planta2', 1),
	(41, 'GABRIELA  MENDOZA  MATEO\r\n', '0022007', '134784938\r\n', 'Planta2', 1),
	(42, 'ADELA  MERCADO  FLORES\r\n', '0021177', '50929655\r\n', 'Planta2', 1),
	(43, 'TERESA  LOPEZ  SANDOVAL\r\n', '0002982', '50433351\r\n', 'Planta2', 1),
	(44, 'ALETHIA ILIANA  MAGARIÑO  LOPEZ\r\n', '0016609', '68158471\r\n', 'Planta2', 1),
	(45, 'UZIEL  ELIGIO  MARTINEZ\r\n', '0022919', '605448028\r\n', 'Planta2', 1),
	(46, 'MARLENE  ZARAGOZA  LONGINOS\r\n', '0006153', '134194698\r\n', 'Planta2', 1),
	(47, 'DIANA  MARTINEZ  SAAVEDRA\r\n', '0023287', '68118615\r\n', 'Planta2', 1),
	(48, 'JUAN MANUEL  MONTOYA  GOMEZ \r\n', '0007990', '601569068\r\n', 'Planta2', 1),
	(49, 'LAURA MARIANA  MONTERO  NICOLAS\r\n', '0021872', '425857341\r\n', 'Planta2', 1),
	(50, 'RODRIGO  IRINEO  ANTONIO\r\n', '0023028', '601221468\r\n', 'Planta2', 1),
	(51, 'JEHOVANA  ALVAREZ  GARCIA\r\n', '0022202\r\n', '602360780\r\n', 'Planta2', 1);

-- Volcando estructura para tabla calidad_inti.categoria_clientes
CREATE TABLE IF NOT EXISTS `categoria_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` tinyblob DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_clientes: ~21 rows (aproximadamente)
INSERT IGNORE INTO `categoria_clientes` (`id`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
	(1, 'VICTORIAS SECRET', _binary 0x31, NULL, NULL),
	(2, 'CHG-III APPAREL GROUP', _binary 0x31, NULL, NULL),
	(3, 'INTIMARK', _binary 0x31, NULL, NULL),
	(4, 'CHICOS RETAIL SERVIC', _binary 0x31, NULL, NULL),
	(5, 'BELLEFIT INC', _binary 0x31, NULL, NULL),
	(6, 'THE MARENA GROUP LLC', _binary 0x31, NULL, NULL),
	(7, 'BN3TH', _binary 0x31, NULL, NULL),
	(8, 'FILUM LLC', _binary 0x31, NULL, NULL),
	(9, 'HOOEY LLC', _binary 0x31, NULL, NULL),
	(10, 'PACIFIC INTERNATIONA', _binary 0x31, NULL, NULL),
	(11, 'INTIMARK S DE RL DE', _binary 0x31, NULL, NULL),
	(12, 'COCO TREE', _binary 0x31, NULL, NULL),
	(13, 'EXPRESS', _binary 0x31, NULL, NULL),
	(14, 'DISTRIBUIDORA DE ROP', _binary 0x31, NULL, NULL),
	(15, 'LACOSTE', _binary 0x31, NULL, NULL),
	(16, 'BRANDIX ASIA HOLDING', _binary 0x31, NULL, NULL),
	(17, 'SOUTHPOINT SPORTSWE', _binary 0x31, NULL, NULL),
	(18, 'CALVIN KLEIN', _binary 0x31, NULL, NULL),
	(19, 'BLUESTEM', _binary 0x31, NULL, NULL),
	(20, 'GIII KOSTROMA LIMITE', _binary 0x31, NULL, NULL),
	(21, 'COATS MEXICO SA DE', _binary 0x31, NULL, NULL);

-- Volcando estructura para tabla calidad_inti.categoria_colores
CREATE TABLE IF NOT EXISTS `categoria_colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` tinyblob DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_colores: ~21 rows (aproximadamente)
INSERT IGNORE INTO `categoria_colores` (`id`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
	(1, 'NON0', _binary 0x31, NULL, NULL),
	(2, 'CAFE', _binary 0x31, NULL, NULL),
	(3, 'NEGRO', _binary 0x31, NULL, NULL),
	(4, 'AZUL', _binary 0x31, NULL, NULL),
	(5, 'AMARILLO', _binary 0x31, NULL, NULL),
	(6, 'MORADO', _binary 0x31, NULL, NULL),
	(7, 'BLANCO', _binary 0x31, NULL, NULL),
	(8, 'CAFE CAMELLO', _binary 0x31, NULL, NULL),
	(9, 'GRIS', _binary 0x31, NULL, NULL),
	(10, 'GRIS CAMELLO', _binary 0x31, NULL, NULL),
	(11, 'AZUL CAMELLO', _binary 0x31, NULL, NULL),
	(12, 'COCO TREE', _binary 0x31, NULL, NULL),
	(13, 'NEGRO CAMELLO', _binary 0x31, NULL, NULL),
	(14, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(15, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(16, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(17, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(18, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(19, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(20, 'OTRO COLOR', _binary 0x31, NULL, NULL),
	(21, 'COATS MEXICO SA DE', _binary 0x31, NULL, NULL);

-- Volcando estructura para tabla calidad_inti.categoria_defectos
CREATE TABLE IF NOT EXISTS `categoria_defectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_defectos: ~3 rows (aproximadamente)
INSERT IGNORE INTO `categoria_defectos` (`id`, `nombre`, `estado`) VALUES
	(11, 'NINGUNO', 1),
	(12, '200', 1),
	(13, '1800', 1);

-- Volcando estructura para tabla calidad_inti.categoria_estilos
CREATE TABLE IF NOT EXISTS `categoria_estilos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `categoria_cliente_id` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `estilo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_estilos: ~11 rows (aproximadamente)
INSERT IGNORE INTO `categoria_estilos` (`id`, `nombre`, `categoria_cliente_id`, `estado`, `created_at`, `updated_at`, `estilo_id`) VALUES
	(11, '3NCFPP', 3, 1, NULL, NULL, NULL),
	(12, '3NCFSR', 4, 1, NULL, NULL, NULL),
	(13, '7MLSS', 5, 1, NULL, NULL, NULL),
	(14, 'FUF000', 6, 1, NULL, NULL, NULL),
	(15, '7MLSS', 7, 1, NULL, NULL, NULL),
	(16, '11219211', 1, 1, NULL, NULL, NULL),
	(17, '11214897', 1, 1, NULL, NULL, NULL),
	(18, '11219209', 1, 1, NULL, NULL, NULL),
	(19, '11246627', 1, 1, NULL, NULL, NULL),
	(20, '070-23C109209', 2, 1, NULL, NULL, NULL),
	(21, '007-22C106075', 2, 1, NULL, NULL, NULL);

-- Volcando estructura para tabla calidad_inti.categoria_no_recibos
CREATE TABLE IF NOT EXISTS `categoria_no_recibos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_no_recibos: ~4 rows (aproximadamente)
INSERT IGNORE INTO `categoria_no_recibos` (`id`, `nombre`, `estado`) VALUES
	(11, '76226', 1),
	(12, '74923', 1),
	(13, '76547', 1),
	(14, '76474', 1);

-- Volcando estructura para tabla calidad_inti.categoria_tallas_cantidades
CREATE TABLE IF NOT EXISTS `categoria_tallas_cantidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `talla_cantidad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_tallas_cantidades: ~11 rows (aproximadamente)
INSERT IGNORE INTO `categoria_tallas_cantidades` (`id`, `nombre`, `estado`, `created_at`, `updated_at`, `cliente_id`, `talla_cantidad_id`) VALUES
	(11, '3R-200', 1, NULL, NULL, NULL, NULL),
	(12, '3R-1800', 1, NULL, NULL, NULL, NULL),
	(13, 'OP-300', 1, NULL, NULL, NULL, NULL),
	(14, 'OP-400', 1, NULL, NULL, NULL, NULL),
	(15, '2P-253', 1, NULL, NULL, NULL, NULL),
	(16, '3P-300', 1, NULL, NULL, NULL, NULL),
	(17, 'X', 1, NULL, NULL, NULL, NULL),
	(18, 'XL', 1, NULL, NULL, NULL, NULL),
	(19, 'SMALL', 1, NULL, NULL, NULL, NULL),
	(20, 'LARGE', 1, NULL, NULL, NULL, NULL),
	(21, 'MEDIUM', 1, NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla calidad_inti.categoria_tamaños_muestras
CREATE TABLE IF NOT EXISTS `categoria_tamaños_muestras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_tamaños_muestras: ~3 rows (aproximadamente)
INSERT IGNORE INTO `categoria_tamaños_muestras` (`id`, `nombre`, `estado`) VALUES
	(11, '50', 1),
	(12, '32', 1),
	(13, '125', 1);

-- Volcando estructura para tabla calidad_inti.categoria_tipos_defectos
CREATE TABLE IF NOT EXISTS `categoria_tipos_defectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Volcando datos para la tabla calidad_inti.categoria_tipos_defectos: ~2 rows (aproximadamente)
INSERT IGNORE INTO `categoria_tipos_defectos` (`id`, `nombre`, `estado`) VALUES
	(11, 'NINGUNO', 1),
	(12, 'TIPO DE LETRA INCORRECTO', 1);

-- Volcando estructura para tabla calidad_inti.cat_acciones_correctivas
CREATE TABLE IF NOT EXISTS `cat_acciones_correctivas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accion_correctiva` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_acciones_correctivas: ~6 rows (aproximadamente)
INSERT IGNORE INTO `cat_acciones_correctivas` (`id`, `accion_correctiva`) VALUES
	(1, 'PT - PARAR TENDIDO'),
	(2, 'AS - AVISO A SUPERVISOR'),
	(3, 'MA - MAQUINA EN ALTO'),
	(4, 'RT - REPARAR TENDIDO'),
	(5, 'RS - REPARAR SELLADO'),
	(6, 'MB - MARCAR BULTOS C/PROBLEMA');

-- Volcando estructura para tabla calidad_inti.cat_auditores
CREATE TABLE IF NOT EXISTS `cat_auditores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Num_Empleado` varchar(50) DEFAULT NULL,
  `Num_Tag` varchar(50) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Planta` varchar(50) DEFAULT NULL,
  `Estatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_auditores: ~51 rows (aproximadamente)
INSERT IGNORE INTO `cat_auditores` (`id`, `Num_Empleado`, `Num_Tag`, `Nombre`, `Planta`, `Estatus`) VALUES
	(1, '0005909', '50691575\r\n', 'MARIA ISABEL MARTINEZ JIMENEZ', 'Planta1', 'Alta'),
	(2, '0016582', '51008423\r\n', 'AMERICA ADELA HUERTA CARREON', 'Planta1', 'Alta'),
	(3, '0004157', '595098124\r\n', 'ANA MARIA ROBLEDO GONZALEZ', 'Planta1', 'Alta'),
	(4, '0003581', '595922796', 'OLGA CRESCENCIO MARCELO', 'Planta1', 'Alta'),
	(5, '0010505', '595848428\r\n', 'CIRILA MORENO TRINIDAD\r\n', 'Planta1', 'Alta'),
	(6, '0003309', '424789853\r\n', 'DENNIS RAMIREZ OSORNIO\r\n', 'Planta1', 'Alta'),
	(7, '0021676', '600520860\r\n', 'LILIANA HERNANDEZ HERNANDEZ\r\n', 'Planta1', 'Alta'),
	(8, '0003441', '134844042\r\n', 'BEATRIZ MARTINEZ GONZALEZ\r\n', 'Planta1', 'Alta'),
	(9, '0006993', '600463628\r\n', 'VICENTE MARTINEZ JIMENEZ\r\n', 'Planta1', 'Alta'),
	(10, '0015910\r\n', '424605453\r\n', 'MARICELA MARTINEZ  GONZALEZ\r\n', 'Planta1', 'Alta'),
	(11, '0022670', '423532781\r\n', 'DAISY MARTINEZ ROMERO\r\n', 'Planta1', 'Alta'),
	(12, '0023317\r\n', '423901725\r\n', 'CRISTINA RAMON AMADO\r\n', 'Planta1', 'Alta'),
	(13, '0023508', '409370541\r\n', 'MAGNOLIA HERNANDEZ RIVERA\r\n', 'Planta1', 'Alta'),
	(14, '0011484\r\n', '232766653\r\n', 'MERCEDES NARCISO ANGELES\r\n', 'Planta1', 'Alta'),
	(15, '0023572\r\n', '409363389\r\n', 'ABRAHAM  GARCIA DOMINGUEZ\r\n', 'Planta1', 'Alta'),
	(16, '0021907', '600821900\r\n', 'JOANA DOMINGUEZ ANTONIO\r\n', 'Planta1', 'Alta'),
	(17, '0022608', '50420023\r\n', 'KAREN RAFAEL GALICIA\r\n', 'Planta1', 'Alta'),
	(18, '0021931\r\n', '602299692\r\n', 'MARICELA ZOZAYA  FLORES\r\n', 'Planta1', 'Alta'),
	(19, '0013299\r\n', '596104764\r\n', 'MIRIAM FIGUEROA RAMIREZ\r\n', 'Planta1', 'Alta'),
	(20, '0016287\r\n', '407136557\r\n', 'ALAN SANCHEZ SANTANA\r\n', 'Planta1', 'Alta'),
	(21, '0002752\r\n', '595736492\r\n', 'ARIANA HERNANDEZ ASCENCION \r\n', 'Planta1', 'Alta'),
	(22, '0019240\r\n', '423764957\r\n', 'CESAR PAULINO ROMERO\r\n', 'Planta1', 'Alta'),
	(23, '0017384\r\n', '595562172\r\n', 'NOEMI SAMANO DE JESUS\r\n', 'Planta1', 'Alta'),
	(24, '0020530\r\n', '215071277\r\n', 'KARLA MARIA PICHARDO GARIBALDI\r\n', 'Planta1', 'Alta'),
	(25, '0023556\r\n', '406883021\r\n', 'PABLO  RAMIREZ CRUZ\r\n', 'Planta1', 'Alta'),
	(26, '0001044\r\n', '601250556\r\n', 'NOHEMI ROLANDA SALINAS TEJEDA\r\n', 'Planta1', 'Alta'),
	(27, '0021187\r\n', '304494698\r\n', 'GUSTAVO SANCHEZ  AGUIRRE\r\n', 'Planta1', 'Alta'),
	(28, '0000788\r\n', '599961148\r\n', 'BLANCA PATRICIA PALACIOS SAGRERO\r\n', 'Planta1', 'Alta'),
	(29, '0019715', '600055420\r\n', 'MARIO ANTONIO SANTOS  SANTIAGO\r\n', 'Planta1', 'Alta'),
	(30, '0020870', '135250490\r\n', 'VICTOR HUGO SANCHEZ NARCIZO\r\n', 'Planta1', 'Alta'),
	(31, '0022559', '51018855\r\n', 'ROXANA MARMOLEJO PASTRANA\r\n', 'Planta1', 'Alta'),
	(32, '0012575', '423850109\r\n', 'MARIA DE LOURDES  CHAVARRIA  GARCIA\r\n', 'Planta2', 'Alta'),
	(33, '0012273', '50645111\r\n', 'SILVIA  DAVILA  SALAZAR', 'Planta2', 'Alta'),
	(34, '0022596', '68044871\r\n', 'NEFTALI GUADALUPE  CHAVEZ  SAMANIEGO', 'Planta2', 'Alta'),
	(35, '0006100', '134891210\r\n', 'OMAR  JIMENEZ  GONZALEZ\r\n', 'Planta2', 'Alta'),
	(36, '0014291', '605890444\r\n', 'ANABEL  PEREZ  LUNA\r\n', 'Planta2', 'Alta'),
	(37, '0011752', '134434474\r\n', 'VICTORIA  MORALES  LARA\r\n', 'Planta2', 'Alta'),
	(38, '0006239', '601269180\r\n', 'MARIA DEL CARMEN  GUDIÑO  CRESENCIANO', 'Planta2', 'Alta'),
	(39, '0014586', '68344487\r\n', 'JOSE LUIS  TELLEZ  GONZALEZ\r\n', 'Planta2', 'Alta'),
	(40, '0022112', '636134586\r\n', 'ERIKA CITLALI  ANGELES  ROMERO\r\n', 'Planta2', 'Alta'),
	(41, '0022007', '134784938\r\n', 'GABRIELA  MENDOZA  MATEO\r\n', 'Planta2', 'Alta'),
	(42, '0021177', '50929655\r\n', 'ADELA  MERCADO  FLORES\r\n', 'Planta2', 'Alta'),
	(43, '0002982', '50433351\r\n', 'TERESA  LOPEZ  SANDOVAL\r\n', 'Planta2', 'Alta'),
	(44, '0016609', '68158471\r\n', 'ALETHIA ILIANA  MAGARIÑO  LOPEZ\r\n', 'Planta2', 'Alta'),
	(45, '0022919', '605448028\r\n', 'UZIEL  ELIGIO  MARTINEZ\r\n', 'Planta2', 'Alta'),
	(46, '0006153', '134194698\r\n', 'MARLENE  ZARAGOZA  LONGINOS\r\n', 'Planta2', 'Alta'),
	(47, '0023287', '68118615\r\n', 'DIANA  MARTINEZ  SAAVEDRA\r\n', 'Planta2', 'Alta'),
	(48, '0007990', '601569068\r\n', 'JUAN MANUEL  MONTOYA  GOMEZ \r\n', 'Planta2', 'Alta'),
	(49, '0021872', '425857341\r\n', 'LAURA MARIANA  MONTERO  NICOLAS\r\n', 'Planta2', 'Alta'),
	(50, '0023028', '601221468\r\n', 'RODRIGO  IRINEO  ANTONIO\r\n', 'Planta2', 'Alta'),
	(51, '0022202\r\n', '602360780\r\n', 'JEHOVANA  ALVAREZ  GARCIA\r\n', 'Planta2', 'Alta');

-- Volcando estructura para tabla calidad_inti.cat_clientes
CREATE TABLE IF NOT EXISTS `cat_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Clientes` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_clientes: ~10 rows (aproximadamente)
INSERT IGNORE INTO `cat_clientes` (`id`, `Clientes`) VALUES
	(1, 'V.S'),
	(2, 'CH'),
	(3, 'BN3'),
	(4, 'NUDS'),
	(5, 'BELL'),
	(6, 'LEQ'),
	(7, 'MAR'),
	(8, 'ELITE'),
	(9, 'EMPAQUE'),
	(10, 'ENTTO');

-- Volcando estructura para tabla calidad_inti.cat_corte_sellado
CREATE TABLE IF NOT EXISTS `cat_corte_sellado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_cortes` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_corte_sellado: ~7 rows (aproximadamente)
INSERT IGNORE INTO `cat_corte_sellado` (`id`, `option_cortes`) VALUES
	(1, 'Mal Cortado'),
	(2, 'Mal Alineado'),
	(3, 'Parametros Incorrectos'),
	(4, 'Plantilla Incorrecta'),
	(5, 'Mal Foleado'),
	(6, 'Mal Armado'),
	(7, 'Faltante en Piezas');

-- Volcando estructura para tabla calidad_inti.cat_modulos
CREATE TABLE IF NOT EXISTS `cat_modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Modulos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_modulos: ~52 rows (aproximadamente)
INSERT IGNORE INTO `cat_modulos` (`id`, `Modulos`) VALUES
	(1, '101A'),
	(2, '102A'),
	(3, '103A'),
	(4, '104A'),
	(5, '105A'),
	(6, '107A'),
	(7, '110A'),
	(8, '111A'),
	(9, '112A'),
	(10, '113A'),
	(11, '114A'),
	(12, '115A'),
	(13, '117A'),
	(14, '118A'),
	(15, '120A'),
	(16, '121A'),
	(17, '122A'),
	(18, '123A'),
	(19, '125A'),
	(20, '127A'),
	(21, '128A'),
	(22, '130A'),
	(23, '131A'),
	(24, '133A'),
	(25, '138A'),
	(26, '139A'),
	(27, '140A'),
	(28, '143A'),
	(29, '148A'),
	(30, '150A'),
	(31, '152A'),
	(32, '154A'),
	(33, '162A'),
	(34, '164A'),
	(35, '167A'),
	(36, '168A'),
	(37, '172A'),
	(38, '199A'),
	(39, '830A'),
	(40, '119A'),
	(41, '124A'),
	(42, '126A'),
	(43, '135A'),
	(44, '136A'),
	(45, '146A'),
	(46, '147A'),
	(47, '149A'),
	(48, '158A'),
	(49, '141A'),
	(50, '151A'),
	(51, '106A'),
	(52, '145A');

-- Volcando estructura para tabla calidad_inti.cat_puestos
CREATE TABLE IF NOT EXISTS `cat_puestos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Puesto` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_puestos: ~3 rows (aproximadamente)
INSERT IGNORE INTO `cat_puestos` (`id`, `Puesto`) VALUES
	(1, 'Administrador'),
	(2, 'Gerencia Calidad'),
	(3, 'Auditor');

-- Volcando estructura para tabla calidad_inti.cat_teamleader
CREATE TABLE IF NOT EXISTS `cat_teamleader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TeamLeader` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_teamleader: ~16 rows (aproximadamente)
INSERT IGNORE INTO `cat_teamleader` (`id`, `TeamLeader`) VALUES
	(1, 'ALEJANDRA'),
	(2, 'AMBAR'),
	(3, 'ANGELA'),
	(4, 'ARACELI'),
	(5, 'DOMINGO'),
	(6, 'ELIAS'),
	(7, 'ELVIA'),
	(8, 'FAUSTINO'),
	(9, 'FRANCISCO'),
	(10, 'GUADALUPE'),
	(11, 'HEIDI'),
	(12, 'J. CARLOS'),
	(13, 'LORENA'),
	(14, 'MARENA'),
	(15, 'NOE'),
	(16, 'RAYMUNDO');

-- Volcando estructura para tabla calidad_inti.cat_tecnicos
CREATE TABLE IF NOT EXISTS `cat_tecnicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom_Tecnico` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_tecnicos: ~5 rows (aproximadamente)
INSERT IGNORE INTO `cat_tecnicos` (`id`, `Nom_Tecnico`) VALUES
	(1, 'Adolfo'),
	(2, 'Brayam'),
	(3, 'Alejandro'),
	(4, 'Gerardo'),
	(5, 'Jose Luis');

-- Volcando estructura para tabla calidad_inti.cat_tendido
CREATE TABLE IF NOT EXISTS `cat_tendido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `options_tend` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_tendido: ~19 rows (aproximadamente)
INSERT IGNORE INTO `cat_tendido` (`id`, `options_tend`) VALUES
	(1, 'Tela al Revez'),
	(2, 'Direcciones de Tela mal Tendida'),
	(3, 'Tonos No Aprobados'),
	(4, 'Variacion de Tonos muy Marcada'),
	(5, 'Alineacion en Mat. de Rayas y Barras'),
	(6, 'Mal Tendido'),
	(7, 'Error en el Trazo'),
	(8, 'Cantidad Incompleta de Lienzos en el Tendido'),
	(9, 'Long. Mal Marcada'),
	(10, 'Empalmes Mal Hechos'),
	(11, 'Center Line'),
	(12, 'Tela con Quiebres'),
	(13, 'Tela Barrada'),
	(14, 'No Respetar el Metodo de Trabajo'),
	(15, 'Marcar las Direcciones'),
	(16, 'Tela con Defecto'),
	(17, 'Lienzos Tencionados'),
	(18, 'No Respetar Bandera de Tonos'),
	(19, 'Mal Alineado');

-- Volcando estructura para tabla calidad_inti.cat_tipo_auditoria
CREATE TABLE IF NOT EXISTS `cat_tipo_auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_auditoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.cat_tipo_auditoria: ~5 rows (aproximadamente)
INSERT IGNORE INTO `cat_tipo_auditoria` (`id`, `Tipo_auditoria`) VALUES
	(1, 'Calidad'),
	(2, 'Empaque y Embarque'),
	(3, 'Etiquetas'),
	(4, 'Estampado'),
	(5, 'Corte');

-- Volcando estructura para tabla calidad_inti.datos_ax
CREATE TABLE IF NOT EXISTS `datos_ax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `cliente` varchar(50) DEFAULT '',
  `estilo` varchar(50) DEFAULT '',
  `material` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT '',
  `pieza` varchar(50) DEFAULT '',
  `trazo` varchar(50) DEFAULT '',
  `lienzo` varchar(50) DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `yarda_orden` float DEFAULT NULL,
  `yarda_orden_estatus` int(11) DEFAULT NULL,
  `yarda_marcada` int(11) DEFAULT NULL,
  `yarda_marcada_estatus` int(11) DEFAULT NULL,
  `yarda_tendido` int(11) DEFAULT NULL,
  `yarda_tendido_estatus` int(11) DEFAULT NULL,
  `piezas_x_bulto` int(11) DEFAULT NULL,
  `numero_bulto` int(11) DEFAULT NULL,
  `talla1` int(11) DEFAULT NULL,
  `talla2` int(11) DEFAULT NULL,
  `talla3` int(11) DEFAULT NULL,
  `largo_trazo` int(11) DEFAULT NULL,
  `ancho_trazo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='datos que son obtenidos mediante el sistema AX';

-- Volcando datos para la tabla calidad_inti.datos_ax: ~8 rows (aproximadamente)
INSERT IGNORE INTO `datos_ax` (`id`, `orden`, `estatus`, `cliente`, `estilo`, `material`, `color`, `pieza`, `trazo`, `lienzo`, `created_at`, `updated_at`, `deleted_at`, `fecha_inicio`, `yarda_orden`, `yarda_orden_estatus`, `yarda_marcada`, `yarda_marcada_estatus`, `yarda_tendido`, `yarda_tendido_estatus`, `piezas_x_bulto`, `numero_bulto`, `talla1`, `talla2`, `talla3`, `largo_trazo`, `ancho_trazo`) VALUES
	(1, '1111', '', 'VICTORIA SECRET', 'ESTILO-1010', 'TELA TRANSPARENTE', 'NEGRO', '6767', '6776', '6776', '2024-02-06 18:29:08', '2024-02-07 14:45:56', NULL, '2024-02-07 14:45:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(2, '2222', '', 'CHICOS', 'ESTILO-0101', 'ALGODON', 'CAFE CAMELLO', '5657', '6576', '567', '2024-02-06 18:29:07', '2024-02-07 20:04:08', NULL, '2024-02-07 15:11:08', 123, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, '3333', NULL, 'BEXTE', 'ESTILO-10001', 'POLIESTER', 'GRIS CAMELLO', '234', '234', '324', '2024-02-06 18:29:06', '2024-02-06 23:56:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(4, '4444', '', 'INTIMARK', 'ESTILO-CAMELLO', 'HILO CAÑAMO', 'NEGRO', '213', '123', '123', '2024-02-06 18:29:06', '2024-02-07 20:07:04', NULL, '2024-02-07 17:46:17', 45354, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(5, 'OP0043077', '', 'INTIMARK', '11244B55', 'MODAL', 'CAFE', '33232', '233232', '2332', '2024-02-06 17:16:54', '2024-02-07 20:13:32', NULL, '2024-02-07 14:42:49', 67, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'OP0043078', '', 'CHICOS', '11244B56', 'MODAL', 'NEGRO', '456', '456', '456', '2024-02-06 22:45:40', '2024-02-08 00:50:16', NULL, '2024-02-07 20:06:30', 345, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'OP0043079', '', 'VICTORIA SECRET', '11244B57', 'MODAL', 'BLANCO', '7868', '678', '678', '2024-02-06 22:45:40', '2024-02-08 15:00:11', NULL, '2024-02-07 20:12:32', 324.567, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'OP0043080', '', 'VICTORIA SECRET', '11244B58', 'MODAL', 'NEGRO', '567', '567', '567', '2024-02-06 22:45:40', '2024-02-07 20:11:45', NULL, '2024-02-07 20:11:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- Volcando estructura para tabla calidad_inti.defectos_screenprint
CREATE TABLE IF NOT EXISTS `defectos_screenprint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Defecto` varchar(200) DEFAULT NULL,
  `Definicion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.defectos_screenprint: ~29 rows (aproximadamente)
INSERT IGNORE INTO `defectos_screenprint` (`id`, `Defecto`, `Definicion`) VALUES
	(1, 'Descentrado', 'Cuando el arte está mal ubicado y no está en el centro según las especificaciones del cliente.'),
	(2, 'Arte Equivocado (Otros)', 'Cuando en un desarrollo hay variación de tamaños y se pone un arte en la talla que no corresponde.'),
	(3, 'Fuera de Medida', 'Cuando se pone la prenda en una ubicación incorrecta, y afecta a la medida solicitada por el cliente.'),
	(4, 'Marca de paleta', 'Cuando hay que hacer presión para que pase la tinta de forma uniforme y por el acabado de la tela (silicona) se hace una marca.'),
	(5, 'Deformación por Goma', 'Cuando por exceso de goma al sacar el panel o la prenda se deforma el arte (en muchos casos este defecto se origina al ubicar la prenda o panel en el tablero).'),
	(6, 'Fuera de Registro', 'Cuando el arte lleva más de dos colores (cuadros) y no se ve definido.'),
	(7, 'Arte Cortado', 'Cuando por falta de goma se dobla la tela y origina que una parte del stampado no aparezca en la prenda (falta de goma).'),
	(8, 'Falta de Tinta', 'Cuando por un descuido del colaborador encargado de remover la tinta se queda un marco sin la cantidad necesaria de tinta y no imprime una parte del gráfico.'),
	(9, 'Poros', 'Cuando por el trabajo en la máquina, el cuadro pierde parte de la emulsión que bloquea el pase de tinta donde no se necesita originando tinta en partes donde no debe.'),
	(10, 'Tono de Tinta', 'Cuando por el tipo de técnica el calor de los flash hace que se vuelva la tinta más espesa y cambia el tono de la tinta.'),
	(11, 'Contaminado(Hilos)', 'Defecto externo que perjudica el estampado (se debe detectar al inicio de la producción).'),
	(12, 'Contaminado(Sucio)', 'Defecto externo que perjudica el estampado (se debe detectar al inicio de la producción).'),
	(13, 'Contaminado(Pelusa)', 'Defecto externo que perjudica el estampado (se debe detectar al inicio de la producción).'),
	(14, 'Quemado', 'Cuando el flash o el horno están demasiado altos (se debe detectar al inicio de la producción).'),
	(15, 'Falta de Escarcha', 'Cuando el arte no lleva la cantidad aprobada de escarcha de arranque.'),
	(16, 'Exceso de Adhesivo', 'Cuando se utiliza mucho adhesivo en las paletas y la prenda sale pegajosa e inclusive deforme.'),
	(17, 'Manchas', 'Cuando se trabaja un full covertura y al retirar la pieza por no tener de donde sacarla se mancha o cuando se saca mal la prenda o no estira bien en el horno y la tinta aún no está curada o por telas o manos sucias.'),
	(18, 'Exceso de Escarcha', 'Cuando el arte lleva más escarcha que la aprobación del arranque.'),
	(19, 'Problemas Mecanicos(Otros)', 'Cuando es un problema que afecta al print, normalmente afecta a las prendas ya posicionadas en las paletas (falta de aire o energía).'),
	(20, 'HD/Foil Picado', 'Cuando el foil sobre todo deja unos huequitos al pegarlo, en el caso del HD es una malla sucia.'),
	(21, 'Arrugas Pliegues', 'Cuando no se estira bien el panel o la prenda en el tablero y quedan arrugas que impiden la impresión total del arte.'),
	(22, 'Exceso de Brillo', 'No es un defecto como tal se da por otros defectos (horno alto, flash alto, exceso de tinta, tinta espesa, falta de presión en el brazo de máquina).'),
	(23, 'Inclinado', 'Cuando la prenda se ubica torcida con la relación al print y en apariencia se ve chueco no es lo mismo que deforme.'),
	(24, 'Falto de Flock', 'Cuando el flock no pega en alguna parte del arte.'),
	(25, 'HD Bajo', 'Cuando el HD no está de acuerdo a la pieza aprobada en el arranque de producción.'),
	(26, 'Falto de Foil', 'Cuando el foil no pega en alguna parte del arte.'),
	(27, 'Cuarteado', 'Cuando por falta de curado se estira la prenda al salir del horno o al retirarla mal de la paleta y ya no se puede recuperar.'),
	(28, 'Arranque de Producción', 'Cuando se inicia una producción y hay que hacer ajustes con la tela o prenda correcta hasta conseguir tacto y color correcto.'),
	(29, 'Otros (Especificar)', 'Cualquier defecto que no esté especificado en los anteriores.');

-- Volcando estructura para tabla calidad_inti.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla calidad_inti.migrations: ~0 rows (aproximadamente)

-- Volcando estructura para tabla calidad_inti.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.password_resets: ~1 rows (aproximadamente)
INSERT IGNORE INTO `password_resets` (`email`, `token`, `created_at`) VALUES
	('adejesus@intimark.com.mx', '$2y$10$96T0QPmXz9HqJHYqjCJSZOioiES0BQ2.oZI7JruoZ2h62g43LgmqO', '2024-01-23 01:24:18');

-- Volcando estructura para tabla calidad_inti.reporte_auditoria_etiquetas
CREATE TABLE IF NOT EXISTS `reporte_auditoria_etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` varchar(50) DEFAULT NULL,
  `estilo_id` varchar(50) DEFAULT '0',
  `no_recibo_id` varchar(50) DEFAULT NULL,
  `talla_cantidad_id` varchar(50) DEFAULT NULL,
  `tamaño_muestra_id` int(100) DEFAULT NULL,
  `defecto_id` int(100) DEFAULT NULL,
  `tipo_defecto_id` varchar(250) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` tinyblob DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.reporte_auditoria_etiquetas: ~51 rows (aproximadamente)
INSERT IGNORE INTO `reporte_auditoria_etiquetas` (`id`, `cliente_id`, `estilo_id`, `no_recibo_id`, `talla_cantidad_id`, `tamaño_muestra_id`, `defecto_id`, `tipo_defecto_id`, `observaciones`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(9, '1', '12', '12', '11', 11, NULL, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-21 21:49:35', '2024-01-22 21:49:35', NULL),
	(10, '4', '14', '13', '14', 12, 13, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-21 21:50:25', '2024-01-22 21:50:25', NULL),
	(11, '4', '12', '12', '12', 12, 11, '11', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-21 22:57:17', '2024-01-22 22:57:17', NULL),
	(12, '4', '12', '13', NULL, NULL, 12, '11', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-20 23:59:21', '2024-01-22 23:59:21', NULL),
	(13, '1', '12', '12', 'OP-300', 50, NULL, '11', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-20 00:34:19', '2024-01-23 00:34:19', NULL),
	(14, '4', '14', '13', 'OP-300', 50, 100, '11', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-21 00:35:07', '2024-01-23 00:35:07', NULL),
	(15, '9', '14', '12', 'OP-300', 44, 23, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-22 00:36:01', '2024-01-23 00:36:01', NULL),
	(16, '2', '13', '12', 'OP-300', 44, 0, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-22 00:56:31', '2024-01-23 00:56:31', NULL),
	(17, '4', '13', '13', 'OP-300', 50, 0, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 00:57:21', '2024-01-23 00:57:21', NULL),
	(18, '8', '13', '13', 'OP-300', 50, 0, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 00:57:53', '2024-01-23 00:57:53', NULL),
	(19, '2', '13', '14', 'XL-12', 20, 0, '12', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 02:18:46', '2024-01-23 02:18:46', NULL),
	(20, '6', '12', '13', 'xl-34', 125, 32, '12', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 03:53:12', '2024-01-23 03:53:12', NULL),
	(21, '3', '12', '13', 'xl-34', 3, 10000, '12', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 04:13:53', '2024-01-23 04:13:53', NULL),
	(22, '3', '13', '13', 'xl-34', 800, 5555, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 04:15:57', '2024-01-23 04:15:57', NULL),
	(23, '9', '13', '14', 'OP-300', 2000, 9999, '12', NULL, _binary 0x3000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 04:16:17', '2024-01-23 04:16:17', NULL),
	(24, '4', '12', '12', 'prueba', 8, 12, '12', NULL, _binary 0x31, '2024-01-23 04:30:11', '2024-01-23 04:30:11', NULL),
	(25, '1', '13', '12', 'SEGUNDA-PRUEBA', 500, 599, '12', NULL, _binary 0x30, '2024-01-23 04:35:07', '2024-01-23 04:35:07', NULL),
	(26, '3', '13', '13', 'xl-34', 800, 5555, '12', NULL, _binary 0x3100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, '2024-01-23 04:15:57', '2024-01-23 04:15:57', NULL),
	(27, '6', '13', '12', 'CHANGE', 20, 6969, '12', NULL, _binary 0x30, '2024-01-23 04:48:50', '2024-01-23 04:48:50', NULL),
	(28, '10', '12', '11', 'XL-12', 32, 555, '11', NULL, _binary 0x31, '2024-01-23 05:21:47', '2024-01-23 05:21:47', NULL),
	(29, '9', '12', '11', 'PRUEBA', 5, 345, '12', NULL, _binary 0x30, '2024-01-23 05:24:58', '2024-01-23 05:24:58', NULL),
	(30, '2', '12', '11', 'PRUEBA', 8, 666, '11', NULL, _binary 0x30, '2024-01-22 05:25:22', '2024-01-23 05:25:22', NULL),
	(31, '11', '12', '11', '3R-200', 32, 200, '12', NULL, _binary 0x30, '2024-01-11 05:47:07', '2024-01-11 05:47:07', NULL),
	(32, '11', '12', '13', '3R-1800', 125, 1800, '12', NULL, _binary 0x30, '2024-01-11 05:47:45', '2024-01-11 05:47:45', NULL),
	(33, '11', '12', '12', 'OP-300', 50, 0, '11', NULL, _binary 0x31, '2023-07-28 05:50:12', '2023-07-28 05:50:12', NULL),
	(34, '11', '12', '12', 'IP-400', 50, 0, '11', NULL, _binary 0x31, '2023-07-28 05:50:12', '2023-07-28 05:50:12', NULL),
	(35, '11', '12', '12', '2P-253', 32, 0, '11', NULL, _binary 0x31, '2023-07-28 05:50:12', '2023-07-28 05:50:12', NULL),
	(36, '1', '12', '11', 'PRUEBA', 200, 0, '11', NULL, _binary 0x30, '2024-01-23 05:54:00', '2024-01-23 05:54:00', NULL),
	(37, '1', '12', '11', 'OP-300', 200, 0, '11', NULL, _binary 0x31, '2024-01-23 06:02:19', '2024-01-23 06:02:19', NULL),
	(38, '3', '12', '11', 'PRUEBA', 5, 345, '12', NULL, _binary 0x30, '2024-01-24 03:31:05', '2024-01-24 03:31:05', NULL),
	(39, '1', '12', '11', 'OP-300', 50, 333, '12', NULL, _binary 0x30, '2024-01-24 03:31:36', '2024-01-24 03:31:36', NULL),
	(40, '2', '12', '12', '76', 200, 8787, '12', NULL, _binary 0x31, '2024-01-24 23:28:26', '2024-01-24 23:28:26', NULL),
	(41, '1', '12', '11', 'XL-34', 200, 456, '11', NULL, _binary 0x31, '2024-01-25 03:40:14', '2024-01-25 03:40:14', NULL),
	(42, '5', '12', '12', 'XXXXX', 8, 1000001, '11', NULL, _binary 0x30, '2024-01-25 04:09:23', '2024-01-25 04:09:23', NULL),
	(43, '9', '12', '11', 'XXXXX', 50, 45, '11', NULL, _binary 0x31, '2024-01-25 04:16:59', '2024-01-25 04:16:59', NULL),
	(44, '4', '12', '12', 'XXXXX', 50, 34, '12', NULL, _binary 0x31, '2024-01-25 04:54:46', '2024-01-25 04:54:46', NULL),
	(45, '4', '13', '11', 'XXXXX', 50, 87, '12', NULL, _binary 0x31, '2024-01-25 05:00:56', '2024-01-25 05:00:56', NULL),
	(46, '3', '13', '12', 'XXXXX', 50, 56, '11', NULL, _binary 0x30, '2024-01-25 05:37:02', '2024-01-25 05:37:02', NULL),
	(47, '7', '12', '11', 'XL-12', 50, 9999, '12', NULL, _binary 0x30, '2024-01-25 05:37:21', '2024-01-25 05:37:21', NULL),
	(48, '11', '12', '12', 'XL-12', 50, 7567, '12', NULL, _binary 0x31, '2024-01-25 05:37:39', '2024-01-25 05:37:39', NULL),
	(49, '11', '15', '11', 'PRUEBA', 546, 35, '12', NULL, _binary 0x31, '2024-01-25 05:40:03', '2024-01-25 05:40:03', NULL),
	(50, '1', '12', '11', 'OP-300', 50, 54, '11', NULL, _binary 0x31, '2024-01-29 20:55:22', '2024-01-29 20:55:22', NULL),
	(51, '1', '12', '12', '45', 8, 0, '11', NULL, _binary 0x30, '2024-01-30 03:30:51', '2024-01-30 03:30:51', NULL),
	(52, '1', '12', '13', 'PRUEBA', 5, 3445, '12', NULL, _binary 0x31, '2024-01-30 23:44:53', '2024-01-30 23:44:53', NULL),
	(53, '1', '14', '14', 'OP-300', 8, 78, '11', NULL, _binary 0x31, '2024-01-30 23:45:38', '2024-01-30 23:45:38', NULL),
	(54, '1', '15', '13', 'PRUEBA', 50, 4, '11', NULL, _binary 0x30, '2024-01-30 23:46:09', '2024-01-30 23:46:09', NULL),
	(55, '1', '12', '12', 'OP-300', 2, 656, '12', NULL, _binary 0x31, '2024-02-01 01:26:48', '2024-02-01 01:26:48', NULL),
	(56, '1', '17', '11', '18', 50, 555, '12', NULL, _binary 0x31, '2024-02-02 06:48:21', '2024-02-02 06:48:21', NULL),
	(57, '1', '17', '11', '12', 50, 213, '11', NULL, _binary 0x30, '2024-02-02 06:51:50', '2024-02-02 06:51:50', NULL),
	(58, '15', '12', '12', '13', 50, 34, '11', NULL, _binary 0x30, '2024-02-02 06:53:21', '2024-02-02 06:53:21', NULL),
	(59, '1', '11', '11', '13', 50, 34, '11', NULL, _binary 0x31, '2024-02-07 04:26:27', '2024-02-07 04:26:27', NULL);

-- Volcando estructura para tabla calidad_inti.screen_print
CREATE TABLE IF NOT EXISTS `screen_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Status` varchar(50) DEFAULT NULL,
  `Auditor` varchar(190) DEFAULT NULL,
  `Cliente` varchar(190) DEFAULT NULL,
  `Estilo` varchar(190) DEFAULT NULL,
  `OP_Defec` varchar(190) DEFAULT NULL,
  `Tecnico` varchar(190) DEFAULT NULL,
  `Color` varchar(190) DEFAULT NULL,
  `Num_Grafico` varchar(190) DEFAULT NULL,
  `Tecnica` varchar(190) DEFAULT NULL,
  `Fibras` varchar(190) DEFAULT NULL,
  `Porcen_Fibra` varchar(50) DEFAULT NULL,
  `Tipo_Problema` varchar(250) DEFAULT NULL,
  `Ac_Correctiva` varchar(190) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.screen_print: ~3 rows (aproximadamente)
INSERT IGNORE INTO `screen_print` (`id`, `Status`, `Auditor`, `Cliente`, `Estilo`, `OP_Defec`, `Tecnico`, `Color`, `Num_Grafico`, `Tecnica`, `Fibras`, `Porcen_Fibra`, `Tipo_Problema`, `Ac_Correctiva`, `created_at`, `updated_at`) VALUES
	(124, 'Update', 'Gerardo Vergara Mendoza', 'CHICOS', '11244B56', 'OP0043078', 'Adolfo', '3e', '324', 'Base Agua', 'Algodón', '23', 'Arte Equivocado (Otros)', 'MA.MAQUINA EN ALTO', '2024-02-19 19:41:02', '2024-02-19 19:41:25'),
	(125, 'Nuevo', 'Gerardo Vergara Mendoza', 'BEXTE', 'ESTILO-10001', '3333', 'Brayam', 'dd3', 'da3', 'Flock', 'Polyester', '23', 'Tono de Tinta', 'PP.PLANCHADO DE PIEZAS', '2024-02-19 20:11:49', '2024-02-19 20:11:49'),
	(126, 'Nuevo', 'Gerardo Vergara Mendoza', 'CHICOS', 'ESTILO-0101', '2222', 'Alejandro', '354', 'fdsfs', 'Flock', 'licra', '34', 'Descentrado', 'AS.AVISO A SUPERVISOR', '2024-02-19 21:20:58', '2024-02-19 21:20:58');

-- Volcando estructura para tabla calidad_inti.tipo_fibra
CREATE TABLE IF NOT EXISTS `tipo_fibra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_Fibra` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.tipo_fibra: ~4 rows (aproximadamente)
INSERT IGNORE INTO `tipo_fibra` (`id`, `Tipo_Fibra`, `created_at`, `updated_at`) VALUES
	(1, 'Otra', NULL, NULL),
	(2, 'Polyester', NULL, NULL),
	(3, 'Algodón', NULL, NULL),
	(10, 'licra', '2024-02-14 23:37:02', '2024-02-14 23:37:02');

-- Volcando estructura para tabla calidad_inti.tipo_tecnica
CREATE TABLE IF NOT EXISTS `tipo_tecnica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo_tecnica` varchar(190) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla calidad_inti.tipo_tecnica: ~8 rows (aproximadamente)
INSERT IGNORE INTO `tipo_tecnica` (`id`, `Tipo_tecnica`, `created_at`, `updated_at`) VALUES
	(1, 'Otra', NULL, NULL),
	(2, 'Base Agua', NULL, NULL),
	(3, 'Flock', NULL, NULL),
	(4, 'Glitter', NULL, NULL),
	(5, 'Foil', NULL, NULL),
	(6, 'Sugar', NULL, NULL),
	(7, 'High Density', NULL, NULL),
	(8, 'Plastisol', NULL, NULL);

-- Volcando estructura para tabla calidad_inti.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `no_empleado` varchar(20) NOT NULL,
  `password` varchar(191) DEFAULT NULL,
  `puesto` varchar(200) DEFAULT NULL,
  `tipo_auditor` varchar(191) DEFAULT NULL,
  `Estatus` varchar(191) DEFAULT 'Alta',
  `Planta` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `fecha_ultimo_acceso` datetime DEFAULT NULL,
  `fecha_ultima_notificacion` datetime DEFAULT NULL,
  `usuario_creacion_id` bigint(20) unsigned DEFAULT NULL,
  `usuario_actualizacion_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_no_empleado_unique` (`no_empleado`) USING BTREE,
  KEY `users_usuario_creacion_id_foreign` (`usuario_creacion_id`),
  KEY `users_usuario_actualizacion_id_foreign` (`usuario_actualizacion_id`),
  KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=539 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla calidad_inti.users: 4 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `no_empleado`, `password`, `puesto`, `tipo_auditor`, `Estatus`, `Planta`, `remember_token`, `fecha_ultimo_acceso`, `fecha_ultima_notificacion`, `usuario_creacion_id`, `usuario_actualizacion_id`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador del Sistema', 'admin@hotmail.com', '1', '$2y$10$U2sg1kgo5ZFN2XyYO5SAn.MP6LIRJBFxeO5tcahAvfdWvdwBcDqWW', 'Administrador', NULL, 'Alta', NULL, NULL, '2023-06-06 18:31:29', '2023-02-01 00:00:00', NULL, NULL, '2020-11-04 19:34:26', '2024-01-30 00:20:38'),
	(2, 'Gerardo Vergara Mendoza', 'gvm7506@gmail.com', '2', '$2y$10$7N.rGO6qbRdNVFKWwKF5ieXZC9HIB7CazRicYwDepcBDoL3t60KOG', 'Administrador', NULL, 'Alta', NULL, 'aNg6h9ghbNjkREtbeawCGHe5w0pnn8MF8ynN5ldYVI58psA4p1fo3r3wwjZ8', '2023-12-19 11:08:19', '2023-02-01 00:00:00', NULL, NULL, '2020-11-04 19:34:26', '2024-01-26 22:29:09'),
	(520, 'Brayam', 'bteofilo@intimark.com.mx', '18080', '$2y$10$r/fhvAUeHZILq7x6nBq74eMYCwmB3NmIp/ZZACS40Ba7WIr1TZOCi', 'Administrador', '', 'Alta', NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-22 23:52:24', '2024-01-26 22:29:07'),
	(519, 'Adolfo', 'adejesus@intimark.com.mx', '23015', '$2y$10$jsCC4VeuuypTsc9A5O14aeBnWEbSgXKAXZ41Sc5NYSzq5aMbfgxM.', 'Administrador', 'Calidad', 'Alta', 'Planta1', NULL, NULL, NULL, NULL, NULL, '2024-01-22 23:51:13', '2024-01-26 22:39:13');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
