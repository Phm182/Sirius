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
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Equipo e instalaciones de Sirius"
           <?php echo cms_attrs('quienes.imagen', 'image', 'Imagen principal', $aboutImage); ?>>
    </div>

    <div class="texto1 ordenador">
      <p class="nombre"><span><?php cms_text('quienes.eyebrow', 'Sirius', $conn); ?></span></p>
      <h3><?php cms_text('quienes.titulo', 'Escuela de navegación', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.intro', '', $conn, true); ?>
      </p>
      <a href="#nuestra-historia" class="nuestra-historia"><?php cms_text('quienes.boton', 'Nuestra historia', $conn); ?></a>
    </div>

    <div class="texto1 mobile">
      <p class="nombre"><span><?php cms_text('quienes.eyebrow', 'Sirius', $conn); ?></span></p>
      <h3><?php cms_text('quienes.titulo', 'Escuela de navegación', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.intro', '', $conn, true); ?>
      </p>
    </div>
    <div class="nosotros-img mobile">
      <img src="<?php echo htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8'); ?>"
           alt="Equipo e instalaciones de Sirius"
           <?php echo cms_attrs('quienes.imagen', 'image', 'Imagen principal', $aboutImage); ?>>
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="#nuestra-historia" class="nuestra-historia2"><?php cms_text('quienes.boton', 'Nuestra historia', $conn); ?></a>
  </div>

  <hr id="nuestra-historia">
  <div class="texto1">
    <h5>Nuestra historia</h5>
    <div class="texto_historia">
      <h3><?php cms_text('quienes.historia_titulo', '', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.historia_texto', '', $conn, true); ?>
      </p>
      <h3><?php cms_text('quienes.metodo_titulo', '', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.metodo_texto', '', $conn, true); ?>
      </p>
      <h3><?php cms_text('quienes.sede_titulo', '', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.sede_texto', '', $conn, true); ?>
      </p>
      <h3><?php cms_text('quienes.comunidad_titulo', '', $conn); ?></h3>
      <p class="nosotros">
        <?php cms_text('quienes.comunidad_texto', '', $conn, true); ?>
      </p>
    </div>
  </div>
</section>

<?php include 'inc/templates/footer.php'; ?>
