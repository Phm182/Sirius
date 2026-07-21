<footer>
  <div class="footer contenedor2">
    <div class="contenedor-footer">
      <div class="caja-footer ordenador">
        <h4><?php cms_text('footer.sobre_titulo', 'Sobre Sirius', $conn); ?></h4>
        <p>
          <?php cms_text('footer.sobre', '', $conn, true); ?>
        </p>
      </div>
      <div class="caja-footer">
        <h4><?php cms_text('footer.sede_titulo', 'Nuestra Sede', $conn); ?></h4>
        <div class="footer-p">
          <p>
            <?php cms_text('footer.sede', '', $conn, true); ?>
          </p>
          <p>
            <?php cms_text('footer.sede_extra', '', $conn, true); ?>
          </p>
        </div>
      </div>
      <div class="caja-footer">
        <h4><?php cms_text('footer.redes_titulo', 'Redes Sociales', $conn); ?></h4>
        <nav class="nav-redes">
          <a href="<?php echo htmlspecialchars(contenido('footer.facebook', 'https://www.facebook.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>"
             <?php echo cms_attrs('footer.facebook', 'url', 'Facebook'); ?>
             target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo htmlspecialchars(contenido('footer.youtube', 'https://www.youtube.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>"
             <?php echo cms_attrs('footer.youtube', 'url', 'YouTube'); ?>
             target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          <a href="<?php echo htmlspecialchars(contenido('footer.instagram', 'https://www.instagram.com/', $conn), ENT_QUOTES, 'UTF-8'); ?>"
             <?php echo cms_attrs('footer.instagram', 'url', 'Instagram'); ?>
             target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </nav>
      </div>
    </div>
    <div class="copyright">
      <p><?php cms_text('footer.credito', 'Diseño Web: BitFlow', $conn); ?></p>
      <p>Todos los derechos reservados Sirius <?php echo date('Y'); ?> ®</p>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="<?php echo htmlspecialchars(sirius_asset('js/lightbox.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<script src="<?php echo htmlspecialchars(sirius_asset('js/main.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<?php if (function_exists('cms_edit_mode') && cms_edit_mode()): ?>
<link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('admin/assets/visual-editor.css'), ENT_QUOTES, 'UTF-8'); ?>">
<script src="<?php echo htmlspecialchars(sirius_asset('admin/assets/visual-editor.js'), ENT_QUOTES, 'UTF-8'); ?>"></script>
<?php endif; ?>

</body>
</html>
