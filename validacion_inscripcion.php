<?php
if (isset($_POST['enviar'])) {
    $nombre = trim(strip_tags((string) ($_POST['nombre'] ?? '')));
    $apellido = trim(strip_tags((string) ($_POST['apellido'] ?? '')));
    $celular = trim(strip_tags((string) ($_POST['celular'] ?? '')));
    $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_SANITIZE_EMAIL);
    $curso = trim(strip_tags((string) ($_POST['curso'] ?? '')));
    $experiencia = trim(strip_tags((string) ($_POST['experiencia'] ?? 'ninguna')));
    $mensaje = trim(strip_tags((string) ($_POST['mensaje'] ?? '')));

    $exp_ok = ['ninguna', 'basica', 'intermedia', 'avanzada'];

    require_once 'inc/funciones/bd.php';
    require_once 'inc/funciones/contenido.php';
    if (!curso_por_slug($curso, $conn)) {
        header('Location: inscripcion.php?error=1');
        exit;
    }
    if (!in_array($experiencia, $exp_ok, true)) {
        $experiencia = 'ninguna';
    }

    if ($nombre === '' || $apellido === '' || $celular === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: inscripcion.php?error=1');
        exit;
    }

    try {
        $stmt = $conn->prepare(
            'INSERT INTO `inscripcion` (nombre, apellido, celular, email, curso, experiencia, mensaje) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('sssssss', $nombre, $apellido, $celular, $email, $curso, $experiencia, $mensaje);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header('Location: validacion_inscripcion.php?exitoso=1');
        exit;
    } catch (Exception $e) {
        error_log('inscripcion insert: ' . $e->getMessage());
        header('Location: inscripcion.php?error=1');
        exit;
    }
}

$inscripto = null;
try {
    require_once 'inc/funciones/bd.php';
    $sql = 'SELECT id, nombre, apellido, curso FROM inscripcion ORDER BY id DESC LIMIT 1';
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $inscripto = $res->fetch_assoc();
    }
} catch (Exception $e) {
    error_log('inscripcion select: ' . $e->getMessage());
}

include_once 'inc/templates/header.php';

$nombre_ok = $inscripto
    ? htmlspecialchars($inscripto['nombre'] . ' ' . $inscripto['apellido'], ENT_QUOTES, 'UTF-8')
    : 'navegantes';
$curso_ok = $inscripto ? htmlspecialchars(ucfirst($inscripto['curso']), ENT_QUOTES, 'UTF-8') : 'tu curso';
?>

<header class="site-header is-scrolled" id="site-header">
  <div class="header">
    <?php include 'inc/templates/nav.php'; ?>
  </div>
</header>

<section class="page-offset page-surface">
  <div class="exitoso exitoso-card">
    <p class="nombre"><span>Sirius</span></p>
    <h2 class="conferencia">¡Listo, <span><?php echo $nombre_ok; ?></span>!</h2>
    <hr>
    <?php if (isset($_GET['exitoso']) && $_GET['exitoso'] === '1'): ?>
      <h3>Recibimos tu inscripción a <span><?php echo $curso_ok; ?></span>. El equipo de Sirius te va a contactar para cerrar fechas y vacante.</h3>
    <?php else: ?>
      <h3>Si acabás de enviar el formulario, ya estamos revisando tu solicitud.</h3>
    <?php endif; ?>
    <div class="exitoso-actions">
      <a href="cursos.php" class="nuestra-historia">Ver cursos</a>
      <a href="index.php" class="nuestra-historia">Volver al inicio</a>
    </div>
  </div>
</section>

<?php include_once 'inc/templates/footer.php'; ?>
