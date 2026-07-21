<?php
require_once __DIR__ . '/bootstrap.php';
admin_require_login();

$type = (string) ($_GET['tipo'] ?? '');
if (!in_array($type, ['contacto', 'inscripcion'], true)) {
    http_response_code(400);
    exit('Tipo de exportación no válido.');
}

$status = trim((string) ($_GET['estado'] ?? ''));
$search = trim((string) ($_GET['buscar'] ?? ''));
$course = trim((string) ($_GET['curso'] ?? ''));
$archived = isset($_GET['archivados']) && $_GET['archivados'] === '1' ? 1 : 0;

if ($status !== '' && !array_key_exists($status, admin_statuses($type))) {
    $status = '';
}
if (!in_array($course, ['', 'lanchas', 'veleros', 'yates'], true)) {
    $course = '';
}

$like = '%' . $search . '%';

if ($type === 'contacto') {
    $stmt = $conn->prepare(
        "SELECT id, nombre, celular, email, consulta, metodo, estado, notas_admin, archivado, created_at, updated_at
         FROM contacto
         WHERE archivado = ?
           AND (? = '' OR estado = ?)
           AND (? = '' OR nombre LIKE ? OR email LIKE ? OR celular LIKE ? OR consulta LIKE ?)
         ORDER BY created_at DESC, id DESC"
    );
    $stmt->bind_param('isssssss', $archived, $status, $status, $search, $like, $like, $like, $like);
    $headers = ['ID', 'Nombre', 'Celular', 'Email', 'Consulta', 'Método', 'Estado', 'Notas internas', 'Archivado', 'Creado', 'Actualizado'];
} else {
    $stmt = $conn->prepare(
        "SELECT id, nombre, apellido, celular, email, curso, experiencia, mensaje, estado, notas_admin, archivado, created_at, updated_at
         FROM inscripcion
         WHERE archivado = ?
           AND (? = '' OR estado = ?)
           AND (? = '' OR curso = ?)
           AND (? = '' OR nombre LIKE ? OR apellido LIKE ? OR email LIKE ? OR celular LIKE ?)
         ORDER BY created_at DESC, id DESC"
    );
    $stmt->bind_param(
        'isssssssss',
        $archived,
        $status,
        $status,
        $course,
        $course,
        $search,
        $like,
        $like,
        $like,
        $like
    );
    $headers = ['ID', 'Nombre', 'Apellido', 'Celular', 'Email', 'Curso', 'Experiencia', 'Mensaje', 'Estado', 'Notas internas', 'Archivado', 'Creado', 'Actualizado'];
}

$stmt->execute();
$result = $stmt->get_result();

$filename = $type . 's-sirius-' . date('Y-m-d-His') . '.csv';
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-store, no-cache, must-revalidate');

$output = fopen('php://output', 'wb');
fwrite($output, "\xEF\xBB\xBF");
fputcsv($output, $headers, ';');

while ($row = $result->fetch_assoc()) {
    fputcsv($output, array_values($row), ';');
}

$stmt->close();
admin_audit($conn, 'exportacion_csv', $type, null, 'Filtros: estado=' . $status . ', curso=' . $course);
fclose($output);
exit;
