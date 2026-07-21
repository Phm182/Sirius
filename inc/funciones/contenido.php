<?php
declare(strict_types=1);

/**
 * Lecturas públicas del CMS. Todas las funciones conservan defaults locales
 * para que el sitio siga disponible antes de ejecutar la migración.
 */

function sitio_contenido_defaults(): array
{
    return [
        'site.logo' => 'img/Logo Web.png',
        'site.fondo' => 'img/velas_para_crucero.jpg',
        'theme.primary' => '#b91515',
        'theme.secondary' => '#09134e',
        'theme.background' => '#111111',
        'theme.surface' => '#0d1533',
        'theme.text' => '#f4f6fa',
        'nav.quienes' => '¿Quiénes somos?',
        'nav.cursos' => 'Cursos',
        'nav.inscripcion' => 'Inscripción',
        'nav.sede' => 'Sede',
        'nav.galeria' => 'Galería',
        'nav.contacto' => 'Contacto',
        'nav.admin' => 'Administración',
        'inicio.hero_titulo' => 'SIRIUS',
        'inicio.hero_subtitulo' => 'Escuela Náutica',
        'inicio.hero_boton' => 'Quiero navegar',
        'inicio.presentacion_eyebrow' => 'Sirius',
        'inicio.presentacion_titulo' => 'Escuela de navegación',
        'inicio.presentacion_texto' => 'Somos un equipo de instructores apasionados por el río y el mar. Formamos navegantes desde el primer amarre hasta maniobras avanzadas, con clases claras, práctica real y acompañamiento cercano en cada etapa.',
        'inicio.presentacion_imagen' => 'img/4.jpeg',
        'inicio.presentacion_boton' => 'Nuestra historia',
        'inicio.cursos_titulo' => 'Cursos',
        'inicio.inscripcion_eyebrow' => '¡Te esperamos a bordo!',
        'inicio.inscripcion_titulo' => 'Inscripción',
        'inicio.inscripcion_texto' => 'Reservá tu lugar en el próximo ciclo. Completá el formulario y el equipo de Sirius te contacta para confirmar fechas, vacantes y aranceles.',
        'inicio.inscripcion_imagen' => 'img/5.jpeg',
        'inicio.inscripcion_boton' => 'Inscribirme',
        'inicio.sede_eyebrow' => 'Sede',
        'inicio.sede_titulo' => 'Costanera Norte',
        'inicio.sede_texto' => 'Practicamos en la Sede Náutica de la Costanera Norte. En breve publicamos la dirección exacta; mientras tanto, encontranos en el mapa.',
        'inicio.sede_boton' => 'Consultar cómo llegar',
        'inicio.mapa_zoom' => '14',
        'quienes.eyebrow' => 'Sirius',
        'quienes.titulo' => 'Escuela de navegación',
        'quienes.intro' => 'En Sirius formamos navegantes con criterio, seguridad y pasión por el agua. Combinamos teoría sólida con horas reales a bordo para que cada alumno salga con confianza y herramientas concretas.',
        'quienes.imagen' => 'img/4.jpeg',
        'quienes.boton' => 'Nuestra historia',
        'quienes.historia_titulo' => 'De la pasión por navegar a una escuela',
        'quienes.historia_texto' => 'Sirius nace de años de experiencia a bordo y de la necesidad de enseñar navegación de forma clara, moderna y cercana.',
        'quienes.metodo_titulo' => 'Método: teoría que se vive en el agua',
        'quienes.metodo_texto' => 'Creemos que se aprende navegando. Por eso cada módulo teórico se traduce en práctica real.',
        'quienes.sede_titulo' => 'Costanera Norte como aula abierta',
        'quienes.sede_texto' => 'Nuestra sede náutica en la Costanera Norte nos permite entrenar en un entorno vivo, con tráfico, corrientes y situaciones reales de río.',
        'quienes.comunidad_titulo' => 'Una comunidad que sigue creciendo',
        'quienes.comunidad_texto' => 'Más que un curso, Sirius es una comunidad de personas que aman el agua y comparten las ganas de seguir aprendiendo.',
        'cursos.eyebrow' => 'Sirius',
        'cursos.titulo' => 'Cursos',
        'cursos.intro' => 'Formación náutica con teoría clara y práctica real a bordo.',
        'galeria.eyebrow' => 'Sirius',
        'galeria.titulo' => 'Galería a bordo',
        'galeria.intro' => 'Momentos reales de práctica, aprendizaje y vida náutica. Tocá una imagen para verla en grande.',
        'galeria.cta' => '¿Querés vivir esto en primera persona?',
        'galeria.cta_boton' => 'Inscribite a un curso',
        'contacto.eyebrow' => 'Sirius',
        'contacto.titulo' => 'Contactanos',
        'contacto.intro' => 'Consultas sobre cursos, fechas, aranceles o cómo llegar a la sede. Te respondemos a la brevedad.',
        'contacto.boton' => 'Enviar consulta',
        'contacto.label_nombre' => 'Nombre',
        'contacto.label_celular' => 'Celular',
        'contacto.label_email' => 'E-Mail',
        'contacto.label_consulta' => 'Consulta',
        'contacto.label_medio' => '¿Por qué medio preferís la respuesta?',
        'contacto.label_whatsapp' => 'Celular / WhatsApp',
        'contacto.label_correo' => 'Correo electrónico',
        'contacto.label_ambos' => 'Ambos',
        'inscripcion.eyebrow' => 'Sirius',
        'inscripcion.titulo' => 'Inscripción a la escuela náutica',
        'inscripcion.intro' => 'Completá tus datos y elegí el curso. Te contactamos para confirmar vacante, fechas y aranceles.',
        'inscripcion.nota' => 'Te vamos a contactar para confirmar vacante, fechas y aranceles.',
        'inscripcion.boton' => 'Enviar inscripción',
        'inscripcion.label_nombre' => 'Nombre',
        'inscripcion.label_apellido' => 'Apellido',
        'inscripcion.label_celular' => 'Celular',
        'inscripcion.label_email' => 'E-Mail',
        'inscripcion.label_curso' => 'Curso',
        'inscripcion.label_experiencia' => 'Experiencia náutica',
        'inscripcion.label_mensaje' => 'Comentarios o disponibilidad',
        'footer.sobre_titulo' => 'Sobre Sirius',
        'footer.sobre' => 'Escuela náutica en Buenos Aires. Formamos navegantes con práctica real.',
        'footer.sede_titulo' => 'Nuestra Sede',
        'footer.sede' => 'Sede Náutica · Costanera Norte, Ciudad Autónoma de Buenos Aires.',
        'footer.sede_extra' => 'Próximamente publicamos la dirección exacta. Mientras tanto, escribinos por Contacto o visitá el mapa en el inicio.',
        'footer.redes_titulo' => 'Redes Sociales',
        'footer.facebook' => 'https://www.facebook.com/',
        'footer.youtube' => 'https://www.youtube.com/',
        'footer.instagram' => 'https://www.instagram.com/',
        'footer.credito' => 'Diseño Web: BitFlow',
        'seo.titulo' => 'Sirius · Escuela Náutica',
        'seo.descripcion' => 'Cursos de navegación en Buenos Aires con práctica real a bordo.',
    ];
}

