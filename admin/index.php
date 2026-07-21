<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$requestedType = (string) ($_GET['tipo'] ?? '');
$type = in_array($requestedType, ['contacto', 'inscripcion'], true) ? $requestedType : 'contacto';
$isDashboard = $requestedType === '';
$pageTitle = $isDashboard ? 'Resumen' : ($type === 'contacto' ? 'Contactos' : 'Inscripciones');
$activePage = $isDashboard ? 'dashboard' : ($type === 'contacto' ? 'contactos' : 'inscripciones');

$status = trim((string) ($_GET['estado'] ?? ''));
$search = trim((string) ($_GET['buscar'] ?? ''));
$course = trim((string) ($_GET['curso'] ?? ''));
$archived = isset($_GET['archivados']) && $_GET['archivados'] === '1' ? 1 : 0;
$page = max(1, (int) ($_GET['pagina'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

if ($status !== '' && !array_key_exists($status, admin_statuses($type))) {
    $status = '';
}
if (!in_array($course, ['', 'lanchas', 'veleros', 'yates'], true)) {
    $course = '';
}

$metrics = [
    'contactos_nuevos' => 0,
    'contactos_pendientes' => 0,
    'inscripciones_nuevas' => 0,
    'inscripciones_confirmadas' => 0,
];

$metricSql = "
    SELECT
      (SELECT COUNT(*) FROM contacto WHERE archivado = 0 AND estado = 'nuevo') AS contactos_nuevos,
      (SELECT COUNT(*) FROM contacto WHERE archivado = 0 AND estado IN ('nuevo', 'en_proceso')) AS contactos_pendientes,
      (SELECT COUNT(*) FROM inscripcion WHERE archivado = 0 AND estado = 'nueva') AS inscripciones_nuevas,
      (SELECT COUNT(*) FROM inscripcion WHERE archivado = 0 AND estado = 'confirmada') AS inscripciones_confirmadas
";
$metricResult = $conn->query($metricSql);
if ($metricResult) {
    $metrics = array_merge($metrics, $metricResult->fetch_assoc());
}

$auditRows = [];
if ($isDashboard) {
    $auditResult = $conn->query(
        'SELECT a.accion, a.entidad, a.entidad_id, a.detalle, a.created_at, u.usuario
         FROM admin_auditoria a
         LEFT JOIN admin_usuario u ON u.id = a.admin_id
         ORDER BY a.created_at DESC, a.id DESC
         LIMIT 10'
    );
    if ($auditResult) {
        $auditRows = $auditResult->fetch_all(MYSQLI_ASSOC);
    }
}

$like = '%' . $search . '%';

if ($type === 'contacto') {
    $where = "archivado = ?
      AND (? = '' OR estado = ?)
      AND (? = '' OR nombre LIKE ? OR email LIKE ? OR celular LIKE ? OR consulta LIKE ?)";
    $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM contacto WHERE $where");
    $countStmt->bind_param(
        'isssssss',
        $archived,
        $status,
        $status,
        $search,
        $like,
        $like,
        $like,
        $like
    );
    $countStmt->execute();
    $total = (int) ($countStmt->get_result()->fetch_assoc()['total'] ?? 0);
    $countStmt->close();

    $stmt = $conn->prepare(
        "SELECT id, nombre, celular, email, metodo, estado, archivado, created_at
         FROM contacto
         WHERE $where
         ORDER BY created_at DESC, id DESC
         LIMIT ? OFFSET ?"
    );
    $stmt->bind_param(
        'isssssssii',
        $archived,
        $status,
        $status,
        $search,
        $like,
        $like,
        $like,
        $like,
        $perPage,
        $offset
    );
} else {
    $where = "archivado = ?
      AND (? = '' OR estado = ?)
      AND (? = '' OR curso = ?)
      AND (? = '' OR nombre LIKE ? OR apellido LIKE ? OR email LIKE ? OR celular LIKE ?)";
    $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM inscripcion WHERE $where");
    $countStmt->bind_param(
        'isssssssss',
        $archived,
        $status,
        $status,
        $course,
        $course,
        $search,
        $like,
        $like,
        $like,
        $like
    );
    $countStmt->execute();
    $total = (int) ($countStmt->get_result()->fetch_assoc()['total'] ?? 0);
    $countStmt->close();

    $stmt = $conn->prepare(
        "SELECT id, nombre, apellido, celular, email, curso, experiencia, estado, archivado, created_at
         FROM inscripcion
         WHERE $where
         ORDER BY created_at DESC, id DESC
         LIMIT ? OFFSET ?"
    );
    $stmt->bind_param(
        'isssssssssii',
        $archived,
        $status,
        $status,
        $course,
        $course,
        $search,
        $like,
        $like,
        $like,
        $like,
        $perPage,
        $offset
    );
}

$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$pages = max(1, (int) ceil($total / $perPage));

$queryForExport = http_build_query([
    'tipo' => $type,
    'estado' => $status,
    'buscar' => $search,
    'curso' => $course,
    'archivados' => $archived,
    'csrf' => admin_csrf_token(),
]);

require __DIR__ . '/templates/header.php';
?>
<div class="admin-page-head">
  <div>
    <h1><?php echo $isDashboard ? 'Resumen' : admin_h($pageTitle); ?></h1>
    <p>Hola, <?php echo admin_h(admin_user()['usuario']); ?>. Acá tenés el estado comercial de Sirius.</p>
  </div>
  <div class="admin-actions">
    <a class="admin-button" href="export.php?<?php echo admin_h($queryForExport); ?>">Exportar CSV</a>
  </div>
</div>

<section class="admin-stats">
  <article class="admin-stat">
    <small>Contactos nuevos</small>
    <strong><?php echo (int) $metrics['contactos_nuevos']; ?></strong>
    <a href="index.php?tipo=contacto&estado=nuevo">Ver contactos</a>
  </article>
  <article class="admin-stat">
    <small>Contactos pendientes</small>
    <strong><?php echo (int) $metrics['contactos_pendientes']; ?></strong>
    <a href="index.php?tipo=contacto">Gestionar</a>
  </article>
  <article class="admin-stat">
    <small>Inscripciones nuevas</small>
    <strong><?php echo (int) $metrics['inscripciones_nuevas']; ?></strong>
    <a href="index.php?tipo=inscripcion&estado=nueva">Ver inscripciones</a>
  </article>
  <article class="admin-stat">
    <small>Inscripciones confirmadas</small>
    <strong><?php echo (int) $metrics['inscripciones_confirmadas']; ?></strong>
    <a href="index.php?tipo=inscripcion&estado=confirmada">Ver confirmadas</a>
  </article>
</section>

<section class="admin-card">
  <div class="admin-card__head">
    <h2><?php echo $type === 'contacto' ? 'Contactos' : 'Inscripciones'; ?> · <?php echo $total; ?> resultado(s)</h2>
  </div>
  <div class="admin-card__body">
    <form class="admin-filters" method="get">
      <input type="hidden" name="tipo" value="<?php echo admin_h($type); ?>">
      <div class="admin-field">
        <label for="buscar">Buscar</label>
        <input id="buscar" name="buscar" value="<?php echo admin_h($search); ?>" placeholder="Nombre, email, celular o mensaje">
      </div>
      <div class="admin-field">
        <label for="estado">Estado</label>
        <select id="estado" name="estado">
          <option value="">Todos</option>
          <?php foreach (admin_statuses($type) as $value => $label): ?>
            <option value="<?php echo admin_h($value); ?>" <?php echo $status === $value ? 'selected' : ''; ?>>
              <?php echo admin_h($label); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php if ($type === 'inscripcion'): ?>
        <div class="admin-field">
          <label for="curso">Curso</label>
          <select id="curso" name="curso">
            <option value="">Todos</option>
            <?php foreach (['lanchas' => 'Lanchas', 'veleros' => 'Veleros', 'yates' => 'Yates'] as $value => $label): ?>
              <option value="<?php echo $value; ?>" <?php echo $course === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
      <label class="admin-check">
        <input type="checkbox" name="archivados" value="1" <?php echo $archived ? 'checked' : ''; ?>>
        Ver archivados
      </label>
      <button class="admin-button admin-button--primary" type="submit">Filtrar</button>
    </form>
  </div>

  <?php if (!$rows): ?>
    <div class="admin-empty">No hay registros que coincidan con los filtros.</div>
  <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Persona</th>
            <?php if ($type === 'inscripcion'): ?><th>Curso</th><?php endif; ?>
            <th>Contacto</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $row): ?>
            <tr>
              <td>
                <div class="admin-table__primary">
                  <?php echo admin_h($row['nombre'] . ($type === 'inscripcion' ? ' ' . $row['apellido'] : '')); ?>
                </div>
                <div class="admin-table__secondary"><?php echo admin_h($row['email']); ?></div>
              </td>
              <?php if ($type === 'inscripcion'): ?>
                <td><?php echo admin_h(ucfirst($row['curso'])); ?></td>
              <?php endif; ?>
              <td>
                <?php echo admin_h($row['celular']); ?>
                <?php if ($type === 'contacto'): ?>
                  <div class="admin-table__secondary">Prefiere: <?php echo admin_h($row['metodo']); ?></div>
                <?php endif; ?>
              </td>
              <td><span class="admin-badge admin-badge--<?php echo admin_h($row['estado']); ?>"><?php echo admin_h(admin_status_label($type, $row['estado'])); ?></span></td>
              <td><?php echo admin_h(admin_format_date($row['created_at'])); ?></td>
              <td><a class="admin-button" href="registro.php?tipo=<?php echo admin_h($type); ?>&id=<?php echo (int) $row['id']; ?>">Abrir</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>

  <?php if ($pages > 1): ?>
    <nav class="admin-pagination" aria-label="Paginación">
      <?php for ($i = 1; $i <= $pages; $i++): ?>
        <?php
        $pageQuery = http_build_query([
            'tipo' => $type,
            'estado' => $status,
            'buscar' => $search,
            'curso' => $course,
            'archivados' => $archived,
            'pagina' => $i,
        ]);
        ?>
        <?php if ($i === $page): ?>
          <span><?php echo $i; ?></span>
        <?php else: ?>
          <a href="?<?php echo admin_h($pageQuery); ?>"><?php echo $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </nav>
  <?php endif; ?>
</section>

<?php if ($isDashboard): ?>
  <section class="admin-card">
    <div class="admin-card__head"><h2>Actividad reciente</h2></div>
    <?php if (!$auditRows): ?>
      <div class="admin-empty">Todavía no hay actividad administrativa registrada.</div>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr><th>Acción</th><th>Usuario</th><th>Registro</th><th>Detalle</th><th>Fecha</th></tr>
          </thead>
          <tbody>
            <?php foreach ($auditRows as $audit): ?>
              <tr>
                <td><?php echo admin_h(ucfirst(str_replace('_', ' ', $audit['accion']))); ?></td>
                <td><?php echo admin_h($audit['usuario'] ?: 'Sistema'); ?></td>
                <td>
                  <?php if ($audit['entidad'] && $audit['entidad_id']): ?>
                    <?php echo admin_h($audit['entidad']); ?> #<?php echo (int) $audit['entidad_id']; ?>
                  <?php else: ?>—<?php endif; ?>
                </td>
                <td><?php echo admin_h($audit['detalle'] ?: '—'); ?></td>
                <td><?php echo admin_h(admin_format_date($audit['created_at'])); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/templates/footer.php'; ?>
