-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2019 a las 20:31:31
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sistema_de_examenes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tipoUsuario` varchar(5) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `fechaDeRegistro` datetime DEFAULT NULL,
  `fechaDeActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_de_examen`
--

CREATE TABLE IF NOT EXISTS `configuracion_de_examen` (
  `configEx_id` int(11) NOT NULL AUTO_INCREMENT,
  `configEx_examen` int(11) DEFAULT NULL,
  `configEx_horaDeAplicacion` time DEFAULT NULL,
  `configEx_fechaDeAplicacion` date DEFAULT NULL,
  `configEx_horaDeExpiracion` time DEFAULT NULL,
  `configEx_fechaDeExpiracion` date DEFAULT NULL,
  `configEx_tiempoLimite` time DEFAULT NULL,
  `configEx_promMin` int(11) DEFAULT NULL,
  PRIMARY KEY (`configEx_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE IF NOT EXISTS `examenes` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_nombre` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `exam_instrucciones` text COLLATE utf8_spanish_ci,
  `exam_status` int(11) DEFAULT NULL,
  `exam_fechaRegistro` datetime DEFAULT NULL,
  `exam_fechaActualizar` datetime DEFAULT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_realizados`
--

CREATE TABLE IF NOT EXISTS `examenes_realizados` (
  `er_id` int(11) NOT NULL AUTO_INCREMENT,
  `er_examen` int(11) DEFAULT NULL,
  `er_alumno` int(11) DEFAULT NULL,
  `er_correctas` int(11) DEFAULT NULL,
  `er_incorrectas` int(11) DEFAULT NULL,
  `er_promedio` int(11) DEFAULT NULL,
  PRIMARY KEY (`er_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE IF NOT EXISTS `preguntas` (
  `preg_id` int(11) NOT NULL AUTO_INCREMENT,
  `preg_pregunta` text COLLATE utf8_spanish_ci,
  `preg_examen` int(11) DEFAULT NULL,
  `preg_fechaRegistro` datetime DEFAULT NULL,
  `preg_fechaActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`preg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE IF NOT EXISTS `respuestas` (
  `resp_id` int(11) NOT NULL AUTO_INCREMENT,
  `resp_texto` text COLLATE utf8_spanish_ci,
  `resp_pregunta` int(11) DEFAULT NULL,
  `resp_examen` int(11) DEFAULT NULL,
  `resp_correcta` int(11) DEFAULT NULL,
  `resp_fechaRegistro` datetime DEFAULT NULL,
  `resp_fechaActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`resp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=207 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuario` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estado` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tipoUsuario` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechaDeRegistro` datetime DEFAULT NULL,
  `fechaDeActualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `estado`, `tipoUsuario`, `fechaDeRegistro`, `fechaDeActualizacion`) VALUES
(4, 'administrador de sistema', 'admin', '$2y$09$RpQ.xiT9oJjN38o90mWIq.NAvDGus4llxhJXpFA9kqrXFMhWad/se', '1', 'admin', '2019-03-28 19:08:48', '2019-10-07 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
