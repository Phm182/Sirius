<?php include 'inc/templates/header.php'; ?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="inscripcion-page page-offset page-surface">
  <div class="inscripcion-hero">
    <div class="inscripcion-hero__content">
      <p class="nombre"><span><?php echo htmlspecialchars(contenido('inscripcion.eyebrow', 'Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></span></p>
      <h2><?php echo htmlspecialchars(contenido('inscripcion.titulo', 'Inscripción a la escuela náutica', $conn), ENT_QUOTES, 'UTF-8'); ?></h2>
      <p><?php echo nl2br(htmlspecialchars(contenido('inscripcion.intro', '', $conn), ENT_QUOTES, 'UTF-8')); ?></p>
    </div>
  </div>

  <div class="inscripcion-form-block">
    <?php if (isset($_GET['error'])): ?>
      <p class="form-error">Revisá los datos e intentá de nuevo. Nombre, apellido, celular, email y curso son obligatorios.</p>
    <?php endif; ?>
    <?php include 'inc/templates/inscripcion.php'; ?>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
