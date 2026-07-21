
                  <div>
                    <a href="index.php" class="logo"><img
                      src="<?php echo htmlspecialchars(contenido_asset('site.logo', 'img/Logo Web.png', $conn), ENT_QUOTES, 'UTF-8'); ?>"
                      alt="Logo Sirius"
                      <?php echo cms_attrs('site.logo', 'image', 'Logo del sitio', contenido_asset('site.logo', 'img/Logo Web.png', $conn)); ?>
                    ></a>
                  </div>
                  <div class="menu-pc">
                    <div class="options">
                        <ul>
                                            <li><a href="quienes_somos.php"><?php cms_text('nav.quienes', '¿Quiénes somos?', $conn); ?></a></li>
                                            <li><a href="cursos.php"><?php cms_text('nav.cursos', 'Cursos', $conn); ?></a></li>
                                            <li><a href="inscripcion.php"><?php cms_text('nav.inscripcion', 'Inscripción', $conn); ?></a></li>
                                            <li><a href="index.php#mapa"><?php cms_text('nav.sede', 'Sede', $conn); ?></a></li>
                                            <li><a href="galeria.php"><?php cms_text('nav.galeria', 'Galería', $conn); ?></a></li>
                                            <li><a href="contacto.php"><?php cms_text('nav.contacto', 'Contacto', $conn); ?></a></li>
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
                  
                  
