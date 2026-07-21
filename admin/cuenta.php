<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$adminId = admin_user()['id'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $currentPassword = (string) ($_POST['password_actual'] ?? '');
    $newPassword = (string) ($_POST['password_nueva'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    $stmt = $conn->prepare('SELECT password_hash FROM admin_usuario WHERE id = ? AND activo = 1 LIMIT 1');
    $stmt->bind_param('i', $adminId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row || !password_verify($currentPassword, (string) $row['password_hash'])) {
        $error = 'La contraseña actual no es correcta.';
    } elseif (strlen($newPassword) < 12) {
        $error = 'La contraseña nueva debe tener al menos 12 caracteres.';
    } elseif ($newPassword !== $confirmation) {
        $error = 'Las contraseñas nuevas no coinciden.';
    } elseif (hash_equals($currentPassword, $newPassword)) {
        $error = 'La contraseña nueva debe ser diferente a la actual.';
    } else {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $conn->prepare('UPDATE admin_usuario SET password_hash = ? WHERE id = ?');
        $update->bind_param('si', $hash, $adminId);
        $update->execute();
        $update->close();
        admin_audit($conn, 'password_actualizado', 'admin_usuario', $adminId);
        session_regenerate_id(true);
        admin_flash('success', 'La contraseña se actualizó correctamente.');
        admin_redirect('cuenta.php');
    }
}

$stmt = $conn->prepare('SELECT usuario, email, ultimo_acceso, created_at FROM admin_usuario WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $adminId);
$stmt->execute();
$account = $stmt->get_result()->fetch_assoc();
$stmt->close();

$pageTitle = 'Cuenta';
$activePage = 'cuenta';
require __DIR__ . '/templates/header.php';
?>
<div class="admin-page-head">
  <div>
    <h1>Mi cuenta</h1>
    <p>Datos de acceso y seguridad del panel.</p>
  </div>
</div>

<div class="admin-detail-grid">
  <article class="admin-card">
    <div class="admin-card__head"><h2>Datos del administrador</h2></div>
    <div class="admin-card__body">
      <dl class="admin-data-grid">
        <div class="admin-data"><dt>Usuario</dt><dd><?php echo admin_h($account['usuario'] ?? ''); ?></dd></div>
        <div class="admin-data"><dt>Email</dt><dd><?php echo admin_h($account['email'] ?? ''); ?></dd></div>
        <div class="admin-data"><dt>Último acceso</dt><dd><?php echo admin_h(admin_format_date($account['ultimo_acceso'] ?? null)); ?></dd></div>
        <div class="admin-data"><dt>Cuenta creada</dt><dd><?php echo admin_h(admin_format_date($account['created_at'] ?? null)); ?></dd></div>
      </dl>
    </div>
  </article>

  <article class="admin-card">
    <div class="admin-card__head"><h2>Cambiar contraseña</h2></div>
    <div class="admin-card__body">
      <?php if ($error): ?>
        <div class="admin-alert admin-alert--error"><?php echo admin_h($error); ?></div>
      <?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
        <div class="admin-field">
          <label for="password_actual">Contraseña actual</label>
          <input id="password_actual" type="password" name="password_actual" required autocomplete="current-password">
        </div>
        <div class="admin-field">
          <label for="password_nueva">Nueva contraseña (mínimo 12 caracteres)</label>
          <input id="password_nueva" type="password" name="password_nueva" required minlength="12" autocomplete="new-password">
        </div>
        <div class="admin-field">
          <label for="password_confirmation">Repetir nueva contraseña</label>
          <input id="password_confirmation" type="password" name="password_confirmation" required minlength="12" autocomplete="new-password">
        </div>
        <button class="admin-button admin-button--primary" type="submit">Actualizar contraseña</button>
      </form>
    </div>
  </article>
</div>

<?php require __DIR__ . '/templates/footer.php'; ?>
