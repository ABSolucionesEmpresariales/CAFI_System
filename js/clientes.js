$(document).ready(function () {
    //VUsuarios_ab
    let editar = false;
    let idusuario = "";
    optenerDatosTablaUsuarios();

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
          $("#mensaje").text(response);
          $("#mensaje").css("color", "green");
          $("#email").focus();
          $("#formulario").trigger("reset");
        } else {
          $("#mensaje").text(response);
          $("#mensaje").css("color", "red");
          $("#email").focus();
        }
      });
      e.preventDefault();
    });

    function optenerDatosTablaUsuarios() {
      $.ajax({
        url: "../Controllers/clienteab.php",
        type: "POST",
        data: "tabla=tabla",
        success: function (response) {

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
                  <td class="text-nowrap text-center">${item[14]}</td>
                  <td class="text-nowrap text-center">${item[15]}</td>
                  <td class="text-nowrap text-center">${item[16]}</td>
                  <th class="text-nowrap text-center" style="width:100px;">
                  <div class="row">
                      <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="BeditarUsuarios btn btn-danger" href="#">
                        Editar
                      </a>
                  </div>
                  </th>
            `;
          });
          $("#cuerpo").html(template);
        }
      });
    }

    $(document).on("click", ".BeditarUsuarios", function () {
      var valores = "";
      // Obtenemos todos los valores contenidos en los <td> de la fila
      // seleccionada
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
      $("#acceso").val(datos[13]);
      $("#entrada_sistema").val(datos[14]);
      $("#contrasena").val(datos[15]);
      $("#negocio").val(datos[16]);
      editar = true;
    });
  });
