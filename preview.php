<?php
declare(strict_types=1);

/**
 * Vista previa privada del sitio para el panel de administración.
 * Con ?edit=1 inyecta el editor visual sobre la página real.
 */

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

if (empty($_SESSION['admin_id']) || (int) $_SESSION['admin_id'] <= 0) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=UTF-8');
    exit('No autorizado.');
}

header('X-Frame-Options: SAMEORIGIN');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store, no-cache, must-revalidate');

if (empty($_SESSION['admin_csrf'])) {
    $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
}

$overrides = $_SESSION['cms_preview'] ?? [];
if (is_array($overrides) && $overrides !== []) {
    $GLOBALS['cms_preview_overrides'] = $overrides;
}

$allowedPages = [
    'index.php',
    'quienes_somos.php',
    'cursos.php',
    'galeria.php',
    'contacto.php',
    'inscripcion.php',
];

$page = (string) ($_GET['page'] ?? 'index.php');
if (!in_array($page, $allowedPages, true)) {
    $page = 'index.php';
}

$editMode = isset($_GET['edit']) && (string) $_GET['edit'] === '1';
$GLOBALS['cms_edit_mode'] = $editMode;
$GLOBALS['cms_editor_csrf'] = (string) $_SESSION['admin_csrf'];
$GLOBALS['cms_editor_api'] = 'admin/cms_api.php';

if (!defined('SIRIUS_PREVIEW')) {
    define('SIRIUS_PREVIEW', true);
}

chdir(__DIR__);
require __DIR__ . '/' . $page;
