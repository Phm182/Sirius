<?php
include 'inc/templates/header.php';
$aboutImage = contenido_asset('quienes.imagen', 'img/4.jpeg', $conn);
?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="contenedor2 section_quienes">
    <div class="nosotros-img ordenador">
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>" alt="Equipo e instalaciones de Sirius">
    </div>

    <div class="texto1 ordenador">
      <p class="nombre"><span><?php echo htmlspecialchars(contenido('quienes.eyebrow', 'Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></span></p>
      <h3><?php echo htmlspecialchars(contenido('quienes.titulo', 'Escuela de navegación', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.intro', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
      <a href="#nuestra-historia" class="nuestra-historia"><?php echo htmlspecialchars(contenido('quienes.boton', 'Nuestra historia', $conn), ENT_QUOTES, 'UTF-8'); ?></a>
    </div>

    <div class="texto1 mobile">
      <p class="nombre"><span><?php echo htmlspecialchars(contenido('quienes.eyebrow', 'Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></span></p>
      <h3><?php echo htmlspecialchars(contenido('quienes.titulo', 'Escuela de navegación', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.intro', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
    </div>
    <div class="nosotros-img mobile">
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>" alt="Equipo e instalaciones de Sirius">
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="#nuestra-historia" class="nuestra-historia2"><?php echo htmlspecialchars(contenido('quienes.boton', 'Nuestra historia', $conn), ENT_QUOTES, 'UTF-8'); ?></a>
  </div>

  <hr id="nuestra-historia">
  <div class="texto1">
    <h5>Nuestra historia</h5>
    <div class="texto_historia">
      <h3><?php echo htmlspecialchars(contenido('quienes.historia_titulo', '', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.historia_texto', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
      <h3><?php echo htmlspecialchars(contenido('quienes.metodo_titulo', '', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.metodo_texto', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
      <h3><?php echo htmlspecialchars(contenido('quienes.sede_titulo', '', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.sede_texto', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
      <h3><?php echo htmlspecialchars(contenido('quienes.comunidad_titulo', '', $conn), ENT_QUOTES, 'UTF-8'); ?></h3>
      <p class="nosotros">
        <?php echo nl2br(htmlspecialchars(contenido('quienes.comunidad_texto', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
      </p>
    </div>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
