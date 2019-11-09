$(document).ready(function (){
    //Otros ingresos
    let editar = false;
    let idotrosIngresos = "";
    obtenerDatosTablaOtrosIngresos();

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
          if (new Date().getTime() - touchtime < 800) {
            // double click occurred
            var valores = "";
            $('#hideedit').hide();
            $("#mensaje").css("display", "none");
    
            $(this).parents("tr").find("td").each(function(){
                valores+= $(this).html() + "?";
            });
            datos = valores.split("?");
            idotrosIngresos = datos[0];
            $('#cantidad').val(datos[1]);
            $('#tipo').val(datos[2]);
            $('#forma_ingreso').val(datos[3]);
            $('#fecha').val(datos[4]);
            $('#estado').val(datos[5]);
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

    function obtenerDatosTablaOtrosIngresos(){
        $.ajax({
            url: '../Controllers/otros_ingresos.php',
            type: 'POST',
            data:'tabla=tabla',

            success: function(response){
                let datos = JSON.parse(response);
                let template = '';
            $.each(datos, function (i, item) {
                    template+=`
                    <tr>
                    <td class="text-nowrap text-center">${item[0]}</td>
                    <td class="text-nowrap text-center">${item[1]}</td>
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