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
  `estado` VARCHAR(30) NOT NULL DEFAULT 'nuevo',
  `notas_admin` TEXT NULL,
  `archivado` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_contacto_created` (`created_at`),
  KEY `idx_contacto_estado` (`estado`, `archivado`)
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
  `estado` VARCHAR(30) NOT NULL DEFAULT 'nueva',
  `notas_admin` TEXT NULL,
  `archivado` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inscripcion_curso` (`curso`),
  KEY `idx_inscripcion_created` (`created_at`),
  KEY `idx_inscripcion_estado` (`estado`, `archivado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admin_usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(80) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `intentos_fallidos` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `bloqueado_hasta` DATETIME NULL,
  `ultimo_acceso` DATETIME NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_usuario` (`usuario`),
  UNIQUE KEY `uq_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `admin_auditoria` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` INT UNSIGNED NULL,
  `accion` VARCHAR(80) NOT NULL,
  `entidad` VARCHAR(30) NULL,
  `entidad_id` INT UNSIGNED NULL,
  `detalle` VARCHAR(500) NULL,
  `ip` VARCHAR(45) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_auditoria_admin` (`admin_id`),
  KEY `idx_auditoria_entidad` (`entidad`, `entidad_id`),
  KEY `idx_auditoria_created` (`created_at`),
  CONSTRAINT `fk_auditoria_admin`
    FOREIGN KEY (`admin_id`) REFERENCES `admin_usuario` (`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
