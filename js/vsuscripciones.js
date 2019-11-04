//vsuscripciones
$(document).ready(function () {
  let idsuscripcion = "";
  let editar = false;
  optenerDatosTabla();

  $('#bclose').click(function () {
    $('.modal').modal('hide');
  });

  $('.bmodal').click(function () {
    $('#divnegocio').show();
    $('.divusextra').hide();
  });

  $('.close').click(function () {
    $('#formulario').trigger('reset');
  });

  $('#estado').change(function () {
    swal({
      title: 'Alerta',
      text: '¿Está seguro de cambiar el estado ? Esto afectará el estado de todos los usuarios del sistema que dependen a la suscripción',
      type: 'warning'
    });
  });

  function optenerDatosTabla() {
    $.ajax({
      url: 'tablasuscripcion.php',
      type: 'GET',
      success: function (response) {
        let datos = JSON.parse(response);
        let template = '';
        datos.forEach(datos => {
          template += `
            <tr>
            <td class="text-nowrap text-center">${datos.id}</td>
            <td class="text-nowrap text-center">${datos.fecha_activacion}</td>
            <td class="text-nowrap text-center">${datos.fecha_vencimiento}</td>
            <td class="text-nowrap text-center">${datos.estado}</td>
            <td class="text-nowrap text-center">${datos.negocio}</td>
            <td class="text-nowrap text-center">${datos.paquete}</td>
            <td class="text-nowrap text-center">${datos.usextra}</td>
            <td class="text-nowrap text-center">${datos.monto}</td>
            <td class="text-nowrap text-center">${datos.registro}</td>
            <th class="text-nowrap text-center" style="width:100px;">
                <div class="row">
                    <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                        Editar
                    </a>
                </div>
            </th>
        </tr>`;
        });
        $('#cuerpo').html(template);
      }
    })
  }

    let url = editar === false ? 'post-guardar.php' : 'post-edit.php';
    $.post(url, postData, function (response) {
      console.log(response);
      $('#formulario').trigger('reset');
      editar = false;
      if (response == "1") {
        swal({
          title: 'Exito',
          text: 'Datos guardados satisfactoriamente',
          type: 'success'
        });
      } else {
        swal({
          title: 'Alerta',
          text: 'Datos no guardados, compruebe los campos unicos',
          type: 'warning'
        });
      }
      optenerDatosTabla();
    });
    e.preventDefault();
  })

  $(document).on('click', '.beditar', function () {
    var valores = "";
    $('#divnegocio').hide();
    $('.divusextra').show();
    // Obtenemos todos los valores contenidos en los <td> de la fila
    // seleccionada
    $(this).parents("tr").find("td").each(function () {
      valores += $(this).html() + "?";
    });
    datos = valores.split("?");
    idsuscripcion = datos[0];
    $('#fecha_activacion').val(datos[1]);
    $('#fecha_vencimiento').val(datos[2]);
    $('#estado').val(datos[3]);
    $('#monto').val(datos[4]);
    $('#paquete').val(datos[5]);
    $('#usuario_extra').val(datos[6]);
    $('#negocio').val(datos[7]);
    editar = true;

  })
});
