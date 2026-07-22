<?php
$pageTitle = $pageTitle ?? 'Administración';
$activePage = $activePage ?? '';
$flash = admin_take_flash();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow">
  <title><?php echo admin_h($pageTitle); ?> · Sirius Admin</title>
  <link rel="icon" type="image/png" href="../img/Logo%20Web.png">
  <link rel="apple-touch-icon" href="../img/Logo%20Web.png">
  <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
  <header class="admin-header">
    <a class="admin-brand" href="index.php">
      <span class="admin-brand__mark">
        <img src="../img/Logo Web.png" alt="Logo Sirius">
      </span>
      <span><strong>Sirius</strong><small>Administración</small></span>
    </a>

    <?php if (admin_is_logged_in()): ?>
      <button class="admin-menu-button" type="button" data-menu-toggle
              aria-label="Abrir menú" aria-expanded="false" aria-controls="admin-navigation">☰</button>
      <nav class="admin-nav" id="admin-navigation" data-admin-nav>
        <a class="<?php echo $activePage === 'dashboard' ? 'is-active' : ''; ?>" href="index.php">Resumen</a>
        <a class="<?php echo $activePage === 'contactos' ? 'is-active' : ''; ?>" href="index.php?tipo=contacto">Contactos</a>
        <a class="<?php echo $activePage === 'inscripciones' ? 'is-active' : ''; ?>" href="index.php?tipo=inscripcion">Inscripciones</a>
        <a class="<?php echo $activePage === 'editor' ? 'is-active' : ''; ?>" href="editor.php">Editor</a>
        <a class="<?php echo $activePage === 'cuenta' ? 'is-active' : ''; ?>" href="cuenta.php">Cuenta</a>
        <a href="../index.php" target="_blank" rel="noopener">Ver sitio</a>
        <form action="logout.php" method="post">
          <input type="hidden" name="csrf" value="<?php echo admin_h(admin_csrf_token()); ?>">
          <button type="submit">Salir</button>
        </form>
      </nav>
    <?php endif; ?>
  </header>

  <main class="admin-main">
    <?php if ($flash): ?>
      <div class="admin-alert admin-alert--<?php echo admin_h($flash['type']); ?>" role="status">
        <?php echo admin_h($flash['message']); ?>
      </div>
    <?php endif; ?>
