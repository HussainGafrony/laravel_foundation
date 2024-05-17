$(document).ready(function () {
  $("#alert")
    .delay(2500)
    .fadeTo(500, 0, function () {
      $(this).slideUp(500, function () {
        $(this).remove();
      });
    });

  var newUrl = window.location.href.split("?")[0];
  window.history.replaceState(null, null, newUrl);
});
