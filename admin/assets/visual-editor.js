(function () {
  "use strict";

  if (!document.body.classList.contains("cms-edit-mode")) return;

  var LABEL_FALLBACK = {
    "site.logo": "Logo",
    "site.fondo": "Fondo del sitio",
    "inicio.presentacion_imagen": "Imagen de presentación",
    "inicio.inscripcion_imagen": "Imagen de inscripción",
    "quienes.imagen": "Imagen principal",
  };

  function labelFor(el) {
    return (
      el.getAttribute("data-cms-label") ||
      LABEL_FALLBACK[el.getAttribute("data-cms-key")] ||
      el.getAttribute("data-cms-key") ||
      "Editar"
    );
  }

  function textValue(el) {
    var type = el.getAttribute("data-cms-type") || "text";
    if (type === "url" && el.tagName === "A") {
      return el.getAttribute("href") || "";
    }
    if (type === "number" && el.hasAttribute("data-zoom")) {
      return el.getAttribute("data-zoom") || "";
    }
    if (el.tagName === "INPUT" || el.tagName === "TEXTAREA" || el.tagName === "BUTTON") {
      return el.value || "";
    }
    return (el.innerText || el.textContent || "").replace(/\u00a0/g, " ").trim();
  }

  function imageValue(el) {
    var raw = el.getAttribute("data-cms-src");
    if (raw) return raw;
    if (el.tagName === "IMG") {
      var src = el.getAttribute("src") || "";
      try {
        var path = new URL(src, window.location.href).pathname;
        var marker = path.indexOf("/uploads/");
        if (marker === -1) marker = path.indexOf("/img");
        if (marker !== -1) return path.slice(marker + 1);
        return src.replace(/^\//, "");
      } catch (e) {
        return src;
      }
    }
    return "";
  }

  function postToParent(payload) {
    window.parent.postMessage(
      Object.assign({ source: "sirius-cms" }, payload),
      window.location.origin
    );
  }

  function handleEdit(el) {
    if (el.hasAttribute("data-cms-entity")) {
      var entity = el.getAttribute("data-cms-entity");
      var id = el.getAttribute("data-cms-id");
      if (entity === "curso") {
        postToParent({ type: "edit-course", id: id });
      } else if (entity === "gallery") {
        postToParent({ type: "edit-gallery", id: id });
      }
      return;
    }
    var fieldType = el.getAttribute("data-cms-type") || "text";
    var value = fieldType === "image" ? imageValue(el) : textValue(el);
    postToParent({
      type: "edit-field",
      key: el.getAttribute("data-cms-key"),
      fieldType: fieldType,
      value: value,
      label: labelFor(el),
    });
  }

  function decorate(el) {
    if (el === document.body) return;
    if (el.getAttribute("data-cms-decorated")) return;
    el.setAttribute("data-cms-decorated", "1");
    el.classList.add("cms-editable");
    el.setAttribute("title", "Tocá para editar " + labelFor(el));
  }

  document
    .querySelectorAll("[data-cms-key], [data-cms-entity]")
    .forEach(decorate);

  // Un toque sobre el contenido abre su editor. No se insertan botones dentro
  // del sitio, por lo que tipografías, colores y espaciados quedan intactos.
  document.body.addEventListener(
    "click",
    function (event) {
      var action = event.target.closest("[data-cms-action]");
      if (action) {
        event.preventDefault();
        event.stopPropagation();
        postToParent({ type: action.getAttribute("data-cms-action") });
        return;
      }

      var editable = event.target.closest("[data-cms-key], [data-cms-entity]");
      if (editable && editable !== document.body) {
        event.preventDefault();
        event.stopPropagation();
        handleEdit(editable);
        return;
      }

      var link = event.target.closest("a");
      if (link) {
        event.preventDefault();
        event.stopPropagation();
      }
    },
    true
  );
  document.body.addEventListener(
    "submit",
    function (event) {
      event.preventDefault();
      event.stopPropagation();
    },
    true
  );

  var controls = document.createElement("div");
  controls.className = "cms-editor-controls";
  controls.setAttribute("aria-label", "Acciones del editor");

  if (document.querySelector("[data-course-slider]")) {
    var courseButton = document.createElement("button");
    courseButton.type = "button";
    courseButton.className = "cms-editor-add";
    courseButton.setAttribute("data-cms-action", "new-course");
    courseButton.textContent = "+ Agregar curso";
    controls.appendChild(courseButton);
  }

  if (document.querySelector("[data-gallery-slider]")) {
    var galleryButton = document.createElement("button");
    galleryButton.type = "button";
    galleryButton.className = "cms-editor-add";
    galleryButton.setAttribute("data-cms-action", "new-gallery");
    galleryButton.textContent = "+ Agregar imagen";
    controls.appendChild(galleryButton);
  }

  if (controls.children.length) {
    document.body.appendChild(controls);
  }
})();
