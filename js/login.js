$(document).ready(function () {

  $('.mostrar').css('display','none');

  $('Snegocios').on('change',function(){
    if ($(this).val() != '') {
      $.post("../Controllers/login.php","negocio="+ $(this).val(),function(response){
        window.location.replace('');
      });
    }
  });

  $("#formulario").submit(function (e) {
    $.post("../Controllers/login.php",$("#formulario").serialize(), function (response) {
      let datos = JSON.parse(response);
      console.log(datos[0][1]);
      if(typeof(datos[0][3]) != "undefined"){
         console.log('existe');
      }

      $("#mensaje").css("display", "block");
        if (response != "[]") {
          let datos = JSON.parse(response);
          $.each(datos, function (i, item) {
              if (typeof (item[3]) != 'undefined' ) {
                if (item[2]=='A') {
                  if (item[1] == 'CEO' && item[3] == 'null'){
                    $('.ocultar').hide();
                    $('.mostrar').show();
                      var negocio= $(this).val();
                      $.post("../Controllers/login.php","combo=combo",function (response) {
                        let datos =JSON.parse(response);
                        var template='';
                        $.each(datos, function(i, item) {
                          template += `
                          <option value="${item[0]}">${item[1]}</option>
                          `;
                        });
                        $('#Snegocios').html(template);
                      });
                  }else{
                    console.log('Trabajador');
                  }
                }else{
                  $("#mensaje").text("Usuario inactivo");
                  $("#mensaje").css("color", "red");
                }

              }else{
                window.location.replace('usuariosab.html')
                  console.log('Usuario AB');
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
