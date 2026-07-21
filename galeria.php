<?php
include 'inc/templates/header.php';
$fotos = galeria_activa($conn);
?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="galeria-page">
    <div class="galeria-hero">
      <p class="nombre"><span><?php echo htmlspecialchars(contenido('galeria.eyebrow', 'Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></span></p>
      <h2><?php echo htmlspecialchars(contenido('galeria.titulo', 'Galería a bordo', $conn), ENT_QUOTES, 'UTF-8'); ?></h2>
      <p class="galeria-lead"><?php echo nl2br(htmlspecialchars(contenido('galeria.intro', '', $conn), ENT_QUOTES, 'UTF-8')); ?></p>
    </div>

    <?php if (count($fotos) > 1): ?>
      <div class="galeria-swipe-guide" aria-hidden="true">
        <span><i class="fas fa-hand-pointer"></i> Deslizá para ver más fotos <b>→</b></span>
        <span class="galeria-counter" data-gallery-counter>1 / <?php echo count($fotos); ?></span>
      </div>
    <?php endif; ?>

    <div class="galeria-mosaic"
         data-gallery-slider
         role="region"
         aria-label="Galería de fotos deslizable"
         tabindex="0">
      <?php foreach ($fotos as $foto): ?>
        <a href="<?php echo htmlspecialchars($foto['archivo'], ENT_QUOTES, 'UTF-8'); ?>"
           class="galeria-item"
           data-lightbox="galeria"
           data-title="<?php echo htmlspecialchars($foto['titulo'], ENT_QUOTES, 'UTF-8'); ?>">
          <img src="<?php echo htmlspecialchars($foto['archivo'], ENT_QUOTES, 'UTF-8'); ?>"
               alt="<?php echo htmlspecialchars($foto['alt'], ENT_QUOTES, 'UTF-8'); ?>"
               loading="lazy">
          <span class="galeria-item__overlay">
            <span class="galeria-item__label"><?php echo htmlspecialchars($foto['titulo'], ENT_QUOTES, 'UTF-8'); ?></span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="galeria-cta">
      <p><?php echo htmlspecialchars(contenido('galeria.cta', '¿Querés vivir esto en primera persona?', $conn), ENT_QUOTES, 'UTF-8'); ?></p>
      <a href="inscripcion.php" class="nuestra-historia"><?php echo htmlspecialchars(contenido('galeria.cta_boton', 'Inscribite a un curso', $conn), ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
