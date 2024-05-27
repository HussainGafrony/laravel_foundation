$(document).ready(function () {
  $("#alert")
    .delay(2500)
    .fadeTo(500, 0, function () {
      $(this).slideUp(500, function () {
        $(this).remove();
      });
    });
});

const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");
if (togglePassword && password) {
  togglePassword.addEventListener("click", function () {
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    togglePassword.classList.toggle("bi-eye");
  });
}
/**
 * Easy selector helper function
 */
const select = (el, all = false) => {
  el = el.trim();
  if (all) {
    return [...document.querySelectorAll(el)];
  } else {
    return document.querySelector(el);
  }
};

/**
 * Easy event listener function
 */
const on = (type, el, listener, all = false) => {
  if (all) {
    select(el, all).forEach((e) => e.addEventListener(type, listener));
  } else {
    select(el, all).addEventListener(type, listener);
  }
};

/**
 * Sidebar toggle
 */
if (select(".toggle-sidebar-btn")) {
  on("click", ".toggle-sidebar-btn", function (e) {
    select("body").classList.toggle("toggle-sidebar");
  });
}

/**
 * Search bar toggle
 */
if (select(".search-bar-toggle")) {
  on("click", ".search-bar-toggle", function (e) {
    select(".search-bar").classList.toggle("search-bar-show");
  });
}
