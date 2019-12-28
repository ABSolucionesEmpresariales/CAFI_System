$(document).ready(function () {
  //Trabajadores
  let editar = false;
  let idtrabajador = "";
  let idnego = "";
  let acceso = "";
  obtenerAcceso();
  tablaExtra();

  function obtenerAcceso() {
    $.ajax({
      url: "../Controllers/login.php",
      type: "POST",
      data: "accesoPersona=accesoPersona",

      success: function (response) {
        acceso = response;
        $.ajax({
          url: "../Controllers/trabajadorCafi.php",
          type: "POST",
          data: "tabla=tabla",
          success: function (response) {
            let datos = JSON.parse(response);
            let template = "";
            let color;
            $.each(datos, function (i, item) {
              for(var j = 0; j <= item.length; j++){
                if(item[j] == 'null' || item[j] === null){
                  item[j] = "";
                }
              }
              if (item[1] === "0") {
                item[1] = "Realizada";
                color = "text-success";
              } else {
                item[1] = "No realizada"
                color = "text-danger";
              }
              template += `<tr>`;
              if (acceso == 'CEO') {
                template += `
                    <td><input type="checkbox" value="si"></td>`;
              }
              template += `
                      <td class="text-nowrap text-center email">${item[0]}</td>
                      <td class="text-nowrap text-center ${color}">${item[1]}</td>
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
                      <td class="text-nowrap text-center">${item[17]}</td>
                  `;
            });
            $("#cuerpo").html(template);
          }
        });
      }
    });
  }

  $('#cp').keyup(function (e) {
    let codigopostal = $('#cp').val();
    if (codigopostal.length === 5) {
      
      //const uri = 'https://api-sepomex.hckdrk.mx/query/info_cp/'+codigopostal+'?type=simplified';

/*       let req = new Request(uri, {
        "method": "GET",
        "headers": {
          "Content-Type": "application/json",
          "Access-Control-Allow-Origin": "https://api-sepomex.hckdrk.mx",
        },
        "mode": 'no-cors'
      }) */

      fetch('https://api-sepomex.hckdrk.mx/query/info_cp/'+codigopostal+'?type=simplified')
        .then(res => res.json())
        .then(data => {
          let template = '';
          for (i = 0; i < data.response.asentamiento.length; i++) {
            template += ` <option value="${data.response.asentamiento[i]}">`;
          }
          $("#localidad").html(template);
          $("#municipio").val(data.municipio);
          $("#estado").val(data.estado);
        });
    } else {
      $("#localidad").empty();
      $("#Tlocalidad").val('');
      $("#municipio").val('');
      $("#estado").val('');
    }
  });

  $('#cp2').keyup(function (e) {
    let codigopostal = $('#cp2').val();
    if (codigopostal.length === 5) {
      fetch('https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' + codigopostal)
        .then(res => res.json())
        .then(data => {
          let template = '';
          for (i = 0; i < data.colonias.length; i++) {
            template += ` <option value="${data.colonias[i]}">`;
          }
          $("#localidad2").html(template);
          $("#municipio2").val(data.municipio);
          $("#estado2").val(data.estado);
        });
    } else {
      $("#localidad2").empty();
      $("#Tlocalidad2").val('');
      $("#municipio2").val('');
      $("#estado2").val('');
    }
  });

  $(document).on('click', '.agregar', function () {
    $("#mensaje").css("display", "none");
    $("#divpass").css('display', 'block');
    $("#contrasena").attr('required');
    editar = false;
    $(".ocultar").show();
  });

  $("#formulario").submit(function (e) {
    $.post("../Controllers/trabajadorCafi.php", $("#formulario").serialize() + '&accion=' + editar, function (response) {
      $("#mensaje").css("display", "block");
      console.log(response);
      if (response == "1") {
        if (editar == true) {
          $('.modal').modal('hide');
          $("#mensaje").css("display", "none");
        }
        $("#mensaje").text("Registro Exitoso");
        $("#mensaje").css("color", "green");
        $("#formulario").trigger("reset");
        $("#email").focus();
      } else if (response == "exceso") {
        $("#mensaje").text("Limite de usuarios exedido");
        $("#mensaje").css("color", "red");
        $("#nombre").focus();
      } else {
        $("#mensaje").text("Registro fallido");
        $("#mensaje").css("color", "red");
        $("#email").focus();
      }
      obtenerAcceso();
    });
    e.preventDefault();
  });

  function tablaExtra(){
    $.ajax({
      url: "../Controllers/trabajadorCafi.php",
      type: "POST",
      data: "tablaExtra=tablaExtra",

      success: function (response) {
        let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          template += `<tr>
                  <td class="text-nowrap text-center pagar">${item[0]}</td>
                  <td class="text-nowrap text-center">${item[1]}</td>
                  <td class="text-nowrap text-center">${item[2]}</td>
                  <td class="text-nowrap text-center"><button class="agregar d-none d-lg-flex btn btn-primary ml-3">Pagar</button></td>
              `;
        });
        $("#cuerpoExtras").html(template);
      }
    });
  }

  $("#agregarUsuarioExtra").submit(function (e) {
    $.post("../Controllers/trabajadorCafi.php", $("#agregarUsuarioExtra").serialize() + '&extra=extra', function (response) {
      $("#mensaje").css("display", "block");
      console.log(response);
      if (response == "1") {
        $("#2mensaje").text("Registro Exitoso");
        $("#2mensaje").css("color", "green");
        $("#agregarUsuarioExtra").trigger("reset");
        $("#email2").focus();
      }else {
        $("#mensaje2").text("Registro fallido");
        $("#mensaje2").css("color", "red");
        $("#email2").focus();
      }
      obtenerAcceso();
      tablaExtra();
    });
    e.preventDefault();
  });

  var touchtime = 0;
  $(document).on("click", "td", function () {
    $("#divpass").css('display', 'none');
    $("#contrasena").removeAttr('required');
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
        $(".ocultar").hide();
        $("#email").val(datos[1]);
        $("#rfc").val(datos[5]);
        $("#nombre").val(datos[6]);
        $("#cp").val(datos[7]);
        $("#calle_numero").val(datos[8]);
        $("#colonia").val(datos[9]);
        $("#Tlocalidad").val(datos[10]);
        $("#municipio").val(datos[11]);
        $("#estado").val(datos[12]);
        $("#pais").val(datos[13]);
        $("#telefono").val(datos[14]);
        $("#fecha_nacimiento").val(datos[15]);
        $("#sexo").val(datos[16]);
        $("#acceso").val(datos[17]);
        $("#contrasena").val("null");
        editar = true;
        $("#modalForm").modal("show");
      } else {
        // not a double click so set as a new first click
        touchtime = new Date().getTime();
      }
    }
  });

  /* 
        var touchtime = 0;
        $(document).on("click", "td", function () {
            if (touchtime == 0) {
              touchtime = new Date().getTime();
            } else {
              // compare first click to this click and see if they occurred within double click threshold
              if (new Date().getTime() - touchtime < 800) {
                // double click occurred
  
  
  
              $("#modalForm").modal("show");
              } else {
                // not a double click so set as a new first click
                touchtime = new Date().getTime();
              }
            }
          }
      }); 
      */


  $(document).on('click', '.eliminar', function () {
    swal({
      title: "Esta seguro que desea eliminar ?",
      text: "Esta accion eliminara los datos!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, eliminarlo!",
      closeOnConfirm: false
    },
      function () {
        var valores = "";
        $('#cuerpo').children("tr").find("td").find("input").each(function () {
          if ($(this).prop('checked')) {
            valores += $(this).parents("tr").find("td").eq(1).text() + "?";
          }
        });
        valores += "0";
        result = valores.split("?");
        console.log(result);
        $.ajax({
          url: "../Controllers/trabajadorCafi.php",
          type: "POST",
          data: { 'array': JSON.stringify(result) },

          success: function (response) {
            if (typeof (response) != '0') {
              swal("Exito!",
                "Sus datos han sido eliminados.",
                "success");
            } else {
              swal("Error!",
                "Ups, algo salio mal.",
                "warning");
            }
          }
        });
        $('.check').prop("checked", false);
        obtenerAcceso();
      });
  });

  $(document).on('click', '.check', function () {

    if ($(this).prop('checked')) {
      $('#cuerpo').children("tr").find("td").find("input").each(function () {
        $(this).prop("checked", true);
      });
    } else {
      $('#cuerpo').children("tr").find("td").find("input").each(function () {
        $(this).prop("checked", false);

      });
    }
  });

  $('#agregarUsuarioExtra').submit(function(e){
    e.preventDefault();
  });


  $('.close').click(function () {
    $('#formulario').trigger('reset');
    $("#mensaje").css("display", "none");
  });

});