function sitio_cursos_defaults(): array
{
    return [
        ['id' => 0, 'slug' => 'lanchas', 'nombre' => 'Lanchas', 'resumen' => 'Ideal para quienes quieren manejar embarcaciones a motor con seguridad.', 'descripcion' => 'Aprendé a operar embarcaciones a motor con seguridad y criterio.', 'inicio' => 'Abril, junio, agosto y octubre', 'duracion' => '2 meses', 'modalidad' => 'Práctico presencial · Teórico online', 'ubicacion' => 'Sede Náutica · Costanera Norte (CABA)', 'precio' => 'Consultar', 'imagen' => 'img/1.jpg', 'imagen_alt' => 'Práctica del curso de lanchas', 'activo' => 1, 'orden' => 10],
        ['id' => 0, 'slug' => 'veleros', 'nombre' => 'Veleros', 'resumen' => 'Descubrí el arte de navegar a vela con técnica y seguridad.', 'descripcion' => 'Aprendé trimado, rumbos, maniobras y toma de decisiones con viento.', 'inicio' => 'Abril y agosto', 'duracion' => '4 meses', 'modalidad' => 'Práctico presencial · Teórico online', 'ubicacion' => 'Sede Náutica · Costanera Norte (CABA)', 'precio' => 'Consultar', 'imagen' => 'img/2.jpg', 'imagen_alt' => 'Práctica del curso de veleros', 'activo' => 1, 'orden' => 20],
        ['id' => 0, 'slug' => 'yates', 'nombre' => 'Yates', 'resumen' => 'Programa avanzado para ganar autonomía y responsabilidad náutica.', 'descripcion' => 'Planificación, sistemas a bordo, meteorología, guardias y liderazgo.', 'inicio' => 'Abril', 'duracion' => '1 año', 'modalidad' => 'Práctico presencial · Teórico online', 'ubicacion' => 'Sede Náutica · Costanera Norte (CABA)', 'precio' => 'Consultar', 'imagen' => 'img/3.jpg', 'imagen_alt' => 'Práctica del curso de yates', 'activo' => 1, 'orden' => 30],
    ];
}

