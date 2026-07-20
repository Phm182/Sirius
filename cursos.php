<?php include 'inc/templates/header.php'; ?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="section-cursos page-offset">
  <div id="cursos" class="cursos pagina-cursos">
    <div class="cursos-titulo">
      <p class="nombre"><span>Sirius</span></p>
      <h2>Cursos</h2>
    </div>
    <div class="contenedor-cursos">
      <div class="curso">
        <img src="img/1.jpg" alt="Curso de lanchas">
        <h3>Lanchas</h3>
        <p>
          Ideal para quienes quieren manejar embarcaciones a motor con seguridad. Aprendés maniobras básicas y avanzadas, normativa, comunicaciones y práctica en río con instructores a bordo.
        </p>
        <a href="lanchas.php" class="boton">Más información</a>
      </div>

      <div class="curso">
        <img src="img/2.jpg" alt="Curso de veleros">
        <h3>Veleros</h3>
        <p>
          Descubrí el arte de navegar a vela: trimado, ceñida, empopada, cambios de rumbo y trabajo en equipo. Una formación completa para disfrutar el viento con criterio y control.
        </p>
        <a href="veleros.php" class="boton">Más información</a>
      </div>

      <div class="curso">
        <img src="img/3.jpg" alt="Curso de yates">
        <h3>Yates</h3>
        <p>
          Programa avanzado para quienes buscan navegar yates con responsabilidad: planificación de travesías, sistemas a bordo, guardias, meteorología aplicada y liderazgo de tripulación.
        </p>
        <a href="yates.php" class="boton">Más información</a>
      </div>
    </div>
  </div>
</section>

<div class="pagina-cursos-footer">
  <?php include 'inc/templates/footer.php'; ?>
</div>
