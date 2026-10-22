-- Sitio Web Creado por ITred Spa.
-- Direccion: Guido Reni #4190
-- Pedro Aguirre Cerda - Santiago - Chile
-- contacto@itred.cl o itred.spa@gmail.com
-- https://www.itred.cl
-- Creado, Programado y Diseñado por ITred Spa.
-- BPPJ


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
-- 40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
-- 40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
-- 40101 SET NAMES utf8mb4;


--
-- Base de datos: `informes_app`
--

-- IMPORTANTE: crea primero la base de datos y selecciónala antes de importar.
--   XAMPP local: crea `informes_app` (utf8mb4_spanish_ci) en phpMyAdmin.
--   Hosting:     usa la base de datos que te asigna el panel (no permite CREATE DATABASE).


-- ------------------------------------------------------------------------------------------------------------
-- ------------------------- INICIO ITred Spa Base de Datos informes_app .SQL --------------------------------
-- ------------------------------------------------------------------------------------------------------------


-- -------------------------------------------
-- Estructura de tabla para la tabla `usuarios`
-- -------------------------------------------

CREATE TABLE `usuarios` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO NOMBRE USUARIO
  `usuario` varchar(100) NOT NULL,

  -- TITULO NOMBRE VISUAL USUARIO
  `nombre_usuario` varchar(150) NOT NULL,

  -- TITULO PASSWORD USUARIO
  `password` varchar(255) NOT NULL,

  -- TITULO FECHA CREACION
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `informes`
-- -------------------------------------------

CREATE TABLE `informes` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO ID USUARIO RELACIONADO
  `id_usuario` int(11) NOT NULL,

  -- TITULO NOMBRE INFORME
  `nombre_informe` varchar(255) NOT NULL,

  -- TITULO CAMPOS PORTADA
  `area_trabajo` varchar(255) NOT NULL DEFAULT '',
  `nombre_1` varchar(255) NOT NULL DEFAULT '',
  `nombre_2` varchar(255) NOT NULL DEFAULT '',
  `nombre_3` varchar(255) NOT NULL DEFAULT '',
  `nombre_4` varchar(255) NOT NULL DEFAULT '',
  `proyecto` varchar(255) NOT NULL DEFAULT '',
  `avance` varchar(255) NOT NULL DEFAULT '',
  `solicitado_por` varchar(255) NOT NULL DEFAULT '',
  `cargo` varchar(255) NOT NULL DEFAULT '',
  `fecha_entrega` varchar(20) NOT NULL DEFAULT '',
  `indice` longtext NOT NULL,

  -- TITULO FECHA CREACION
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),

  CONSTRAINT `informes_ibfk_1`
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `introduccion`
-- -------------------------------------------

CREATE TABLE `introduccion` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO NIVEL DEL TITULO
  `nivel_titulo` varchar(2) NOT NULL DEFAULT '1',

  -- TITULO NUMERO DEL TITULO
  `numero_titulo` varchar(50) NOT NULL DEFAULT '',

  -- TITULO TEXTO DEL TITULO
  `texto_titulo` varchar(255) NOT NULL DEFAULT '',

  -- TITULO CONTENIDO DE LA INTRODUCCION
  `texto_contenido` longtext NOT NULL,

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `id_informe` (`id_informe`),
  CONSTRAINT `introduccion_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `base_datos`
-- -------------------------------------------

CREATE TABLE `base_datos` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO NIVEL DEL TITULO
  `nivel_titulo` varchar(2) NOT NULL DEFAULT '1',

  -- TITULO NUMERO DEL TITULO
  `numero_titulo` varchar(50) NOT NULL DEFAULT '',

  -- TITULO TEXTO DEL TITULO
  `texto_titulo` varchar(255) NOT NULL DEFAULT '',

  -- TITULO CONTENIDO BASE DE DATOS
  `texto_contenido` longtext NOT NULL,

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `id_informe` (`id_informe`),
  CONSTRAINT `base_datos_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `documentacion_caso_uso`
-- -------------------------------------------

CREATE TABLE `documentacion_caso_uso` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO NIVEL Y CONTENIDO TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '1',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',

  -- TITULO NIVEL Y CONTENIDO TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO NIVEL Y CONTENIDO TITULO 3
  `nivel_titulo_3` varchar(2) NOT NULL DEFAULT '3',
  `numero_titulo_3` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_3` varchar(255) NOT NULL DEFAULT '',

  -- TITULO CONTENIDO DOCUMENTACION
  `texto_contenido` longtext NOT NULL,

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `id_informe` (`id_informe`),
  CONSTRAINT `documentacion_caso_uso_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `caso_uso_imagen`
-- -------------------------------------------

CREATE TABLE `caso_uso_imagen` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '1',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DATOS IMAGEN
  `nombre_imagen` varchar(255) NOT NULL DEFAULT '',
  `ruta_imagen` varchar(500) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_orden` (`id_informe`, `orden`),
  CONSTRAINT `caso_uso_imagen_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `carpeta_diagramas`
