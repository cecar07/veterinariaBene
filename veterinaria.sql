-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2025 a las 19:18:44
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
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `id_veterinario` int(11) NOT NULL,
  `id_recepcionista` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text DEFAULT NULL,
  `estado` enum('pendiente','confirmada','cancelada','reagendada') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_mascota`, `id_veterinario`, `id_recepcionista`, `fecha`, `hora`, `motivo`, `estado`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 3, '2025-08-29', '10:00:00', 'Rutinario', 'reagendada', '2025-08-23 21:59:37', '2025-08-23 22:12:16'),
(4, 1, 2, 3, '2025-08-25', '15:00:00', 'Rutina', 'cancelada', '2025-08-23 22:02:32', '2025-08-23 22:11:43'),
(5, 2, 2, 1, '2025-08-27', '10:00:00', 'Consulta de rutina', 'confirmada', '2025-08-23 22:09:28', '2025-10-19 09:45:58'),
(6, 3, 1, 3, '2025-08-26', '15:00:00', 'Consulta Rutinaria', 'confirmada', '2025-08-24 15:28:51', '2025-08-24 15:29:10'),
(7, 5, 1, 1, '2025-08-24', '18:00:00', 'Rutinario', 'cancelada', '2025-08-24 21:27:52', '2025-09-10 20:49:31'),
(8, 4, 2, 1, '2025-08-24', '19:00:00', 'Consulta rutinaria', 'cancelada', '2025-08-24 21:37:54', '2025-09-10 20:49:19'),
(9, 3, 2, 1, '2025-08-24', '19:30:00', 'Vomito', 'reagendada', '2025-08-24 21:48:02', '2025-09-10 20:48:51'),
(10, 3, 2, 3, '2025-09-11', '14:00:00', 'Rutina', 'pendiente', '2025-09-10 20:47:05', '2025-09-10 20:47:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `id_veterinario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `tratamiento` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('en curso','finalizada','anulada') DEFAULT 'en curso',
  `id_recepcionista` int(11) DEFAULT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `sintomas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `id_mascota`, `id_veterinario`, `fecha`, `hora`, `motivo`, `diagnostico`, `tratamiento`, `observaciones`, `estado`, `id_recepcionista`, `id_cita`, `sintomas`) VALUES
(6, 1, 2, '2025-08-25', '15:00:00', 'consulta de rutina', 'nada grave', 'baño medicado', NULL, 'finalizada', NULL, 4, 'picazón'),
(7, 1, 1, '2025-08-24', '19:38:00', 'Rutina', 'sin nada', 'Sin nada', NULL, 'finalizada', NULL, 3, 'sin nada'),
(8, 3, 1, '2025-08-26', '15:00:00', 'Rutinario', 'Caída de pelo, golpe en la pata izquierda delantera, sin ser muy grave', 'para la caída del pelo un jabón para el baño por lo menos 2 veces a la semana, y para la pata solo vendamos', NULL, 'finalizada', NULL, 6, 'Nada que agregar'),
(10, 2, 2, '2025-08-27', '10:15:00', 'Rutinario', 'Alergia en la piel', 'Baño medicado', NULL, 'finalizada', NULL, 5, 'Caída del pelo'),
(11, 5, 1, '2025-08-25', '10:00:00', 'Rutina', 'Alergia', 'baño medicado y antiparasitarios', NULL, 'finalizada', NULL, 7, 'caida del pelo'),
(12, 4, 2, '2025-08-24', '19:00:00', 'Consulta de Rutina', 'Embarazo', 'Cuidado en la alimentacion', NULL, 'finalizada', NULL, 8, 'Vómitos y diarrea'),
(13, 3, 2, '0000-00-00', '00:00:00', NULL, 'prueba', NULL, NULL, 'en curso', NULL, 9, 'prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_clinico`
--

