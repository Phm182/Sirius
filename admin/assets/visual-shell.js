(function () {
  "use strict";

  var root = document.querySelector("[data-visual-editor]");
  if (!root) return;

  var csrf = root.getAttribute("data-csrf") || "";
  var apiUrl = root.getAttribute("data-api") || "cms_api.php";
  var previewBase = root.getAttribute("data-preview-base") || "../preview.php";
  var iframe = root.querySelector("[data-visual-iframe]");
  var frame = root.querySelector("[data-visual-frame]");
  var pageSelect = root.querySelector("[data-visual-page]");
  var deviceSelect = root.querySelector("[data-visual-device]");
  var drawer = root.querySelector("[data-visual-drawer]");
  var drawerTitle = root.querySelector("[data-drawer-title]");
  var drawerBody = root.querySelector("[data-drawer-body]");
  var drawerStatus = root.querySelector("[data-drawer-status]");

  function previewUrl(page) {
    return previewBase + "?page=" + encodeURIComponent(page) + "&edit=1&t=" + Date.now();
  }

  function reloadPreview() {
    if (!iframe || !pageSelect) return;
    iframe.src = previewUrl(pageSelect.value);
  }

  function setStatus(message, isError) {
    if (!drawerStatus) return;
    if (!message) {
      drawerStatus.hidden = true;
      drawerStatus.textContent = "";
      return;
    }
    drawerStatus.hidden = false;
    drawerStatus.textContent = message;
    drawerStatus.classList.toggle("is-error", !!isError);
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.hidden = true;
    drawerBody.innerHTML = "";
    setStatus("");
  }

  function openDrawer(title, node) {
    drawerTitle.textContent = title;
    drawerBody.innerHTML = "";
    drawerBody.appendChild(node);
    drawer.hidden = false;
    setStatus("");
  }

  function prettyLabel(label) {
    if (!label || /\s/.test(label) || !/[._]/.test(label)) return label;
    return label
      .split(/[._]/)
      .filter(Boolean)
      .map(function (w) {
        return w.charAt(0).toUpperCase() + w.slice(1);
      })
      .join(" · ");
  }

  function cloneTemplate(id) {
    var tpl = document.getElementById(id);
    return tpl.content.firstElementChild.cloneNode(true);
  }

  function postForm(formData) {
    formData.append("csrf", csrf);
    return fetch(apiUrl, { method: "POST", body: formData, credentials: "same-origin" }).then(
      function (res) {
        return res.json().then(function (data) {
          if (!res.ok || !data.ok) {
            throw new Error((data && data.error) || "No se pudo guardar.");
          }
          return data;
        });
      }
    );
  }

  function bindFieldForm(form, key, type, value, label) {
    form.querySelector('[name="key"]').value = key;
    var valueInput = form.querySelector('[name="value"]');
    if (valueInput) valueInput.value = value || "";
    var preview = form.querySelector("[data-image-preview]");
    if (preview && value) {
      preview.src = "../" + value;
      preview.hidden = false;
    } else if (preview) {
      preview.hidden = true;
    }
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      setStatus("Guardando…");
      var fd = new FormData(form);
      postForm(fd)
        .then(function () {
          setStatus("Guardado.");
          reloadPreview();
          window.setTimeout(closeDrawer, 500);
        })
        .catch(function (err) {
          setStatus(err.message || "Error al guardar.", true);
        });
    });
    openDrawer(label || "Editar", form);
  }

  function openFieldEditor(detail) {
    var key = detail.key;
    var type = detail.fieldType || detail.type || "text";
    var label = detail.label || key;
    var value = detail.value || "";
    var tpl =
      type === "image"
        ? "tpl-field-image"
        : type === "textarea"
          ? "tpl-field-textarea"
          : "tpl-field-text";
    var form = cloneTemplate(tpl);
    if (type === "number" || type === "url") {
      form = cloneTemplate("tpl-field-text");
      var input = form.querySelector('[name="value"]');
      input.type = type === "number" ? "number" : type === "url" ? "url" : "text";
    }
    bindFieldForm(form, key, type, value, prettyLabel(label));
  }

  function fillCourseForm(form, course) {
    form.querySelector('[name="id"]').value = course.id || 0;
    form.querySelector('[name="nombre"]').value = course.nombre || "";
    form.querySelector('[name="slug"]').value = course.slug || "";
    form.querySelector('[name="resumen"]').value = course.resumen || "";
    form.querySelector('[name="descripcion"]').value = course.descripcion || "";
    form.querySelector('[name="inicio"]').value = course.inicio || "";
    form.querySelector('[name="duracion"]').value = course.duracion || "";
    form.querySelector('[name="modalidad"]').value = course.modalidad || "";
    form.querySelector('[name="ubicacion"]').value = course.ubicacion || "";
    form.querySelector('[name="precio"]').value = course.precio || "";
    form.querySelector('[name="orden"]').value = course.orden || 10;
    form.querySelector('[name="imagen_alt"]').value = course.imagen_alt || "";
    form.querySelector('[name="imagen_actual"]').value = course.imagen || "";
    form.querySelector('[name="activo"]').checked = String(course.activo ?? 1) !== "0";
    var preview = form.querySelector("[data-image-preview]");
    if (preview && course.imagen) {
      preview.src = "../" + course.imagen;
      preview.hidden = false;
    }
    var delBtn = form.querySelector("[data-delete-course]");
    if (delBtn && course.id) {
      delBtn.hidden = false;
      delBtn.addEventListener("click", function () {
        if (!window.confirm("¿Eliminar este curso?")) return;
        var fd = new FormData();
        fd.append("action", "delete_course");
        fd.append("id", String(course.id));
        setStatus("Eliminando…");
        postForm(fd)
          .then(function () {
            reloadPreview();
            closeDrawer();
          })
          .catch(function (err) {
            setStatus(err.message, true);
          });
      });
    }
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      setStatus("Guardando curso…");
      postForm(new FormData(form))
        .then(function () {
          setStatus("Curso guardado.");
          reloadPreview();
          window.setTimeout(closeDrawer, 500);
        })
        .catch(function (err) {
          setStatus(err.message, true);
        });
    });
  }

  function openCourseEditor(course) {
    var form = cloneTemplate("tpl-course");
    fillCourseForm(form, course || { id: 0, activo: 1, orden: 10 });
    openDrawer(course && course.id ? "Editar curso" : "Nuevo curso", form);
  }

  function openGalleryEditor(photo) {
    var form = cloneTemplate("tpl-gallery");
    form.querySelector('[name="id"]').value = photo.id || 0;
    form.querySelector('[name="titulo"]').value = photo.titulo || "";
    form.querySelector('[name="alt"]').value = photo.alt || "";
    form.querySelector('[name="orden"]').value = photo.orden || 10;
    form.querySelector('[name="archivo_actual"]').value = photo.archivo || "";
    form.querySelector('[name="activo"]').checked = String(photo.activo ?? 1) !== "0";
    var preview = form.querySelector("[data-image-preview]");
    if (preview && photo.archivo) {
      preview.src = "../" + photo.archivo;
      preview.hidden = false;
    }
    var delBtn = form.querySelector("[data-delete-gallery]");
    if (delBtn && photo.id) {
      delBtn.hidden = false;
      delBtn.addEventListener("click", function () {
        if (!window.confirm("¿Eliminar esta foto?")) return;
        var fd = new FormData();
        fd.append("action", "delete_gallery");
        fd.append("id", String(photo.id));
        postForm(fd)
          .then(function () {
            reloadPreview();
            closeDrawer();
          })
          .catch(function (err) {
            setStatus(err.message, true);
          });
      });
    }
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      setStatus("Guardando foto…");
      postForm(new FormData(form))
        .then(function () {
          reloadPreview();
          window.setTimeout(closeDrawer, 500);
        })
        .catch(function (err) {
          setStatus(err.message, true);
        });
    });
    openDrawer(photo && photo.id ? "Editar foto" : "Subir foto", form);
  }

  function openGlobals() {
    var form = cloneTemplate("tpl-globals");
    form.querySelectorAll('.admin-color-field input[type="color"]').forEach(function (input) {
      input.addEventListener("input", function () {
        var output = input.parentElement.querySelector("output");
        if (output) output.textContent = input.value.toUpperCase();
      });
    });
    form.querySelectorAll("[data-save-global]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var fieldset = btn.closest("[data-global-key]");
        var key = fieldset.getAttribute("data-global-key");
        var type = fieldset.getAttribute("data-global-type");
        var fd = new FormData();
        fd.append("action", "save_field");
        fd.append("key", key);
        if (type === "image") {
          var file = fieldset.querySelector("[data-global-file]");
          var current = fieldset.querySelector("[data-global-value]");
          fd.append("value", current ? current.value : "");
          if (file && file.files && file.files[0]) {
            fd.append("image", file.files[0]);
          }
        } else {
          fd.append("value", fieldset.querySelector("[data-global-value]").value);
        }
        setStatus("Guardando " + key + "…");
        postForm(fd)
          .then(function () {
            setStatus("Guardado.");
            reloadPreview();
          })
          .catch(function (err) {
            setStatus(err.message, true);
          });
      });
    });
    openDrawer("Diseño y ajustes", form);
  }

  // Toolbar
  if (pageSelect) {
    pageSelect.addEventListener("change", function () {
      var url = new URL(window.location.href);
      url.searchParams.set("page", pageSelect.value);
      window.history.replaceState({}, "", url.toString());
      reloadPreview();
    });
  }
  if (deviceSelect && frame) {
    deviceSelect.addEventListener("change", function () {
      frame.setAttribute("data-device", deviceSelect.value);
    });
  }
  root.querySelector("[data-visual-reload]")?.addEventListener("click", reloadPreview);
  root.addEventListener("click", function (event) {
    if (event.target.closest("[data-drawer-close]")) {
      closeDrawer();
    }
  });

  root.querySelector('[data-open-panel="globals"]')?.addEventListener("click", openGlobals);
  root.querySelector('[data-open-panel="course-new"]')?.addEventListener("click", function () {
    openCourseEditor({ id: 0, activo: 1, orden: 10 });
  });
  root.querySelector('[data-open-panel="gallery-new"]')?.addEventListener("click", function () {
    openGalleryEditor({ id: 0, activo: 1, orden: 10 });
  });

  // Messages from iframe visual editor
  window.addEventListener("message", function (event) {
    if (event.origin !== window.location.origin) return;
    var data = event.data;
    if (!data || data.source !== "sirius-cms") return;

    if (data.type === "edit-field") {
      openFieldEditor(data);
      return;
    }
    if (data.type === "new-course") {
      openCourseEditor({ id: 0, activo: 1, orden: 10 });
      return;
    }
    if (data.type === "new-gallery") {
      openGalleryEditor({ id: 0, activo: 1, orden: 10 });
      return;
    }
    if (data.type === "edit-course") {
      var fd = new FormData();
      fd.append("action", "get_course");
      fd.append("id", String(data.id));
      postForm(fd)
        .then(function (res) {
          openCourseEditor(res.course);
        })
        .catch(function (err) {
          window.alert(err.message);
        });
      return;
    }
    if (data.type === "edit-gallery") {
      var fdg = new FormData();
      fdg.append("action", "get_gallery");
      fdg.append("id", String(data.id));
      postForm(fdg)
        .then(function (res) {
          openGalleryEditor(res.photo);
        })
        .catch(function (err) {
          window.alert(err.message);
        });
    }
  });
})();
