$(document).ready(function (){
    //Otros ingresos
    let editar = false;
    let idotrosIngresos = "";
    let acceso = '';
    obtenerAcceso();
    obtenerDatosTablaOtrosIngresos();

    function obtenerAcceso(){
        $.ajax({
          url: "../Controllers/login.php",
          type: "POST",
          data:"accesoPersona=accesoPersona",
    
          success: function (response) {
            acceso = response
          }
        });
      }

      
    function obtenerDatosTablaOtrosIngresos(){
        $.ajax({
            url: '../Controllers/otros_ingresos.php',
            type: 'POST',
            data:'tabla=tabla',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
            $.each(datos, function (i, item) {
                    template+=`<tr>`;
                    if(acceso == 'CEO'){
                        template+=`<td><input type="checkbox" value="si"></td>`;   
                    }
                    template+=`
                    <td class="text-nowrap text-center d-none">${item[0]}</td>
                    <td class="text-nowrap text-center">$${item[1]}</td>
                    <td class="text-nowrap text-center">${item[2]}</td>
                    <td class="text-nowrap text-center">${item[3]}</td>
                    <td class="text-nowrap text-center">${item[4]}</td>
                    <td class="text-nowrap text-center">${item[5]}</td>
                    <td class="text-nowrap text-center">${item[6]}</td>`;
                });
                $('#cuerpo').html(template);
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
              if(enviarDatos2() != '0'){
                swal("Exito!", 
                "Sus datos han sido eliminados.",
                 "success");
              }else{
                swal("Error!", 
                "Ups, algo salio mal.",
                 "warning");
              }
              $('.check').prop("checked", false);
              obteneDatosProveedor();
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
          url: "../Controllers/otros_ingresos.php",
          type: "POST",
          data: {'array': JSON.stringify(result)},
  
          success: function (response) {
            console.log(response);
                return response;
          }
        });  
    }


    $('.agregar').click(function(){
        $('#formulario').trigger('reset');
        $("#mensaje").css("display", "none");
        $('#hideedit').show();
        editar = false;
        idotrosIngresos = "";
        console.log(editar);
    });

    $(".close").click(function() {
        $("#formulario").trigger("reset");
        $("#mensaje").css("display", "none");
        $('#hideedit').show();
        editar = false;
        idotrosIngresos = "";
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
            $('#hideedit').hide();
            $("#mensaje").css("display", "none");
    
            $(this).parents("tr").find("td").each(function(){
                valores+= $(this).html() + "?";
            });
            datos = valores.split("?");
            idotrosIngresos = datos[1];
            $('#cantidad').val(datos[2]);
            $('#tipo').val(datos[3]);
            $('#forma_ingreso').val(datos[4]);
            $('#fecha').val(datos[5]);
            $('#estado').val(datos[6]);
            editar = true;
          $("#modalForm").modal("show");
          } else {
            // not a double click so set as a new first click
            touchtime = new Date().getTime();
          }
        }
    }); 

    function enviarDatos(){
        $.ajax({
            url: '../Controllers/otros_ingresos.php',
            type: 'POST',
            data: $('#formulario').serialize() + "&id="+ idotrosIngresos + "&accion=" + editar,
            success: function(response) {
                $("#mensaje").css("display", "block");
                console.log(response);
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
                      console.log('si llego');  
                    $("#mensaje").text("Registro fallido");
                    $("#mensaje").css("color", "red");
                    $("#email").focus();
                  }
                  obtenerDatosTablaOtrosIngresos();
            }
        });
    }


    $('#formulario').submit(function(e){
        if(editar == false){
            if($('#cantidad').val() == ''){
                $('#cantidad').focus();
                return false;
            }else if($('#tipo').val() == ''){
                $('#tipo').focus();
                return false;
            }else if($('#forma_ingreso').val() == ''){
                $('#forma_ingreso').focus();
                return false;
            }else if($('#fecha').val() == ''){
                $('#fecha').focus();
                return false;
            }else if($('#estado').val() == ''){
                $('#estado').focus();
                return false;
            }else{
                enviarDatos();
            }
        }else{
                enviarDatos();
        }
        e.preventDefault();
    });


});