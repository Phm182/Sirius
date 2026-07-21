<?php
// Evita que el navegador sirva HTML viejo cacheado (así siempre toma la
// versión nueva de CSS/JS con su ?v=). Los assets se siguen cacheando.
if (!headers_sent()) {
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
}

require_once __DIR__ . '/../funciones/bd.php';
require_once __DIR__ . '/../funciones/contenido.php';

$siteTitle = contenido('seo.titulo', 'Sirius · Escuela Náutica', $conn);
$siteDescription = contenido('seo.descripcion', 'Cursos de navegación en Buenos Aires con práctica real a bordo.', $conn);
$siteBackground = contenido_asset('site.fondo', 'img/velas_para_crucero.jpg', $conn);

/**
 * El fondo se inyecta como variable CSS. Dentro de una hoja de estilos, un
 * url() de una custom property se resuelve relativo al .css, por eso lo
 * convertimos a una ruta absoluta desde la raíz del sitio (funciona tanto en
 * /Sirius local como en la raíz del dominio en producción).
 */
if (!function_exists('sirius_base_path')) {
    function sirius_base_path(): string
    {
        $dir = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '')));
        return ($dir === '/' || $dir === '.' || $dir === '') ? '' : rtrim($dir, '/');
    }
}
if (!function_exists('sirius_asset_url')) {
    function sirius_asset_url(string $path): string
    {
        if ($path === '' || $path[0] === '/' || preg_match('#^(?:https?:)?//#', $path)) {
            return $path;
        }
        return sirius_base_path() . '/' . ltrim($path, '/');
    }
}
$siteBackground = sirius_asset_url($siteBackground);

/**
 * Cache-busting para assets locales: agrega ?v=<mtime> para que el navegador
 * descargue la versión nueva del CSS/JS en lugar de servir una cacheada.
 */
if (!function_exists('sirius_asset')) {
    function sirius_asset(string $path): string
    {
        $file = __DIR__ . '/../../' . ltrim($path, '/');
        $url = sirius_asset_url($path);
        if (is_file($file)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . 'v=' . filemtime($file);
        }
        return $url;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($siteTitle, ENT_QUOTES, 'UTF-8'); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($siteDescription, ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Redressed&family=Open+Sans:wght@300;400;600;700;800&family=Oswald:wght@300;400;700&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('css/normalize.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('css/boton-menu.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('css/contacto.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('css/lightbox.css'), ENT_QUOTES, 'UTF-8'); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars(sirius_asset('css/style.css'), ENT_QUOTES, 'UTF-8'); ?>">
</head>
<body style="--site-bg-image: url('<?php echo htmlspecialchars($siteBackground, ENT_QUOTES, 'UTF-8'); ?>')">
