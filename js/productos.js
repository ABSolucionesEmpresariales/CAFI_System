$(document).ready(function () {
editar = false;
console.log("entro al js");
/* $.ajax({
  url: "../Controllers/generador.php",
  type: "GET",

  success: function (response) {
    console.log(response);
    let datos =JSON.parse(response);
    $.each(datos, function(i, item) {

    });
      $("#").val(datos[1]);
  }
  }); */
  $(document).on('click','#bclose', function(){
    else if(boton == "bclose"){
        var codigo = $('#codigo_barras').val();
        var modelo = $('#modelo').val();
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        var categoria = $('#categoria').val();
        var marca = $('#marca').val();
        var proveedor = $('#proveedor').val();
        var color = $('#color').val();
        var imagen = $('#imagen').val();
        var compra = $('#precio_compra').val();
        var venta = $('#precio_compra').val();
        var medida = $('#unidad_medida').val();
        var talla = $('#talla_numero').val();
        var iva = $('#tasa_iva').val();
        var ipes = $('#tasa_ipes').val();
        var descuento = $('#descuento').val();

        if(codigo.trim() == ''){
            $('#codigo_barras').focus();
            return false;
        }if(modelo.trim() == ''){
            $('#modelo').focus();
            return false;
        }if(nombre.trim() == ''){
            $('#nombre').focus();
            return false;
        }if(descripcion.trim() == ''){
            $('#descripcion').focus();
            return false;
        }if(categoria.trim() == ''){
            $('#categoria').focus();
            return false;
        }if(marca.trim() == ''){
            $('#marca').focus();
            return false;
        }if(proveedor.trim() == ''){
            $('#proveedor').focus();
            return false;
        }if(color.trim() == ''){
            $('#color').focus();
            return false;
        }else if(imagen.trim() == '' || imagen.trim() < 1){
            $('#imagen').focus();
            return false;
        }else if(compra.trim() == '' || compra.trim() < 1){
            $('#precio_compra').focus();
            return false;
        }else if(venta.trim() == '' || venta.trim() < 1){
            $('#precio_venta').focus();
            return false;
        }else if(medida.trim() == '' || medida.trim() < 1){
            $('#unidad_medida').focus();
            return false;
        }else if(talla.trim() == '' || talla.trim() < 1){
            $('#talla_numero').focus();
            return false;
        }else if(iva.trim() == '' || iva.trim() < 1){
            $('#tasa_iva').focus();
            return false;
        }else if(ipes.trim() == '' || ipes.trim() < 1){
            $('#tasa_ipes').focus();
            return false;
        }else if(descuento.trim() == '' || descuento.trim() < 1){
            $('#descuento').focus();
            return false;
          }
        }
  });

  $("#formulario").submit(function (e) {
    var formData = new FormData(this);

    $.ajax({
      url: "../Controllers/productos.php",
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,

      success: function(response) {
          console.log("Respuesta: "+response);

      }
  });
e.preventDefault();
  });
});
