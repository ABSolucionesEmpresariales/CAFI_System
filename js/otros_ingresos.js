$(document).ready(function (){
    //Otros ingresos
    let editar = false;
    let idotrosIngresos = "";
    obtenerDatosTablaOtrosIngresos();

    $('.close').click(function(){
        $('#formotrosingresos').trigger('reset');
    });

    $(document).on('click','#editar',function(){
        var valores = "";
        $('#hideedit').hide();

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
    });

    function enviarDatos(){
        $.ajax({
            url: '../Controllers/otros_ingresos.php',
            type: 'POST',
            data: $('#formulario').serialize() + "&id="+ idotrosIngresos + "&accion=" + editar,
            success: function(response) {
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
                    <td class="text-nowrap text-center">${item[6]}</td>
                    <th style="width:100px;">
                        <div class="row">
                            <a id="editar"  data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                                Editar
                            </a>
                        </div>
                    </th>`;
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