function sitio_galeria_defaults(): array
{
    $labels = ['Salida al río', 'Maniobras', 'Cubierta', 'Navegación', 'Instrucción', 'Equipo', 'Práctica', 'Atardecer', 'Costanera', 'Comunidad'];
    $photos = [];
    foreach ($labels as $index => $label) {
        $number = $index + 1;
        $photos[] = [
            'id' => 0,
            'archivo' => 'imgS/' . $number . ($number === 9 ? '.jpeg' : '.jpg'),
            'titulo' => $label,
            'alt' => $label,
            'activo' => 1,
            'orden' => $number * 10,
        ];
    }
    return $photos;
}

function sitio_db(?mysqli $db = null): ?mysqli
{
    if ($db instanceof mysqli) {
        return $db;
    }
    global $conn;
    return isset($conn) && $conn instanceof mysqli ? $conn : null;
}

function contenido(string $clave, string $fallback = '', ?mysqli $db = null): string
{
    if (
        isset($GLOBALS['cms_preview_overrides'])
        && is_array($GLOBALS['cms_preview_overrides'])
        && array_key_exists($clave, $GLOBALS['cms_preview_overrides'])
    ) {
        return (string) $GLOBALS['cms_preview_overrides'][$clave];
    }

    static $cache = [];
    $defaults = sitio_contenido_defaults();
    $default = $fallback !== '' ? $fallback : (string) ($defaults[$clave] ?? '');

    if (array_key_exists($clave, $cache)) {
        return $cache[$clave];
    }

    $connection = sitio_db($db);
    if (!$connection) {
        return $cache[$clave] = $default;
    }

    try {
        $stmt = $connection->prepare('SELECT valor FROM sitio_contenido WHERE clave = ? LIMIT 1');
        if (!$stmt) {
            return $cache[$clave] = $default;
        }
        $stmt->bind_param('s', $clave);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $cache[$clave] = isset($row['valor']) ? (string) $row['valor'] : $default;
    } catch (Throwable $exception) {
        return $cache[$clave] = $default;
    }
}

