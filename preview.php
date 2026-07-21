<?php
declare(strict_types=1);

/**
 * Vista previa privada del sitio para el panel de administración.
 * Renderiza las páginas públicas reales aplicando el borrador sin guardar
 * que el editor deja en la sesión. Solo accesible con sesión de admin activa.
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

// El editor embebe esta página en un iframe del mismo origen.
header('X-Frame-Options: SAMEORIGIN');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store, no-cache, must-revalidate');

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

if (!defined('SIRIUS_PREVIEW')) {
    define('SIRIUS_PREVIEW', true);
}

chdir(__DIR__);
require __DIR__ . '/' . $page;
