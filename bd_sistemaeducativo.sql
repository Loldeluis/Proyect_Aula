-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 11:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_sistemaeducativo`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesos_usuario`
--

CREATE TABLE `accesos_usuario` (
  `id_acceso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_institucion` int(11) DEFAULT NULL,
  `acceso_docente` tinyint(1) DEFAULT 0,
  `acceso_estudiante` tinyint(1) DEFAULT 0,
  `fecha_asignacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id_ejercicio` int(11) NOT NULL,
  `id_nivel` int(11) DEFAULT NULL,
  `enunciado` text NOT NULL,
  `respuesta_correcta` text NOT NULL,
  `tipo_ejercicio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instituciones`
--

CREATE TABLE `instituciones` (
  `id_institucion` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `dificultad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reporte_usuario`
--

CREATE TABLE `reporte_usuario` (
  `id_reporte` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_ejercicio` int(11) DEFAULT NULL,
  `fecha_reporte` datetime DEFAULT current_timestamp(),
  `estado_ejercicio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` enum('admin','estudiante','docente') NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `cedula`, `nombre_usuario`, `correo`, `clave`, `rol`, `estado`) VALUES
(2, '1041974755', 'camilo', 'camilo@gmail.com', '$2y$10$vvAz5/VH1IGHkEC4dIfWb.faX2k7McCQ3mexebrcG0/wF7FR1A0cu', 'estudiante', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_instituciones`
--

CREATE TABLE `usuarios_instituciones` (
  `id_usuario` int(11) NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesos_usuario`
--
ALTER TABLE `accesos_usuario`
  ADD PRIMARY KEY (`id_acceso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_institucion` (`id_institucion`);

--
-- Indexes for table `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indexes for table `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id_institucion`);

--
-- Indexes for table `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indexes for table `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indexes for table `usuarios_instituciones`
--
ALTER TABLE `usuarios_instituciones`
  ADD PRIMARY KEY (`id_usuario`,`id_institucion`),
  ADD KEY `id_institucion` (`id_institucion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesos_usuario`
--
ALTER TABLE `accesos_usuario`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id_institucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesos_usuario`
--
ALTER TABLE `accesos_usuario`
  ADD CONSTRAINT `accesos_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `accesos_usuario_ibfk_2` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`);

--
-- Constraints for table `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`);

--
-- Constraints for table `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD CONSTRAINT `reporte_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reporte_usuario_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicios` (`id_ejercicio`);

--
-- Constraints for table `usuarios_instituciones`
--
ALTER TABLE `usuarios_instituciones`
  ADD CONSTRAINT `usuarios_instituciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuarios_instituciones_ibfk_2` FOREIGN KEY (`id_institucion`) REFERENCES `instituciones` (`id_institucion`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
