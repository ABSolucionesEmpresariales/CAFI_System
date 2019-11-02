$(document).ready(function () {
  //variables globales
  let editar = false;
  let idSuscripcion = "";
  let extra = 99;
  let uno = 450;
  let dos = 540;
  let tres = 585;

  obtenerDatosTablaUsuarios();
  obtenerNegocios();

  $(".close").click(function () {
    $("#formulario").trigger("reset");
    $("#mensaje").css("display", "none");
  });

  $('#usuario_extra').on('keyup',function(){

      var paquete = $('#paquete').val();
      if(paquete == 0){
        pack = 0;
      }
      if(paquete == 1){
        pack = uno;
      }else if(paquete == 2){
        pack = dos;
      }else if(paquete == 3){
        pack = tres;
      }
      if($(this).val() == ''){
        total_usuarios = parseInt(0) * extra + pack;
      }else{
        $('#monto').val(total_usuarios = parseInt($(this).val()) * extra + pack);
      }
  });


  $('#paquete').on('change',function(){
    var paquete = $(this).val();
    var cant_usuario_extra = $('#usuario_extra').val();

    if(paquete == 1){
      $('#monto').val(total_usuarios = parseInt(cant_usuario_extra) * extra + uno);
    }else if(paquete == 2){
      $('#monto').val(total_usuarios = parseInt(cant_usuario_extra) * extra + dos);
    }else if(paquete == 3){
      $('#monto').val(total_usuarios = parseInt(cant_usuario_extra) * extra + tres);
    }
  });


  $('#estado').on('change',function(){
    if(editar == true && $(this).val() == 'I'){
      swal("Alerta!", 
           "Esto afectara a tosdos los trabajadores de este negocio!!", 
           "warning"
           );
    }
  });

  $('#usuario_extra').on('click',function(){
    var cant_usuario_extra = $(this).val();
    var paquete = $('#paquete').val();
    var pack;
    if(paquete == 0){
      pack = 0;
    }
    if(paquete == 1){
      pack = uno;
    }else if(paquete == 2){
      pack = dos;
    }else if(paquete == 3){
      pack = tres;
    }
    $('#monto').val(total_usuarios = parseInt(cant_usuario_extra) * extra + pack);
  });



  function obtenerNegocios(){
    $.ajax({
      url: "../Controllers/suscripcion.php",
      type: "POST",
      data: "combo=combo",

      success: function (response) {
        let datos = JSON.parse(response);
        console.log(datos);
        let template1 = "";

        $.each(datos, function(i, item) {
          template1 += `
          <option value="${item[0]}">${item[1]}</option>
          `;
        });
        $('#negocio').html(template1);
    }
  });
  }

  $('.agregar').click(function(){
    editar = false;
    $('.ocultar').show();
  });

  $("#login").keyup(function () {
    var username = $("#email").val();
    if (username.length >= 7) {
      $(".contro").show();
      $.post("username_check.php", {
        username2: username
      }, function (data, status) {
        $("#status").html(data);
      });
    } else {
      $(".contro").hide();
    }
  });

  $("#formulario").submit(function (e) {

    $.post("../Controllers/suscripcion.php",$("#formulario").serialize() + '&idsuscripcion=' + idSuscripcion + '&accion=' + editar, function (response) {
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

      obtenerDatosTablaUsuarios();
    });
    e.preventDefault();
  });

  function obtenerDatosTablaUsuarios() {
    $.ajax({
      url: "../Controllers/suscripcion.php",
      type: "POST",
      data: "tabla=tabla",
      success: function (response) {

       let datos = JSON.parse(response);
        let template = "";
        $.each(datos, function (i, item) {
          template += `
          <tr>
                <td class="text-nowrap text-center d-none">${item[0]}</td>
                <td class="text-nowrap text-center">${item[1]}</td>
                <td class="text-nowrap text-center">${item[2]}</td>
                <td class="text-nowrap text-center">${item[3]}</td>
                <td class="text-nowrap text-center">${item[4]}</td>
                <td class="text-nowrap text-center">${item[5]}</td>
                <td class="text-nowrap text-center">${item[6]}</td>
                <td class="text-nowrap text-center">${item[7]}</td>
                <td class="text-nowrap text-center d-none">${item[8]}</td>
                <td class="text-nowrap text-center">${item[9]}</td>
          `;
        });
        $("#cuerpo").html(template);
      }
    });
  }

  var touchtime = 0;
  $(document).on("click", "td", function () {
      if (touchtime == 0) {
        touchtime = new Date().getTime();
      } else {
        // compare first click to this click and see if they occurred within double click threshold
        if (new Date().getTime() - touchtime < 800) {
          // double click occurred
          var valores = "";
          // Obtenemos todos los valores contenidos en los <td> de la fila
          // seleccionada
          $(this).parents("tr").find("td").each(function () {
            valores += $(this).html() + "?";
          });
          datos = valores.split("?");
          console.log(datos[0]);
          idSuscripcion = datos[0];
          $('.ocultar').hide();
          $("#fecha_activacion").val(datos[1]);
          $("#fecha_vencimiento").val(datos[2]);
          $("#estado").val(datos[3]);
          $("#monto").val(datos[4]);
          $("#paquete").val(datos[5]);
          $("#usuario_extra").val(datos[6]);
          var template = `<option value='${datos[8]}'>${datos[7]}</option>`;
          $("#negocio").html(template);
          editar = true;
        $("#modalForm").modal("show");
        } else {
          // not a double click so set as a new first click
          touchtime = new Date().getTime();
        }
      }
  }); 

});
