$(document).ready(function () {
    var datos = [];

    //Datos compra
    var descuento = $('#descuento').val();
    var anticipo = $('#anticipo').val();

    //Descripcion de compra
    var subtotal_total = 0;
    var iva_total = 0;
    var ieps_total = 0;
    var total = parseInt($('#info_total').text().split('$')[1]);

    $(document).on('click','#btncompra, #compra_finalizada, #cancelar_compra, #agregar_producto, #eliminar_producto', function(){
        var boton = $(this).attr('id');

        if(boton == "cancelar_compra"){//Boton cancelar compra
            $('#compras').show();
            $('#compra').hide();
        }else if(boton == "btncompra"){//Boton comprar
            $('#compras').hide();
            $('#compra').show();
        }else if(boton == "agregar_producto"){//Boton agregar producto a compra
            //Productos en la compra
            var codigo = $('#codigo_producto').val();
            var nombre = $('#nombre_producto').val();
            var costo = $('#costo_producto').val();
            var ieps = $('#ieps').val();
            var cantidad = $('#cantidad').val();

            if(codigo.trim() == '' || codigo.trim() < 0){
                $('#codigo_producto').focus();
                return false;
            }else if(nombre.trim() == ''){
                $('#nombre_producto').focus();
                return false;
            }else if(costo.trim() == '' || costo.trim() < 1){
                $('#costo_producto').focus();
                return false;
            }else if(ieps.trim() < 0){
                $('#ieps').focus();
                return false;
            }else if(cantidad.trim() == '' || cantidad.trim() < 1){
                $('#cantidad').focus();
                return false;
            }else{
                iva_producto = 0;
                var ieps_producto = 0;
                ieps_producto = ((costo/100)*ieps)*cantidad;

                var subtotal_producto = costo*cantidad;
                
                if ($('#iva').is(":checked")){//Impuesto IVA
                    iva_producto = ((costo/100)*16)*cantidad;
                    subtotal_producto += iva_producto;
                }
                if (ieps != 0){//Impuesto IEPS
                    subtotal_producto += ieps_producto;
                }

                subtotal_total += (costo*cantidad);
                iva_total += iva_producto;
                ieps_total += ieps_producto;
                total += subtotal_producto;

                var row=`
                        <tr>
                            <td class="text-nowrap text-center"><button id='eliminar_producto' class='btn btn-danger' name=''>Eliminar</button></td>
                            <td class="text-nowrap text-center numero">${codigo}</td>
                            <td class="text-nowrap text-center">${nombre}</td>
                            <td id="producto_costo" class="text-nowrap text-center">$${costo}</td>
                            <td id="producto_iva" class="text-nowrap text-center">$${iva_producto}</td>
                            <td id="producto_ieps" class="text-nowrap text-center">$${ieps_producto}</td>
                            <td id="producto_cantidad" class="text-nowrap text-center">${cantidad}</td>
                            <td id="producto_subtotal" class="text-nowrap text-center">$${subtotal_producto}</td>
                        </tr>
                        `;
    
                $('#tabla_compra').append(row);


                $('#info_subtotal').html("$"+subtotal_total);
                $('#info_descuento').html("$"+descuento);
                $('#info_iva').html("$"+iva_total);
                $('#info_ieps').html("$"+ieps_total);
                $('#info_anticipo').html("$"+anticipo);
                $('#info_total').html("$"+total);
                
                $('#codigo_producto').val('');
                $('#nombre_producto').val('');
                $('#costo_producto').val('');
                $('#ieps').val('');
                $('#cantidad').val('');
                $('#codigo_producto').focus();
            }

        }else if(boton == "eliminar_producto"){//Boton eliminar producto de tabla
            var producto_costo = parseInt($(this).parent().parent().find("#producto_costo").text().split('$')[1]);
            var producto_cantidad = parseInt($(this).parent().parent().find("#producto_cantidad").text());
            var producto_iva = parseInt($(this).parent().parent().find("#producto_iva").text().split('$')[1]);
            var producto_ieps = parseInt($(this).parent().parent().find("#producto_ieps").text().split('$')[1]);
            var producto_subtotal = parseInt($(this).parent().parent().find("#producto_subtotal").text().split('$')[1]);

            subtotal_total -= (producto_costo*producto_cantidad);
            iva_total -= producto_iva;
            ieps_total -= producto_ieps;
            total -= producto_subtotal;

            $(this).parent().parent().remove();
            $('#info_subtotal').html("$"+subtotal_total);
            $('#info_iva').html("$"+iva_total);
            $('#info_ieps').html("$"+ieps_total);
            $('#info_total').html("$"+total);

        }else if(boton == "compra_finalizada"){//Boton compra finalizada
            var valores = "";
            var cont = 0;
            $(".numero").parent("tr").find("td").each(function() {
                if($(this).html() != '<button id="eliminar_producto" class="btn btn-danger" name="">Eliminar</button>'){
                    valores += $(this).html() + "?";
                }
            });
    
            console.log(valores);
            datos = valores.split("?");
            console.log(datos);
            $.ajax({
                type: "POST",
                url: 'guardarCompra.php',
                data: {'array': JSON.stringify(datos)},//capturo array     
                success: function(response){
                    console.log("La respuesta: "+response);
                }

            });

            $('#compras').show();
            $('#compra').hide();

        }

    });//Clicks en botones

    $('#forma_de_pago').on('change', function() {
        if(this.value == "Credito"){
            $('.fechascredito').removeClass("d-none").addClass("d-block");
        }else{
            $('.fechascredito').removeClass("d-block").addClass("d-none");
        }
    });//Combobox on change
    
});//Document ready