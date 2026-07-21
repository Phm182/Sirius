<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/cms_catalog.php';
admin_require_login();

$pageTitle = 'Editor del sitio';
$activePage = 'editor';
$cmsReady = admin_cms_ready($conn);

$pages = [
    'index.php' => 'Inicio',
    'quienes_somos.php' => 'Quiénes somos',
    'cursos.php' => 'Cursos',
    'galeria.php' => 'Galería',
    'contacto.php' => 'Contacto',
    'inscripcion.php' => 'Inscripción',
];

$currentPage = (string) ($_GET['page'] ?? 'index.php');
if (!isset($pages[$currentPage])) {
    $currentPage = 'index.php';
}

$catalog = cms_field_catalog();
$flat = cms_flat_catalog();
require_once SITE_ROOT . '/inc/funciones/contenido.php';

$globalKeys = [
    'site.logo', 'site.fondo',
    'theme.primary', 'theme.secondary', 'theme.background', 'theme.surface', 'theme.text',
    'nav.quienes', 'nav.cursos', 'nav.inscripcion', 'nav.sede', 'nav.galeria', 'nav.contacto', 'nav.admin',
    'footer.sobre_titulo', 'footer.sobre', 'footer.sede_titulo', 'footer.sede', 'footer.sede_extra',
    'footer.redes_titulo', 'footer.facebook', 'footer.youtube', 'footer.instagram', 'footer.credito',
    'seo.titulo', 'seo.descripcion',
];

include __DIR__ . '/templates/header.php';
?>

<?php if (!$cmsReady): ?>
  <div class="admin-alert admin-alert--error">
    Primero ejecutá <code>sql/cms_migration.sql</code> para habilitar el editor.
  </div>
<?php else: ?>
<section
  class="admin-visual"
  data-visual-editor
  data-csrf="<?php echo admin_h(admin_csrf_token()); ?>"
  data-api="cms_api.php"
  data-preview-base="../preview.php"
  data-page="<?php echo admin_h($currentPage); ?>"
>
  <div class="admin-visual__toolbar">
    <div class="admin-visual__toolbar-left">
      <label class="admin-visual__label">
        Pantalla
        <select data-visual-page>
          <?php foreach ($pages as $file => $label): ?>
            <option value="<?php echo admin_h($file); ?>" <?php echo $file === $currentPage ? 'selected' : ''; ?>>
              <?php echo admin_h($label); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="admin-visual__label">
        Vista
        <select data-visual-device>
          <option value="desktop">Escritorio</option>
          <option value="tablet">Tablet</option>
          <option value="mobile">Celular</option>
        </select>
      </label>
    </div>
    <div class="admin-visual__toolbar-right">
      <span class="admin-visual__hint">Tocá directamente un texto, imagen, curso o foto para editarlo.</span>
      <button type="button" class="admin-button admin-button--ghost" data-open-panel="globals">Diseño y ajustes</button>
      <button type="button" class="admin-button admin-button--ghost" data-open-panel="course-new">Nuevo curso</button>
      <button type="button" class="admin-button admin-button--primary" data-open-panel="gallery-new">Subir foto</button>
      <button type="button" class="admin-button admin-button--ghost" data-visual-reload title="Recargar vista">↻</button>
    </div>
  </div>

  <div class="admin-visual__stage">
    <div class="admin-visual__frame" data-visual-frame data-device="desktop">
      <iframe
        title="Editor visual del sitio"
        data-visual-iframe
        src="../preview.php?page=<?php echo rawurlencode($currentPage); ?>&edit=1"
      ></iframe>
    </div>
  </div>

  <aside class="admin-visual__drawer" data-visual-drawer hidden>
    <div class="admin-visual__drawer-head">
      <h2 data-drawer-title>Editar</h2>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close aria-label="Cerrar">✕</button>
    </div>
    <div class="admin-visual__drawer-body" data-drawer-body></div>
    <p class="admin-visual__status" data-drawer-status hidden></p>
  </aside>
</section>

<template id="tpl-field-text">
  <form class="admin-visual-form" data-form="field">
    <input type="hidden" name="action" value="save_field">
    <input type="hidden" name="key" value="">
    <label>Texto
      <input type="text" name="value" required>
    </label>
    <div class="admin-visual-form__actions">
      <button type="submit" class="admin-button admin-button--primary">Guardar</button>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cancelar</button>
    </div>
  </form>
</template>

<template id="tpl-field-textarea">
  <form class="admin-visual-form" data-form="field">
    <input type="hidden" name="action" value="save_field">
    <input type="hidden" name="key" value="">
    <label>Texto
      <textarea name="value" rows="6" required></textarea>
    </label>
    <div class="admin-visual-form__actions">
      <button type="submit" class="admin-button admin-button--primary">Guardar</button>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cancelar</button>
    </div>
  </form>
</template>

