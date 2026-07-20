<div class="wrapper form-inscripcion-wrap">
  <form id="form-inscripcion" action="validacion_inscripcion.php" method="post" name="formulario_inscripcion" novalidate>
    <div class="form_contacto">
      <div class="field-row">
        <div class="field">
          <input type="text" id="nombre" name="nombre" placeholder=" " value="" required autofocus>
          <label for="nombre">Nombre</label>
        </div>
        <div class="field">
          <input type="text" id="apellido" name="apellido" placeholder=" " value="" required>
          <label for="apellido">Apellido</label>
        </div>
      </div>
      <div class="field-row">
        <div class="field">
          <input type="tel" id="celular" name="celular" placeholder=" " minlength="10" value="" required>
          <label for="celular">Celular</label>
        </div>
        <div class="field">
          <input type="email" id="email" name="email" placeholder=" " value="" required>
          <label for="email">E-Mail</label>
        </div>
      </div>
      <div class="field field-select">
        <label for="curso">Curso</label>
        <select id="curso" name="curso" required>
          <option value="" disabled selected>Elegí un curso</option>
          <option value="lanchas">Lanchas</option>
          <option value="veleros">Veleros</option>
          <option value="yates">Yates</option>
        </select>
      </div>
      <div class="field field-select">
        <label for="experiencia">Experiencia náutica</label>
        <select id="experiencia" name="experiencia" required>
          <option value="ninguna" selected>Sin experiencia previa</option>
          <option value="basica">Básica (paseos / práctica informal)</option>
          <option value="intermedia">Intermedia (navegación habitual)</option>
          <option value="avanzada">Avanzada</option>
        </select>
      </div>
      <div class="field">
        <textarea id="mensaje" rows="4" name="mensaje" placeholder=" "></textarea>
        <label for="mensaje">Comentarios o disponibilidad</label>
      </div>
      <p class="form-nota">Te vamos a contactar para confirmar vacante, fechas y aranceles.</p>
      <input id="btn_inscribir" class="button" name="enviar" type="submit" value="Enviar inscripción">
    </div>
  </form>
</div>
