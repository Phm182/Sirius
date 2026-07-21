<?php
require_once __DIR__ . '/bootstrap.php';

if (admin_is_logged_in()) {
    admin_redirect('index.php');
}

if (!admin_table_exists($conn, 'admin_usuario')) {
    admin_redirect('setup.php');
}

$count = $conn->query('SELECT COUNT(*) AS total FROM admin_usuario');
if ((int) ($count->fetch_assoc()['total'] ?? 0) === 0) {
    admin_redirect('setup.php');
}

$pageTitle = 'Ingresar';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $identifier = trim((string) ($_POST['identificador'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($identifier === '' || $password === '') {
        $error = 'Completá usuario/email y contraseña.';
    } else {
        $stmt = $conn->prepare(
            'SELECT id, usuario, email, password_hash, activo, intentos_fallidos, bloqueado_hasta
             FROM admin_usuario
             WHERE usuario = ? OR email = ?
             LIMIT 1'
        );
        $stmt->bind_param('ss', $identifier, $identifier);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $locked = $admin && !empty($admin['bloqueado_hasta'])
            && strtotime((string) $admin['bloqueado_hasta']) > time();
        $valid = $admin && (int) $admin['activo'] === 1 && !$locked
            && password_verify($password, (string) $admin['password_hash']);

        if ($valid) {
            $adminId = (int) $admin['id'];
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $adminId;
            $_SESSION['admin_usuario'] = (string) $admin['usuario'];
            $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));

            if (password_needs_rehash((string) $admin['password_hash'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $rehash = $conn->prepare('UPDATE admin_usuario SET password_hash = ? WHERE id = ?');
                $rehash->bind_param('si', $newHash, $adminId);
                $rehash->execute();
                $rehash->close();
            }

            $update = $conn->prepare(
                'UPDATE admin_usuario
                 SET intentos_fallidos = 0, bloqueado_hasta = NULL, ultimo_acceso = NOW()
                 WHERE id = ?'
            );
            $update->bind_param('i', $adminId);
            $update->execute();
            $update->close();

            admin_audit($conn, 'login_exitoso');
            admin_redirect('index.php');
        }

        if ($admin && !$locked) {
            $adminId = (int) $admin['id'];
            $attempts = (int) $admin['intentos_fallidos'] + 1;
            $blockedUntil = $attempts >= 5 ? date('Y-m-d H:i:s', time() + 15 * 60) : null;
            $attempts = $attempts >= 5 ? 0 : $attempts;

            $update = $conn->prepare(
                'UPDATE admin_usuario
                 SET intentos_fallidos = ?, bloqueado_hasta = ?
                 WHERE id = ?'
            );
            $update->bind_param('isi', $attempts, $blockedUntil, $adminId);
            $update->execute();
            $update->close();
        }

        usleep(350000);
        $error = $locked
            ? 'Acceso bloqueado temporalmente. Intentá nuevamente en unos minutos.'
            : 'Usuario/email o contraseña incorrectos.';
    }
}

require __DIR__ . '/templates/header.php';
?>
<section class="admin-auth">
  <div class="admin-card">
    <div class="admin-card__body">
      <h1>Ingresar al panel</h1>
      <p>Administrá contactos e inscripciones de Sirius.</p>

      <?php if ($error): ?>
        <div class="admin-alert admin-alert--error"><?php echo admin_h($error); ?></div>
      <?php endif; ?>

      <form method="post">
        <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
        <div class="admin-field">
          <label for="identificador">Usuario o email</label>
          <input id="identificador" name="identificador" required autocomplete="username" autofocus>
        </div>
        <div class="admin-field">
          <label for="password">Contraseña</label>
          <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>
        <button class="admin-button admin-button--primary" type="submit">Ingresar</button>
      </form>
      <p class="admin-auth__help"><a href="../index.php">Volver al sitio</a></p>
    </div>
  </div>
</section>
<?php require __DIR__ . '/templates/footer.php'; ?>
