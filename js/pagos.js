$(document).ready(function () {
  
    idpago = "";
  
    obtenerDatosTablaUsuarios();
  
    $("#formulario").submit(function (e) {
      $.post("../Controllers/cpp.php",$("#formulario").serialize() + "&idpago=" + idpago, function (response) {
        if (response == "1") {
          $('.modal').modal('hide');
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
        url: "../Controllers/cpp.php",
        type: "POST",
        data: "tabla_abonos_compras=tabla_abonos_compras",
        success: function (response) {
         let datos = JSON.parse(response);
          let template = "";
          $.each(datos, function (i, item) {
            template += `
            <tr>
                  <td class="text-nowrap text-center">${item[0]}</td>
                  <td class="text-nowrap text-center">${item[1]}</td>
                  <td class="text-nowrap text-center font-weight-bold">${item[2]}</td>
                  <td class="text-nowrap text-center text-success font-weight-bold">$${item[3]}</td>
                  <td class="text-nowrap text-center">${item[4]}</td>
                  <td class="text-nowrap text-center">${item[5]}</td>
                  <td class="text-nowrap text-center">${item[6]}</td>
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
          if (new Date().getTime() - touchtime < 300) {
            // double click occurred
            var valores = "";
            // Obtenemos todos los valores contenidos en los <td> de la fila
            // seleccionada
            $(this).parents("tr").find("td").each(function () {
              valores += $(this).html() + "?";
            });
            datos = valores.split("?");
  
            idpago = datos[0];
            console.log(idpago);
            $("#estado").val(datos[1]);
            $("#modalForm").modal("show");
  
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 
  
  });
  