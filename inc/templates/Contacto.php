<div class="wrapper">
  <form id="form-contacto" action="validacion_contacto.php" method="post" name="formulario" novalidate>
    <div class="form_contacto">
      <div class="field">
        <input type="text" id="nombre" name="nombre" placeholder=" " value="" required autofocus>
        <label for="nombre"><?php cms_text('contacto.label_nombre', 'Nombre', $conn); ?></label>
      </div>
      <div class="field">
        <input type="tel" id="celular" name="celular" placeholder=" " minlength="10" value=""
               inputmode="tel" autocomplete="tel" required>
        <label for="celular"><?php cms_text('contacto.label_celular', 'Celular', $conn); ?></label>
      </div>
      <div class="field">
        <input type="email" id="email" name="email" placeholder=" " value=""
               inputmode="email" autocomplete="email" required>
        <label for="email"><?php cms_text('contacto.label_email', 'E-Mail', $conn); ?></label>
      </div>
      <div class="field">
        <textarea id="consulta" rows="4" name="consulta" placeholder=" " required></textarea>
        <label for="consulta"><?php cms_text('contacto.label_consulta', 'Consulta', $conn); ?></label>
      </div>
      <div class="radio">
        <div>
          <p><?php cms_text('contacto.label_medio', '¿Por qué medio preferís la respuesta?', $conn); ?></p>
        </div>
        <div class="radio_options">
          <div>
            <input type="radio" id="metodo-celular" name="metodo" value="celular" checked>
            <label for="metodo-celular"><?php cms_text('contacto.label_whatsapp', 'Celular / WhatsApp', $conn); ?></label>
          </div>
          <div>
            <input type="radio" id="metodo-email" name="metodo" value="email">
            <label for="metodo-email"><?php cms_text('contacto.label_correo', 'Correo electrónico', $conn); ?></label>
          </div>
          <div>
            <input type="radio" id="metodo-ambos" name="metodo" value="ambos metodos">
            <label for="metodo-ambos"><?php cms_text('contacto.label_ambos', 'Ambos', $conn); ?></label>
          </div>
        </div>
      </div>
      <input id="btn_enviar" class="button" name="enviar" type="submit"
             value="<?php echo htmlspecialchars(contenido('contacto.boton', 'Enviar consulta', $conn), ENT_QUOTES, 'UTF-8'); ?>"
             <?php echo cms_attrs('contacto.boton', 'text', 'Botón de contacto'); ?>>
    </div>
  </form>
</div>
