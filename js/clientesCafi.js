$(document).ready(function () {
    //clientesab
    let editar = false;
    let idclienteab = "";
    let acceso = '';
    obtenerAcceso();

    function obtenerAcceso(){
        $.ajax({
          url: "../Controllers/login.php",
          type: "POST",
          data:"accesoPersona=accesoPersona",
    
          success: function (response) {
            acceso = response;
            $.ajax({
                url: '../Controllers/clientes.php',
                type: 'POST',
                data:"tabla=tabla",
                success: function (response) {
                    let datos = JSON.parse(response);
                    let template = '';
                    $.each(datos, function (i, item) {
    
                        template += `<tr>`;
                        if(acceso == 'CEO'){
                            template += `<td class="text-nowrap text-center"><input type="checkbox" value="si"></td>`;
                        }
                        template += ` 
                        <td  class="text-nowrap text-center">${item[0]}</td>
                        <td  class="text-nowrap text-center">${item[1]}</td>
                        <td  class="text-nowrap text-center">${item[2]}</td>
                        <td  class="text-nowrap text-center">${item[3]}</td>
                        <td  class="text-nowrap text-center">${item[4]}</td>
                        <td  class="text-nowrap text-center">${item[5]}</td>
                        <td  class="text-nowrap text-center">${item[6]}</td>
                        <td  class="text-nowrap text-center">${item[7]}</td>
                        <td  class="text-nowrap text-center">${item[8]}</td>
                        <td  class="text-nowrap text-center">${item[9]}</td>
                        <td  class="text-nowrap text-center">${item[10]}</td>
                        <td  class="text-nowrap text-center">${item[11]}</td>
                        <td  class="text-nowrap text-center">${item[12]}</td>
                        <td  class="text-nowrap text-center">${item[13]}</td>
                        <td  class="text-nowrap text-center">${item[14]}</td>
                        <td  class="text-nowrap text-center">${item[15]}</td>
                        <td  class="text-nowrap text-center">${item[16]}</td>
                    </tr>`;
                    });
                    $('#cuerpo').html(template);
                }
            });
          }
        });
      }

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
              if(typeof (enviarDatos2()) != 'undefined'){
                swal("Exito!", 
                "Sus datos han sido eliminados.",
                 "success");
              }else{
                swal("Error!", 
                "Ups, algo salio mal.",
                 "warning");
              }
              $('.check').prop("checked", false);
              obtenerAcceso();
          });
    });

    

    function enviarDatos2(){
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
          url: "../Controllers/clientes.php",
          type: "POST",
          data: {'array': JSON.stringify(result)},
  
          success: function (response) {
            console.log(response);
                return response;
          }
        }); 
    }

    $('.close').click(function () {
        $('#formulario').trigger('reset');
        $('.contro').hide();
    });


    function enviarDatos(){
        $.ajax({
            url: "../Controllers/clientes.php",   
            type: "POST",
            data: $('#formulario').serialize() + "&accion=" + editar,
       
            success: function (response) {
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
            }
        });
    }

    $('#formulario').submit(function (e) {
        if($('#email').val() == ''){
            $('#email').focus();
            return false;
        }else if($('#nombre').val() == ''){
            $('#nombre').focus();
            return false;
        }else if($('#localidad').val() == ''){
            $('#localidad').focus();
            return false;
        }else if($('#telefono').val() == ''){
            $('#telefono').focus();
            return false;
        }else if($('#credito').val() == ''){
            $('#credito').focus();
            return false;
        }

        if(editar == false){

                console.log('entro');
                enviarDatos();
            
        }else{
            enviarDatos();
        }
        e.preventDefault();
    });

    $(document).on('click','.agregar',function(){
        $('.ocultar').css('display','block');
        editar = false;
    });

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
            $('.ocultar').css('display','none');
            $('.ampliar').removeClass( "col-lg-4" );
            $('.ampliar').addClass( "col-lg-6" );
            console.log(datos);
            $("#email").val(datos[1]);
            $("#rfc").val(datos[2]);
            $("#nombre").val(datos[3]);
            $("#cp").val(datos[4]);
            $("#calle_numero").val(datos[5]);
            $("#colonia").val(datos[6]);
            $("#localidad").val(datos[7]);
            $("#municipio").val(datos[8]);
            $("#estado").val(datos[9]);
            $("#pais").val(datos[10]);
            $("#telefono").val(datos[11]);
            $("#fecha_nacimiento").val(datos[12]);
            $("#sexo").val(datos[13]);
            $("#credito").val(datos[14]);
            $("#plazo_credito").val(datos[15]);
            $("#limite_credito").val(datos[16]);
            editar = true;
          $("#modalForm").modal("show");
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 

});