<?php
require_once __DIR__ . '/../funciones/bd.php';
require_once __DIR__ . '/../funciones/contenido.php';

$curso_slug = $curso_slug ?? (string) ($_GET['slug'] ?? '');
$course = curso_por_slug($curso_slug, $conn);
if (!$course) {
    http_response_code(404);
}
include 'inc/templates/header.php';
?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="section-cursos page-offset">
  <div id="cursos" class="cursos pagina-cursos">
    <h2>Curso</h2>

    <?php if (!$course): ?>
      <div class="exitoso">
        <h3>El curso solicitado no está disponible.</h3>
        <a href="cursos.php" class="boton">Ver cursos</a>
      </div>
    <?php else: ?>
    <div class="contenedor-curso ordenador">
      <div class="curso info-curso">
        <div>
          <img src="<?php echo htmlspecialchars($course['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($course['imagen_alt'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="info-curso2">
          <h3><?php echo htmlspecialchars($course['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p>
            <b>Inicio:</b> <?php echo htmlspecialchars($course['inicio'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Duración:</b> <?php echo htmlspecialchars($course['duracion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Modalidad:</b> <?php echo htmlspecialchars($course['modalidad'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Ubicación:</b> <?php echo htmlspecialchars($course['ubicacion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Arancel:</b> <?php echo htmlspecialchars($course['precio'], ENT_QUOTES, 'UTF-8'); ?>
          </p>
          <a href="inscripcion.php?curso=<?php echo rawurlencode($course['slug']); ?>" class="boton">Inscribirme</a>
        </div>
      </div>

      <div class="curso">
        <p><?php echo nl2br(htmlspecialchars($course['descripcion'], ENT_QUOTES, 'UTF-8')); ?></p>
      </div>
    </div>

    <div class="contenedor-curso mobile">
      <div class="curso info-curso">
        <div>
          <img src="<?php echo htmlspecialchars($course['imagen'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($course['imagen_alt'], ENT_QUOTES, 'UTF-8'); ?>"><br>
          <h3><?php echo htmlspecialchars($course['nombre'], ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div>
          <p><?php echo nl2br(htmlspecialchars($course['descripcion'], ENT_QUOTES, 'UTF-8')); ?></p>
        </div>
      </div>
      <hr>
      <div class="curso info-curso">
        <div class="info-curso2">
          <p>
            <b>Inicio:</b> <?php echo htmlspecialchars($course['inicio'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Duración:</b> <?php echo htmlspecialchars($course['duracion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Modalidad:</b> <?php echo htmlspecialchars($course['modalidad'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Ubicación:</b> <?php echo htmlspecialchars($course['ubicacion'], ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Arancel:</b> <?php echo htmlspecialchars($course['precio'], ENT_QUOTES, 'UTF-8'); ?>
          </p>
          <a href="inscripcion.php?curso=<?php echo rawurlencode($course['slug']); ?>" class="boton">Inscribirme</a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<div class="pagina-cursos-footer">
  <?php include 'inc/templates/footer.php'; ?>
</div>
