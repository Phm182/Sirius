<?php // Último contacto (página de confirmación)

try {
    require_once 'inc/funciones/bd.php';
    $sql = 'SELECT id, nombre, celular, email, consulta, metodo FROM contacto ORDER BY id DESC LIMIT 1';
    $resultado = $conn->query($sql);
} catch (Exception $e) {
    error_log($e->getMessage());
    $resultado = false;
}
