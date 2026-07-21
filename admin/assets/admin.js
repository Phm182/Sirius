document.addEventListener("DOMContentLoaded", function () {
  var button = document.querySelector("[data-menu-toggle]");
  var nav = document.querySelector("[data-admin-nav]");

  if (button && nav) {
    button.addEventListener("click", function () {
      nav.classList.toggle("is-open");
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
