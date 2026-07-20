<?php include 'inc/templates/header.php'; ?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="section_galeria">
    <div class="texto1">
      <p class="nombre"><span>Sirius</span></p>
      <h3>Contactanos</h3>
      <p class="contacto-lead">Consultas sobre cursos, fechas, aranceles o cómo llegar a la sede. Te respondemos a la brevedad.</p>
    </div>

    <hr>

    <?php if (isset($_GET['error'])): ?>
      <p class="form-error">Revisá los datos e intentá de nuevo.</p>
    <?php endif; ?>

    <?php include 'inc/templates/Contacto.php'; ?>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
