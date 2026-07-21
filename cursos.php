<?php
include 'inc/templates/header.php';
$courses = cursos_activos($conn);
?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="section-cursos page-offset">
  <div id="cursos" class="cursos pagina-cursos">
    <div class="cursos-titulo">
      <p class="nombre"><span><?php echo htmlspecialchars(contenido('cursos.eyebrow', 'Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></span></p>
      <h2><?php echo htmlspecialchars(contenido('cursos.titulo', 'Cursos', $conn), ENT_QUOTES, 'UTF-8'); ?></h2>
      <p class="cursos-intro"><?php echo nl2br(htmlspecialchars(contenido('cursos.intro', '', $conn), ENT_QUOTES, 'UTF-8')); ?></p>
    </div>
    <p class="cursos-swipe-hint" aria-hidden="true">
      <i class="fas fa-hand-pointer"></i>
      Deslizá para ver todos los cursos
      <span>→</span>
    </p>
    <div class="contenedor-cursos" data-course-slider role="region" aria-label="Cursos disponibles" tabindex="0">
      <?php foreach ($courses as $course): ?>
        <div class="curso">
          <img src="<?php echo htmlspecialchars($course['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($course['imagen_alt'], ENT_QUOTES, 'UTF-8'); ?>">
          <h3><?php echo htmlspecialchars($course['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p><?php echo nl2br(htmlspecialchars($course['resumen'], ENT_QUOTES, 'UTF-8')); ?></p>
          <p><b>Arancel:</b> <?php echo htmlspecialchars($course['precio'], ENT_QUOTES, 'UTF-8'); ?></p>
          <a href="curso.php?slug=<?php echo rawurlencode($course['slug']); ?>" class="boton">Más información</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="pagina-cursos-footer">
  <?php include 'inc/templates/footer.php'; ?>
</div>
