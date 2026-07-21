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

CREATE TABLE IF NOT EXISTS `sitio_contenido` (
  `clave` VARCHAR(120) NOT NULL,
  `valor` MEDIUMTEXT NOT NULL,
  `tipo` VARCHAR(20) NOT NULL DEFAULT 'text',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `curso` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(80) NOT NULL,
  `nombre` VARCHAR(120) NOT NULL,
  `resumen` TEXT NULL,
  `descripcion` MEDIUMTEXT NULL,
  `inicio` VARCHAR(180) NOT NULL DEFAULT '',
  `duracion` VARCHAR(120) NOT NULL DEFAULT '',
  `modalidad` VARCHAR(180) NOT NULL DEFAULT '',
  `ubicacion` VARCHAR(180) NOT NULL DEFAULT '',
  `precio` VARCHAR(120) NOT NULL DEFAULT '',
  `imagen` VARCHAR(255) NOT NULL DEFAULT '',
  `imagen_alt` VARCHAR(180) NOT NULL DEFAULT '',
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `orden` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_curso_slug` (`slug`),
  KEY `idx_curso_activo_orden` (`activo`, `orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `galeria_foto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `archivo` VARCHAR(255) NOT NULL,
  `titulo` VARCHAR(180) NOT NULL DEFAULT '',
  `alt` VARCHAR(180) NOT NULL DEFAULT '',
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `orden` INT NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_galeria_activo_orden` (`activo`, `orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `sitio_contenido` (`clave`, `valor`, `tipo`) VALUES
('inicio.hero_titulo', 'SIRIUS', 'text'),
('inicio.hero_subtitulo', 'Escuela Náutica', 'text'),
('inicio.hero_boton', 'Quiero navegar', 'text'),
('inicio.presentacion_titulo', 'Escuela de navegación', 'text'),
('inicio.presentacion_texto', 'Somos un equipo de instructores apasionados por el río y el mar. Formamos navegantes desde el primer amarre hasta maniobras avanzadas, con clases claras, práctica real y acompañamiento cercano en cada etapa.', 'textarea'),
('inicio.presentacion_imagen', 'img/4.jpeg', 'image'),
('inicio.inscripcion_titulo', 'Inscripción', 'text'),
('inicio.inscripcion_texto', 'Reservá tu lugar en el próximo ciclo. Completá el formulario y el equipo de Sirius te contacta para confirmar fechas, vacantes y aranceles.', 'textarea'),
('inicio.inscripcion_imagen', 'img/5.jpeg', 'image'),
('inicio.sede_titulo', 'Costanera Norte', 'text'),
('inicio.sede_texto', 'Practicamos en la Sede Náutica de la Costanera Norte. En breve publicamos la dirección exacta; mientras tanto, encontranos en el mapa.', 'textarea'),
('inicio.mapa_zoom', '14', 'number'),
('quienes.titulo', 'Escuela de navegación', 'text'),
('quienes.intro', 'En Sirius formamos navegantes con criterio, seguridad y pasión por el agua. Combinamos teoría sólida con horas reales a bordo para que cada alumno salga con confianza y herramientas concretas.', 'textarea'),
('quienes.imagen', 'img/4.jpeg', 'image'),
('quienes.historia_titulo', 'De la pasión por navegar a una escuela', 'text'),
('quienes.historia_texto', 'Sirius nace de años de experiencia a bordo y de la necesidad de enseñar navegación de forma clara, moderna y cercana. Empezamos acompañando a quienes daban sus primeros pasos en lancha y, con el tiempo, armamos un programa completo que hoy incluye veleros y yates.', 'textarea'),
('quienes.metodo_titulo', 'Método: teoría que se vive en el agua', 'text'),
('quienes.metodo_texto', 'Creemos que se aprende navegando. Por eso cada módulo teórico se traduce en práctica real: amarre, zarpe, comunicaciones, seguridad, lectura del entorno y toma de decisiones.', 'textarea'),
('cursos.titulo', 'Cursos', 'text'),
('cursos.intro', 'Formación náutica con teoría clara y práctica real a bordo.', 'textarea'),
('galeria.titulo', 'Galería a bordo', 'text'),
('galeria.intro', 'Momentos reales de práctica, aprendizaje y vida náutica. Tocá una imagen para verla en grande.', 'textarea'),
('galeria.cta', '¿Querés vivir esto en primera persona?', 'text'),
('contacto.titulo', 'Contactanos', 'text'),
('contacto.intro', 'Consultas sobre cursos, fechas, aranceles o cómo llegar a la sede. Te respondemos a la brevedad.', 'textarea'),
('inscripcion.titulo', 'Inscripción a la escuela náutica', 'text'),
('inscripcion.intro', 'Completá tus datos y elegí el curso. Te contactamos para confirmar vacante, fechas y aranceles.', 'textarea'),
('footer.sobre', 'Escuela náutica en Buenos Aires. Formamos navegantes en lanchas, veleros y yates con práctica real en la Costanera Norte y acompañamiento de instructores experimentados.', 'textarea'),
('footer.sede', 'Sede Náutica · Costanera Norte, Ciudad Autónoma de Buenos Aires.', 'textarea'),
('footer.facebook', 'https://www.facebook.com/', 'url'),
('footer.youtube', 'https://www.youtube.com/', 'url'),
('footer.instagram', 'https://www.instagram.com/', 'url'),
('seo.titulo', 'Sirius · Escuela Náutica', 'text'),
('seo.descripcion', 'Cursos de navegación en Buenos Aires con práctica real a bordo.', 'textarea');

INSERT IGNORE INTO `curso`
(`slug`, `nombre`, `resumen`, `descripcion`, `inicio`, `duracion`, `modalidad`, `ubicacion`, `precio`, `imagen`, `imagen_alt`, `activo`, `orden`) VALUES
('lanchas', 'Lanchas', 'Ideal para quienes quieren manejar embarcaciones a motor con seguridad. Aprendés maniobras, normativa, comunicaciones y práctica en río.', 'En el curso de Lanchas vas a aprender a operar embarcaciones a motor con seguridad y criterio. Trabajamos zarpe y atraque, control de velocidad, comunicaciones, seguridad a bordo y lectura del entorno en el río. Ideal si querés empezar a navegar o formalizar experiencia previa.', 'Abril, junio, agosto y octubre', '2 meses', 'Práctico presencial · Teórico online', 'Sede Náutica · Costanera Norte (CABA)', 'Consultar', 'img/1.jpg', 'Práctica del curso de lanchas', 1, 10),
('veleros', 'Veleros', 'Descubrí el arte de navegar a vela: trimado, rumbos, cambios de rumbo y trabajo en equipo.', 'El curso de Veleros te introduce al mundo de la vela con práctica real. Aprendés trimado, rumbos, maniobras de cambio, trabajo en cubierta y toma de decisiones con viento. Una formación pensada para que disfrutes navegar con técnica, seguridad y confianza.', 'Abril y agosto', '4 meses', 'Práctico presencial · Teórico online', 'Sede Náutica · Costanera Norte (CABA)', 'Consultar', 'img/2.jpg', 'Práctica del curso de veleros', 1, 20),
('yates', 'Yates', 'Programa avanzado sobre travesías, sistemas a bordo, guardias, meteorología y liderazgo.', 'El curso de Yates es el programa más completo de Sirius. Abordamos planificación de salidas, sistemas de a bordo, meteorología aplicada, guardias, seguridad y liderazgo de tripulación. Pensado para quienes buscan un salto serio en autonomía y responsabilidad náutica.', 'Abril', '1 año', 'Práctico presencial · Teórico online', 'Sede Náutica · Costanera Norte (CABA)', 'Consultar', 'img/3.jpg', 'Práctica del curso de yates', 1, 30);

INSERT IGNORE INTO `galeria_foto` (`id`, `archivo`, `titulo`, `alt`, `activo`, `orden`) VALUES
(1, 'imgS/1.jpg', 'Salida al río', 'Salida al río', 1, 10),
(2, 'imgS/2.jpg', 'Maniobras', 'Maniobras', 1, 20),
(3, 'imgS/3.jpg', 'Cubierta', 'Cubierta', 1, 30),
(4, 'imgS/4.jpg', 'Navegación', 'Navegación', 1, 40),
(5, 'imgS/5.jpg', 'Instrucción', 'Instrucción', 1, 50),
(6, 'imgS/6.jpg', 'Equipo', 'Equipo', 1, 60),
(7, 'imgS/7.jpg', 'Práctica', 'Práctica', 1, 70),
(8, 'imgS/8.jpg', 'Atardecer', 'Atardecer', 1, 80),
(9, 'imgS/9.jpeg', 'Costanera', 'Costanera', 1, 90),
(10, 'imgS/10.jpg', 'Comunidad', 'Comunidad', 1, 100);

INSERT IGNORE INTO `sitio_contenido` (`clave`, `valor`, `tipo`) VALUES
('site.logo', 'img/Logo Web.png', 'image'),
('site.fondo', 'img/velas_para_crucero.jpg', 'image'),
('theme.primary', '#b91515', 'color'),
('theme.secondary', '#09134e', 'color'),
('theme.background', '#111111', 'color'),
('theme.surface', '#0d1533', 'color'),
('theme.text', '#f4f6fa', 'color'),
('inicio.presentacion_eyebrow', 'Sirius', 'text'),
('inicio.presentacion_boton', 'Nuestra historia', 'text'),
('inicio.cursos_titulo', 'Cursos', 'text'),
('inicio.inscripcion_eyebrow', '¡Te esperamos a bordo!', 'text'),
('inicio.inscripcion_boton', 'Inscribirme', 'text'),
('inicio.sede_eyebrow', 'Sede', 'text'),
('inicio.sede_boton', 'Consultar cómo llegar', 'text'),
('quienes.eyebrow', 'Sirius', 'text'),
('quienes.boton', 'Nuestra historia', 'text'),
('quienes.sede_titulo', 'Costanera Norte como aula abierta', 'text'),
('quienes.sede_texto', 'Nuestra sede náutica en la Costanera Norte nos permite entrenar en un entorno vivo, con tráfico, corrientes y situaciones reales de río.', 'textarea'),
('quienes.comunidad_titulo', 'Una comunidad que sigue creciendo', 'text'),
('quienes.comunidad_texto', 'Más que un curso, Sirius es una comunidad de personas que aman el agua y comparten las ganas de seguir aprendiendo.', 'textarea'),
('cursos.eyebrow', 'Sirius', 'text'),
('galeria.eyebrow', 'Sirius', 'text'),
('galeria.cta_boton', 'Inscribite a un curso', 'text'),
('contacto.eyebrow', 'Sirius', 'text'),
('contacto.boton', 'Enviar consulta', 'text'),
('inscripcion.eyebrow', 'Sirius', 'text'),
('inscripcion.nota', 'Te vamos a contactar para confirmar vacante, fechas y aranceles.', 'text'),
('inscripcion.boton', 'Enviar inscripción', 'text'),
('footer.sede_extra', 'Próximamente publicamos la dirección exacta. Mientras tanto, escribinos por Contacto o visitá el mapa en el inicio.', 'textarea'),
('footer.credito', 'Diseño Web: BitFlow', 'text');

INSERT IGNORE INTO `sitio_contenido` (`clave`, `valor`, `tipo`) VALUES
('nav.quienes', '¿Quiénes somos?', 'text'),
('nav.cursos', 'Cursos', 'text'),
('nav.inscripcion', 'Inscripción', 'text'),
('nav.sede', 'Sede', 'text'),
('nav.galeria', 'Galería', 'text'),
('nav.contacto', 'Contacto', 'text'),
('nav.admin', 'Administración', 'text'),
('contacto.label_nombre', 'Nombre', 'text'),
('contacto.label_celular', 'Celular', 'text'),
('contacto.label_email', 'E-Mail', 'text'),
('contacto.label_consulta', 'Consulta', 'text'),
('contacto.label_medio', '¿Por qué medio preferís la respuesta?', 'text'),
('contacto.label_whatsapp', 'Celular / WhatsApp', 'text'),
('contacto.label_correo', 'Correo electrónico', 'text'),
('contacto.label_ambos', 'Ambos', 'text'),
('inscripcion.label_nombre', 'Nombre', 'text'),
('inscripcion.label_apellido', 'Apellido', 'text'),
('inscripcion.label_celular', 'Celular', 'text'),
('inscripcion.label_email', 'E-Mail', 'text'),
('inscripcion.label_curso', 'Curso', 'text'),
('inscripcion.label_experiencia', 'Experiencia náutica', 'text'),
('inscripcion.label_mensaje', 'Comentarios o disponibilidad', 'text'),
('footer.sobre_titulo', 'Sobre Sirius', 'text'),
('footer.sede_titulo', 'Nuestra Sede', 'text'),
('footer.redes_titulo', 'Redes Sociales', 'text');
