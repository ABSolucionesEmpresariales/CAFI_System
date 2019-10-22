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
  
  $("#formulario").submit(function (e) {

    $.post("../Controllers/productos.php",$("#formulario").serialize(), function (response) {
      console.log(response);
      $("#mensaje").css("display", "block");
      if (response == "1") {
        if(editar == true){
          $('.modal').modal('hide');
          $("#mensaje").css("display", "none");
        }
        $("#mensaje").text("Registro Exitoso");
        $("#mensaje").css("color", "green");
        $("#email").focus();
        $("#formulario").trigger("reset");
      } else {
        $("#mensaje").text("Registro fallido");
        $("#mensaje").css("color", "red");
        $("#email").focus();
      }

      obtenerDatosTablaUsuarios();
    });
});
