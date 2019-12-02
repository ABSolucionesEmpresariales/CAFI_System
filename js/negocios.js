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
    $("#formulario").trigger("reset");
    $("#mensaje").css("display", "none");
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
        let template = `<option value="">Elegir</option>`;
        $.each(datos, function (i, item) {
          template +=`<option value="${item[0]}">${item[0]}</option>`;
        });
        $("#clientes").html(template);
    }
  });
  }

  $('#cp').keyup(function (e) {
    let codigopostal = $('#cp').val();
    if (codigopostal.length === 5) {
      fetch('https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' + codigopostal)
        .then(res => res.json())
        .then(data => {
          let template = '';
          for (i = 0; i < data.colonias.length; i++) {
            template += ` <option value="${data.colonias[i]}">`;
          }
          $("#localidad").html(template);
          $("#municipio").val(data.municipio);
          $("#estado").val(data.estado);

        });
    }else{
      $("#localidad").empty();
      $("#Tlocalidad").val('');
      $("#municipio").val('');
      $("#estado").val('');
    }

  });

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
/*           for(var y = 0; y < 12; y++){
            template += `
            <tr>
                  <td class="text-nowrap text-center ">${item[y]}</td>`;
          } */
           template += `
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
                  `;
                }else{
                  template += `<td class="text-nowrap text-center">${item[12]}</td>
                  `; 
                }
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
          $("#mensaje").css("display", "none");
          datos = valores.split("?");
          console.log(datos);
          idnegocio = datos[0];
          $("#nombre").val(datos[1]);
          $("#giro").val(datos[2]);
          $("#cp").val(datos[3]);
          $("#calle_numero").val(datos[4]);
          $("#colonia").val(datos[5]);
          $("#Tlocalidad").val(datos[6]);
          $("#municipio").val(datos[7]);
          $("#estado").val(datos[8]);
          $("#telefono").val(datos[10]);
          $("#impresora").val(datos[11]);
          $("#dueno").val(datos[12]);
          editar = true;
        $("#modalForm").modal("show");
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
  }); 

});
