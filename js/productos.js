$(document).ready(function () {
$.ajax({
  url: "../Controllers/generador.php",
  type: "GET",

  success: function (response) {
    console.log(response);
    let datos =JSON.parse(response);
    $.each(datos, function(i, item) {

    });
      $("#").val(datos[1]);
  }
  });
});
