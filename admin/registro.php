<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$type = (string) ($_GET['tipo'] ?? $_POST['tipo'] ?? '');
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if (!in_array($type, ['contacto', 'inscripcion'], true) || $id < 1) {
    http_response_code(404);
    exit('Registro no encontrado.');
}

$table = $type === 'contacto' ? 'contacto' : 'inscripcion';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    $action = (string) ($_POST['accion'] ?? 'actualizar');

    if ($action === 'actualizar') {
        $status = (string) ($_POST['estado'] ?? '');
        $notes = trim((string) ($_POST['notas_admin'] ?? ''));

        if (!array_key_exists($status, admin_statuses($type))) {
            admin_flash('error', 'El estado seleccionado no es válido.');
        } else {
            $stmt = $conn->prepare("UPDATE `$table` SET estado = ?, notas_admin = ? WHERE id = ?");
            $stmt->bind_param('ssi', $status, $notes, $id);
            $stmt->execute();
            $stmt->close();
            admin_audit($conn, 'registro_actualizado', $type, $id, 'Estado: ' . $status);
            admin_flash('success', 'Los cambios se guardaron correctamente.');
        }
    } elseif ($action === 'archivar') {
        $archived = (int) ($_POST['archivado'] ?? 1) === 1 ? 1 : 0;
        $stmt = $conn->prepare("UPDATE `$table` SET archivado = ? WHERE id = ?");
        $stmt->bind_param('ii', $archived, $id);
        $stmt->execute();
        $stmt->close();
        admin_audit($conn, $archived ? 'registro_archivado' : 'registro_restaurado', $type, $id);
        admin_flash('success', $archived ? 'Registro archivado.' : 'Registro restaurado.');
    } elseif ($action === 'eliminar') {
        admin_audit($conn, 'registro_eliminado', $type, $id);
        $stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
        admin_flash('success', 'Registro eliminado definitivamente.');
        admin_redirect('index.php?tipo=' . urlencode($type));
    }

    admin_redirect('registro.php?tipo=' . urlencode($type) . '&id=' . $id);
}

$stmt = $conn->prepare("SELECT * FROM `$table` WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$record = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$record) {
    http_response_code(404);
    exit('Registro no encontrado.');
}

$pageTitle = $type === 'contacto' ? 'Detalle de contacto' : 'Detalle de inscripción';
$activePage = $type === 'contacto' ? 'contactos' : 'inscripciones';
$fullName = $record['nombre'] . ($type === 'inscripcion' ? ' ' . $record['apellido'] : '');
$phoneLink = preg_replace('/\D+/', '', (string) $record['celular']);
$backUrl = 'index.php?tipo=' . urlencode($type) . ((int) $record['archivado'] === 1 ? '&archivados=1' : '');

require __DIR__ . '/templates/header.php';
?>
<div class="admin-page-head">
  <div>
    <h1><?php echo admin_h($fullName); ?></h1>
    <p><?php echo $type === 'contacto' ? 'Consulta de contacto' : 'Solicitud de inscripción'; ?> #<?php echo $id; ?></p>
  </div>
  <div class="admin-actions">
    <a class="admin-button" href="<?php echo admin_h($backUrl); ?>">← Volver</a>
    <a class="admin-button" href="mailto:<?php echo admin_h($record['email']); ?>">Enviar email</a>
    <?php if ($phoneLink !== ''): ?>
      <a class="admin-button admin-button--primary" href="https://wa.me/<?php echo admin_h($phoneLink); ?>" target="_blank" rel="noopener">WhatsApp</a>
    <?php endif; ?>
  </div>
</div>

<div class="admin-detail-grid">
  <section>
    <article class="admin-card">
      <div class="admin-card__head"><h2>Información recibida</h2></div>
      <div class="admin-card__body">
        <dl class="admin-data-grid">
          <div class="admin-data">
            <dt>Nombre</dt>
            <dd><?php echo admin_h($fullName); ?></dd>
          </div>
          <div class="admin-data">
            <dt>Fecha</dt>
            <dd><?php echo admin_h(admin_format_date($record['created_at'])); ?></dd>
          </div>
          <div class="admin-data">
            <dt>Email</dt>
            <dd><a href="mailto:<?php echo admin_h($record['email']); ?>"><?php echo admin_h($record['email']); ?></a></dd>
          </div>
          <div class="admin-data">
            <dt>Celular</dt>
            <dd><a href="tel:<?php echo admin_h($phoneLink); ?>"><?php echo admin_h($record['celular']); ?></a></dd>
          </div>

          <?php if ($type === 'contacto'): ?>
            <div class="admin-data">
              <dt>Método preferido</dt>
              <dd><?php echo admin_h($record['metodo']); ?></dd>
            </div>
            <div class="admin-data admin-data--wide">
              <dt>Consulta</dt>
              <dd><?php echo nl2br(admin_h($record['consulta'])); ?></dd>
            </div>
          <?php else: ?>
            <div class="admin-data">
              <dt>Curso</dt>
              <dd><?php echo admin_h(ucfirst($record['curso'])); ?></dd>
            </div>
            <div class="admin-data">
              <dt>Experiencia</dt>
              <dd><?php echo admin_h(ucfirst(str_replace('_', ' ', $record['experiencia']))); ?></dd>
            </div>
            <div class="admin-data admin-data--wide">
              <dt>Comentarios / disponibilidad</dt>
              <dd><?php echo $record['mensaje'] !== '' ? nl2br(admin_h($record['mensaje'])) : 'Sin comentarios.'; ?></dd>
            </div>
          <?php endif; ?>
        </dl>
      </div>
    </article>
  </section>

  <aside>
    <article class="admin-card">
      <div class="admin-card__head"><h2>Seguimiento</h2></div>
      <div class="admin-card__body">
        <form method="post">
          <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
          <input type="hidden" name="tipo" value="<?php echo admin_h($type); ?>">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="accion" value="actualizar">
          <div class="admin-field">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
              <?php foreach (admin_statuses($type) as $value => $label): ?>
                <option value="<?php echo admin_h($value); ?>" <?php echo $record['estado'] === $value ? 'selected' : ''; ?>>
                  <?php echo admin_h($label); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="admin-field">
            <label for="notas_admin">Notas internas (el usuario no las ve)</label>
            <textarea id="notas_admin" name="notas_admin" maxlength="10000"><?php echo admin_h($record['notas_admin']); ?></textarea>
          </div>
          <button class="admin-button admin-button--primary" type="submit">Guardar seguimiento</button>
        </form>
      </div>
    </article>

    <article class="admin-card admin-danger-zone">
      <div class="admin-card__head"><h2>Administrar registro</h2></div>
      <div class="admin-card__body">
        <div class="admin-inline-form">
          <form method="post">
            <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
            <input type="hidden" name="tipo" value="<?php echo admin_h($type); ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="accion" value="archivar">
            <input type="hidden" name="archivado" value="<?php echo (int) $record['archivado'] === 1 ? '0' : '1'; ?>">
            <button class="admin-button" type="submit">
              <?php echo (int) $record['archivado'] === 1 ? 'Restaurar' : 'Archivar'; ?>
            </button>
          </form>
          <form method="post" data-confirm="Esta acción elimina el registro definitivamente. ¿Continuar?">
            <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
            <input type="hidden" name="tipo" value="<?php echo admin_h($type); ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="accion" value="eliminar">
            <button class="admin-button admin-button--danger" type="submit">Eliminar</button>
          </form>
        </div>
      </div>
    </article>
  </aside>
</div>

<?php require __DIR__ . '/templates/footer.php'; ?>
