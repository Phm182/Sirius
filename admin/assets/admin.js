document.addEventListener("DOMContentLoaded", function () {
  var button = document.querySelector("[data-menu-toggle]");
  var nav = document.querySelector("[data-admin-nav]");

  if (button && nav) {
    function setMenu(open) {
      nav.classList.toggle("is-open", open);
      button.setAttribute("aria-expanded", open ? "true" : "false");
      button.setAttribute("aria-label", open ? "Cerrar menú" : "Abrir menú");
    }

    button.addEventListener("click", function () {
      setMenu(!nav.classList.contains("is-open"));
    });

    nav.addEventListener("click", function (event) {
      if (event.target.closest("a")) setMenu(false);
    });

    document.addEventListener("click", function (event) {
      if (!nav.contains(event.target) && !button.contains(event.target)) setMenu(false);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && nav.classList.contains("is-open")) {
        setMenu(false);
        button.focus();
      }
    });
  }

  document.querySelectorAll("[data-confirm]").forEach(function (form) {
    form.addEventListener("submit", function (event) {
      var message = form.getAttribute("data-confirm") || "¿Confirmás esta acción?";
      if (!window.confirm(message)) {
        event.preventDefault();
      }
    });
  });
});