CREATE TABLE `historial_clinico` (
  `id_historial` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `diagnostico` text DEFAULT NULL,
  `sintomas` text DEFAULT NULL,
  `estado` enum('en curso','finalizada','anulada') DEFAULT 'en curso',
  `creado_por` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_clinico`
--

INSERT INTO `historial_clinico` (`id_historial`, `id_mascota`, `id_consulta`, `fecha`, `diagnostico`, `sintomas`, `estado`, `creado_por`, `created_at`) VALUES
(1, 2, 10, '2025-08-24', 'Alergia en la piel', 'Caída del pelo', 'en curso', 1, '2025-08-24 21:22:49'),
(2, 4, 12, '2025-08-24', 'Embarazo', 'Vómitos y diarrea', 'en curso', 1, '2025-08-24 21:39:02'),
(3, 3, 13, '2025-08-24', 'prueba', 'prueba', 'en curso', 2, '2025-08-24 22:22:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascotas`
--

CREATE TABLE `mascotas` (
  `id_mascota` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `especie` varchar(50) DEFAULT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `sexo` enum('Macho','Hembra') DEFAULT NULL,
  `id_propietario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascotas`
--

INSERT INTO `mascotas` (`id_mascota`, `nombre`, `especie`, `raza`, `edad`, `sexo`, `id_propietario`) VALUES
(1, 'Tobi', 'Perro', 'Buldog Francés', 5, 'Macho', 1),
(2, 'Mia', 'Perro', 'Boxer', 5, 'Hembra', 2),
(3, 'Coco', 'Perro', 'Mestizo', 12, 'Macho', 3),
(4, 'Flopi', 'Gato', 'Angora', 2, 'Hembra', 4),
(5, 'Bluey', 'Perro', 'Pastor Ganadero Australiano', 2, 'Hembra', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE `propietarios` (
  `id_propietario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`id_propietario`, `nombre`, `direccion`, `telefono`, `email`) VALUES
(1, 'Pedro Farias', 'Choferes 123', '0985321123', 'pedro123@gmail.com'),
(2, 'Marta Vargas', 'San Juan c/ Villa Z', '0982696867', 'martav@gmail.com'),
(3, 'Lucas Acosta', 'San Lorenzo', '0991321123', 'lucasa@gmail.com'),
(4, 'Carmen Magali', 'Manuel Domínguez y Mexico', '0981321123', 'carmen@gmail.com'),
(5, 'Fio Cardozo', 'Quesada y Roque González', '0991202020', 'fiocardo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id_tratamiento` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `medicamentos` text DEFAULT NULL,
  `duracion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`id_tratamiento`, `id_consulta`, `descripcion`, `medicamentos`, `duracion`) VALUES
(2, 10, 'Baño medicado', '', ''),
(3, 11, 'baño medicado y antiparasitarios', 'Clorhexidina y el Peróxido de Benzoilo para infecciones bacterianas y fúngicas, la Avena Coloidal para calmar la piel, y el Amitraz para el tratamiento de parásitos como ácaros', '5 dias'),
(4, 12, 'Cuidado en la alimentacion', 'vitaminas', '5 dias seguidos'),
(5, 13, 'prueba', 'prueba', '2 dias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('admin','veterinario','recepcionista') DEFAULT 'veterinario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `usuario`, `contrasena`, `rol`) VALUES
(1, 'Admin_001', 'admin', '$2y$10$ELuIs7lndBM5BEOq1smPdOwOliUSf0pFJKyphG9LxYkYG51xgWOOq', 'admin'),
(2, 'Dr. Juan Barreto', 'drjuan', '$2y$10$SZ1xe7doXA2hSl8.Goo1uOJw/dZLNHp5j9ot/8aV6md0291QxnstO', 'veterinario'),
(3, 'Sara Connor', 'sara', '$2y$10$yaa8b5za0VvZSygoIUd0w.GlTDEgTUaa6.k2d9b8p7zPwl.99FP8q', 'recepcionista'),
(4, 'Dra. Marina Galeano', 'drmar', '$2y$10$CnVAHmoRI4RXpW3KwanpXeF.LOQ.3EaJiod9fxrHCb9N5ZEIKbx6q', 'veterinario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas`
--

CREATE TABLE `vacunas` (
  `id_vacuna` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `nombre_vacuna` varchar(100) DEFAULT NULL,
  `fecha_aplicacion` date DEFAULT NULL,
  `proxima_dosis` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinarios`
--

CREATE TABLE `veterinarios` (
  `id_veterinario` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `veterinarios`
--

INSERT INTO `veterinarios` (`id_veterinario`, `id_usuario`, `especialidad`) VALUES
(1, 2, 'Cirujano.'),
(2, 4, 'Clínica General');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_veterinario` (`id_veterinario`),
  ADD KEY `id_recepcionista` (`id_recepcionista`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_veterinario` (`id_veterinario`),
  ADD KEY `fk_consultas_recepcionista` (`id_recepcionista`),
  ADD KEY `fk_consultas_cita` (`id_cita`);

--
-- Indices de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_mascota` (`id_mascota`),
  ADD KEY `id_consulta` (`id_consulta`),
  ADD KEY `creado_por` (`creado_por`);

--
-- Indices de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_propietario` (`id_propietario`);

--
-- Indices de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  ADD PRIMARY KEY (`id_propietario`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id_tratamiento`),
  ADD KEY `id_consulta` (`id_consulta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  ADD PRIMARY KEY (`id_vacuna`),
  ADD KEY `id_mascota` (`id_mascota`);

--
-- Indices de la tabla `veterinarios`
--
ALTER TABLE `veterinarios`
  ADD PRIMARY KEY (`id_veterinario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mascotas`
--
ALTER TABLE `mascotas`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  MODIFY `id_propietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id_tratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `vacunas`
--
ALTER TABLE `vacunas`
  MODIFY `id_vacuna` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `veterinarios`
--
ALTER TABLE `veterinarios`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_veterinario`) REFERENCES `veterinarios` (`id_veterinario`),
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_recepcionista`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`),
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`id_veterinario`) REFERENCES `veterinarios` (`id_veterinario`),
  ADD CONSTRAINT `fk_consultas_cita` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`),
  ADD CONSTRAINT `fk_consultas_recepcionista` FOREIGN KEY (`id_recepcionista`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `historial_clinico`
--
ALTER TABLE `historial_clinico`
  ADD CONSTRAINT `historial_clinico_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`),
  ADD CONSTRAINT `historial_clinico_ibfk_2` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id_consulta`),
  ADD CONSTRAINT `historial_clinico_ibfk_3` FOREIGN KEY (`creado_por`) REFERENCES `veterinarios` (`id_veterinario`);

--
-- Filtros para la tabla `mascotas`
--
ALTER TABLE `mascotas`
  ADD CONSTRAINT `mascotas_ibfk_1` FOREIGN KEY (`id_propietario`) REFERENCES `propietarios` (`id_propietario`);

--
-- Filtros para la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD CONSTRAINT `tratamientos_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id_consulta`);

--
-- Filtros para la tabla `vacunas`
--
ALTER TABLE `vacunas`
  ADD CONSTRAINT `vacunas_ibfk_1` FOREIGN KEY (`id_mascota`) REFERENCES `mascotas` (`id_mascota`);

--
-- Filtros para la tabla `veterinarios`
--
ALTER TABLE `veterinarios`
  ADD CONSTRAINT `veterinarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
