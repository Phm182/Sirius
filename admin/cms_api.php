<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/cms_catalog.php';

admin_require_login();

header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store');

function cms_api_fail(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function cms_api_ok(array $payload = []): void
{
    echo json_encode(['ok' => true] + $payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    cms_api_fail('Método no permitido.', 405);
}

$token = (string) ($_POST['csrf'] ?? '');
if ($token === '' || !hash_equals(admin_csrf_token(), $token)) {
    cms_api_fail('La sesión venció. Recargá el editor e intentá de nuevo.', 403);
}

if (!admin_cms_ready($conn)) {
    cms_api_fail('Primero ejecutá sql/cms_migration.sql.');
}

$action = (string) ($_POST['action'] ?? '');
$catalog = cms_flat_catalog();

try {
    switch ($action) {
        case 'save_field':
            $key = (string) ($_POST['key'] ?? '');
            if (!isset($catalog[$key])) {
                cms_api_fail('Campo no editable.');
            }
            [$label, $type] = $catalog[$key];
            $value = (string) ($_POST['value'] ?? '');

            if ($type === 'image' && isset($_FILES['image']) && (int) ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $value = admin_store_image($_FILES['image'], 'site');
            } elseif ($type === 'url' && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                cms_api_fail('URL no válida.');
            } elseif ($type === 'number' && $value !== '' && !is_numeric($value)) {
                cms_api_fail('El valor debe ser numérico.');
            } elseif ($type === 'color' && !preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
                cms_api_fail('El color no es válido.');
            }

            if ($type === 'image' && $value === '') {
                cms_api_fail('Elegí una imagen o conservá la actual.');
            }

            $stmt = $conn->prepare(
                'INSERT INTO sitio_contenido (clave, valor, tipo) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE valor = VALUES(valor), tipo = VALUES(tipo)'
            );
            if (!$stmt) {
                throw new RuntimeException('No se pudo preparar el guardado.');
            }
            $stmt->bind_param('sss', $key, $value, $type);
            $stmt->execute();
            $stmt->close();

            // Actualiza también el borrador de preview.
            if (!isset($_SESSION['cms_preview']) || !is_array($_SESSION['cms_preview'])) {
                $_SESSION['cms_preview'] = [];
            }
            $_SESSION['cms_preview'][$key] = $value;

            admin_audit($conn, 'cms_field_save', 'sitio_contenido', null, $key . ': ' . $label);
            cms_api_ok(['key' => $key, 'value' => $value, 'type' => $type, 'label' => $label]);

        case 'save_course':
            $id = (int) ($_POST['id'] ?? 0);
            $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $resumen = trim((string) ($_POST['resumen'] ?? ''));
            $descripcion = trim((string) ($_POST['descripcion'] ?? ''));
            $inicio = trim((string) ($_POST['inicio'] ?? ''));
            $duracion = trim((string) ($_POST['duracion'] ?? ''));
            $modalidad = trim((string) ($_POST['modalidad'] ?? ''));
            $ubicacion = trim((string) ($_POST['ubicacion'] ?? ''));
            $precio = trim((string) ($_POST['precio'] ?? ''));
            $imagenAlt = trim((string) ($_POST['imagen_alt'] ?? ''));
            $orden = (int) ($_POST['orden'] ?? 0);
            $activo = isset($_POST['activo']) ? 1 : 0;
            $imagen = trim((string) ($_POST['imagen_actual'] ?? ''));

            if ($nombre === '' || $slug === '') {
                cms_api_fail('Nombre y slug son obligatorios.');
            }
            if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
                cms_api_fail('El slug solo admite minúsculas, números y guiones.');
            }

            if (isset($_FILES['imagen']) && (int) ($_FILES['imagen']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $imagen = admin_store_image($_FILES['imagen'], 'site');
            }
            if ($imagen === '') {
                cms_api_fail('El curso necesita una imagen.');
            }
            if ($imagenAlt === '') {
                $imagenAlt = 'Práctica del curso de ' . $nombre;
            }

            if ($id > 0) {
                $stmt = $conn->prepare(
                    'UPDATE curso SET slug=?, nombre=?, resumen=?, descripcion=?, inicio=?, duracion=?, modalidad=?, ubicacion=?, precio=?, imagen=?, imagen_alt=?, activo=?, orden=? WHERE id=?'
                );
                if (!$stmt) {
                    throw new RuntimeException('No se pudo actualizar el curso.');
                }
                $stmt->bind_param(
                    'sssssssssssiii',
                    $slug,
                    $nombre,
                    $resumen,
                    $descripcion,
                    $inicio,
                    $duracion,
                    $modalidad,
                    $ubicacion,
                    $precio,
                    $imagen,
                    $imagenAlt,
                    $activo,
                    $orden,
                    $id
                );
                $stmt->execute();
                $stmt->close();
                admin_audit($conn, 'curso_update', 'curso', $id, $nombre);
            } else {
                $stmt = $conn->prepare(
                    'INSERT INTO curso (slug, nombre, resumen, descripcion, inicio, duracion, modalidad, ubicacion, precio, imagen, imagen_alt, activo, orden)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)'
                );
                if (!$stmt) {
                    throw new RuntimeException('No se pudo crear el curso.');
                }
                $stmt->bind_param(
                    'sssssssssssii',
                    $slug,
                    $nombre,
                    $resumen,
                    $descripcion,
                    $inicio,
                    $duracion,
                    $modalidad,
                    $ubicacion,
                    $precio,
                    $imagen,
                    $imagenAlt,
                    $activo,
                    $orden
                );
                $stmt->execute();
                $id = (int) $stmt->insert_id;
                $stmt->close();
                admin_audit($conn, 'curso_create', 'curso', $id, $nombre);
            }

            cms_api_ok(['id' => $id, 'slug' => $slug]);

        case 'get_course':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('SELECT * FROM curso WHERE id = ? LIMIT 1');
            if (!$stmt) {
                throw new RuntimeException('No se pudo leer el curso.');
            }
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
                cms_api_fail('Curso no encontrado.', 404);
            }
            cms_api_ok(['course' => $row]);

        case 'delete_course':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('SELECT slug, nombre FROM curso WHERE id = ? LIMIT 1');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
                cms_api_fail('Curso no encontrado.', 404);
            }
            $slug = (string) $row['slug'];
            $check = $conn->prepare('SELECT COUNT(*) AS total FROM inscripcion WHERE curso = ?');
            $check->bind_param('s', $slug);
            $check->execute();
            $total = (int) ($check->get_result()->fetch_assoc()['total'] ?? 0);
            $check->close();
            if ($total > 0) {
                cms_api_fail('No se puede borrar: hay inscripciones asociadas a este curso.');
            }
            $del = $conn->prepare('DELETE FROM curso WHERE id = ?');
            $del->bind_param('i', $id);
            $del->execute();
            $del->close();
            admin_audit($conn, 'curso_delete', 'curso', $id, (string) $row['nombre']);
            cms_api_ok();

        case 'get_gallery':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('SELECT * FROM galeria_foto WHERE id = ? LIMIT 1');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
                cms_api_fail('Foto no encontrada.', 404);
            }
            cms_api_ok(['photo' => $row]);

        case 'save_gallery':
            $id = (int) ($_POST['id'] ?? 0);
            $titulo = trim((string) ($_POST['titulo'] ?? ''));
            $alt = trim((string) ($_POST['alt'] ?? ''));
            $orden = (int) ($_POST['orden'] ?? 0);
            $activo = isset($_POST['activo']) ? 1 : 0;
            $archivo = trim((string) ($_POST['archivo_actual'] ?? ''));

            if (isset($_FILES['imagen']) && (int) ($_FILES['imagen']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $archivo = admin_store_image($_FILES['imagen'], 'gallery');
            }

            if ($id <= 0) {
                if ($archivo === '') {
                    cms_api_fail('Elegí una imagen para subir.');
                }
                if ($titulo === '') {
                    $titulo = pathinfo($archivo, PATHINFO_FILENAME);
                }
                if ($alt === '') {
                    $alt = $titulo;
                }
                $stmt = $conn->prepare(
                    'INSERT INTO galeria_foto (archivo, titulo, alt, activo, orden) VALUES (?,?,?,?,?)'
                );
                $stmt->bind_param('sssii', $archivo, $titulo, $alt, $activo, $orden);
                $stmt->execute();
                $id = (int) $stmt->insert_id;
                $stmt->close();
                admin_audit($conn, 'gallery_create', 'galeria_foto', $id, $titulo);
            } else {
                if ($archivo === '') {
                    cms_api_fail('La foto necesita un archivo.');
                }
                if ($titulo === '') {
                    $titulo = 'Foto';
                }
                if ($alt === '') {
                    $alt = $titulo;
                }
                $stmt = $conn->prepare(
                    'UPDATE galeria_foto SET archivo=?, titulo=?, alt=?, activo=?, orden=? WHERE id=?'
                );
                $stmt->bind_param('sssiii', $archivo, $titulo, $alt, $activo, $orden, $id);
                $stmt->execute();
                $stmt->close();
                admin_audit($conn, 'gallery_update', 'galeria_foto', $id, $titulo);
            }
            cms_api_ok(['id' => $id, 'archivo' => $archivo]);

        case 'delete_gallery':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $conn->prepare('SELECT titulo FROM galeria_foto WHERE id = ? LIMIT 1');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if (!$row) {
                cms_api_fail('Foto no encontrada.', 404);
            }
            $del = $conn->prepare('DELETE FROM galeria_foto WHERE id = ?');
            $del->bind_param('i', $id);
            $del->execute();
            $del->close();
            admin_audit($conn, 'gallery_delete', 'galeria_foto', $id, (string) $row['titulo']);
            cms_api_ok();

        case 'get_field':
            $key = (string) ($_POST['key'] ?? '');
            if (!isset($catalog[$key])) {
                cms_api_fail('Campo no editable.');
            }
            [$label, $type] = $catalog[$key];
            require_once SITE_ROOT . '/inc/funciones/contenido.php';
            $value = contenido($key, '', $conn);
            cms_api_ok(['key' => $key, 'value' => $value, 'type' => $type, 'label' => $label]);

        default:
            cms_api_fail('Acción no reconocida.');
    }
} catch (Throwable $exception) {
    cms_api_fail($exception->getMessage(), 500);
}
