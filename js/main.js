(function ($) {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var header = document.getElementById("site-header");
    var hamburger = document.querySelector(".material-design-hamburger__icon");
    var mobileMenu = document.getElementById("menu-mobile-panel");

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

    if (hamburger && mobileMenu) {
      var hamburgerLayer = hamburger.querySelector(".material-design-hamburger__layer");

      function setMobileMenu(open) {
        mobileMenu.classList.toggle("menu--on", open);
        document.body.classList.toggle("background--blur", open);
        document.body.classList.toggle("menu-open", open);
        hamburger.setAttribute("aria-expanded", open ? "true" : "false");
        hamburger.setAttribute("aria-label", open ? "Cerrar menú" : "Abrir menú");
        mobileMenu.setAttribute("aria-hidden", open ? "false" : "true");
        if (hamburgerLayer) {
          hamburgerLayer.classList.toggle("material-design-hamburger__icon--to-arrow", open);
          hamburgerLayer.classList.toggle("material-design-hamburger__icon--from-arrow", !open);
        }
      }

      hamburger.addEventListener("click", function () {
        setMobileMenu(!mobileMenu.classList.contains("menu--on"));
      });

      mobileMenu.addEventListener("click", function (event) {
        if (event.target.closest("a")) setMobileMenu(false);
      });

      document.addEventListener("click", function (event) {
        if (
          mobileMenu.classList.contains("menu--on") &&
          !mobileMenu.contains(event.target) &&
          !hamburger.contains(event.target)
        ) {
          setMobileMenu(false);
        }
      });

      document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && mobileMenu.classList.contains("menu--on")) {
          setMobileMenu(false);
          hamburger.focus();
        }
      });

      window.addEventListener("resize", function () {
        if (window.innerWidth > 770) setMobileMenu(false);
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

    // Carrusel mobile de galería: muestra la posición actual y permite
    // recorrerlo también con las flechas del teclado.
    document.querySelectorAll("[data-gallery-slider]").forEach(function (slider) {
      var items = Array.prototype.slice.call(
        slider.querySelectorAll(".galeria-item")
      );
      var counter = document.querySelector("[data-gallery-counter]");
      var counterFrame = null;

      function currentGalleryIndex() {
        var sliderCenter = slider.scrollLeft + slider.clientWidth / 2;
        var nearestIndex = 0;
        var nearestDistance = Infinity;

        items.forEach(function (item, index) {
          var itemCenter = item.offsetLeft + item.offsetWidth / 2;
          var distance = Math.abs(itemCenter - sliderCenter);
          if (distance < nearestDistance) {
            nearestDistance = distance;
            nearestIndex = index;
          }
        });

        return nearestIndex;
      }

      function updateGalleryCounter() {
        counterFrame = null;
        if (counter && items.length) {
          counter.textContent = currentGalleryIndex() + 1 + " / " + items.length;
        }
      }

      slider.addEventListener(
        "scroll",
        function () {
          if (counterFrame === null) {
            counterFrame = window.requestAnimationFrame(updateGalleryCounter);
          }
        },
        { passive: true }
      );

      slider.addEventListener("keydown", function (event) {
        if (event.key !== "ArrowLeft" && event.key !== "ArrowRight") return;
        event.preventDefault();
        var direction = event.key === "ArrowRight" ? 1 : -1;
        var nextIndex = Math.max(
          0,
          Math.min(items.length - 1, currentGalleryIndex() + direction)
        );
        items[nextIndex].scrollIntoView({
          behavior: "smooth",
          block: "nearest",
          inline: "start",
        });
      });

      updateGalleryCounter();
    });

    // Rueda del mouse -> scroll horizontal en los carruseles (cursos y galería).
    // Solo actúa cuando el carrusel realmente desborda (layout mobile) y libera
    // el scroll de la página al llegar a los extremos para no atraparlo.
    document
      .querySelectorAll("[data-course-slider], [data-gallery-slider]")
      .forEach(function (slider) {
        slider.addEventListener(
          "wheel",
          function (event) {
            var maxScroll = slider.scrollWidth - slider.clientWidth;
            if (maxScroll <= 1) return;

            var delta =
              Math.abs(event.deltaY) >= Math.abs(event.deltaX)
                ? event.deltaY
                : event.deltaX;
            if (event.deltaMode === 1) delta *= 16;
            if (!delta) return;

            var atStart = slider.scrollLeft <= 0;
            var atEnd = slider.scrollLeft >= maxScroll - 1;
            if ((delta < 0 && atStart) || (delta > 0 && atEnd)) return;

            event.preventDefault();
            slider.scrollLeft += delta;
          },
          { passive: false }
        );
      });

    // Lightbox: tamaño estable y transición más corta al pasar de imagen
    if (typeof lightbox !== "undefined") {
      lightbox.option({
        fadeDuration: 150,
        imageFadeDuration: 150,
        resizeDuration: 120,
        wrapAround: true,
        fitImagesInViewport: true,
        positionFromTop: window.innerWidth <= 520 ? 12 : 40,
      });
    }

    // Carruseles (cursos y galería): decide el eje del gesto para no bloquear
    // el scroll vertical de la página cuando el ítem queda a mitad de camino.
    document
      .querySelectorAll("[data-course-slider], [data-gallery-slider]")
      .forEach(function (slider) {
      var startX = 0;
      var startY = 0;
      var lastY = 0;
      var axis = null;

      slider.addEventListener(
        "touchstart",
        function (event) {
          var touch = event.touches[0];
          startX = touch.clientX;
          startY = touch.clientY;
          lastY = touch.clientY;
          axis = null;
        },
        { passive: true }
      );

      slider.addEventListener(
        "touchmove",
        function (event) {
          var touch = event.touches[0];

          if (axis === null) {
            var dx = Math.abs(touch.clientX - startX);
            var dy = Math.abs(touch.clientY - startY);
            if (dx < 6 && dy < 6) {
              return;
            }
            axis = dx > dy ? "x" : "y";
          }

          if (axis === "y") {
            // Evita que el carrusel capture el gesto y movemos la página.
            event.preventDefault();
            window.scrollBy(0, lastY - touch.clientY);
            lastY = touch.clientY;
          }
        },
        { passive: false }
      );

      slider.addEventListener("touchend", function () {
        axis = null;
      });
    });

    // Lightbox: swipe táctil y arrastre con mouse para cambiar de imagen.
    // El HTML del lightbox se crea recién al abrir la primera imagen, por eso
    // usamos delegación en document y resolvemos el contenedor en cada evento.
    if (typeof lightbox !== "undefined") {
      var lbContainer = null;
      var lbImage = null;
      var dragPointerId = null;
      var dragStartX = 0;
      var dragStartY = 0;
      var dragX = 0;
      var dragAxis = null;
      var suppressDragClick = false;

      function resetLightboxDrag() {
        if (lbContainer) lbContainer.classList.remove("is-dragging");
        if (lbImage) {
          lbImage.style.transform = "";
          lbImage.style.opacity = "";
        }
        dragPointerId = null;
        dragAxis = null;
        dragX = 0;
      }

      document.addEventListener("pointerdown", function (event) {
        var container = event.target.closest && event.target.closest(".lb-container");
        if (!container) return;
        if (event.pointerType === "mouse" && event.button !== 0) return;
        if (!lightbox.album || lightbox.album.length < 2) return;

        lbContainer = container;
        lbImage = container.querySelector(".lb-image");
        dragPointerId = event.pointerId;
        dragStartX = event.clientX;
        dragStartY = event.clientY;
        dragX = 0;
        dragAxis = null;
        try {
          container.setPointerCapture(event.pointerId);
        } catch (e) {}
      });

      document.addEventListener("pointermove", function (event) {
        if (event.pointerId !== dragPointerId || !lbContainer) return;

        var dx = event.clientX - dragStartX;
        var dy = event.clientY - dragStartY;

        if (dragAxis === null) {
          if (Math.abs(dx) < 8 && Math.abs(dy) < 8) return;
          dragAxis = Math.abs(dx) > Math.abs(dy) ? "x" : "y";
        }
        if (dragAxis !== "x") return;

        event.preventDefault();
        dragX = dx;
        lbContainer.classList.add("is-dragging");
        if (lbImage) {
          lbImage.style.transform = "translateX(" + dx + "px)";
          lbImage.style.opacity = String(Math.max(0.45, 1 - Math.abs(dx) / 500));
        }
      });

      function finishLightboxDrag(event) {
        if (event.pointerId !== dragPointerId || !lbContainer) return;

        var threshold = Math.min(90, Math.max(45, lbContainer.clientWidth * 0.12));
        var shouldChange = dragAxis === "x" && Math.abs(dragX) >= threshold;
        var direction = dragX < 0 ? 1 : -1;

        if (shouldChange) {
          suppressDragClick = true;
          window.setTimeout(function () {
            suppressDragClick = false;
          }, 400);
          var nextIndex = lightbox.currentImageIndex + direction;
          if (nextIndex < 0) nextIndex = lightbox.album.length - 1;
          if (nextIndex >= lightbox.album.length) nextIndex = 0;
          lightbox.changeImage(nextIndex);
        }

        resetLightboxDrag();
      }

      document.addEventListener("pointerup", finishLightboxDrag);
      document.addEventListener("pointercancel", resetLightboxDrag);

      document.addEventListener(
        "click",
        function (event) {
          if (!suppressDragClick) return;
          if (!event.target.closest || !event.target.closest(".lb-container")) return;
          event.preventDefault();
          event.stopImmediatePropagation();
          suppressDragClick = false;
        },
        true
      );
    }
  });
})(jQuery);
