<?php include 'inc/templates/header.php'; ?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="section_galeria">
    <div class="texto1">
      <p class="nombre"><span><?php cms_text('contacto.eyebrow', 'Sirius', $conn); ?></span></p>
      <h3><?php cms_text('contacto.titulo', 'Contactanos', $conn); ?></h3>
      <p class="contacto-lead"><?php cms_text('contacto.intro', '', $conn, true); ?></p>
    </div>

    <hr>

    <?php if (isset($_GET['error'])): ?>
      <p class="form-error">Revisá los datos e intentá de nuevo.</p>
    <?php endif; ?>

    <?php include 'inc/templates/Contacto.php'; ?>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