function contenido_asset(string $clave, string $fallback, ?mysqli $db = null): string
{
    $value = str_replace('\\', '/', contenido($clave, $fallback, $db));
    if (
        $value === ''
        || str_contains($value, '..')
        || !preg_match('#^(?:img|imgS|images|uploads)/(?:[a-zA-Z0-9._/-]+)$#', $value)
    ) {
        return $fallback;
    }
    return $value;
}

function contenido_color(string $clave, string $fallback, ?mysqli $db = null): string
{
    $value = contenido($clave, $fallback, $db);
    return preg_match('/^#[0-9a-fA-F]{6}$/', $value) ? strtolower($value) : $fallback;
}

function cursos_activos(?mysqli $db = null): array
{
    static $cache = null;
    if (is_array($cache)) {
        return $cache;
    }
    $connection = sitio_db($db);
    if (!$connection) {
        return $cache = sitio_cursos_defaults();
    }
    try {
        $result = $connection->query('SELECT * FROM curso WHERE activo = 1 ORDER BY orden ASC, nombre ASC');
        if (!$result) {
            return $cache = sitio_cursos_defaults();
        }
        return $cache = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Throwable $exception) {
        return $cache = sitio_cursos_defaults();
    }
}

function curso_por_slug(string $slug, ?mysqli $db = null): ?array
{
    foreach (cursos_activos($db) as $course) {
        if (hash_equals((string) $course['slug'], $slug)) {
            return $course;
        }
    }
    return null;
}

function galeria_activa(?mysqli $db = null): array
{
    static $cache = null;
    if (is_array($cache)) {
        return $cache;
    }
    $connection = sitio_db($db);
    if (!$connection) {
        return $cache = sitio_galeria_defaults();
    }
    try {
        $result = $connection->query('SELECT * FROM galeria_foto WHERE activo = 1 ORDER BY orden ASC, id ASC');
        if (!$result) {
            return $cache = sitio_galeria_defaults();
        }
        return $cache = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Throwable $exception) {
        return $cache = sitio_galeria_defaults();
    }
}

/** True cuando la página se renderiza dentro del editor visual. */
function cms_edit_mode(): bool
{
    return defined('SIRIUS_PREVIEW') && !empty($GLOBALS['cms_edit_mode']);
}

/**
 * Atributos data-* para marcar un elemento editable en el editor visual.
 * No imprime nada en el sitio público normal.
 */
function cms_attrs(string $key, string $type = 'text', string $label = '', string $src = ''): string
{
    if (!cms_edit_mode()) {
        return '';
    }
    $html = ' data-cms-key="' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '"'
        . ' data-cms-type="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '"';
    if ($label !== '') {
        $html .= ' data-cms-label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '"';
    }
    if ($src !== '') {
        $html .= ' data-cms-src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '"';
    }
    return $html;
}

function cms_entity_attrs(string $entity, int|string $id, string $label = ''): string
{
    if (!cms_edit_mode()) {
        return '';
    }
    $html = ' data-cms-entity="' . htmlspecialchars($entity, ENT_QUOTES, 'UTF-8') . '"'
        . ' data-cms-id="' . htmlspecialchars((string) $id, ENT_QUOTES, 'UTF-8') . '"';
    if ($label !== '') {
        $html .= ' data-cms-label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '"';
    }
    return $html;
}

/**
 * Imprime texto CMS escapado. En edición usa un elemento propio en vez de
 * <span>: la hoja pública tiene reglas globales para span y modificaría
 * tipografía/color solamente dentro del editor.
 */
function cms_text(string $key, string $fallback = '', ?mysqli $db = null, bool $multiline = false): void
{
    $raw = contenido($key, $fallback, $db);
    $escaped = htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
    $html = $multiline ? nl2br($escaped) : $escaped;
    if (!cms_edit_mode()) {
        echo $html;
        return;
    }
    $type = $multiline ? 'textarea' : 'text';
    echo '<cms-editable class="cms-spot"' . cms_attrs($key, $type) . '>' . $html . '</cms-editable>';
}
