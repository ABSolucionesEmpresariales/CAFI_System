$(document).ready(function () {

  $('#Snegocios').on('change',function(){
    
    if ($(this).val() != '') {
      $.ajax({
        url: "../Controllers/login.php",
        type: "POST",
        data: "negocio=" + $(this).val(),

        success: function (response) {
        console.log(response);
        window.location.replace('ventas.php');
        }
      });
    }
  });

  $("#formulario").submit(function (e) {
    $.post("../Controllers/login.php",$("#formulario").serialize(), function (response) {
      console.log(response);
      $("#mensaje").css("display", "block");
        if (response != "[]") {
          let datos = JSON.parse(response);
          $.each(datos, function (i, item) {
              if (typeof (item[3]) != 'undefined' ) {
                if (item[2]=='A') {
                  if (item[1] == 'CEO' && item[3] == null){
                    $('.ocultar').hide();
                    $('.mostrar').show();

                    $.ajax({
                      url: "../Controllers/login.php",
                      type: "POST",
                      data: "combo=combo",

                      success: function (response) {
                        console.log(response);
                        let datos =JSON.parse(response);
                        var template='<option value="">Elegir Sucursal</option>';
                        $.each(datos, function(i, item) {
                          template += `
                          <option value="${item[0]}">${item[1]}</option>
                          `;
                        });
                        $('#Snegocios').html(template);
                      }
                      });
                  }else{
                    window.location.replace('ventas.php');
                  }
                }else{
                  $("#mensaje").text("Usuario inactivo");
                  $("#mensaje").css("color", "red");
                }

              }else{
                if (item[2]=='A') {
                  window.location.replace('usuariosab.php');
                }else{
                  $("#mensaje").text("Usuario inactivo");
                  $("#mensaje").css("color", "red");
                }
                  
              }
          });
        }else{
          $("#mensaje").text("Usuario incorrecto");
          $("#mensaje").css("color", "red");
        }
    });
      e.preventDefault();
      });
  });
