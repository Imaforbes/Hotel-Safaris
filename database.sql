-- ==============================================================================
-- SISTEMA DE GESTIÓN HOTELERA "SAFARI'S" - ESQUEMA Y DATOS DE PRUEBA (SEED)
-- Autor: Imanol Forbes (Refactorizado 2025)
-- Motor: MySQL 8.0+ / MariaDB 10.5+ (PDO PHP 8+)
-- Juego de Caracteres: UTF-8 (utf8mb4_unicode_ci)
-- ==============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `hotel`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `hotel`;

-- ------------------------------------------------------------------------------
-- 1. TABLA: empleados
-- Maneja usuarios administrativos y del personal del hotel (con roles y contraseñas hash)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `Codigo_empl` int(11) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `passwor` varchar(255) NOT NULL COMMENT 'Almacena hash bcrypt generado con password_hash()',
  `Nombre` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Cargo` varchar(100) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'empleado' COMMENT 'Valores: admin, empleado',
  PRIMARY KEY (`Codigo_empl`),
  UNIQUE KEY `uk_empleado_usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contraseñas precargadas:
-- ADMIN:    'admin123'    -> $2y$10$1RrTDnbaoiwmxXmTnmvq3Oq1k.GYH5IRSPAdvRSAy/N/jmKVnyeNO
-- EMPLEADO: 'empleado123' -> $2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG
INSERT INTO `empleados` (`Codigo_empl`, `Usuario`, `passwor`, `Nombre`, `Apellidos`, `Cargo`, `rol`) VALUES
(101, 'admin', '$2y$10$1RrTDnbaoiwmxXmTnmvq3Oq1k.GYH5IRSPAdvRSAy/N/jmKVnyeNO', 'Imanol', 'Forbes', 'Gerente General & Admin', 'admin'),
(102, 'iforbes', '$2y$10$1RrTDnbaoiwmxXmTnmvq3Oq1k.GYH5IRSPAdvRSAy/N/jmKVnyeNO', 'Imanol', 'Forbes', 'Director de Operaciones', 'admin'),
(201, 'empleado', '$2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG', 'Carlos', 'Rodríguez', 'Recepcionista Principal', 'empleado'),
(202, 'rsafari', '$2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG', 'Roberto', 'Gómez', 'Guía de Safaris & Conserje', 'empleado'),
(203, 'mvelasquez', '$2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG', 'Mariana', 'Velásquez', 'Supervisora de Habitaciones', 'empleado');


-- ------------------------------------------------------------------------------
-- 2. TABLA: cliente
-- Registro general de clientes del resort
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `codigo_cli` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `dni_cli` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigo_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cliente` (`codigo_cli`, `nombre`, `direccion`, `telefono`, `dni_cli`) VALUES
(1001, 'Elena Martínez Silva', 'Av. Reforma 420, CDMX, México', '+52 55 4321 8765', 'MEX-88992233'),
(1002, 'Dr. Alexander Wright', '742 Evergreen Terrace, Seattle, WA, EE.UU.', '+1 206 555 0199', 'USA-44112233'),
(1003, 'Sofía Lorena Mendoza', 'Calle Granada 14, Sevilla, España', '+34 612 345 678', 'ESP-99887766'),
(1004, 'Fernando Castillo Rojas', 'Blvd. Kukulcán Km 12, Cancún, México', '+52 998 123 4567', 'MEX-55667788'),
(1005, 'Amélie Dupont', '15 Rue de la Paix, París, Francia', '+33 1 42 68 55 00', 'FRA-33221100');


-- ------------------------------------------------------------------------------
-- 3. TABLA: habitaciones
-- Inventario de habitaciones y disponibilidad (Si / No)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `habitaciones`;
CREATE TABLE `habitaciones` (
  `codigo_hab` int(11) NOT NULL,
  `tipo_hab` varchar(100) NOT NULL,
  `hab_disp` varchar(10) NOT NULL DEFAULT 'Si',
  PRIMARY KEY (`codigo_hab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `habitaciones` (`codigo_hab`, `tipo_hab`, `hab_disp`) VALUES
(101, 'Suite Safari Real (Vista a la Sabana)', 'Si'),
(102, 'Cabaña Selva Deluxe con Terraza', 'Si'),
(103, 'Lodge Río Zambezi con Jacuzzi', 'No'),
(201, 'Suite Panorámica Kilimanjaro', 'Si'),
(202, 'Bungalow Sabana VIP', 'Si'),
(203, 'Habitación Estándar Acacia', 'No'),
(301, 'Villa Familiar Serengueti (4 Huéspedes)', 'Si');


