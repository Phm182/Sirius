<?php
require_once __DIR__ . '/bootstrap.php';

$pageTitle = 'Crear administrador';
$error = '';
$schemaReady = admin_table_exists($conn, 'admin_usuario');
$hasAdmin = false;
$remoteIp = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
$isLocal = in_array($remoteIp, ['127.0.0.1', '::1'], true);
$setupAllowed = $isLocal || ADMIN_SETUP_KEY !== '';

if ($schemaReady) {
    $result = $conn->query('SELECT COUNT(*) AS total FROM admin_usuario');
    $hasAdmin = (int) ($result->fetch_assoc()['total'] ?? 0) > 0;
}

if ($hasAdmin) {
    admin_redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $schemaReady && $setupAllowed) {
    admin_verify_csrf();

    $username = trim((string) ($_POST['usuario'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');
    $providedSetupKey = (string) ($_POST['setup_key'] ?? '');

    if (!$isLocal && !hash_equals(ADMIN_SETUP_KEY, $providedSetupKey)) {
        $error = 'La clave de instalación no es correcta.';
    } elseif (!preg_match('/^[a-zA-Z0-9._-]{4,40}$/', $username)) {
        $error = 'El usuario debe tener entre 4 y 40 caracteres y usar solo letras, números, punto, guion o guion bajo.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Ingresá un email válido.';
    } elseif (strlen($password) < 12) {
        $error = 'La contraseña debe tener al menos 12 caracteres.';
    } elseif ($password !== $confirmation) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare(
            'INSERT INTO admin_usuario (usuario, email, password_hash) VALUES (?, ?, ?)'
        );
        $stmt->bind_param('sss', $username, $email, $hash);

        try {
            $stmt->execute();
            admin_audit($conn, 'admin_inicial_creado', 'admin_usuario', (int) $stmt->insert_id, $username);
            $stmt->close();
            admin_flash('success', 'Administrador creado. Ya podés iniciar sesión.');
            admin_redirect('login.php');
        } catch (mysqli_sql_exception $exception) {
            $error = 'Ese usuario o email ya existe.';
        }
    }
}

require __DIR__ . '/templates/header.php';
?>
<section class="admin-auth">
  <div class="admin-card">
    <div class="admin-card__body">
      <h1>Configurar administrador</h1>
      <p>Este formulario funciona una sola vez. Luego queda bloqueado automáticamente.</p>

      <?php if (!$schemaReady): ?>
        <div class="admin-alert admin-alert--warning">
          Primero importá <strong>sql/admin_migration.sql</strong> en la base de datos.
        </div>
      <?php elseif (!$setupAllowed): ?>
        <div class="admin-alert admin-alert--warning">
          Por seguridad, antes de crear el usuario definí
          <strong>$admin_setup_key = 'una-clave-larga-y-unica';</strong>
          en <strong>inc/funciones/bd.php</strong>, o la variable de entorno
          <strong>SIRIUS_ADMIN_SETUP_KEY</strong>.
        </div>
      <?php else: ?>
        <?php if ($error): ?>
          <div class="admin-alert admin-alert--error"><?php echo admin_h($error); ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
          <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
          <?php if (!$isLocal): ?>
            <div class="admin-field">
              <label for="setup_key">Clave de instalación</label>
              <input id="setup_key" type="password" name="setup_key" required autocomplete="off">
            </div>
          <?php endif; ?>
          <div class="admin-field">
            <label for="usuario">Usuario</label>
            <input id="usuario" name="usuario" required minlength="4" maxlength="40" autocomplete="username">
          </div>
          <div class="admin-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required maxlength="180" autocomplete="email">
          </div>
          <div class="admin-field">
            <label for="password">Contraseña (mínimo 12 caracteres)</label>
            <input id="password" type="password" name="password" required minlength="12" autocomplete="new-password">
          </div>
          <div class="admin-field">
            <label for="password_confirmation">Repetir contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required minlength="12" autocomplete="new-password">
          </div>
          <button class="admin-button admin-button--primary" type="submit">Crear administrador</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require __DIR__ . '/templates/footer.php'; ?>
