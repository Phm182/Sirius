<?php
$curso_slug = strtolower(trim((string) ($_GET['slug'] ?? '')));
include 'inc/templates/curso-detalle.php';
