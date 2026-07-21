<section class="wrapper">

  <section class="material-design-hamburger">
    <button class="material-design-hamburger__icon" type="button"
            aria-label="Abrir menú" aria-expanded="false" aria-controls="menu-mobile-panel">
      <span class="material-design-hamburger__layer"></span>
    </button>
  </section>

  <nav class="menu menu--off" id="menu-mobile-panel" aria-label="Navegación móvil" aria-hidden="true">
    <div><a href="quienes_somos.php"><?php echo htmlspecialchars(contenido('nav.quienes', '¿Quiénes somos?', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <div><a href="cursos.php"><?php echo htmlspecialchars(contenido('nav.cursos', 'Cursos', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <div><a href="inscripcion.php"><?php echo htmlspecialchars(contenido('nav.inscripcion', 'Inscripción', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <div><a href="index.php#mapa"><?php echo htmlspecialchars(contenido('nav.sede', 'Sede', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <div><a href="galeria.php"><?php echo htmlspecialchars(contenido('nav.galeria', 'Galería', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <!-- <div><a href="#">Noticias</a></div> -->
    <div><a href="contacto.php"><?php echo htmlspecialchars(contenido('nav.contacto', 'Contacto', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
    <div><a href="admin/login.php"><i class="fas fa-user-shield" aria-hidden="true"></i> <?php echo htmlspecialchars(contenido('nav.admin', 'Administración', $conn), ENT_QUOTES, 'UTF-8'); ?></a></div>
  </nav>
  
</section>