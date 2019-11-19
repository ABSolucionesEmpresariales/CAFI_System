$(document).ready(function () {
    let idcpp = "";
    let totaldeuda = "";
    let accion = false;
    let cambio = 0;
    var total = "";

    obtenerDatosTablaCPP();
    
    $(document).on('click','.befectivo, .btarjeta', function(){
        var boton = $(this).attr('id');
        if(boton == "tarjeta"){
            accion = true;
            $('#divefectivo').hide();
            $('#msjtarjeta').html("Recuerde cargar el abono a la tarjeta despues de registrarlo");
        }else{
            $('#divefectivo').show();
            $('#msjtarjeta').html("");
        }

        $('.modal').modal('show');
        let valores = "";
        $(this).parents("tr").find(".datos").each(function () {
            valores += $(this).html() + "?";
        });

        datos = valores.split("?");
        console.log(datos[1]);
        console.log(datos[0]);
        idcpp = datos[0];
        total = datos[1].split("$") ;
        totaldeuda = total[1];
        console.log(totaldeuda);
    });

    $("#formulario").submit(function (e) {

        pago = $('.tpago').val();
        abono = $('.inabono').val();
        if(accion == false){
            if(abono == ''){
                $('.inabono').focus();
                return false;
            }else{
                if(pago == ''){
                    $('.tpago').focus();
                    return false;
                }
            }
        }else{
            if(abono == ''){
                $('.inabono').focus();
                return false;
            } 
        }


        pago = parseFloat(pago);
        abono = parseFloat(abono);

        cambio =  pago - abono;
        totalif = totaldeuda;
        
        totaldeuda = parseFloat(totaldeuda) - abono;
        
            if(accion == false){
                swal({
                    title: 'Su cambio es de $ ' + cambio,
                    text: 'Confirme la venta',
                    imageUrl: '../img/cambio.png',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'Ok',
                    cancelButtonClass: 'btn-danger',
                    cancelButtonText: 'Cancelar',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },function (isConfirm) {
                    if (isConfirm) {
                        enviarDatos();
                    }
                });
    
            }else{
                swal({
                    title: 'Seguro desea hacer esta accion ?',
                    text: 'Confirme la venta',
                    imageUrl: '../img/cambio.png',
                    showCancelButton: true,
                    confirmButtonClass: 'btn-success',
                    confirmButtonText: 'Ok',
                    cancelButtonClass: 'btn-danger',
                    cancelButtonText: 'Cancelar',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },function (isConfirm) {
                    if (isConfirm) {
                        enviarDatos();
                    }
                });
            }
        e.preventDefault();
    });

    function enviarDatos(){
        $.post("../Controllers/cpp.php",$("#formulario").serialize() + 
        "&accion=" + accion +"&idcpp=" + idcpp +"&totaldeuda=" + totaldeuda +"&cambio="+ cambio,function(response){
            if(response == 1){
                swal({
                    title: 'Exito',
                    text: 'Venta exitosa',
                    type: 'success'
                },
                function (isConfirm){
                    if(isConfirm){
                        editar = false;
                        $('#formulario').trigger('reset');
                        $('.modal').modal('hide');
                        obtenerDatosTablaCPP();
                    }
                });
            }else{
                console.log(response);
                swal({
                    title: 'oh,oh',
                    text: 'Algo salio mal, favor de verificar los campos',
                    type: 'warning'
                });
            }
        });
    }

    function obtenerDatosTablaCPP(){
        $.ajax({
            url: "../Controllers/cpp.php",   
            type: "POST",
            data: "tabla=tabla",
       
            success: function (response) {
              let datos = JSON.parse(response);
              let template = "";
              $.each(datos, function (i, item) {
                template += `
                <tr>
                       <td class="text-nowrap text-center datos">${item[0]}</td>
                       <td class="text-nowrap text-center datos">$${item[1]}</td>
                       <td class="text-nowrap text-center datos">$${item[2]}</td>
                       <td class="text-nowrap text-center datos">${item[3]}</td>
                       <td class="text-nowrap text-center datos">${item[4]}</td>
                       <td class="text-nowrap text-center datos">${item[5]}</td>
                 `;
                 if(item[3] == "A"){
                    template += `
                    <td class="text-nowrap text-center"><button id="efectivo" class="befectivo btn btn-success"  ><img src="../img/abonos.png"></button>
                    <button id="tarjeta" class="btarjeta btn btn-success"  ><img src="../img/tarjeta.png"></button></td>
                    <`;
                 }else{
                    template += `
                    <td class="text-nowrap text-center"><button class=" btn btn-success" disabled ><img src="../img/abonos.png"></button>
                    <button class=" btn btn-success" disabled ><img src="../img/tarjeta.png"></button></td>
                    <`;
                 }
               });
               $("#cuerpo").html(template);
             }
         });
    }
});