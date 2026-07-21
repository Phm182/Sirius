<section class="wrapper">

  <section class="material-design-hamburger">
    <button class="material-design-hamburger__icon" type="button"
            aria-label="Abrir menú" aria-expanded="false" aria-controls="menu-mobile-panel">
      <span class="material-design-hamburger__layer"></span>
    </button>
  </section>

  <nav class="menu menu--off" id="menu-mobile-panel" aria-label="Navegación móvil" aria-hidden="true">
    <div><a href="quienes_somos.php"><?php cms_text('nav.quienes', '¿Quiénes somos?', $conn); ?></a></div>
    <div><a href="cursos.php"><?php cms_text('nav.cursos', 'Cursos', $conn); ?></a></div>
    <div><a href="inscripcion.php"><?php cms_text('nav.inscripcion', 'Inscripción', $conn); ?></a></div>
    <div><a href="index.php#mapa"><?php cms_text('nav.sede', 'Sede', $conn); ?></a></div>
    <div><a href="galeria.php"><?php cms_text('nav.galeria', 'Galería', $conn); ?></a></div>
    <div><a href="contacto.php"><?php cms_text('nav.contacto', 'Contacto', $conn); ?></a></div>
    <div><a href="admin/login.php"><i class="fas fa-user-shield" aria-hidden="true"></i> <?php cms_text('nav.admin', 'Administración', $conn); ?></a></div>
  </nav>
  
</section>
