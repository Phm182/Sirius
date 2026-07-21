<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
admin_require_login();

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

admin_verify_csrf();

$content = $_POST['content'] ?? [];
$draft = [];

if (is_array($content)) {
    foreach ($content as $key => $value) {
        $key = (string) $key;
        if (!preg_match('/^[a-z][a-z0-9_]*\.[a-z0-9_]+$/', $key)) {
            continue;
        }
        $draft[$key] = mb_substr((string) $value, 0, 5000);
        if (count($draft) >= 300) {
            break;
        }
    }
}

$_SESSION['cms_preview'] = $draft;

echo json_encode(['ok' => true, 'campos' => count($draft)]);
