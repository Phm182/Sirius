-- Ejecutar UNA VEZ sobre una instalación existente de Sirius.
-- Para una instalación nueva alcanza con importar sirius.sql.

USE `sirius`;

ALTER TABLE `contacto`
  ADD COLUMN `estado` VARCHAR(30) NOT NULL DEFAULT 'nuevo' AFTER `metodo`,
  ADD COLUMN `notas_admin` TEXT NULL AFTER `estado`,
  ADD COLUMN `archivado` TINYINT(1) NOT NULL DEFAULT 0 AFTER `notas_admin`,
  ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`,
  ADD KEY `idx_contacto_estado` (`estado`, `archivado`);

ALTER TABLE `inscripcion`
  ADD COLUMN `estado` VARCHAR(30) NOT NULL DEFAULT 'nueva' AFTER `mensaje`,
  ADD COLUMN `notas_admin` TEXT NULL AFTER `estado`,
  ADD COLUMN `archivado` TINYINT(1) NOT NULL DEFAULT 0 AFTER `notas_admin`,
  ADD COLUMN `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`,
  ADD KEY `idx_inscripcion_estado` (`estado`, `archivado`);

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
