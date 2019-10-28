$(document).ready(function () {
    let idretiro = null;
    let efectivo = null;
    let banco = null;
    obtenerDatosDeTabla();
    obtenerDinero();

    function obtenerDinero() {
        $.ajax({
            url: '../Controllers/retiros.php',
            type: "POST",
            data: "tablacantidades=cantidades",

            success: function (response) {
                console.log(response);
                let datos = JSON.parse(response);
                let template = null;
                $.each(datos, function (i, item) {
                    efectivo = item[0];
                    banco = item[1];

                    template = `
                    <td>${efectivo}</td>
                    <td>${banco}</td>
                    `;
                });
                $('#cuerpoEfectivo').html(template);
            }
        });
    }


    function obtenerDatosDeTabla() {
        $.ajax({
            url: '../Controllers/retiros.php',
            type: "POST",
            data: "tabla=tabla",

            success: function (response) {
                let datos = JSON.parse(response);
               console.log(datos);
               let template = null;
                $.each(datos, function (i, item) {
                    console.log('llego');
                  

                    template += `
                    <tr>
                    <td class="datos">${item[0]}</td>
                    <td>${item[1]}</td>
                    <td>${item[2]}</td>
                    <td>${item[3]}</td>
                    <td>${item[4]}</td>
                    <td>${item[5]}</td>
                    <td>${item[6]}</td>
                    <td class="datos">${item[7]}</td>
                    <td>${item[8]}</td>
                    <td style="width:100px;">
                    <div class="row">
                        <a data-toggle="modal" data-target="#modalForm2" style="margin: 0 auto;" class="beditar btn btn-danger" href="#">
                            Editar
                        </a>
                    </div>
                </td>
                   </tr> `;
                });
                $('#cuerpo').html(template);
            }
        });
    }

    $('#formulario1').submit(function (e) {
      
        let cantidad = $('#cant').val();
        let tipo = $('#de').val();
        let concepto = $('#concepto').val();
        let descripcion = $('#desc').val();

        if (concepto == "Corte de caja" && tipo == "Banco") {
            //se compara que la cantidad a retirar en efectivo no sea superior a la cantidad en en efectivo que hay en caja
            swal({
                title: 'Alerta',
                text: 'Proceso erroneo, No puede hacer corte de caja en banco',
                type: 'warning'
            });

        } else if (tipo == "Caja" && cantidad <= efectivo) {
            $.post("../Controllers/retiros.php", $("#formulario1").serialize() + '&idretiro=' + null, function (response) {
                console.log(response);
                obtenerDatosDeTabla();
                obtenerDinero();
               // $("#mensaje").css("display", "block");
           
          
               // obtenerDatosTablaUsuarios();
              });
              
            } else if (tipo == "Caja" && cantidad > efectivo) {
                swal({
                    title: 'Alerta',
                    text: 'Saldo insuficiente en caja',
                    type: 'warning'
                });
            } else if (tipo == "Banco" && cantidad <= banco) {
                $.post("../Controllers/retiros.php", $("#formulario1").serialize() + '&idretiro=' + null, function (response) {
                    console.log(response);
                    if (response == "1") {
                       // $("#mensaje").text("Registro Exitoso");
                       // $("#mensaje").css("color", "green");
                        $("#formulario1").trigger("reset");
                      } else {
                      //  $("#mensaje").text("Registro fallido");
                      //  $("#mensaje").css("color", "red");
                      }
                    obtenerDatosDeTabla();
                    obtenerDinero();
                   // $("#mensaje").css("display", "block");
                   
                  });
              
            } else if (tipo == "Banco" && cantidad > banco) {
                swal({
                    title: 'Alerta',
                    text: 'Saldo insuficiente en banco',
                    type: 'warning'
                });
            }
        
        e.preventDefault();
    });

    $('#formulario2').submit(function (e) {
      
    $.post("../Controllers/retiros.php", $("#formulario2").serialize() + '&idretiro=' + idretiro, function (response) {
                console.log(response);
                if (response == "1") {
                    $("#formulario2").trigger("reset");
                    $("#mensaje").text("Registro Exitoso");
                    $("#mensaje").css("color", "green");
                   } else {
                    $("#mensaje").text("Registro fallido");
                    $("#mensaje").css("color", "red");
                   }
                obtenerDatosDeTabla();
                obtenerDinero();
                $('#modalForm2').modal('hide');
              });
              
     e.preventDefault();
    });


    $(document).on('click', '.beditar', function () {
     let valores = "";
    $(this).parents("tr").find(".datos").each(function () {
      valores += $(this).html() + "?";
    });
        
        datos = valores.split("?");
        console.log(datos);
        idretiro = datos[0];
        $('#estado').val(datos[1]);

    });


});
