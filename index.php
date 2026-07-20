<?php
include 'inc/templates/header.php';
?>

<header class="site-header" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="hero-section">
  <div class="contenedor parallax">
    <div class="sirius">
      <h1>SIRIUS</h1>
      <p>Escuela Náutica</p>
      <a href="inscripcion.php" class="hero-cta">Quiero navegar</a>
    </div>
  </div>
</section>

<section>
  <div class="contenedor2">
    <div id="quienes_somos" class="nosotros-img ordenador">
      <img src="img/4.jpeg" alt="Alumnos de Sirius en práctica de navegación">
    </div>

    <div class="texto1 ordenador">
      <p class="nombre"><span>Sirius</span></p>
      <h3>Escuela de navegación</h3>
      <p class="nosotros">
        Somos un equipo de instructores apasionados por el río y el mar. Formamos navegantes desde el primer amarre hasta maniobras avanzadas, con clases claras, práctica real y acompañamiento cercano en cada etapa.
      </p>
      <a href="quienes_somos.php" class="nuestra-historia">Nuestra historia</a>
    </div>

    <div id="quienes_somos2" class="texto1 mobile">
      <p class="nombre"><span>Sirius</span></p>
      <h3>Escuela de navegación</h3>
      <p class="nosotros">
        Somos un equipo de instructores apasionados por el río y el mar. Formamos navegantes desde el primer amarre hasta maniobras avanzadas, con clases claras, práctica real y acompañamiento cercano en cada etapa.
      </p>
    </div>
    <div class="nosotros-img mobile">
      <img src="img/4.jpeg" alt="Alumnos de Sirius en práctica de navegación">
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="quienes_somos.php" class="nuestra-historia2">Nuestra historia</a>
  </div>
</section>

<section class="section-cursos">
  <div id="cursos" class="cursos">
    <h2>Cursos</h2>
    <div class="contenedor-cursos">
      <div class="curso">
        <img src="img/1.jpg" alt="Curso de lanchas">
        <h3>Lanchas</h3>
        <p>
          <b>Inicio:</b> Abril, junio, agosto y octubre<br>
          <b>Duración:</b> 2 meses<br>
          <b>Modalidad:</b> Práctico presencial · Teórico online<br>
          <b>Sede:</b> Costanera Norte · CABA<br>
          <b>Arancel:</b> Consultar
        </p>
        <a href="lanchas.php" class="boton">Más información</a>
      </div>

      <div class="curso">
        <img src="img/2.jpg" alt="Curso de veleros">
        <h3>Veleros</h3>
        <p>
          <b>Inicio:</b> Abril y agosto<br>
          <b>Duración:</b> 4 meses<br>
          <b>Modalidad:</b> Práctico presencial · Teórico online<br>
          <b>Sede:</b> Costanera Norte · CABA<br>
          <b>Arancel:</b> Consultar
        </p>
        <a href="veleros.php" class="boton">Más información</a>
      </div>

      <div class="curso">
        <img src="img/3.jpg" alt="Curso de yates">
        <h3>Yates</h3>
        <p>
          <b>Inicio:</b> Abril<br>
          <b>Duración:</b> 1 año<br>
          <b>Modalidad:</b> Práctico presencial · Teórico online<br>
          <b>Sede:</b> Costanera Norte · CABA<br>
          <b>Arancel:</b> Consultar
        </p>
        <a href="yates.php" class="boton">Más información</a>
      </div>
    </div>
  </div>
</section>

<section>
  <div id="inscripcion" class="contenedor2">
    <div class="texto1 ordenador">
      <p class="nombre"><span>¡Te esperamos a bordo!</span></p>
      <h3>Inscripción</h3>
      <p class="nosotros ordenador">
        Reservá tu lugar en el próximo ciclo. Completá el formulario y el equipo de Sirius te contacta para confirmar fechas, vacantes y aranceles.
      </p>
      <a href="inscripcion.php" class="nuestra-historia">Inscribirme</a>
    </div>

    <div class="nosotros-img ordenador">
      <img src="img/5.jpeg" alt="Práctica a bordo en Sirius" class="inscripción-img">
    </div>
  </div>

  <div class="contenedor2">
    <div class="texto1 mobile">
      <p class="nombre"><span>¡Te esperamos a bordo!</span></p>
    </div>
    <div class="nosotros-img2 mobile">
      <img src="img/5.jpeg" alt="Práctica a bordo en Sirius" class="inscripción-img">
    </div>
    <div class="texto1 mobile">
      <h3>Inscripción</h3>
      <p class="nosotros">
        Reservá tu lugar en el próximo ciclo. Completá el formulario y el equipo de Sirius te contacta para confirmar fechas, vacantes y aranceles.
      </p>
      <a href="inscripcion.php" class="nuestra-historia">Inscribirme</a>
    </div>
  </div>
  <div class="btn-nuestra-historia2">
    <a href="inscripcion.php" class="nuestra-historia2">Inscribirme</a>
  </div>
</section>

<section class="mapa-section" id="mapa-section">
  <div class="mapa-intro">
    <p class="nombre"><span>Sede</span></p>
    <h3>Costanera Norte</h3>
    <p>Practicamos en la Sede Náutica de la Costanera Norte. En breve publicamos la dirección exacta; mientras tanto, encontranos en el mapa.</p>
    <a href="contacto.php" class="nuestra-historia">Consultar cómo llegar</a>
  </div>
  <div id="mapa" class="mapa" role="region" aria-label="Mapa de la sede Sirius"></div>
</section>

<?php include 'inc/templates/footer.php'; ?>
<script src="js/map.js"></script>
