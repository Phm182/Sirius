-- Sirius — schema inicial
-- Charset/collation alineados con bd.php (utf8mb4_unicode_ci)

CREATE DATABASE IF NOT EXISTS `sirius`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `sirius`;

CREATE TABLE IF NOT EXISTS `contacto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(120) NOT NULL,
  `celular` VARCHAR(40) NOT NULL,
  `email` VARCHAR(180) NOT NULL DEFAULT '',
  `consulta` TEXT NULL,
  `metodo` VARCHAR(40) NOT NULL DEFAULT 'celular',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_contacto_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `inscripcion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(120) NOT NULL,
  `apellido` VARCHAR(120) NOT NULL,
  `celular` VARCHAR(40) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `curso` VARCHAR(40) NOT NULL,
  `experiencia` VARCHAR(40) NOT NULL DEFAULT 'ninguna',
  `mensaje` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inscripcion_curso` (`curso`),
  KEY `idx_inscripcion_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
