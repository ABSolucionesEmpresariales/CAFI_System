$(document).ready(function () {
  //VUsuarios_ab
  let editar = false;
  let idnegocio = "";
  optenerDatosTablaUsuarios();

  $(".close").click(function () {
    $("#formulario").trigger("reset");
    $("#mensaje").css("display", "none");
  });


  $('.agregar').click(function(){
    editar = false;
  });


  $("#formulario").submit(function (e) {
    $.post("../Controllers/negocios.php",$("#formulario").serialize() + '&idnegocio=' + idnegocio + '&accion=' + editar, function (response) {
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
                <th class="text-nowrap text-center" style="width:100px;">
                <div class="row">
                    <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="Beditar btn btn-danger" href="#">
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

  $(document).on("click", ".Beditar", function () {
    var valores = "";
    // Obtenemos todos los valores contenidos en los <td> de la fila
    // seleccionada
    $(this).parents("tr").find("td").each(function () {
      valores += $(this).html() + "?";
    });
    datos = valores.split("?");
    console.log(datos);
 
    $("#nombre").val(datos[1]);
    $("#giro").val(datos[2]);
    $("#calle_numero").val(datos[3]);
    $("#colonia").val(datos[4]);
    $("#localidad").val(datos[5]);
    $("#municipio").val(datos[6]);
    $("#estado").val(datos[7]);
    $("#pais").val(datos[8]);
    $("#telefono").val(datos[9]);
    $("#impresora").val(datos[10]);
    $("#dueno").val(datos[11]);
    editar = true;
  });
});
