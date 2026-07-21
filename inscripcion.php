<?php include 'inc/templates/header.php'; ?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="inscripcion-page page-offset page-surface">
  <div class="inscripcion-hero">
    <div class="inscripcion-hero__content">
      <p class="nombre"><span><?php cms_text('inscripcion.eyebrow', 'Sirius', $conn); ?></span></p>
      <h2><?php cms_text('inscripcion.titulo', 'Inscripción a la escuela náutica', $conn); ?></h2>
      <p><?php cms_text('inscripcion.intro', '', $conn, true); ?></p>
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
