<?php
declare(strict_types=1);

const ADMIN_ROOT = __DIR__;
const SITE_ROOT = __DIR__ . '/..';

if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_name('sirius_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
header("Content-Security-Policy: default-src 'self'; style-src 'self'; img-src 'self' data:; form-action 'self'; frame-ancestors 'none'; base-uri 'self'");

require_once SITE_ROOT . '/inc/funciones/bd.php';

if (!defined('ADMIN_SETUP_KEY')) {
    $setupKey = getenv('SIRIUS_ADMIN_SETUP_KEY');
    if ($setupKey === false || $setupKey === '') {
        $setupKey = isset($admin_setup_key) ? (string) $admin_setup_key : '';
    }
    define('ADMIN_SETUP_KEY', $setupKey);
    unset($setupKey);
}

function admin_h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function admin_redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function admin_csrf_token(): string
{
    if (empty($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['admin_csrf'];
}

function admin_verify_csrf(): void
{
    $token = (string) ($_POST['csrf'] ?? '');
    if ($token === '' || !hash_equals(admin_csrf_token(), $token)) {
        http_response_code(403);
        exit('La solicitud venció o no es válida. Volvé atrás e intentá nuevamente.');
    }
}

function admin_is_logged_in(): bool
{
    return isset($_SESSION['admin_id']) && (int) $_SESSION['admin_id'] > 0;
}

function admin_require_login(): void
{
    if (!admin_is_logged_in()) {
        $_SESSION['admin_after_login'] = basename((string) ($_SERVER['REQUEST_URI'] ?? 'index.php'));
        admin_redirect('login.php');
    }
}

function admin_user(): array
{
    return [
        'id' => (int) ($_SESSION['admin_id'] ?? 0),
        'usuario' => (string) ($_SESSION['admin_usuario'] ?? ''),
    ];
}

function admin_flash(string $type, string $message): void
{
    $_SESSION['admin_flash'] = ['type' => $type, 'message' => $message];
}

function admin_take_flash(): ?array
{
    $flash = $_SESSION['admin_flash'] ?? null;
    unset($_SESSION['admin_flash']);
    return is_array($flash) ? $flash : null;
}

function admin_audit(
    mysqli $conn,
    string $action,
    ?string $entity = null,
    ?int $entityId = null,
    ?string $detail = null
): void {
    $adminId = admin_is_logged_in() ? (int) $_SESSION['admin_id'] : null;
    $ip = substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
    $detail = $detail !== null ? substr($detail, 0, 500) : null;

    $stmt = $conn->prepare(
        'INSERT INTO admin_auditoria (admin_id, accion, entidad, entidad_id, detalle, ip)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    if (!$stmt) {
        return;
    }
    $stmt->bind_param('ississ', $adminId, $action, $entity, $entityId, $detail, $ip);
    $stmt->execute();
    $stmt->close();
}

function admin_table_exists(mysqli $conn, string $table): bool
{
    $stmt = $conn->prepare(
        'SELECT COUNT(*) AS total
         FROM information_schema.tables
         WHERE table_schema = DATABASE() AND table_name = ?'
    );
    $stmt->bind_param('s', $table);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return (int) ($row['total'] ?? 0) > 0;
}

function admin_statuses(string $type): array
{
    if ($type === 'contacto') {
        return [
            'nuevo' => 'Nuevo',
            'en_proceso' => 'En proceso',
            'respondido' => 'Respondido',
            'cerrado' => 'Cerrado',
        ];
    }

    return [
        'nueva' => 'Nueva',
        'contactado' => 'Contactado',
        'confirmada' => 'Confirmada',
        'lista_espera' => 'Lista de espera',
        'cancelada' => 'Cancelada',
    ];
}

function admin_status_label(string $type, string $status): string
{
    return admin_statuses($type)[$status] ?? ucfirst(str_replace('_', ' ', $status));
}

function admin_format_date(?string $value): string
{
    if (!$value) {
        return '—';
    }
    $timestamp = strtotime($value);
    return $timestamp ? date('d/m/Y H:i', $timestamp) : $value;
}

function admin_cms_ready(mysqli $conn): bool
{
    return admin_table_exists($conn, 'sitio_contenido')
        && admin_table_exists($conn, 'curso')
        && admin_table_exists($conn, 'galeria_foto');
}

function admin_course_options(mysqli $conn): array
{
    $fallback = ['lanchas' => 'Lanchas', 'veleros' => 'Veleros', 'yates' => 'Yates'];
    if (!admin_table_exists($conn, 'curso')) {
        return $fallback;
    }
    try {
        $result = $conn->query('SELECT slug, nombre FROM curso ORDER BY orden ASC, nombre ASC');
        if (!$result) {
            return $fallback;
        }
        $options = [];
        while ($row = $result->fetch_assoc()) {
            $options[(string) $row['slug']] = (string) $row['nombre'];
        }
        return $options ?: $fallback;
    } catch (Throwable $exception) {
        return $fallback;
    }
}

/**
 * Guarda una imagen validada por contenido real y devuelve su ruta web.
 *
 * @throws RuntimeException
 */
function admin_store_image(array $file, string $folder): string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('No se pudo recibir la imagen.');
    }
    if ((int) ($file['size'] ?? 0) < 1 || (int) $file['size'] > 8 * 1024 * 1024) {
        throw new RuntimeException('La imagen debe pesar menos de 8 MB.');
    }

    $tmp = (string) ($file['tmp_name'] ?? '');
    $info = @getimagesize($tmp);
    $allowed = [
        IMAGETYPE_JPEG => ['image/jpeg', 'jpg'],
        IMAGETYPE_PNG => ['image/png', 'png'],
        IMAGETYPE_WEBP => ['image/webp', 'webp'],
    ];
    $imageType = (int) ($info[2] ?? 0);
    if (!isset($allowed[$imageType]) || ($info['mime'] ?? '') !== $allowed[$imageType][0]) {
        throw new RuntimeException('Solo se admiten imágenes JPG, PNG o WEBP válidas.');
    }

    $folder = trim($folder, '/\\');
    if (!in_array($folder, ['site', 'gallery'], true)) {
        throw new RuntimeException('Destino de imagen no válido.');
    }
    $relativeDirectory = 'uploads/' . $folder;
    $directory = SITE_ROOT . '/' . $relativeDirectory;
    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        throw new RuntimeException('No se pudo crear la carpeta de imágenes.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$imageType][1];
    if (!move_uploaded_file($tmp, $directory . '/' . $filename)) {
        throw new RuntimeException('No se pudo guardar la imagen.');
    }
    return $relativeDirectory . '/' . $filename;
}
