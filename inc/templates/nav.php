
                  <div>
                    <a href="index.php" class="logo"><img src="<?php echo htmlspecialchars(contenido_asset('site.logo', 'img/Logo Web.png', $conn), ENT_QUOTES, 'UTF-8'); ?>" alt="Logo Sirius"></a>
                  </div>
                  <div class="menu-pc">
                    <div class="options">
                        <ul>
                                            <li><a href="quienes_somos.php"><?php echo htmlspecialchars(contenido('nav.quienes', '¿Quiénes somos?', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <li><a href="cursos.php"><?php echo htmlspecialchars(contenido('nav.cursos', 'Cursos', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <li><a href="inscripcion.php"><?php echo htmlspecialchars(contenido('nav.inscripcion', 'Inscripción', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <li><a href="index.php#mapa"><?php echo htmlspecialchars(contenido('nav.sede', 'Sede', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <li><a href="galeria.php"><?php echo htmlspecialchars(contenido('nav.galeria', 'Galería', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <!-- <li><a href="#">Noticias</a></li> -->
                                            <li><a href="contacto.php"><?php echo htmlspecialchars(contenido('nav.contacto', 'Contacto', $conn), ENT_QUOTES, 'UTF-8'); ?></a></li>
                                            <li class="admin-access">
                                                <a href="admin/login.php" class="admin-access__link" aria-label="Ingresar al panel de administración" title="Administración">
                                                    <i class="fas fa-user-shield" aria-hidden="true"></i>
                                                </a>
                                            </li>
                        </ul>
                    </div> 
                  </div>
                  <div class="menu-mobile">
                    <?php 
                        include 'inc/templates/boton-menu.php';
                    ?>
                  </div>
                  
                  
