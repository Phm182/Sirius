(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var mapEl = document.getElementById("mapa");
    if (!mapEl || typeof L === "undefined") return;

    // Sede Náutica — Costanera Norte (CABA). Coordenada aproximada; se ajusta con la dirección exacta.
    var sede = [-34.5584, -58.4112];
    var configuredZoom = parseInt(mapEl.dataset.zoom || "15", 10);
    var zoom = Math.min(19, Math.max(10, configuredZoom || 15));

    var map = L.map("mapa", {
      scrollWheelZoom: false,
      zoomControl: false,
    }).setView(sede, zoom);

    L.control.zoom({ position: "bottomright" }).addTo(map);

    L.tileLayer("https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png", {
      attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/">CARTO</a>',
      subdomains: "abcd",
      maxZoom: 19,
    }).addTo(map);

    var pinHtml =
      '<div class="sirius-pin"><span class="sirius-pin__dot"></span><span class="sirius-pin__pulse"></span></div>';

    var icon = L.divIcon({
      className: "sirius-marker",
      html: pinHtml,
      iconSize: [28, 28],
      iconAnchor: [14, 14],
      popupAnchor: [0, -16],
    });

    L.marker(sede, { icon: icon })
      .addTo(map)
      .bindPopup(
        "<strong>Sirius · Escuela Náutica</strong><br>Sede Náutica · Costanera Norte<br><small>Buenos Aires</small>",
        { className: "sirius-popup" }
      )
      .openPopup();

    mapEl.addEventListener("mouseenter", function () {
      map.scrollWheelZoom.enable();
    });
    mapEl.addEventListener("mouseleave", function () {
      map.scrollWheelZoom.disable();
    });

    var resizeTimer;
    window.addEventListener("resize", function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(function () {
        map.invalidateSize();
      }, 150);
    });

    window.setTimeout(function () {
      map.invalidateSize();
    }, 250);
  });
})();
