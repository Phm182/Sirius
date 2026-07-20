<?php 
	include 'inc/templates/header.php';
?>

        <!-- Header -->

        <section>
  
            <div class="contenedor parallax">
                <div class="header">
                    <?php 
                        include 'inc/templates/nav.php';
                    ?>
                </div>
                
              <div class="sirius">
                  <h1>SIRIUS</h1>
                  <p>Escuela Nautica</p>

              </div> 

            </div>

        </section>

        <!-- ¿Quiénes somos? -->

        <section>
                 <!-- Ordenador -->

            <div class="contenedor2">
                <div id="quienes_somos" class="nosotros-img ordenador">
                    <img src="img/4.jpeg" alt="img">
                </div>

                <div class="texto1 ordenador">
                    <p class="nombre"><span>Sirius</span></p>
                    <h3>Escuela de navegación</h2>
                    <p class="nosotros">
                        Somos un equipo experimentado que trabaja hace X años, que está para brindarte las mejores clases de navegación y asesorarte en este gran camino nautico. Aprendiendo desde lo básico, hasta lo mas avanzado.
                    </p>
                    <a href="quienes_somos.php" class="nuestra-historia">Nuestra Historia</a>
                </div>

                <!-- Mobile -->

                <div id="quienes_somos2" class="texto1 mobile">
                    <p class="nombre"><span>Sirius</span></p>
                    <h3>Escuela de navegación</h2>
                    <p class="nosotros">
                        Somos un equipo experimentado que trabaja hace X años, que está para brindarte las mejores clases de navegación y asesorarte en este gran camino nautico. Aprendiendo desde lo básico, hasta lo mas avanzado.
                    </p>
                </div>
                <div class="nosotros-img mobile">
                    <img src="img/4.jpeg" alt="img">
                </div>
            </div>
            <div class="btn-nuestra-historia2">
                <a href="quienes_somos.php" class="nuestra-historia2">Nuestra Historia</a>
            </div>


        </section>

        <!-- Cursos -->

        <section class="section-cursos">
            <div id="cursos" class="cursos">

                <h2>Cursos</h2>
                <div class="contenedor-cursos">
                    <div class="curso">
                        <img src="img/1.jpg" alt="">
                        <h3>Lanchas</h3>
                        <p>
                            <b>Inicio: </b> Abril, Junio, Agosto y Octubre 2021 <br>
                            <b>Duración: </b> 2 meses <br>
                            <b>Modalidad: </b> Práctico de forma presencial, Teórico Online  <br>
                            <b>Ubicación Presencial: </b> CABA y GBA  <br>
                            <b>Arancel: </b> $xxxx <br>
                        </p>
                        <a href="lanchas.php" class="boton">Mas información</a>
                    </div>
    
                    <div class="curso">
                        <img src="img/2.jpg" alt="">
                        <h3>Veleros</h3>
                        <p>
                            <b>Inicio: </b> Abril y Agosto 2021 <br>
                            <b>Duración: </b> 4 meses <br>
                            <b>Modalidad: </b> Práctico de forma presencial, Teórico Online  <br>
                            <b>Ubicación Presencial: </b> CABA y GBA  <br>
                            <b>Arancel: </b> $xxxx <br>
                        </p>
                        <a href="veleros.php" class="boton">Mas información</a>
                    </div>
    
                    <div class="curso">
                        <img src="img/3.jpg" alt="">
                        <h3>Yates</h3>
                        <p>
                            <b>Inicio: </b> Abril 2021 <br>
                            <b>Duración: </b> 1 año <br>
                            <b>Modalidad: </b> Práctico de forma presencial, Teórico Online  <br>
                            <b>Ubicación Presencial: </b> CABA y GBA  <br>
                            <b>Arancel: </b> $xxxx <br>
                        </p>
                        <a href="yates.php" class="boton">Mas información</a>
                    </div>
                </div>

            </div>
        </section>

            <!-- Inscripción  -->

            <section>
                <div id="inscripcion" class="contenedor2 ">

                    <!-- Ordenador -->
                    <div class="texto1 ordenador">
                        <p class="nombre"><span>¡Esperamos verte en nuestros cursos!</span></p>
                        <h3 class="ordenador">Inscripciòn</h2>
                        <p class="nosotros ordenador">
                            Si estás interesado en nuestros cursos, anotate haciendo click en el siguiente botón:                        </p>
                        <a href="#" class="nuestra-historia">Inscribirse</a>
                    </div>
    
                    <div class="nosotros-img ordenador">
                        <img src="img/5.jpeg" alt="img" class="inscripción-img">
                    </div>
                </div>
                    <!-- Mobile -->
                <div class="contenedor2">    
                    <div class="texto1 mobile">
                        <p class="nombre"><span>¡Esperamos verte en nuestros cursos!</span></p>
                    </div>
    
                    <div class="nosotros-img2 mobile">
                        <img src="img/5.jpeg" alt="img" class="inscripción-img">
                    </div>

                    <div class="texto1 mobile">
                        <h3>Inscripciòn</h2>
                        <p class="nosotros">
                            Si estás interesado en nuestros cursos, anotate presionando en el siguiente botón:                        </p>
                        <a href="#" class="nuestra-historia">Inscribirse</a><br>
                    </div>
                    
                </div>
                <div class="btn-nuestra-historia2">
                    <a href="#" class="nuestra-historia2">Inscribirse</a>
                </div>
    
    
            </section>

            <!-- Maps  -->
        <section>
            <div id="mapa" class="mapa">
  
            </div>
        </section>

<?php 
	include 'inc/templates/footer.php';
?>
<script src="js/map.js"></script>


