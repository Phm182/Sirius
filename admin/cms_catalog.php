<?php
declare(strict_types=1);

/**
 * Catálogo único de claves editables del CMS (label + tipo).
 */
function cms_field_catalog(): array
{
    return [
        'General' => [
            'site.logo' => ['Logo del sitio', 'image'],
            'site.fondo' => ['Fondo principal y parallax', 'image'],
            'theme.primary' => ['Color principal', 'color'],
            'theme.secondary' => ['Color secundario', 'color'],
            'theme.background' => ['Fondo oscuro', 'color'],
            'theme.surface' => ['Superficie de formularios', 'color'],
            'theme.text' => ['Texto claro', 'color'],
            'nav.quienes' => ['Menú: Quiénes somos', 'text'],
            'nav.cursos' => ['Menú: Cursos', 'text'],
            'nav.inscripcion' => ['Menú: Inscripción', 'text'],
            'nav.sede' => ['Menú: Sede', 'text'],
            'nav.galeria' => ['Menú: Galería', 'text'],
            'nav.contacto' => ['Menú: Contacto', 'text'],
            'nav.admin' => ['Menú móvil: Administración', 'text'],
        ],
        'Inicio' => [
            'inicio.hero_titulo' => ['Título principal', 'text'],
            'inicio.hero_subtitulo' => ['Subtítulo principal', 'text'],
            'inicio.hero_boton' => ['Texto del botón', 'text'],
            'inicio.presentacion_eyebrow' => ['Marca sobre presentación', 'text'],
            'inicio.presentacion_titulo' => ['Título de presentación', 'text'],
            'inicio.presentacion_texto' => ['Presentación', 'textarea'],
            'inicio.presentacion_imagen' => ['Imagen de presentación', 'image'],
            'inicio.presentacion_boton' => ['Botón de presentación', 'text'],
            'inicio.cursos_titulo' => ['Título de cursos', 'text'],
            'inicio.inscripcion_eyebrow' => ['Frase sobre inscripción', 'text'],
            'inicio.inscripcion_titulo' => ['Título de inscripción', 'text'],
            'inicio.inscripcion_texto' => ['Texto de inscripción', 'textarea'],
            'inicio.inscripcion_imagen' => ['Imagen de inscripción', 'image'],
            'inicio.inscripcion_boton' => ['Botón de inscripción', 'text'],
            'inicio.sede_eyebrow' => ['Marca sobre sede', 'text'],
            'inicio.sede_titulo' => ['Título de sede', 'text'],
            'inicio.sede_texto' => ['Texto de sede', 'textarea'],
            'inicio.sede_boton' => ['Botón de sede', 'text'],
            'inicio.mapa_zoom' => ['Zoom inicial del mapa', 'number'],
        ],
        'Quiénes somos' => [
            'quienes.eyebrow' => ['Marca', 'text'],
            'quienes.titulo' => ['Título', 'text'],
            'quienes.intro' => ['Introducción', 'textarea'],
            'quienes.imagen' => ['Imagen principal', 'image'],
            'quienes.boton' => ['Texto del botón', 'text'],
            'quienes.historia_titulo' => ['Título de historia', 'text'],
            'quienes.historia_texto' => ['Historia', 'textarea'],
            'quienes.metodo_titulo' => ['Título del método', 'text'],
            'quienes.metodo_texto' => ['Descripción del método', 'textarea'],
            'quienes.sede_titulo' => ['Título de sede/aula', 'text'],
            'quienes.sede_texto' => ['Texto de sede/aula', 'textarea'],
            'quienes.comunidad_titulo' => ['Título de comunidad', 'text'],
            'quienes.comunidad_texto' => ['Texto de comunidad', 'textarea'],
        ],
        'Cursos / Galería' => [
            'cursos.eyebrow' => ['Marca sobre cursos', 'text'],
            'cursos.titulo' => ['Título de cursos', 'text'],
            'cursos.intro' => ['Introducción de cursos', 'textarea'],
            'galeria.eyebrow' => ['Marca sobre galería', 'text'],
            'galeria.titulo' => ['Título de galería', 'text'],
            'galeria.intro' => ['Introducción de galería', 'textarea'],
            'galeria.cta' => ['Llamado a la acción', 'text'],
            'galeria.cta_boton' => ['Botón de galería', 'text'],
        ],
        'Contacto / Inscripción' => [
            'contacto.eyebrow' => ['Marca de contacto', 'text'],
            'contacto.titulo' => ['Título de contacto', 'text'],
            'contacto.intro' => ['Introducción de contacto', 'textarea'],
            'contacto.boton' => ['Botón de contacto', 'text'],
            'contacto.label_nombre' => ['Contacto: Nombre', 'text'],
            'contacto.label_celular' => ['Contacto: Celular', 'text'],
            'contacto.label_email' => ['Contacto: Email', 'text'],
            'contacto.label_consulta' => ['Contacto: Consulta', 'text'],
            'contacto.label_medio' => ['Contacto: pregunta de respuesta', 'text'],
            'contacto.label_whatsapp' => ['Contacto: opción WhatsApp', 'text'],
            'contacto.label_correo' => ['Contacto: opción correo', 'text'],
            'contacto.label_ambos' => ['Contacto: opción ambos', 'text'],
            'inscripcion.eyebrow' => ['Marca de inscripción', 'text'],
            'inscripcion.titulo' => ['Título de inscripción', 'text'],
            'inscripcion.intro' => ['Introducción de inscripción', 'textarea'],
            'inscripcion.nota' => ['Nota del formulario', 'text'],
            'inscripcion.boton' => ['Botón de inscripción', 'text'],
            'inscripcion.label_nombre' => ['Inscripción: Nombre', 'text'],
            'inscripcion.label_apellido' => ['Inscripción: Apellido', 'text'],
            'inscripcion.label_celular' => ['Inscripción: Celular', 'text'],
            'inscripcion.label_email' => ['Inscripción: Email', 'text'],
            'inscripcion.label_curso' => ['Inscripción: Curso', 'text'],
            'inscripcion.label_experiencia' => ['Inscripción: Experiencia', 'text'],
            'inscripcion.label_mensaje' => ['Inscripción: Comentarios', 'text'],
        ],
        'Footer / SEO' => [
            'footer.sobre_titulo' => ['Título Sobre Sirius', 'text'],
            'footer.sobre' => ['Descripción de Sirius', 'textarea'],
            'footer.sede_titulo' => ['Título de sede', 'text'],
            'footer.sede' => ['Dirección de sede', 'textarea'],
            'footer.sede_extra' => ['Texto adicional de sede', 'textarea'],
            'footer.redes_titulo' => ['Título de redes', 'text'],
            'footer.facebook' => ['Facebook', 'url'],
            'footer.youtube' => ['YouTube', 'url'],
            'footer.instagram' => ['Instagram', 'url'],
            'footer.credito' => ['Crédito del sitio', 'text'],
            'seo.titulo' => ['Título SEO', 'text'],
            'seo.descripcion' => ['Descripción SEO', 'textarea'],
        ],
    ];
}

function cms_flat_catalog(): array
{
    $flat = [];
    foreach (cms_field_catalog() as $fields) {
        $flat += $fields;
    }
    return $flat;
}