<template id="tpl-field-image">
  <form class="admin-visual-form" data-form="field" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_field">
    <input type="hidden" name="key" value="">
    <input type="hidden" name="value" value="">
    <p class="admin-muted">Imagen actual</p>
    <img class="admin-thumb admin-thumb--large" data-image-preview alt="">
    <label>Reemplazar imagen
      <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
    </label>
    <div class="admin-visual-form__actions">
      <button type="submit" class="admin-button admin-button--primary">Guardar</button>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cancelar</button>
    </div>
  </form>
</template>

<template id="tpl-course">
  <form class="admin-visual-form" data-form="course" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_course">
    <input type="hidden" name="id" value="0">
    <input type="hidden" name="imagen_actual" value="">
    <div class="admin-form-grid">
      <label>Nombre <input type="text" name="nombre" required></label>
      <label>Slug <input type="text" name="slug" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*"></label>
      <label class="admin-field--wide">Resumen <textarea name="resumen" rows="2"></textarea></label>
      <label class="admin-field--wide">Descripción <textarea name="descripcion" rows="4"></textarea></label>
      <label>Inicio <input type="text" name="inicio"></label>
      <label>Duración <input type="text" name="duracion"></label>
      <label>Modalidad <input type="text" name="modalidad"></label>
      <label>Sede <input type="text" name="ubicacion"></label>
      <label>Arancel <input type="text" name="precio"></label>
      <label>Orden <input type="number" name="orden" value="10"></label>
      <label>Alt de imagen <input type="text" name="imagen_alt"></label>
      <label><input type="checkbox" name="activo" value="1" checked> Activo</label>
      <label class="admin-field--wide">Imagen
        <img class="admin-thumb admin-thumb--large" data-image-preview alt="">
        <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
      </label>
    </div>
    <div class="admin-visual-form__actions">
      <button type="submit" class="admin-button admin-button--primary">Guardar curso</button>
      <button type="button" class="admin-button admin-button--danger" data-delete-course hidden>Eliminar</button>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cancelar</button>
    </div>
  </form>
</template>

<template id="tpl-gallery">
  <form class="admin-visual-form" data-form="gallery" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_gallery">
    <input type="hidden" name="id" value="0">
    <input type="hidden" name="archivo_actual" value="">
    <label>Título <input type="text" name="titulo"></label>
    <label>Texto alternativo <input type="text" name="alt"></label>
    <label>Orden <input type="number" name="orden" value="10"></label>
    <label><input type="checkbox" name="activo" value="1" checked> Visible</label>
    <label>Imagen
      <img class="admin-thumb admin-thumb--large" data-image-preview alt="">
      <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
    </label>
    <div class="admin-visual-form__actions">
      <button type="submit" class="admin-button admin-button--primary">Guardar foto</button>
      <button type="button" class="admin-button admin-button--danger" data-delete-gallery hidden>Eliminar</button>
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cancelar</button>
    </div>
  </form>
</template>

<template id="tpl-globals">
  <form class="admin-visual-form" data-form="globals">
    <p class="admin-muted">Estos ajustes aparecen en todas las pantallas. Guardá cada campo con su botón.</p>
    <?php foreach ($globalKeys as $key):
        if (!isset($flat[$key])) {
            continue;
        }
        [$label, $type] = $flat[$key];
        $value = contenido($key, '', $conn);
        ?>
      <fieldset class="admin-visual-global" data-global-key="<?php echo admin_h($key); ?>" data-global-type="<?php echo admin_h($type); ?>">
        <legend><?php echo admin_h($label); ?></legend>
        <?php if ($type === 'image'): ?>
          <img class="admin-thumb" src="../<?php echo admin_h($value); ?>" alt="">
          <input type="file" accept="image/jpeg,image/png,image/webp" data-global-file>
          <input type="hidden" data-global-value value="<?php echo admin_h($value); ?>">
        <?php elseif ($type === 'color'): ?>
          <div class="admin-color-field">
            <input type="color" data-global-value value="<?php echo admin_h($value); ?>">
            <output><?php echo admin_h($value); ?></output>
          </div>
        <?php elseif ($type === 'textarea'): ?>
          <textarea rows="3" data-global-value><?php echo admin_h($value); ?></textarea>
        <?php else: ?>
          <input type="<?php echo $type === 'url' ? 'url' : 'text'; ?>" data-global-value value="<?php echo admin_h($value); ?>">
        <?php endif; ?>
        <button type="button" class="admin-button admin-button--primary admin-button--small" data-save-global>Guardar</button>
      </fieldset>
    <?php endforeach; ?>
    <div class="admin-visual-form__actions">
      <button type="button" class="admin-button admin-button--ghost" data-drawer-close>Cerrar</button>
    </div>
  </form>
</template>

<script src="assets/visual-shell.js"></script>
<?php endif; ?>

<?php include __DIR__ . '/templates/footer.php'; ?>
