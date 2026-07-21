<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$cmsReady = admin_cms_ready($conn);
if (!$cmsReady) {
    admin_flash('warning', 'Primero ejecutá sql/cms_migration.sql.');
    admin_redirect('editor.php');
}

$id = max(0, (int) ($_GET['id'] ?? $_POST['id'] ?? 0));
$course = [
    'id' => 0,
    'slug' => '',
    'nombre' => '',
    'resumen' => '',
    'descripcion' => '',
    'inicio' => '',
    'duracion' => '',
    'modalidad' => 'Práctico presencial · Teórico online',
    'ubicacion' => 'Sede Náutica · Costanera Norte (CABA)',
    'precio' => 'Consultar',
    'imagen' => '',
    'imagen_alt' => '',
    'activo' => 1,
    'orden' => 0,
];

if ($id > 0) {
    $stmt = $conn->prepare('SELECT * FROM curso WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$existing) {
        http_response_code(404);
        exit('Curso no encontrado.');
    }
    $course = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    $action = (string) ($_POST['action'] ?? 'save');

    if ($action === 'delete') {
        if ($id < 1) {
            admin_flash('error', 'El curso no existe.');
            admin_redirect('editor.php#cursos');
        }
        $slugToDelete = (string) $course['slug'];
        $usage = $conn->prepare('SELECT COUNT(*) AS total FROM inscripcion WHERE curso = ?');
        $usage->bind_param('s', $slugToDelete);
        $usage->execute();
        $usedBy = (int) ($usage->get_result()->fetch_assoc()['total'] ?? 0);
        $usage->close();
        if ($usedBy > 0) {
            admin_flash('error', 'El curso tiene inscripciones asociadas. Ocultalo en lugar de eliminarlo para conservar el historial.');
            admin_redirect('curso_editar.php?id=' . $id);
        }
        $stmt = $conn->prepare('DELETE FROM curso WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        admin_audit($conn, 'curso_eliminado', 'curso', $id, 'El archivo de imagen se conservó');
        admin_flash('success', 'El curso se eliminó.');
        admin_redirect('editor.php#cursos');
    }

    $course = [
        'id' => $id,
        'slug' => strtolower(trim((string) ($_POST['slug'] ?? ''))),
        'nombre' => trim((string) ($_POST['nombre'] ?? '')),
        'resumen' => trim((string) ($_POST['resumen'] ?? '')),
        'descripcion' => trim((string) ($_POST['descripcion'] ?? '')),
        'inicio' => trim((string) ($_POST['inicio'] ?? '')),
        'duracion' => trim((string) ($_POST['duracion'] ?? '')),
        'modalidad' => trim((string) ($_POST['modalidad'] ?? '')),
        'ubicacion' => trim((string) ($_POST['ubicacion'] ?? '')),
        'precio' => trim((string) ($_POST['precio'] ?? '')),
        'imagen' => trim((string) ($_POST['imagen_actual'] ?? '')),
        'imagen_alt' => trim((string) ($_POST['imagen_alt'] ?? '')),
        'activo' => isset($_POST['activo']) ? 1 : 0,
        'orden' => (int) ($_POST['orden'] ?? 0),
    ];

    $error = '';
    if ($course['nombre'] === '' || $course['slug'] === '') {
        $error = 'Nombre y slug son obligatorios.';
    } elseif (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $course['slug'])) {
        $error = 'El slug solo puede contener minúsculas, números y guiones simples.';
    }

    if ($error === '' && isset($_FILES['imagen'])
        && ($_FILES['imagen']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        try {
            $course['imagen'] = admin_store_image($_FILES['imagen'], 'site');
        } catch (RuntimeException $exception) {
            $error = $exception->getMessage();
        }
    }
    if ($error === '' && $course['imagen'] === '') {
        $error = 'Ingresá una ruta o subí una imagen para el curso.';
    }

    if ($error === '') {
        try {
            if ($id > 0) {
                $stmt = $conn->prepare(
                    'UPDATE curso SET slug = ?, nombre = ?, resumen = ?, descripcion = ?, inicio = ?,
                     duracion = ?, modalidad = ?, ubicacion = ?, precio = ?, imagen = ?, imagen_alt = ?,
                     activo = ?, orden = ? WHERE id = ?'
                );
                $stmt->bind_param(
                    'sssssssssssiii',
                    $course['slug'],
                    $course['nombre'],
                    $course['resumen'],
                    $course['descripcion'],
                    $course['inicio'],
                    $course['duracion'],
                    $course['modalidad'],
                    $course['ubicacion'],
                    $course['precio'],
                    $course['imagen'],
                    $course['imagen_alt'],
                    $course['activo'],
                    $course['orden'],
                    $id
                );
                $stmt->execute();
                $stmt->close();
                admin_audit($conn, 'curso_actualizado', 'curso', $id, $course['slug']);
                admin_flash('success', 'El curso se actualizó.');
            } else {
                $stmt = $conn->prepare(
                    'INSERT INTO curso
                     (slug, nombre, resumen, descripcion, inicio, duracion, modalidad, ubicacion,
                      precio, imagen, imagen_alt, activo, orden)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->bind_param(
                    'sssssssssssii',
                    $course['slug'],
                    $course['nombre'],
                    $course['resumen'],
                    $course['descripcion'],
                    $course['inicio'],
                    $course['duracion'],
                    $course['modalidad'],
                    $course['ubicacion'],
                    $course['precio'],
                    $course['imagen'],
                    $course['imagen_alt'],
                    $course['activo'],
                    $course['orden']
                );
                $stmt->execute();
                $id = $conn->insert_id;
                $stmt->close();
                admin_audit($conn, 'curso_creado', 'curso', $id, $course['slug']);
                admin_flash('success', 'El curso se creó.');
            }
            admin_redirect('editor.php#cursos');
        } catch (mysqli_sql_exception $exception) {
            $error = $exception->getCode() === 1062
                ? 'Ya existe un curso con ese slug.'
                : 'No se pudo guardar el curso.';
        }
    }
}

$pageTitle = $id > 0 ? 'Editar curso' : 'Crear curso';
$activePage = 'editor';
require __DIR__ . '/templates/header.php';
?>
<div class="admin-page-head">
  <div>
    <h1><?php echo admin_h($pageTitle); ?></h1>
    <p>Los cambios se reflejan automáticamente en el inicio, cursos e inscripción.</p>
  </div>
  <a class="admin-button" href="editor.php#cursos">Volver al editor</a>
</div>

<?php if (!empty($error)): ?>
  <div class="admin-alert admin-alert--error"><?php echo admin_h($error); ?></div>
<?php endif; ?>

<section class="admin-card">
  <div class="admin-card__body">
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
      <input type="hidden" name="imagen_actual" value="<?php echo admin_h($course['imagen']); ?>">
      <div class="admin-form-grid">
        <div class="admin-field">
          <label for="nombre">Nombre *</label>
          <input id="nombre" name="nombre" maxlength="120" required value="<?php echo admin_h($course['nombre']); ?>">
        </div>
        <div class="admin-field">
          <label for="slug">Slug *</label>
          <input id="slug" name="slug" maxlength="80" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" value="<?php echo admin_h($course['slug']); ?>" placeholder="navegacion-costera">
        </div>
        <div class="admin-field admin-field--wide">
          <label for="resumen">Resumen</label>
          <textarea id="resumen" name="resumen"><?php echo admin_h($course['resumen']); ?></textarea>
        </div>
        <div class="admin-field admin-field--wide">
          <label for="descripcion">Descripción completa</label>
          <textarea id="descripcion" name="descripcion"><?php echo admin_h($course['descripcion']); ?></textarea>
        </div>
        <?php foreach ([
            'inicio' => 'Inicio',
            'duracion' => 'Duración',
            'modalidad' => 'Modalidad',
            'ubicacion' => 'Ubicación',
            'precio' => 'Precio / arancel',
        ] as $field => $label): ?>
          <div class="admin-field">
            <label for="<?php echo admin_h($field); ?>"><?php echo admin_h($label); ?></label>
            <input id="<?php echo admin_h($field); ?>" name="<?php echo admin_h($field); ?>" maxlength="180" value="<?php echo admin_h($course[$field]); ?>">
          </div>
        <?php endforeach; ?>
        <div class="admin-field">
          <label for="imagen">Imagen JPG, PNG o WEBP (máx. 8 MB)</label>
          <input id="imagen" type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
          <?php if ($course['imagen'] !== ''): ?>
            <img class="admin-thumb admin-thumb--large" src="../<?php echo admin_h($course['imagen']); ?>" alt="Imagen actual">
          <?php endif; ?>
        </div>
        <div class="admin-field">
          <label for="imagen_alt">Texto alternativo de imagen</label>
          <input id="imagen_alt" name="imagen_alt" maxlength="180" value="<?php echo admin_h($course['imagen_alt']); ?>">
        </div>
        <div class="admin-field">
          <label for="orden">Orden</label>
          <input id="orden" type="number" name="orden" value="<?php echo (int) $course['orden']; ?>">
        </div>
        <label class="admin-check">
          <input type="checkbox" name="activo" value="1" <?php echo $course['activo'] ? 'checked' : ''; ?>>
          Curso publicado
        </label>
      </div>
      <button class="admin-button admin-button--primary" type="submit">Guardar curso</button>
    </form>
  </div>
</section>

<?php if ($id > 0): ?>
  <section class="admin-card admin-danger-zone">
    <div class="admin-card__head"><h2>Eliminar curso</h2></div>
    <div class="admin-card__body">
      <p>Se elimina el registro, pero se conserva el archivo de imagen por si está compartido.</p>
      <form method="post" data-confirm="¿Eliminar definitivamente este curso?">
        <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
        <button class="admin-button admin-button--danger" type="submit">Eliminar curso</button>
      </form>
    </div>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/templates/footer.php'; ?>
