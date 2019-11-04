$(document).ready(function () {
  //VUsuarios_ab
  let editar = false;
  let idnegocio = "";
  obtenerDuenos();
  obtenerDatosTablaUsuarios();

  $(".close").click(function () {
    $("#formulario").trigger("reset");
    $("#mensaje").css("display", "none");
  });


  $('.agregar').click(function(){
    editar = false;
  });

  function obtenerDuenos(){
    $.ajax({
      url: "../Controllers/negocio.php",
      type: "POST",
      data: "combo=combo",

      success: function (response) {
        console.log(response);
        let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          template += `
          <option>${item[0]}<option>
          `;
        });
        $("#clientes").html(template);
    }
  });
  }

  $("#formulario").submit(function (e) {
    $.post("../Controllers/negocio.php",$("#formulario").serialize() + '&idnegocios=' + idnegocio + '&accion=' + editar, function (response) {
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
      url: "../Controllers/negocio.php",
      type: "POST",
      data: "tabla=tabla",
      success: function (response) {
        console.log(response);
       let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          for(var y = 0; y < 12; y++){
            template += `
            <tr>
                  <td class="text-nowrap text-center d-none">${item[y]}</td>`;
          }
          /* template += `
          <tr>
                <td class="text-nowrap text-center d-none">${item[0]}</td>
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
                <td class="text-nowrap text-center">${item[11]}</td>`;
                if(item[12] == null){
                  template += `<td class="text-nowrap text-center"></td>
                  '<th class="text-nowrap text-center" style="width:100px;">
                  <div class="row">
                      <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="Beditar btn btn-danger" href="#">
                        Editar
                      </a>
                  </div>
                  </th>`;
                }else{
                  template += `<td class="text-nowrap text-center">${item[12]}</td>
                  '<th class="text-nowrap text-center" style="width:100px;">
                  <div class="row">
                      <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="Beditar btn btn-danger" href="#">
                        Editar
                      </a>
                  </div>
                  </th>`; 
                }*/

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
    idnegocio = datos[0];
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
