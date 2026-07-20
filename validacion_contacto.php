<?php
if (isset($_POST['enviar'])) {
    $nombre = trim(strip_tags((string) ($_POST['nombre'] ?? '')));
    $celular = trim(strip_tags((string) ($_POST['celular'] ?? '')));
    $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL);
    $consulta = trim(strip_tags((string) ($_POST['consulta'] ?? '')));
    $metodo = trim(strip_tags((string) ($_POST['metodo'] ?? 'celular')));

    $metodos_ok = ['celular', 'email', 'ambos metodos'];
    if (!in_array($metodo, $metodos_ok, true)) {
        $metodo = 'celular';
    }

    if ($nombre === '' || $celular === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: contacto.php?error=1');
        exit;
    }

    try {
        require_once 'inc/funciones/bd.php';
        $stmt = $conn->prepare('INSERT INTO `contacto` (nombre, celular, email, consulta, metodo) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $nombre, $celular, $email, $consulta, $metodo);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: validacion_contacto.php?exitoso=1');
        exit;
    } catch (Exception $e) {
        error_log('contacto insert: ' . $e->getMessage());
        header('Location: contacto.php?error=1');
        exit;
    }
}

include_once 'inc/funciones/funciones.php';
include_once 'inc/templates/header.php';

$contacto = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
$nombre_ok = $contacto ? htmlspecialchars($contacto['nombre'], ENT_QUOTES, 'UTF-8') : 'navegantes';
$metodo_ok = $contacto ? htmlspecialchars($contacto['metodo'], ENT_QUOTES, 'UTF-8') : 'tu medio preferido';
?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="exitoso exitoso-card">
    <p class="nombre"><span>Sirius</span></p>
    <h2 class="conferencia">Gracias <span><?php echo $nombre_ok; ?></span> por tu consulta</h2>
    <hr>
    <?php if (isset($_GET['exitoso']) && $_GET['exitoso'] === '1'): ?>
      <h3>Tu mensaje se envió con éxito. En breve te respondemos por <?php echo $metodo_ok; ?>.</h3>
    <?php else: ?>
      <h3>Si acabás de enviar el formulario, ya estamos revisando tu consulta.</h3>
    <?php endif; ?>
    <div class="exitoso-actions">
      <a href="contacto.php" class="nuestra-historia">Nueva consulta</a>
      <a href="index.php" class="nuestra-historia">Volver al inicio</a>
    </div>
  </div>
</section>

<?php include_once 'inc/templates/footer.php'; ?>
