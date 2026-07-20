(function ($) {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var header = document.getElementById("site-header");
    var hamburger = document.querySelector(".material-design-hamburger__icon");

    function updateHeader() {
      if (!header) return;
      if (window.scrollY > 40) {
        header.classList.add("is-scrolled");
      } else {
        header.classList.remove("is-scrolled");
      }
    }

    updateHeader();
    window.addEventListener("scroll", updateHeader, { passive: true });

    if (hamburger) {
      hamburger.addEventListener("click", function () {
        var child;
        document.body.classList.toggle("background--blur");
        this.parentNode.nextElementSibling.classList.toggle("menu--on");

        child = this.childNodes[1].classList;

        if (child.contains("material-design-hamburger__icon--to-arrow")) {
          child.remove("material-design-hamburger__icon--to-arrow");
          child.add("material-design-hamburger__icon--from-arrow");
          $(".sirius").removeClass("tit-position");
        } else {
          child.remove("material-design-hamburger__icon--from-arrow");
          child.add("material-design-hamburger__icon--to-arrow");
          $(".sirius").addClass("tit-position");
        }
      });
    }

    // Reveal suave en galería
    var galleryItems = document.querySelectorAll(".galeria-item");
    if (galleryItems.length && "IntersectionObserver" in window) {
      var observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.15 }
      );
      galleryItems.forEach(function (item) {
        observer.observe(item);
      });
    } else {
      galleryItems.forEach(function (item) {
        item.classList.add("is-visible");
      });
    }

    // Lightbox: tamaño estable y transición más corta al pasar de imagen
    if (typeof lightbox !== "undefined") {
      lightbox.option({
        fadeDuration: 150,
        imageFadeDuration: 150,
        resizeDuration: 120,
        wrapAround: true,
        fitImagesInViewport: true,
        positionFromTop: 40,
      });
    }
  });
})(jQuery);
