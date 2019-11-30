$(document).ready(function () {
  //clientes que compran cafi
    let editar = false;
    let idusuario = "";
    let acceso = "";
    obtenerAcceso();

    function obtenerAcceso(){
      $.ajax({
        url: "../Controllers/login.php",
        type: "POST",
        data:"accesoPersona=accesoPersona",
  
        success: function (response) {
          acceso = response;
          $.ajax({
            url: "../Controllers/clienteab.php",
            type: "POST",
            data: "tabla=tabla",
    
            success: function (response) {
              console.log(response);
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `<tr>`;
                  if(acceso == 'CEOAB'){
                    template += `<td class="text-nowrap text-center"><input type="checkbox" value="si"></td>`;
                  }
                template += `<td class="text-nowrap text-center">${item[0]}</td>
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
    
    $(document).on('click','.check',function(){

      if($(this).prop('checked')){
          $('#cuerpo').children("tr").find("td").find("input").each(function () {
                   $(this).prop("checked", true);
          });    
      }else{
          $('#cuerpo').children("tr").find("td").find("input").each(function () {
                   $(this).prop("checked", false);
              
          });    
      }
  });



  $(document).on('click','.eliminar',function(){
      swal({
          title: "Esta seguro que desea eliminar ?",
          text: "Esta accion eliminara los datos!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si, eliminarlo!",
          closeOnConfirm: false
        },
        function(){
            if(typeof (enviarDatos()) != 'undefined'){
              swal("Exito!", 
              "Sus datos han sido eliminados.",
               "success");
            }else{
              swal("Error!", 
              "Ups, algo salio mal.",
               "warning");
            }
            $('.check').prop("checked", false);
            
        });
  });


  function enviarDatos(){
      var valores = "";
  
      $('#cuerpo').children("tr").find("td").find("input").each(function () {
          if($(this).prop('checked')){
              valores += $(this).parents("tr").find("td").eq(1).text() + "?";
          }
      }); 
      valores += "0";
      result = valores.split("?");
      console.log(result);
       $.ajax({
        url: "../Controllers/clienteab.php",
        type: "POST",
        data: {'array': JSON.stringify(result)},

        success: function (response) {
          console.log(response);
          obtenerAcceso();
              return response;
        }
      }); 
  }

    $(".close").click(function () {
      $("#formulario").trigger("reset");
      $("#mensaje").css("display", "none");
    });


    $('.agregar').click(function(){
      editar = false;
      $("#formulario").trigger("reset");
      $("#mensaje").css("display", "none");
      $("#divpass").css('display','block');
      $("#contrasena").attr('required');
      $("#divemail").css('display','block');
      $("#email").attr('required');
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
        obtenerAcceso();
      });
      
      e.preventDefault();
    });


    var touchtime = 0;
    $(document).on("click", "td", function () {
      $("#divpass").css('display','none');
      $("#contrasena").removeAttr('required');
      $("#divemail").css('display','none');
      $("#email").removeAttr('required');
        if (touchtime == 0) {
          touchtime = new Date().getTime();
        } else {
          // compare first click to this click and see if they occurred within double click threshold
          if (new Date().getTime() - touchtime < 300) {
            // double click occurred
            var valores = "";
            $(this).parents("tr").find("td").each(function () {
              valores += $(this).html() + "?";
            });
            datos = valores.split("?");
            console.log(datos);
            $('.ocultar').hide();
            $("#email").val(datos[1]);
            $("#rfc").val(datos[2]);
            $("#nombre").val(datos[3]);
            $("#cp").val(datos[4]);
            $("#calle_numero").val(datos[5]);
            $("#colonia").val(datos[6]);
            $("#Tlocalidad").val(datos[7]);
            $("#municipio").val(datos[8]);
            $("#estado").val(datos[9]);
            $("#pais").val(datos[10]);
            $("#telefono").val(datos[11]);
            $("#fecha_nacimiento").val(datos[12]);
            $("#sexo").val(datos[13]);
            $("#entrada_sistema").val(datos[14]);
            $("#contrasena").val("null");
            editar = true;
            $("#modalForm").modal("show");
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 

 
  });