-- -------------------------------------------

CREATE TABLE `carpeta_diagramas` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '1',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DATOS IMAGEN
  `nombre_imagen` varchar(255) NOT NULL DEFAULT '',
  `ruta_imagen` varchar(500) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_orden` (`id_informe`, `orden`),
  CONSTRAINT `carpeta_diagramas_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `carpeta_informes_programas`
-- -------------------------------------------

CREATE TABLE `carpeta_informes_programas` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '1',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DATOS RUTA
  `ruta_principal` varchar(500) NOT NULL DEFAULT '',
  `sin_manual_momento` tinyint(1) NOT NULL DEFAULT 0,
  `carpeta` varchar(255) NOT NULL DEFAULT '',
  `archivo` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `ruta_extra_1` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_2` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_3` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_4` varchar(500) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_orden` (`id_informe`, `orden`),
  CONSTRAINT `carpeta_informes_programas_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `carpeta_pantallazos_programas`
-- -------------------------------------------

CREATE TABLE `carpeta_pantallazos_programas` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '1',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DATOS IMAGEN
  `nombre_imagen` varchar(255) NOT NULL DEFAULT '',
  `ruta_imagen` varchar(500) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_orden` (`id_informe`, `orden`),
  CONSTRAINT `carpeta_pantallazos_programas_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `carpeta_rutas_estructurales`
-- -------------------------------------------

CREATE TABLE `carpeta_rutas_estructurales` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO SECCION
  `seccion` varchar(80) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '2',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '3',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DATOS RUTA
  `ruta_principal` varchar(500) NOT NULL DEFAULT '',
  `sin_manual_momento` tinyint(1) NOT NULL DEFAULT 0,
  `carpeta` varchar(255) NOT NULL DEFAULT '',
  `archivo` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `ruta_extra_1` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_2` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_3` varchar(500) NOT NULL DEFAULT '',
  `ruta_extra_4` varchar(500) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_seccion_orden` (`id_informe`, `seccion`, `orden`),
  CONSTRAINT `carpeta_rutas_estructurales_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- -------------------------------------------
-- Estructura de tabla para la tabla `carpeta_fuentes_detalle`
-- -------------------------------------------

CREATE TABLE `carpeta_fuentes_detalle` (

  `id` int(11) NOT NULL AUTO_INCREMENT,

  -- TITULO INFORME RELACIONADO
  `id_informe` int(11) NOT NULL,

  -- TITULO SECCION
  `seccion` varchar(80) NOT NULL,

  -- TITULO ORDEN DE SECUENCIA
  `orden` int(11) NOT NULL DEFAULT 1,

  -- TITULO 1
  `nivel_titulo_1` varchar(2) NOT NULL DEFAULT '3',
  `numero_titulo_1` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_1` varchar(255) NOT NULL DEFAULT '',
  `titulo_1_bloqueado` tinyint(1) NOT NULL DEFAULT 0,

  -- TITULO 2
  `nivel_titulo_2` varchar(2) NOT NULL DEFAULT '4',
  `numero_titulo_2` varchar(50) NOT NULL DEFAULT '',
  `texto_titulo_2` varchar(255) NOT NULL DEFAULT '',

  -- TITULO DETALLE FUENTE
  `nombre_fuente` varchar(255) NOT NULL DEFAULT '',

  -- TITULO FECHAS
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `id_informe` (`id_informe`),
  KEY `id_informe_seccion_orden` (`id_informe`, `seccion`, `orden`),
  CONSTRAINT `carpeta_fuentes_detalle_ibfk_1`
  FOREIGN KEY (`id_informe`) REFERENCES `informes` (`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



-- ------------------------------------------------------------------------------------------------------------
-- ------------------------------------- INICIO USUARIO DEMO --------------------------------------------------
-- ------------------------------------------------------------------------------------------------------------

-- TITULO USUARIO DEMO (usuario: demo / contraseña: demo1234, guardada con password_hash)
INSERT INTO `usuarios` (`usuario`, `nombre_usuario`, `password`) VALUES
('demo', 'Usuario Demo', '$2y$10$1BwKveQA3cJZzprsWPbnTu8vd1Kks9/T/VaZyToNelQ0JFX7Pq97m');

-- ------------------------------------------------------------------------------------------------------------
-- --------------------------------------- FIN USUARIO DEMO ---------------------------------------------------
-- ------------------------------------------------------------------------------------------------------------

COMMIT;



-- ------------------------------------------------------------------------------------------------------------
-- -------------------------- FIN ITred Spa Base de Datos informes_app .SQL ----------------------------------
-- ------------------------------------------------------------------------------------------------------------


-- 40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
-- 40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
-- 40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;


-- Sitio Web Creado por ITred Spa.
-- Direccion: Guido Reni #4190
-- Pedro Aguirre Cerda - Santiago - Chile
-- contacto@itred.cl o itred.spa@gmail.com
-- https://www.itred.cl
-- Creado, Programado y Diseñado por ITred Spa.
-- BPPJ
