$(document).ready(function () {
    var datos = [];
    var nombres = []; 
    
    $(document).on('click','#btncompra, #guardar_compra, #cancelar_compra, #agregar_producto, #eliminar_producto', function(){
        var boton = $(this).attr('id');

        if(boton == "guardar_compra" || boton == "cancelar_compra"){
            $('#compras').show();
            $('#compra').hide();
        }else if(boton == "btncompra"){
            $('#compras').hide();
            $('#compra').show();
        }else if(boton == "agregar_producto"){
            var codigo = $('#codigo_producto').val();
            var nombre = $('#nombre_producto').val();
            var costo = $('#costo_producto').val();
            var cantidad = $('#cantidad').val();

            if(codigo.trim() == ''){
                $('#codigo_producto').focus();
                return false;
            }
            if(nombre.trim() == ''){
                $('#nombre_producto').focus();
                return false;
            }else if(costo.trim() == '' || costo.trim() < 1){
                $('#costo_producto').focus();
                return false;
            }else if(cantidad.trim() == '' || cantidad.trim() < 1){
                $('#cantidad').focus();
                return false;
            }else{
                var subtotal = costo*cantidad;
                var total = parseInt($('#total_compra').text().split('$')[1])+subtotal;
                console.log($('#total_compra').text().split('$')[1]+subtotal);

                var row=`
                        <tr>
                            <td class="text-nowrap text-center"><button id='eliminar_producto' class='btn btn-danger' name=''>Eliminar</button></td>
                            <td class="text-nowrap text-center numero">${codigo}</td>
                            <td class="text-nowrap text-center">${nombre}</td>
                            <td class="text-nowrap text-center">$${costo}</td>
                            <td class="text-nowrap text-center">${cantidad}</td>
                            <td id="producto_subtotal" class="text-nowrap text-center">$${subtotal}</td>
                        </tr>
                        `;
    
                $('#tabla_compra').append(row);
                $('#total_compra').html("$"+total);
                
                $('#codigo_producto').val('');
                $('#nombre_producto').val('');
                $('#costo_producto').val('');
                $('#cantidad').val('');
                $('#codigo_producto').focus();


            }
        }else if(boton == "eliminar_producto"){
            var subtotal = parseInt($(this).parent().parent().find("#producto_subtotal").text().split('$')[1]);
            var total = parseInt($('#total_compra').text().split('$')[1])-subtotal;

            $(this).parent().parent().remove();
            $('#total_compra').html("$"+total);
        }
    });

    $('#forma_de_pago').on('change', function() {
        if(this.value == "Credito"){
            $(this).parent().removeClass("col-lg-12").addClass("col-lg-4");
            $('.fechascredito').removeClass("d-none").addClass("d-block");
        }else{
            $(this).parent().removeClass("col-lg-4").addClass("col-lg-12");
            $('.fechascredito').removeClass("d-block").addClass("d-none");
        }
    });

    $(document).on('click','.compra_finalizada',function(){
        var valores = "";
        //Agregar clase a la funcion find
        $(".numero").parent("tr").find("td").each(function() {
                if($(this).html() != '<button id="eliminar_producto" class="btn btn-danger" name="">Eliminar</button>'){
                    valores+= $(this).html() +"?";
                    }
        });
        datos = valores.split("?");

        

        $.ajax({
            type: "POST",
            url: 'guardarCompra.php',
            data: {'array': JSON.stringify(datos)},//capturo array     
            success: function(response){
                console.log("La respuesta: "+response);
          }
  });

    });
    
});