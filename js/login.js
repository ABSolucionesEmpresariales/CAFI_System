$(document).ready(function () {
  $("#formulario").submit(function (e) {

    $.post("../Controllers/login.php",$("#formulario").serialize(), function (response) {
      let datos = JSON.parse(response);
      console.log(datos[0][1]);
      if(typeof(datos[0][3]) != "undefined"){
         console.log('existe');
      }

      $("#mensaje").css("display", "block");
      if (response == "1") {
        document.location.replace='login.html';
        $("#formulario").trigger("reset");
      } else {
        $("#mensaje").text("Usuario incorrecto");
        $("#mensaje").css("color", "red");
      }
    });

    e.preventDefault();
  });
  });
