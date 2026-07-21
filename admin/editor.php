<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$pageTitle = 'Editor del sitio';
$activePage = 'editor';
$cmsReady = admin_cms_ready($conn);

$catalog = [
    'General' => [
        'site.logo' => ['Logo del sitio', 'image'],
        'site.fondo' => ['Fondo principal y parallax', 'image'],
        'nav.quienes' => ['Menú: Quiénes somos', 'text'],
        'nav.cursos' => ['Menú: Cursos', 'text'],
        'nav.inscripcion' => ['Menú: Inscripción', 'text'],
        'nav.sede' => ['Menú: Sede', 'text'],
        'nav.galeria' => ['Menú: Galería', 'text'],
        'nav.contacto' => ['Menú: Contacto', 'text'],
        'nav.admin' => ['Menú móvil: Administración', 'text'],
    ],
    'Inicio' => [
        'inicio.hero_titulo' => ['Título principal', 'text'],
        'inicio.hero_subtitulo' => ['Subtítulo principal', 'text'],
        'inicio.hero_boton' => ['Texto del botón', 'text'],
        'inicio.presentacion_eyebrow' => ['Marca sobre presentación', 'text'],
        'inicio.presentacion_titulo' => ['Título de presentación', 'text'],
        'inicio.presentacion_texto' => ['Presentación', 'textarea'],
        'inicio.presentacion_imagen' => ['Imagen de presentación', 'image'],
        'inicio.presentacion_boton' => ['Botón de presentación', 'text'],
        'inicio.cursos_titulo' => ['Título de cursos', 'text'],
        'inicio.inscripcion_eyebrow' => ['Frase sobre inscripción', 'text'],
        'inicio.inscripcion_titulo' => ['Título de inscripción', 'text'],
        'inicio.inscripcion_texto' => ['Texto de inscripción', 'textarea'],
        'inicio.inscripcion_imagen' => ['Imagen de inscripción', 'image'],
        'inicio.inscripcion_boton' => ['Botón de inscripción', 'text'],
        'inicio.sede_eyebrow' => ['Marca sobre sede', 'text'],
        'inicio.sede_titulo' => ['Título de sede', 'text'],
        'inicio.sede_texto' => ['Texto de sede', 'textarea'],
        'inicio.sede_boton' => ['Botón de sede', 'text'],
        'inicio.mapa_zoom' => ['Zoom inicial del mapa', 'number'],
    ],
    'Quiénes somos' => [
        'quienes.eyebrow' => ['Marca', 'text'],
        'quienes.titulo' => ['Título', 'text'],
        'quienes.intro' => ['Introducción', 'textarea'],
        'quienes.imagen' => ['Imagen principal', 'image'],
        'quienes.boton' => ['Texto del botón', 'text'],
        'quienes.historia_titulo' => ['Título de historia', 'text'],
        'quienes.historia_texto' => ['Historia', 'textarea'],
        'quienes.metodo_titulo' => ['Título del método', 'text'],
        'quienes.metodo_texto' => ['Descripción del método', 'textarea'],
        'quienes.sede_titulo' => ['Título de sede/aula', 'text'],
        'quienes.sede_texto' => ['Texto de sede/aula', 'textarea'],
        'quienes.comunidad_titulo' => ['Título de comunidad', 'text'],
        'quienes.comunidad_texto' => ['Texto de comunidad', 'textarea'],
    ],
    'Cursos / Galería' => [
        'cursos.eyebrow' => ['Marca sobre cursos', 'text'],
        'cursos.titulo' => ['Título de cursos', 'text'],
        'cursos.intro' => ['Introducción de cursos', 'textarea'],
        'galeria.eyebrow' => ['Marca sobre galería', 'text'],
        'galeria.titulo' => ['Título de galería', 'text'],
        'galeria.intro' => ['Introducción de galería', 'textarea'],
        'galeria.cta' => ['Llamado a la acción', 'text'],
        'galeria.cta_boton' => ['Botón de galería', 'text'],
    ],
    'Contacto / Inscripción' => [
        'contacto.eyebrow' => ['Marca de contacto', 'text'],
        'contacto.titulo' => ['Título de contacto', 'text'],
        'contacto.intro' => ['Introducción de contacto', 'textarea'],
        'contacto.boton' => ['Botón de contacto', 'text'],
        'contacto.label_nombre' => ['Contacto: Nombre', 'text'],
        'contacto.label_celular' => ['Contacto: Celular', 'text'],
        'contacto.label_email' => ['Contacto: Email', 'text'],
        'contacto.label_consulta' => ['Contacto: Consulta', 'text'],
        'contacto.label_medio' => ['Contacto: pregunta de respuesta', 'text'],
        'contacto.label_whatsapp' => ['Contacto: opción WhatsApp', 'text'],
        'contacto.label_correo' => ['Contacto: opción correo', 'text'],
        'contacto.label_ambos' => ['Contacto: opción ambos', 'text'],
        'inscripcion.eyebrow' => ['Marca de inscripción', 'text'],
        'inscripcion.titulo' => ['Título de inscripción', 'text'],
        'inscripcion.intro' => ['Introducción de inscripción', 'textarea'],
        'inscripcion.nota' => ['Nota del formulario', 'text'],
        'inscripcion.boton' => ['Botón de inscripción', 'text'],
        'inscripcion.label_nombre' => ['Inscripción: Nombre', 'text'],
        'inscripcion.label_apellido' => ['Inscripción: Apellido', 'text'],
        'inscripcion.label_celular' => ['Inscripción: Celular', 'text'],
        'inscripcion.label_email' => ['Inscripción: Email', 'text'],
        'inscripcion.label_curso' => ['Inscripción: Curso', 'text'],
        'inscripcion.label_experiencia' => ['Inscripción: Experiencia', 'text'],
        'inscripcion.label_mensaje' => ['Inscripción: Comentarios', 'text'],
    ],
    'Footer / SEO' => [
        'footer.sobre_titulo' => ['Título Sobre Sirius', 'text'],
        'footer.sobre' => ['Descripción de Sirius', 'textarea'],
        'footer.sede_titulo' => ['Título de sede', 'text'],
        'footer.sede' => ['Dirección de sede', 'textarea'],
        'footer.sede_extra' => ['Texto adicional de sede', 'textarea'],
        'footer.redes_titulo' => ['Título de redes', 'text'],
        'footer.facebook' => ['Facebook', 'url'],
        'footer.youtube' => ['YouTube', 'url'],
        'footer.instagram' => ['Instagram', 'url'],
        'footer.credito' => ['Crédito del sitio', 'text'],
        'seo.titulo' => ['Título SEO', 'text'],
        'seo.descripcion' => ['Descripción SEO', 'textarea'],
    ],
];

