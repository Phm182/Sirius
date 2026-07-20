<?php include 'inc/templates/header.php'; ?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="section-cursos page-offset">
  <div id="cursos" class="cursos pagina-cursos">
    <h2>Curso</h2>

    <div class="contenedor-curso ordenador">
      <div class="curso info-curso">
        <div>
          <img src="<?php echo htmlspecialchars($curso_img, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($curso_alt, ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="info-curso2">
          <h3><?php echo htmlspecialchars($curso_titulo, ENT_QUOTES, 'UTF-8'); ?></h3>
          <p>
            <b>Inicio:</b> <?php echo htmlspecialchars($curso_inicio, ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Duración:</b> <?php echo htmlspecialchars($curso_duracion, ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Modalidad:</b> Práctico presencial · Teórico online<br>
            <b>Ubicación:</b> Sede Náutica · Costanera Norte (CABA)<br>
            <b>Arancel:</b> Consultar
          </p>
          <a href="inscripcion.php" class="boton">Inscribirme</a>
        </div>
      </div>

      <div class="curso">
        <p><?php echo htmlspecialchars($curso_desc, ENT_QUOTES, 'UTF-8'); ?></p>
      </div>
    </div>

    <div class="contenedor-curso mobile">
      <div class="curso info-curso">
        <div>
          <img src="<?php echo htmlspecialchars($curso_img, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($curso_alt, ENT_QUOTES, 'UTF-8'); ?>"><br>
          <h3><?php echo htmlspecialchars($curso_titulo, ENT_QUOTES, 'UTF-8'); ?></h3>
        </div>
        <div>
          <p><?php echo htmlspecialchars($curso_desc, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
      </div>
      <hr>
      <div class="curso info-curso">
        <div class="info-curso2">
          <p>
            <b>Inicio:</b> <?php echo htmlspecialchars($curso_inicio, ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Duración:</b> <?php echo htmlspecialchars($curso_duracion, ENT_QUOTES, 'UTF-8'); ?><br>
            <b>Modalidad:</b> Práctico presencial · Teórico online<br>
            <b>Ubicación:</b> Sede Náutica · Costanera Norte (CABA)<br>
            <b>Arancel:</b> Consultar
          </p>
          <a href="inscripcion.php" class="boton">Inscribirme</a>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="pagina-cursos-footer">
  <?php include 'inc/templates/footer.php'; ?>
</div>
