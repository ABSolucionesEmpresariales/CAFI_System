$(document).ready(function () {
editar = false;
console.log("entro al js");
/* $.ajax({
  url: "../Controllers/generador.php",
  type: "GET",

  success: function (response) {
    console.log(response);
    let datos =JSON.parse(response);
    $.each(datos, function(i, item) {

    });
      $("#").val(datos[1]);
  }
  }); */

  $("#formulario").submit(function (e) {
    var formData = new FormData(this);
    
    $.ajax({
      url: "../Controllers/productos.php",
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      
      success: function(response) {
          console.log("Respuesta: "+response);
         
      }
  });
e.preventDefault();
  });
});
