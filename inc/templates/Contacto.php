<div class="wrapper">
  <form id="form-contacto" action="validacion_contacto.php" method="post" name="formulario" novalidate>
    <div class="form_contacto">
      <div class="field">
        <input type="text" id="nombre" name="nombre" placeholder=" " value="" required autofocus>
        <label for="nombre">Nombre</label>
      </div>
      <div class="field">
        <input type="tel" id="celular" name="celular" placeholder=" " minlength="10" value="" required>
        <label for="celular">Celular</label>
      </div>
      <div class="field">
        <input type="email" id="email" name="email" placeholder=" " value="" required>
        <label for="email">E-Mail</label>
      </div>
      <div class="field">
        <textarea id="consulta" rows="4" name="consulta" placeholder=" " required></textarea>
        <label for="consulta">Consulta</label>
      </div>
      <div class="radio">
        <div>
          <p>¿Por qué medio preferís la respuesta?</p>
        </div>
        <div class="radio_options">
          <div>
            <input type="radio" id="metodo-celular" name="metodo" value="celular" checked>
            <label for="metodo-celular">Celular / WhatsApp</label>
          </div>
          <div>
            <input type="radio" id="metodo-email" name="metodo" value="email">
            <label for="metodo-email">Correo electrónico</label>
          </div>
          <div>
            <input type="radio" id="metodo-ambos" name="metodo" value="ambos metodos">
            <label for="metodo-ambos">Ambos</label>
          </div>
        </div>
      </div>
      <input id="btn_enviar" class="button" name="enviar" type="submit" value="Enviar consulta">
    </div>
  </form>
</div>
