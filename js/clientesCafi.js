$(document).ready(function () {
    //clientesab
    let editar = false;
    let idclienteab = "";
    obtenerDatosTablaClientesab();


    
    function obtenerDatosTablaClientesab() {
        $.ajax({
            url: '../Controllers/clientes.php',
            type: 'POST',
            data:"tabla=tabla",
            success: function (response) {
                let datos = JSON.parse(response);
                let template = '';
                $.each(datos, function (i, item) {
                    template += `
                    <tr>
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
                    <th  class="text-nowrap text-center" style="width:100px;">
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
                obtenerDatosTablaClientesab(); 
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

    $(document).on('click','.Bagregar',function(){
        $('.ocultar').css('display','block');
        $('.ampliar').removeClass( "col-lg-6" );
        $('.ampliar').addClass( "col-lg-4" );
    });


    $(document).on('click', '.beditar', function () {
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
        $("#email").val(datos[0]);
        $("#rfc").val(datos[1]);
        $("#nombre").val(datos[2]);
        $("#cp").val(datos[3]);
        $("#calle_numero").val(datos[4]);
        $("#colonia").val(datos[5]);
        $("#localidad").val(datos[6]);
        $("#municipio").val(datos[7]);
        $("#estado").val(datos[8]);
        $("#pais").val(datos[9]);
        $("#telefono").val(datos[10]);
        $("#fecha_nacimiento").val(datos[11]);
        $("#sexo").val(datos[12]);
        $("#credito").val(datos[13]);
        $("#plazo_credito").val(datos[14]);
        $("#limite_credito").val(datos[15]);
        editar = true;

    })
});