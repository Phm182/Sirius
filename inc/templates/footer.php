<footer>
  <div class="footer contenedor2">
    <div class="contenedor-footer">
      <div class="caja-footer ordenador">
        <h4><?php echo htmlspecialchars(contenido('footer.sobre_titulo', 'Sobre Sirius', $conn), ENT_QUOTES, 'UTF-8'); ?></h4>
        <p>
          <?php echo nl2br(htmlspecialchars(contenido('footer.sobre', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
        </p>
      </div>
      <div class="caja-footer">
        <h4><?php echo htmlspecialchars(contenido('footer.sede_titulo', 'Nuestra Sede', $conn), ENT_QUOTES, 'UTF-8'); ?></h4>
        <div class="footer-p">
          <p>
            <?php echo nl2br(htmlspecialchars(contenido('footer.sede', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
          </p>
          <p>
            <?php echo nl2br(htmlspecialchars(contenido('footer.sede_extra', '', $conn), ENT_QUOTES, 'UTF-8')); ?>
          </p>
        </div>
      </div>
      <div class="caja-footer">
        <h4><?php echo htmlspecialchars(contenido('footer.redes_titulo', 'Redes Sociales', $conn), ENT_QUOTES, 'UTF-8'); ?></h4>
        <nav class="nav-redes">
          <a href="<?php echo htmlspecialchars(contenido('footer.facebook', 'https://www.facebook.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo htmlspecialchars(contenido('footer.youtube', 'https://www.youtube.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          <a href="<?php echo htmlspecialchars(contenido('footer.instagram', 'https://www.instagram.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </nav>
      </div>
    </div>
    <div class="copyright">
      <p><?php echo htmlspecialchars(contenido('footer.credito', 'Diseño Web: BitFlow', $conn), ENT_QUOTES, 'UTF-8'); ?></p>
      <p>Todos los derechos reservados Sirius <?php echo date('Y'); ?> ®</p>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="<?php echo htmlspecialchars(sirius_asset('js/lightbox.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<script src="<?php echo htmlspecialchars(sirius_asset('js/main.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>

</body>
</html>
