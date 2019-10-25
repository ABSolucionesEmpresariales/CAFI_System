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
    var boton = $(this).attr('id');

     if(boton == "bclose"){
        var codigo = $('#codigo_barras').val();
        var nombre = $('#nombre').val();
        var venta = $('#precio_venta').val();
        var medida = $('#unidad_medida').val();
        var dueno = $('#dueno').val();

        if(codigo.trim() == ''){
            $('#codigo_barras').focus();
            return false;
        }if(nombre.trim() == ''){
            $('#nombre').focus();
            return false;
        }else if(venta.trim() == '' || venta.trim() < 1){
            $('#precio_venta').focus();
            return false;
        }else if(medida.trim() == '' || medida.trim() < 1){
            $('#unidad_medida').focus();
            return false;
        }else if(dueno.trim() == '' || dueno.trim() < 1) {
            $('#dueno').focus();
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


 function obtenerDatosTablaUsuarios() {
   $.ajax({
     url: "../Controllers/clienteab.php",
     type: "GET",
     data: "tabla=tabla",

     success: function (response) {
       console.log(response);
       let datos = JSON.parse(response);
       let template = "";
       $.each(datos, function (i, item) {
         template += `
         <tr>
                <td class="text-nowrap text-center">${item[0]}</td>
                <td class="text-nowrap text-center">${item[1]}</td>
                <td class="text-nowrap text-center">${item[2]}</td>
                <td class="text-nowrap text-center">${item[3]}</td>
                <td class="text-nowrap text-center">${item[4]}</td>
                <td class="text-nowrap text-center">${item[5]}</td>
                <td class="text-nowrap text-center">${item[6]}</td>
                <td class="text-nowrap text-center">${item[7]}</td>
                <td class="text-nowrap text-center">${item[8]}</td>
                <td class="text-nowrap text-center">${item[9]}</td>
                <td class="text-nowrap text-center">${item[10]}</td>
                <td class="text-nowrap text-center">${item[11]}</td>
                <td class="text-nowrap text-center">${item[12]}</td>
                <td class="text-nowrap text-center">${item[13]}</td>
                <td class="text-nowrap text-center">${item[14]}</td>
                <td class="text-nowrap text-center d-none">${item[15]}</td>
                <th class="text-nowrap text-center" style="width:100px;">
                <div class="row">
                    <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="Beditar btn btn-danger" href="#">
                      Editar
                    </a>
                </div>
                </th>
          `;
        });
        $("#cuerpo").html(template);
      }
  });
}

$(document).on("click", ".Beditar, #agregar_p", function () {
  var valores = "";
  // Obtenemos todos los valores contenidos en los <td> de la fila
  // seleccionada
  $(this).parents("tr").find("td").each(function () {
    valores += $(this).html() + "?";
  });
  datos = valores.split("?");
  console.log(datos);
  $("#codigo_barras").val(datos[0]);
  $("#modelo").val(datos[1]);
  $("#nombre").val(datos[2]);
  $("#descripcion").val(datos[3]);
  $("#categoria").val(datos[4]);
  $("#marca").val(datos[5]);
  $("#proveedor").val(datos[6]);
  $("#color").val(datos[7]);
  $("#imagen").val(datos[8]);
  $("#precio_compra").val(datos[9]);
  $("#precio_venta").val(datos[10]);
  $("#descuento").val(datos[11]);
  $("#unidad_medida").val(datos[12]);
  $("#tasa_iva").val(datos[13]);
  $("#tasa_ipes").val(datos[14]);
  $("#talla_numero").val(datos[15]);
  editar = true;
});


});