-- ------------------------------------------------------------------------------
-- 4. TABLA: reserva
-- Control de reservas asociando habitaciones y clientes
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `numero_rese` int(11) NOT NULL,
  `fecha_inicio_rese` date NOT NULL,
  `fecha_inicio_esta` date NOT NULL,
  `fecha_final_esta` date NOT NULL,
  `codigo_hab` int(11) DEFAULT NULL,
  `codigo_cli` int(11) DEFAULT NULL,
  PRIMARY KEY (`numero_rese`),
  KEY `fk_reserva_habitacion` (`codigo_hab`),
  KEY `fk_reserva_cliente` (`codigo_cli`),
  CONSTRAINT `fk_reserva_habitacion` FOREIGN KEY (`codigo_hab`) REFERENCES `habitaciones` (`codigo_hab`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`codigo_cli`) REFERENCES `cliente` (`codigo_cli`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reserva` (`numero_rese`, `fecha_inicio_rese`, `fecha_inicio_esta`, `fecha_final_esta`, `codigo_hab`, `codigo_cli`) VALUES
(5001, '2025-09-01', '2025-09-10', '2025-09-15', 103, 1001),
(5002, '2025-09-03', '2025-09-12', '2025-09-18', 203, 1002),
(5003, '2025-09-05', '2025-09-20', '2025-09-25', 101, 1003),
(5004, '2025-09-08', '2025-10-01', '2025-10-07', 201, 1004);


-- ------------------------------------------------------------------------------
-- 5. TABLA: actividades
-- Actividades ecoturísticas y servicios especiales ofrecidos por el hotel
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `actividades`;
CREATE TABLE `actividades` (
  `codigo_act` int(11) NOT NULL,
  `nombre_act` varchar(150) NOT NULL,
  `duracion_act` varchar(50) NOT NULL,
  `horario` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_act` decimal(10,2) NOT NULL DEFAULT '0.00',
  `huespedes_regis` int(11) NOT NULL DEFAULT '0',
  `empl_Codigo` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo_act`),
  KEY `fk_actividad_empleado` (`empl_Codigo`),
  CONSTRAINT `fk_actividad_empleado` FOREIGN KEY (`empl_Codigo`) REFERENCES `empleados` (`Codigo_empl`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `actividades` (`codigo_act`, `nombre_act`, `duracion_act`, `horario`, `descripcion`, `precio_act`, `huespedes_regis`, `empl_Codigo`) VALUES
(301, 'Safari Fotográfico al Amanecer', '3 horas', '05:30 AM - 08:30 AM', 'Recorrido guiado en vehículo 4x4 por la sabana para capturar el amanecer y avistar fauna local.', 120.00, 4, 202),
(302, 'Cena Gourmet bajo las Estrellas', '2.5 horas', '08:00 PM - 10:30 PM', 'Experiencia culinaria de 5 tiempos con fogata nocturna y música acústica en vivo.', 95.00, 6, 201),
(303, 'Excursión al Refugio de Felinos', '4 horas', '09:00 AM - 01:00 PM', 'Visita guiada al centro de conservación de guepardos y leones con biólogo del resort.', 150.00, 2, 202),
(304, 'Kayak en Río Zambezi', '2 horas', '04:00 PM - 06:00 PM', 'Navegación suave por el río al atardecer observando aves acuáticas e hipopótamos a distancia segura.', 75.00, 3, 202),
(305, 'Spa & Relajación Oasis Selva', '1.5 horas', '11:00 AM - 05:00 PM', 'Tratamiento holístico con aceites naturales aromáticos en pabellón abierto frente al río.', 110.00, 2, 203);


-- ------------------------------------------------------------------------------
-- 6. TABLA: cliente_actividad
-- Tabla intermedia para inscripción de clientes en actividades del hotel
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `cliente_actividad`;
CREATE TABLE `cliente_actividad` (
  `Id` int(11) NOT NULL,
  `codigo_cli` int(11) NOT NULL,
  `codigo_act` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_cli_act_cliente` (`codigo_cli`),
  KEY `fk_cli_act_actividad` (`codigo_act`),
  CONSTRAINT `fk_cli_act_cliente` FOREIGN KEY (`codigo_cli`) REFERENCES `cliente` (`codigo_cli`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cli_act_actividad` FOREIGN KEY (`codigo_act`) REFERENCES `actividades` (`codigo_act`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cliente_actividad` (`Id`, `codigo_cli`, `codigo_act`) VALUES
(901, 1001, 301),
(902, 1001, 302),
(903, 1002, 303),
(904, 1003, 301),
(905, 1004, 304);


-- ------------------------------------------------------------------------------
-- 7. TABLA: recepcion
-- Registro heredado para personal de recepción
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `recepcion`;
CREATE TABLE `recepcion` (
  `Usuario` varchar(50) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Passwor` varchar(255) NOT NULL,
  PRIMARY KEY (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `recepcion` (`Usuario`, `Nombre`, `Apellidos`, `Passwor`) VALUES
('recepcion1', 'Andrea', 'López', '$2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG'),
('recepcion2', 'Mario', 'Hernández', '$2y$10$Fs7u8MtfyjQcqmP/f1dDQuTapWgzKRQj3zy3ydkr2aFl4uDqUmBjG');

SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================================================
-- FIN DEL ESQUEMA SQL - LISTO PARA USAR EN MAMP / XAMPP / PRODUCCIÓN
-- ==============================================================================