$flatCatalog = [];
foreach ($catalog as $fields) {
    $flatCatalog += $fields;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    if (!$cmsReady) {
        admin_flash('error', 'Primero ejecutá sql/cms_migration.sql.');
        admin_redirect('editor.php');
    }

    $action = (string) ($_POST['action'] ?? '');
    try {
        if ($action === 'save_content') {
            $stmt = $conn->prepare(
                'INSERT INTO sitio_contenido (clave, valor, tipo) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE valor = VALUES(valor), tipo = VALUES(tipo)'
            );
            $conn->begin_transaction();
            foreach ($flatCatalog as $key => [$label, $type]) {
                $value = trim((string) ($_POST['content'][$key] ?? ''));
                if ($type === 'url' && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                    throw new RuntimeException('La URL de "' . $label . '" no es válida.');
                }
                if ($type === 'number' && $value !== '' && !is_numeric($value)) {
                    throw new RuntimeException('El valor de "' . $label . '" debe ser numérico.');
                }
                if ($type === 'image' && isset($_FILES['content_images']['error'][$key])
                    && $_FILES['content_images']['error'][$key] !== UPLOAD_ERR_NO_FILE) {
                    $value = admin_store_image([
                        'name' => $_FILES['content_images']['name'][$key] ?? '',
                        'type' => $_FILES['content_images']['type'][$key] ?? '',
                        'tmp_name' => $_FILES['content_images']['tmp_name'][$key] ?? '',
                        'error' => $_FILES['content_images']['error'][$key],
                        'size' => $_FILES['content_images']['size'][$key] ?? 0,
                    ], 'site');
                }
                $stmt->bind_param('sss', $key, $value, $type);
                $stmt->execute();
            }
            $stmt->close();
            $conn->commit();
            admin_audit($conn, 'contenido_actualizado', 'sitio_contenido', null, count($flatCatalog) . ' campos');
            admin_flash('success', 'Los textos e imágenes se guardaron.');
        } elseif ($action === 'gallery_upload') {
            $files = $_FILES['photos'] ?? null;
            $saved = 0;
            if (!is_array($files) || !isset($files['name']) || !is_array($files['name'])) {
                throw new RuntimeException('Elegí al menos una imagen.');
            }
            $stmt = $conn->prepare(
                'INSERT INTO galeria_foto (archivo, titulo, alt, activo, orden) VALUES (?, ?, ?, 1, ?)'
            );
            $baseOrder = (int) ($_POST['orden'] ?? 0);
            foreach ($files['name'] as $index => $name) {
                if (($files['error'][$index] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $path = admin_store_image([
                    'name' => $name,
                    'type' => $files['type'][$index] ?? '',
                    'tmp_name' => $files['tmp_name'][$index] ?? '',
                    'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                    'size' => $files['size'][$index] ?? 0,
                ], 'gallery');
                $title = pathinfo((string) $name, PATHINFO_FILENAME);
                $alt = $title;
                $order = $baseOrder + $saved;
                $stmt->bind_param('sssi', $path, $title, $alt, $order);
                $stmt->execute();
                $saved++;
            }
            $stmt->close();
            if ($saved === 0) {
                throw new RuntimeException('Elegí al menos una imagen.');
            }
            admin_audit($conn, 'galeria_imagenes_creadas', 'galeria_foto', null, $saved . ' imagen(es)');
            admin_flash('success', $saved . ' imagen(es) agregada(s) a la galería.');
        } elseif ($action === 'gallery_update') {
            $id = (int) ($_POST['id'] ?? 0);
            $title = trim((string) ($_POST['titulo'] ?? ''));
            $alt = trim((string) ($_POST['alt'] ?? ''));
            $order = (int) ($_POST['orden'] ?? 0);
            $active = isset($_POST['activo']) ? 1 : 0;
            $stmt = $conn->prepare('UPDATE galeria_foto SET titulo = ?, alt = ?, orden = ?, activo = ? WHERE id = ?');
            $stmt->bind_param('ssiii', $title, $alt, $order, $active, $id);
            $stmt->execute();
            $stmt->close();
            admin_audit($conn, 'galeria_imagen_actualizada', 'galeria_foto', $id);
            admin_flash('success', 'La imagen se actualizó.');
        } elseif ($action === 'gallery_delete') {
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('DELETE FROM galeria_foto WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            admin_audit($conn, 'galeria_imagen_eliminada', 'galeria_foto', $id, 'El archivo físico se conservó');
            admin_flash('success', 'La imagen se quitó de la galería.');
        } else {
            throw new RuntimeException('Acción no válida.');
        }
    } catch (Throwable $exception) {
        if ($conn->errno === 0) {
            // No-op: conserva un mensaje de validación útil.
        }
        try {
            $conn->rollback();
        } catch (Throwable $ignored) {
        }
        admin_flash('error', $exception instanceof RuntimeException
            ? $exception->getMessage()
            : 'No se pudieron guardar los cambios.');
    }
    admin_redirect('editor.php');
}

$contentValues = [];
$courses = [];
$photos = [];
if ($cmsReady) {
    $result = $conn->query('SELECT clave, valor FROM sitio_contenido');
    while ($row = $result->fetch_assoc()) {
        $contentValues[$row['clave']] = $row['valor'];
    }
    $courses = $conn->query('SELECT id, slug, nombre, precio, activo, orden, imagen FROM curso ORDER BY orden, nombre')
        ->fetch_all(MYSQLI_ASSOC);
    $photos = $conn->query('SELECT * FROM galeria_foto ORDER BY orden, id')->fetch_all(MYSQLI_ASSOC);
}

require __DIR__ . '/templates/header.php';
?>
<div class="admin-page-head">
  <div>
    <h1>Editor del sitio</h1>
    <p>Administrá textos, imágenes, cursos y la cantidad de fotos publicadas.</p>
  </div>
</div>

<?php if (!$cmsReady): ?>
  <div class="admin-alert admin-alert--warning">
    El CMS todavía no está instalado. Ejecutá <code>sql/cms_migration.sql</code> en la base de datos.
  </div>
<?php else: ?>
  <nav class="admin-tabs" aria-label="Secciones del editor">
    <a href="#textos">Textos e imágenes</a>
    <a href="#cursos">Cursos</a>
    <a href="#galeria">Galería</a>
  </nav>

  <div class="admin-editor" data-editor data-csrf="<?php echo admin_h(admin_csrf_token()); ?>">
    <div class="admin-editor__main">

  <section class="admin-card" id="textos">
    <div class="admin-card__head"><h2>Textos e imágenes</h2></div>
    <div class="admin-card__body">
      <form method="post" enctype="multipart/form-data" data-content-form>
        <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
        <input type="hidden" name="action" value="save_content">
        <?php foreach ($catalog as $group => $fields): ?>
          <fieldset class="admin-fieldset">
            <legend><?php echo admin_h($group); ?></legend>
            <div class="admin-form-grid">
              <?php foreach ($fields as $key => [$label, $type]): ?>
                <?php $value = (string) ($contentValues[$key] ?? ''); ?>
                <div class="admin-field <?php echo $type === 'textarea' ? 'admin-field--wide' : ''; ?>">
                  <label for="<?php echo admin_h('field-' . md5($key)); ?>"><?php echo admin_h($label); ?></label>
                  <?php if ($type === 'textarea'): ?>
                    <textarea id="<?php echo admin_h('field-' . md5($key)); ?>" name="content[<?php echo admin_h($key); ?>]"><?php echo admin_h($value); ?></textarea>
                  <?php else: ?>
                    <input id="<?php echo admin_h('field-' . md5($key)); ?>"
                           type="<?php echo $type === 'image' ? 'text' : admin_h($type); ?>"
                           name="content[<?php echo admin_h($key); ?>]"
                           value="<?php echo admin_h($value); ?>">
                    <?php if ($type === 'image'): ?>
                      <input class="admin-file-input" type="file" name="content_images[<?php echo admin_h($key); ?>]" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                      <?php if ($value !== ''): ?><img class="admin-thumb" src="../<?php echo admin_h($value); ?>" alt="Vista previa"><?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </fieldset>
        <?php endforeach; ?>
        <button class="admin-button admin-button--primary" type="submit">Guardar contenido</button>
      </form>
    </div>
  </section>

  <section class="admin-card" id="cursos">
    <div class="admin-card__head admin-card__head--actions">
      <h2>Cursos</h2>
      <a class="admin-button admin-button--primary" href="curso_editar.php">Crear curso</a>
    </div>
    <?php if (!$courses): ?>
      <div class="admin-empty">No hay cursos cargados.</div>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead><tr><th>Curso</th><th>Precio</th><th>Orden</th><th>Estado</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($courses as $course): ?>
            <tr>
              <td><strong><?php echo admin_h($course['nombre']); ?></strong><div class="admin-table__secondary"><?php echo admin_h($course['slug']); ?></div></td>
              <td><?php echo admin_h($course['precio']); ?></td>
              <td><?php echo (int) $course['orden']; ?></td>
              <td><span class="admin-badge"><?php echo $course['activo'] ? 'Publicado' : 'Oculto'; ?></span></td>
              <td><a class="admin-button" href="curso_editar.php?id=<?php echo (int) $course['id']; ?>">Editar</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <section class="admin-card" id="galeria">
    <div class="admin-card__head"><h2>Galería · <?php echo count(array_filter($photos, static fn(array $photo): bool => (bool) $photo['activo'])); ?> foto(s) activa(s)</h2></div>
    <div class="admin-card__body">
      <form class="admin-inline-form" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
        <input type="hidden" name="action" value="gallery_upload">
        <div class="admin-field admin-field--grow">
          <label for="photos">Agregar una o varias fotos</label>
          <input id="photos" type="file" name="photos[]" multiple required accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
        </div>
        <div class="admin-field">
          <label for="gallery-order">Orden inicial</label>
          <input id="gallery-order" type="number" name="orden" value="100">
        </div>
        <button class="admin-button admin-button--primary" type="submit">Subir fotos</button>
      </form>
    </div>
    <div class="admin-gallery-grid">
      <?php foreach ($photos as $photo): ?>
        <article class="admin-gallery-item">
          <img src="../<?php echo admin_h($photo['archivo']); ?>" alt="<?php echo admin_h($photo['alt']); ?>">
          <form method="post">
            <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
            <input type="hidden" name="action" value="gallery_update">
            <input type="hidden" name="id" value="<?php echo (int) $photo['id']; ?>">
            <div class="admin-field"><label>Título</label><input name="titulo" value="<?php echo admin_h($photo['titulo']); ?>"></div>
            <div class="admin-field"><label>Texto alternativo</label><input name="alt" value="<?php echo admin_h($photo['alt']); ?>"></div>
            <div class="admin-field"><label>Orden</label><input type="number" name="orden" value="<?php echo (int) $photo['orden']; ?>"></div>
            <label class="admin-check"><input type="checkbox" name="activo" value="1" <?php echo $photo['activo'] ? 'checked' : ''; ?>> Publicada</label>
            <button class="admin-button" type="submit">Guardar</button>
          </form>
          <form method="post" data-confirm="¿Eliminar esta foto de la galería? El archivo físico se conservará.">
            <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
            <input type="hidden" name="action" value="gallery_delete">
            <input type="hidden" name="id" value="<?php echo (int) $photo['id']; ?>">
            <button class="admin-button admin-button--danger" type="submit">Eliminar</button>
          </form>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

    </div>

    <aside class="admin-editor__preview" data-preview>
      <div class="admin-preview-bar">
        <label class="admin-preview-bar__field">
          <span>Pantalla</span>
          <select data-preview-page>
            <option value="index.php">Inicio</option>
            <option value="quienes_somos.php">Quiénes somos</option>
            <option value="cursos.php">Cursos</option>
            <option value="galeria.php">Galería</option>
            <option value="contacto.php">Contacto</option>
            <option value="inscripcion.php">Inscripción</option>
          </select>
        </label>
        <label class="admin-preview-bar__field admin-preview-bar__field--device">
          <span>Dispositivo</span>
          <select data-preview-device>
            <option value="desktop">Escritorio</option>
            <option value="tablet">Tablet · 768 px</option>
            <option value="mobile">Móvil · 375 px</option>
          </select>
        </label>
        <button class="admin-button" type="button" data-preview-refresh>Actualizar</button>
        <a class="admin-button" data-preview-open target="_blank" rel="noopener" href="../preview.php?page=index.php">Abrir</a>
      </div>
      <div class="admin-preview-frame">
        <iframe title="Vista previa del sitio" data-preview-iframe src="about:blank"></iframe>
      </div>
      <p class="admin-preview-hint">
        <span data-preview-status>La vista se actualiza mientras escribís.</span>
        Las imágenes nuevas se ven recién después de guardar.
      </p>
    </aside>
  </div>
<?php endif; ?>

<script src="assets/editor.js"></script>
<?php require __DIR__ . '/templates/footer.php'; ?>
