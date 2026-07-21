(function () {
  "use strict";

  var layout = document.querySelector("[data-editor]");
  if (!layout) {
    return;
  }

  var form = document.querySelector("[data-content-form]");
  var iframe = document.querySelector("[data-preview-iframe]");
  var pageSelect = document.querySelector("[data-preview-page]");
  var deviceSelect = document.querySelector("[data-preview-device]");
  var frameContainer = document.querySelector(".admin-preview-frame");
  var refreshBtn = document.querySelector("[data-preview-refresh]");
  var openLink = document.querySelector("[data-preview-open]");
  var status = document.querySelector("[data-preview-status]");
  var csrf = layout.getAttribute("data-csrf") || "";

  var timer = null;
  var sending = false;
  var pending = false;

  function currentPage() {
    return pageSelect && pageSelect.value ? pageSelect.value : "index.php";
  }

  function frameUrl() {
    return "../preview.php?page=" + encodeURIComponent(currentPage()) + "&t=" + Date.now();
  }

  function setStatus(text) {
    if (status) {
      status.textContent = text;
    }
  }

  function reloadFrame() {
    if (iframe) {
      iframe.src = frameUrl();
    }
    if (openLink) {
      openLink.href = "../preview.php?page=" + encodeURIComponent(currentPage());
    }
  }

  function updateDevice() {
    if (!frameContainer || !deviceSelect) return;
    frameContainer.setAttribute("data-device", deviceSelect.value);
  }

  function sendDraft() {
    if (!form) {
      reloadFrame();
      return;
    }
    if (sending) {
      pending = true;
      return;
    }
    sending = true;
    setStatus("Actualizando vista…");

    var data = new FormData();
    data.append("csrf", csrf);
    var fields = form.querySelectorAll("[name^=\"content[\"]");
    fields.forEach(function (el) {
      if (el.type === "file") {
        return;
      }
      data.append(el.name, el.value);
    });

    fetch("preview_draft.php", {
      method: "POST",
      body: data,
      credentials: "same-origin"
    })
      .catch(function () {})
      .then(function () {
        sending = false;
        reloadFrame();
        setStatus("Vista actualizada");
        if (pending) {
          pending = false;
          schedule(0);
        }
      });
  }

  function schedule(delay) {
    if (timer) {
      clearTimeout(timer);
    }
    timer = setTimeout(sendDraft, delay == null ? 500 : delay);
  }

  if (form) {
    form.addEventListener("input", function () {
      schedule(500);
    });
    form.addEventListener("change", function () {
      schedule(250);
    });
  }

  if (pageSelect) {
    pageSelect.addEventListener("change", function () {
      sendDraft();
    });
  }

  if (deviceSelect) {
    deviceSelect.addEventListener("change", updateDevice);
    updateDevice();
  }

  if (refreshBtn) {
    refreshBtn.addEventListener("click", function () {
      sendDraft();
    });
  }

  reloadFrame();
  sendDraft();
})();
