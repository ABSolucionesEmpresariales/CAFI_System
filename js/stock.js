$(document).ready(function () {
  // $(document).on("dblclick","td", function(e) {
  //  // code here
  //
  //
  //      var valores = "";
  //     $(this).parents("tr").find("td").each(function () {
  //        valores+= $(this).html()+"?";
  //      });
  //
  //      datos = valores.split("?");
  //      console.log(datos);
  //
  //      $("#producto").val(datos[0]);
  //      $("#localizacion").val(datos[1]);
  //      $("#stock").val(datos[2]);
  //      $("#stock_minimo").val(datos[3]);
  //      $("#estado").val(datos[4]);
  //      $("#usuariocafi").val(datos[5]);
  //      $("#negocio").val(datos[6]);
  //
  //      $('#modalForm2').modal('show');
  //
  //    $('#accion').val("true");
  //
  //     });

editar = false;
console.log("entro al js");

  $(document).on('click','#bclose', function(){
    var boton = $(this).attr('id');

     if(boton == "bclose"){
        var producto = $('#producto').val();
        var stock = $('#stock').val();
        var estado = $('#estado').val();

        if(producto.trim() == ''){
            $('#producto').focus();
            return false;
        }if(stock.trim() == ''){
            $('#stock').focus();
            return false;
        }else if(estado.trim() == '' || estado.trim() < 1){
            $('#estado').focus();
            return false;
        }
        }
  });

  editar = false;
  console.log("entro al js");
  obtenerDatosTablaProductos();

  $(document).on('click','#Binventariar',function(){
    $.ajax({
      url: "../Controllers/generador.php",
      type: "Get",

      success: function (response) {

        $('#modalStock').modal('show');

      }
      });
  });


  $("#inventario2").submit(function (e) {
 var formData = new FormData(this);

 $.ajax({
   url: "../Controllers/stock.php",
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
                <td class="text-nowrap text-center d-none">${item[6]}</td>
                <th class="text-nowrap text-center" style="width:100px;">
                <div class="row">
                <a data-toggle="modal" data-target="#modalStock" style="margin: 0 auto;" class="Beditar btn btn-danger" href="#">
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

$(document).on("click", ".Beditar, #tableHolder", function () {
  var valores = "";
  // Obtenemos todos los valores contenidos en los <td> de la fila
  // seleccionada
  $(this).parents("tr").find("td").each(function () {
    valores += $(this).html() + "?";
  });
  datos = valores.split("?");
  console.log(datos);
  $("#producto").val(datos[0]);
  $("#localizacion").val(datos[1]);
  $("#stock").val(datos[2]);
  $("#stock_minimo").val(datos[3]);
  $("#estado").val(datos[4]);
  $('#usuariocafi').val(datos[5]);
  $("#negocio").val(datos[6]);
  editar = true;
});


});
