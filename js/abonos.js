$(document).ready(function () {

  idabono = "";

  obtenerDatosTablaUsuarios();

  $("#formulario").submit(function (e) {
    $.post("../Controllers/consultasadeudos.php",$("#formulario").serialize() + "&idabono=" + idabono, function (response) {
      console.log(response);
      if (response == "1") {
        swal({
          title: 'Exito',
          text: 'Registro exitoso!',
          type: 'success'
      },function (isConfirm){
        if(isConfirm){
            $('#formulario').trigger('reset');
            $('.modal').modal('hide');
            obtenerDatosTablaUsuarios();
        }
    });
      } else {
        swal({
          title: 'oh,oh',
          text: 'Algo salio mal',
          type: 'warning'
      });
      } 
    });
    e.preventDefault();
  });

  function obtenerDatosTablaUsuarios() {
    $.ajax({
      url: "../Controllers/consultasadeudos.php",
      type: "POST",
      data: "tabla_abonos=tabla_abonos",
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
    console.log(datos[0]);
    idabono = datos[0];
    $("#estado").val(datos[1]);
  });
});
