<?php include 'inc/templates/header.php'; ?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="galeria-page">
    <div class="galeria-hero">
      <p class="nombre"><span>Sirius</span></p>
      <h2>Galería a bordo</h2>
      <p class="galeria-lead">Momentos reales de práctica, aprendizaje y vida náutica. Tocá una imagen para verla en grande.</p>
    </div>

    <div class="galeria-mosaic">
      <?php
      $fotos = [
        ['src' => 'imgS/1.jpg', 'label' => 'Salida al río'],
        ['src' => 'imgS/2.jpg', 'label' => 'Maniobras'],
        ['src' => 'imgS/3.jpg', 'label' => 'Cubierta'],
        ['src' => 'imgS/4.jpg', 'label' => 'Navegación'],
        ['src' => 'imgS/5.jpg', 'label' => 'Instrucción'],
        ['src' => 'imgS/6.jpg', 'label' => 'Equipo'],
        ['src' => 'imgS/7.jpg', 'label' => 'Práctica'],
        ['src' => 'imgS/8.jpg', 'label' => 'Atardecer'],
        ['src' => 'imgS/9.jpeg', 'label' => 'Costanera'],
        ['src' => 'imgS/10.jpg', 'label' => 'Comunidad'],
      ];
      foreach ($fotos as $foto):
      ?>
        <a href="<?php echo htmlspecialchars($foto['src'], ENT_QUOTES, 'UTF-8'); ?>"
           class="galeria-item"
           data-lightbox="galeria"
           data-title="<?php echo htmlspecialchars($foto['label'], ENT_QUOTES, 'UTF-8'); ?>">
          <img src="<?php echo htmlspecialchars($foto['src'], ENT_QUOTES, 'UTF-8'); ?>"
               alt="<?php echo htmlspecialchars($foto['label'], ENT_QUOTES, 'UTF-8'); ?>"
               loading="lazy">
          <span class="galeria-item__overlay">
            <span class="galeria-item__label"><?php echo htmlspecialchars($foto['label'], ENT_QUOTES, 'UTF-8'); ?></span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="galeria-cta">
      <p>¿Querés vivir esto en primera persona?</p>
      <a href="inscripcion.php" class="nuestra-historia">Inscribite a un curso</a>
    </div>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
