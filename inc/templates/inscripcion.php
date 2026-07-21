<?php
$formCourses = cursos_activos($conn);
$selectedCourse = strtolower(trim((string) ($_GET['curso'] ?? '')));
?>
<div class="wrapper form-inscripcion-wrap">
  <form id="form-inscripcion" action="validacion_inscripcion.php" method="post" name="formulario_inscripcion" novalidate>
    <div class="form_contacto">
      <div class="field-row">
        <div class="field">
          <input type="text" id="nombre" name="nombre" placeholder=" " value=""
                 autocomplete="given-name" required autofocus>
          <label for="nombre"><?php cms_text('inscripcion.label_nombre', 'Nombre', $conn); ?></label>
        </div>
        <div class="field">
          <input type="text" id="apellido" name="apellido" placeholder=" " value=""
                 autocomplete="family-name" required>
          <label for="apellido"><?php cms_text('inscripcion.label_apellido', 'Apellido', $conn); ?></label>
        </div>
      </div>
      <div class="field-row">
        <div class="field">
          <input type="tel" id="celular" name="celular" placeholder=" " minlength="10" value=""
                 inputmode="tel" autocomplete="tel" required>
          <label for="celular"><?php cms_text('inscripcion.label_celular', 'Celular', $conn); ?></label>
        </div>
        <div class="field">
          <input type="email" id="email" name="email" placeholder=" " value=""
                 inputmode="email" autocomplete="email" required>
          <label for="email"><?php cms_text('inscripcion.label_email', 'E-Mail', $conn); ?></label>
        </div>
      </div>
      <div class="field field-select">
        <label for="curso"><?php cms_text('inscripcion.label_curso', 'Curso', $conn); ?></label>
        <select id="curso" name="curso" required>
          <option value="" disabled <?php echo $selectedCourse === '' ? 'selected' : ''; ?>>Elegí un curso</option>
          <?php foreach ($formCourses as $formCourse): ?>
            <option value="<?php echo htmlspecialchars($formCourse['slug'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedCourse === $formCourse['slug'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($formCourse['nombre'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field field-select">
        <label for="experiencia"><?php cms_text('inscripcion.label_experiencia', 'Experiencia náutica', $conn); ?></label>
        <select id="experiencia" name="experiencia" required>
          <option value="ninguna" selected>Sin experiencia previa</option>
          <option value="basica">Básica (paseos / práctica informal)</option>
          <option value="intermedia">Intermedia (navegación habitual)</option>
          <option value="avanzada">Avanzada</option>
        </select>
      </div>
      <div class="field">
        <textarea id="mensaje" rows="4" name="mensaje" placeholder=" "></textarea>
        <label for="mensaje"><?php cms_text('inscripcion.label_mensaje', 'Comentarios o disponibilidad', $conn); ?></label>
      </div>
      <p class="form-nota"><?php cms_text('inscripcion.nota', 'Te vamos a contactar para confirmar vacante, fechas y aranceles.', $conn); ?></p>
      <input id="btn_inscribir" class="button" name="enviar" type="submit"
             value="<?php echo htmlspecialchars(contenido('inscripcion.boton', 'Enviar inscripción', $conn), ENT_QUOTES, 'UTF-8'); ?>"
             <?php echo cms_attrs('inscripcion.boton', 'text', 'Botón de inscripción'); ?>>
    </div>
  </form>
</div>
