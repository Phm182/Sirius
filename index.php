<?php
include 'inc/templates/header.php';
$courses = cursos_activos($conn);
$aboutImage = contenido_asset('inicio.presentacion_imagen', 'img/4.jpeg', $conn);
$signupImage = contenido_asset('inicio.inscripcion_imagen', 'img/5.jpeg', $conn);
?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="hero-section">
  <div class="contenedor parallax">
    <div class="sirius">
      <h1><?php cms_text('inicio.hero_titulo', 'SIRIUS', $conn); ?></h1>
      <p><?php cms_text('inicio.hero_subtitulo', 'Escuela Náutica', $conn); ?></p>
      <a href="inscripcion.php" class="hero-cta"><?php cms_text('inicio.hero_boton', 'Quiero navegar', $conn); ?></a>
    </div>
  </div>
</section>

<section>
  <div class="contenedor2">
    <div id="quienes_somos" class="nosotros-img ordenador">
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Alumnos de Sirius en práctica de navegación"
           <?php echo cms_attrs('inicio.presentacion_imagen', 'image', 'Imagen de presentación', $aboutImage); ?>>
    </div>

    <div class="texto1 ordenador">
      <p class="nombre"><span><?php cms_text('inicio.presentacion_eyebrow', 'Sirius', $conn); ?></span></p>
      <h3><?php cms_text('inicio.presentacion_titulo', 'Escuela de navegación', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('inicio.presentacion_texto', '', $conn, true); ?>
      </p>
      <a href="quienes_somos.php" class="nuestra-historia"><?php cms_text('inicio.presentacion_boton', 'Nuestra historia', $conn); ?></a>
    </div>

    <div id="quienes_somos2" class="texto1 mobile">
      <p class="nombre"><span><?php cms_text('inicio.presentacion_eyebrow', 'Sirius', $conn); ?></span></p>
      <h3><?php cms_text('inicio.presentacion_titulo', 'Escuela de navegación', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('inicio.presentacion_texto', '', $conn, true); ?>
      </p>
    </div>
    <div class="nosotros-img mobile">
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Alumnos de Sirius en práctica de navegación"
           <?php echo cms_attrs('inicio.presentacion_imagen', 'image', 'Imagen de presentación', $aboutImage); ?>>
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="quienes_somos.php" class="nuestra-historia2"><?php cms_text('inicio.presentacion_boton', 'Nuestra historia', $conn); ?></a>
  </div>
</section>

<section class="section-cursos">
  <div id="cursos" class="cursos">
    <h2><?php cms_text('inicio.cursos_titulo', 'Cursos', $conn); ?></h2>
    <p class="cursos-swipe-hint" aria-hidden="true">
      <i class="fas fa-hand-pointer"></i>
      Deslizá para ver todos los cursos
      <span>→</span>
    </p>
    <div class="contenedor-cursos" data-course-slider role="region" aria-label="Cursos disponibles" tabindex="0">
      <?php foreach ($courses as $course): ?>
        <div class="curso" <?php echo ((int) $course['id'] > 0) ? cms_entity_attrs('curso', (int) $course['id'], (string) $course['nombre']) : ''; ?>>
          <img src="<?php echo htmlspecialchars($course['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($course['imagen_alt'], ENT_QUOTES, 'UTF-8'); ?>">
          <h3><?php echo htmlspecialchars($course['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p>
            <b>Inicio:</b> <?php echo htmlspecialchars($course['inicio'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Duración:</b> <?php echo htmlspecialchars($course['duracion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Modalidad:</b> <?php echo htmlspecialchars($course['modalidad'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Sede:</b> <?php echo htmlspecialchars($course['ubicacion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Arancel:</b> <?php echo htmlspecialchars($course['precio'], ENT_QUOTES, 'UTF-8'); ?>
          </p>
          <a href="curso.php?slug=<?php echo rawurlencode($course['slug']); ?>" class="boton">Más información</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section>
  <div id="inscripcion" class="contenedor2">
    <div class="texto1 ordenador">
      <p class="nombre"><span><?php cms_text('inicio.inscripcion_eyebrow', '¡Te esperamos a bordo!', $conn); ?></span></p>
      <h3><?php cms_text('inicio.inscripcion_titulo', 'Inscripción', $conn); ?></h3>
      <p class="nosotros ordenador">
        <?php cms_text('inicio.inscripcion_texto', '', $conn, true); ?>
      </p>
      <a href="inscripcion.php" class="nuestra-historia"><?php cms_text('inicio.inscripcion_boton', 'Inscribirme', $conn); ?></a>
    </div>

    <div class="nosotros-img ordenador">
      <img src="<?php echo htmlspecialchars($signupImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Práctica a bordo en Sirius"
           class="inscripción-img"
           <?php echo cms_attrs('inicio.inscripcion_imagen', 'image', 'Imagen de inscripción', $signupImage); ?>>
    </div>
  </div>

  <div class="contenedor2">
    <div class="texto1 mobile">
      <p class="nombre"><span><?php cms_text('inicio.inscripcion_eyebrow', '¡Te esperamos a bordo!', $conn); ?></span></p>
    </div>
    <div class="nosotros-img2 mobile">
      <img src="<?php echo htmlspecialchars($signupImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Práctica a bordo en Sirius"
           class="inscripción-img"
           <?php echo cms_attrs('inicio.inscripcion_imagen', 'image', 'Imagen de inscripción', $signupImage); ?>>
    </div>
    <div class="texto1 mobile">
      <h3><?php cms_text('inicio.inscripcion_titulo', 'Inscripción', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('inicio.inscripcion_texto', '', $conn, true); ?>
      </p>
      <a href="inscripcion.php" class="nuestra-historia"><?php cms_text('inicio.inscripcion_boton', 'Inscribirme', $conn); ?></a>
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="inscripcion.php" class="nuestra-historia2"><?php cms_text('inicio.inscripcion_boton', 'Inscribirme', $conn); ?></a>
  </div>
</section>

<section class="mapa-section" id="mapa-section">
  <div class="mapa-intro">
    <p class="nombre"><span><?php cms_text('inicio.sede_eyebrow', 'Sede', $conn); ?></span></p>
    <h3><?php cms_text('inicio.sede_titulo', 'Costanera Norte', $conn); ?></h3>
    <p><?php cms_text('inicio.sede_texto', '', $conn, true); ?></p>
    <a href="contacto.php" class="nuestra-historia"><?php cms_text('inicio.sede_boton', 'Consultar cómo llegar', $conn); ?></a>
  </div>
  <div id="mapa" class="mapa" role="region" aria-label="Mapa de la sede Sirius"
       data-zoom="<?php echo (int) contenido('inicio.mapa_zoom', '15', $conn); ?>"
       <?php echo cms_attrs('inicio.mapa_zoom', 'number', 'Zoom del mapa'); ?>></div>
</section>

<?php include 'inc/templates/footer.php'; ?>
<script src="<?php echo htmlspecialchars(sirius_asset('js/map.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
