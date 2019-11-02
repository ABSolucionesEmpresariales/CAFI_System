$(document).ready(function () {
    //VUsuarios_ab
    let editar = false;
    let idusuario = "";
    obtenerDatosTablaUsuarios();

    $(".close").click(function () {
      $("#formulario").trigger("reset");
      $("#mensaje").css("display", "none");
    });


    $('.agregar').click(function(){
      editar = false;
    });

    $("#login").keyup(function () {
      var username = $("#email").val();
      if (username.length >= 7) {
        $(".contro").show();
        $.post("username_check.php", {
          username2: username
        }, function (data, status) {
          $("#status").html(data);
        });
      } else {
        $(".contro").hide();
      }
    });

    $("#formulario").submit(function (e) {
      $.post("../Controllers/clienteab.php",$("#formulario").serialize() + '&accion=' + editar, function (response) {
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
      
      e.preventDefault();
    });

    function obtenerDatosTablaUsuarios() {
      $.ajax({
        url: "../Controllers/clienteab.php",
        type: "POST",
        data: "tabla=tabla",

        success: function (response) {
          console.log(response);
          let datos = JSON.parse(response);
          let template = "";
          $.each(datos, function (i, item) {
            template += `
            <tr>
                  <td class="text-nowrap text-center">${item[0]}</td>
                  <td class="text-nowrap text-center">${item[1]}</td>
                  <td class="text-nowrap text-center">${item[2]}</td>
                  <td class="text-nowrap text-center">${item[3]}</td>
                  <td class="text-nowrap text-center">${item[4]}</td>
                  <td class="text-nowrap text-center">${item[5]}</td>
                  <td class="text-nowrap text-center">${item[6]}</td>
                  <td class="text-nowrap text-center">${item[7]}</td>
                  <td class="text-nowrap text-center">${item[8]}</td>
                  <td class="text-nowrap text-center">${item[9]}</td>
                  <td class="text-nowrap text-center">${item[10]}</td>
                  <td class="text-nowrap text-center">${item[11]}</td>
                  <td class="text-nowrap text-center">${item[12]}</td>
                  <td class="text-nowrap text-center">${item[13]}</td>
                  <td class="text-nowrap text-center d-none">${item[14]}</td>

            `;
          });
          $("#cuerpo").html(template);
        }
      });
    }

    var touchtime = 0;
    $(document).on("click", "td", function () {
        if (touchtime == 0) {
          touchtime = new Date().getTime();
        } else {
          // compare first click to this click and see if they occurred within double click threshold
          if (new Date().getTime() - touchtime < 800) {
            // double click occurred
            var valores = "";
            $(this).parents("tr").find("td").each(function () {
              valores += $(this).html() + "?";
            });
            datos = valores.split("?");
            console.log(datos);
            $("#email").val(datos[0]);
            $("#rfc").val(datos[1]);
            $("#nombre").val(datos[2]);
            $("#cp").val(datos[3]);
            $("#calle_numero").val(datos[4]);
            $("#colonia").val(datos[5]);
            $("#localidad").val(datos[6]);
            $("#municipio").val(datos[7]);
            $("#estado").val(datos[8]);
            $("#pais").val(datos[9]);
            $("#telefono").val(datos[10]);
            $("#fecha_nacimiento").val(datos[11]);
            $("#sexo").val(datos[12]);
            $("#entrada_sistema").val(datos[13]);
            $("#contrasena").val(datos[14]);
            editar = true;
            $("#modalForm").modal("show");
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 

 
  });
