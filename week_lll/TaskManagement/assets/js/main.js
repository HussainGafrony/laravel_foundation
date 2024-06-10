$(document).ready(function () {
  $("#myTable").DataTable();
  $("#alert")
    .delay(2500)
    .fadeTo(500, 0, function () {
      $(this).slideUp(500, function () {
        $(this).remove();
      });
    });

  $("#togglePassword").click(function () {
    var type = $("#password").prop("type") === "password" ? "text" : "password";
    $("#password").prop("type", type);
    $(this).toggleClass("bi-eye");
  });

  const select = (el, all = false) => {
    el = el.trim();
    if (all) {
      return [...document.querySelectorAll(el)];
    } else {
      return document.querySelector(el);
    }
  };

  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach((e) => e.addEventListener(type, listener));
    } else {
      select(el, all).addEventListener(type, listener);
    }
  };

  if (select(".toggle-sidebar-btn")) {
    on("click", ".toggle-sidebar-btn", function (e) {
      select("body").classList.toggle("toggle-sidebar");
    });
  }

  if (select(".search-bar-toggle")) {
    on("click", ".search-bar-toggle", function (e) {
      select(".search-bar").classList.toggle("search-bar-show");
    });
  }
});
