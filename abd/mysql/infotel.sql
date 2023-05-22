-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2023 a las 12:31:10
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infotel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `email_usuario` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `telefono` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`email_usuario`, `nombre`, `apellido`, `telefono`) VALUES
('user1@gmail.com', 'Carlos', 'perez cañas', 123412345),
('user1@gmail.com', 'Maria', 'sanz cañas', 345676543),
('user1@gmail.com', 'Maria', 'sanz perez', 456789870),
('user1@gmail.com', 'Jose', 'roman sanz', 567567456),
('user1@gmail.com', 'Mari sol', 'sanz encinas', 987678767),
('user2@gmail.com', 'Julia', 'lopez roman', 123236787),
('user2@gmail.com', 'Pablo', 'lopez roman', 123456787),
('user2@gmail.com', 'Jose', 'roman sanz', 567567456),
('user4@gmail.com', 'Maria', 'sanz perez', 456789870);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `email_usuario` varchar(255) NOT NULL,
  `telefono_contacto` int(9) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(10) NOT NULL,
  `duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`email_usuario`, `telefono_contacto`, `fecha`, `hora`, `duracion`) VALUES
('user1@gmail.com', 123412345, '1978-05-18', '17:22:51', 27),
('user1@gmail.com', 123412345, '1984-01-15', '23:24:47', 25),
('user1@gmail.com', 567567456, '1975-09-17', '14:55:54', 0),
('user1@gmail.com', 456789870, '1970-03-31', '08:21:10', 59);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`id_tipo`, `tipo`) VALUES
(0, 'administrador'),
(1, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_tipo` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `telefono` int(9) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_tipo`, `id`, `email_usuario`, `nombre`, `apellidos`, `telefono`, `password`) VALUES
(1, 1, 'user1@gmail.com', 'user1', 'cañas encinas', 123456789, 'user'),
(0, 2, 'administrador@gmail.com', 'Maria', 'Cañas', 100000000, 'administrador'),
(1, 3, 'user2@gmail.com', 'user2', 'sanz perez', 111222333, 'user'),
(1, 4, 'user3@gmail.com', 'user3', 'encinas aguerro', 111111222, 'user'),
(1, 5, 'user4@gmail.com', 'user4', 'roman cañas', 222333444, 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD UNIQUE KEY `email_usuario` (`email_usuario`,`telefono`),
  ADD KEY `telefono` (`telefono`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD KEY `telefono_contacto` (`telefono_contacto`),
  ADD KEY `email_usuario` (`email_usuario`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`),
  ADD UNIQUE KEY `telefono` (`telefono`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`email_usuario`) REFERENCES `usuarios` (`email_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`telefono_contacto`) REFERENCES `contactos` (`telefono`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historial_ibfk_3` FOREIGN KEY (`email_usuario`) REFERENCES `contactos` (`email_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_usuarios` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
