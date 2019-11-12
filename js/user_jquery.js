//Busqueda general en tablas//
$(document).ready(function () {
  cargarNegocios();
$('#busqueda').on('keyup', function () {
var value = $(this).val();
var patt = new RegExp(value, "i");
$('.table').find('tr').each(function () {
if (!($(this).find('td').text().search(patt) >= 0)) {
$(this).not('.encabezados').hide();
}

  if (($(this).find('td').text().search(patt) >= 0)) {
    $(this).show();
  }
});
});

$('#Navbarsucursales,#Navbarsucursales2').on('change',function(){
    
  if ($(this).val() != '') {
    $.ajax({
      url: "../Controllers/login.php",
      type: "POST",
      data: "negocio=" + $(this).val(),

      success: function (response) {
      console.log(response);
      location.reload();
      }
    });
  }
});



function cargarNegocios(){
  $.ajax({
    url: "../Controllers/login.php",
    type: "POST",
    data: "combo=combo",

    success: function (response) {
      console.log(response);
      let datos =JSON.parse(response);
      var template='<option value="">Elegir Sucursal</option>';
      $.each(datos, function(i, item) {
        template += `
        <option value="${item[0]}">${item[1]}</option>
        `;
      });
      $('#Navbarsucursales').html(template);
      $('#Navbarsucursales2').html(template);
    }
    });
}


});

//Autofocus en el primer input de los modales y las ventanas
$(document).ready(function () {
//Focus en el input de la ventana
$("input:text:visible:first").focus();
//$('input[@type="text"]')[0].focus();
//Focus en el modal
$('#modalForm').on('shown.bs.modal', function () {
$("input:text:visible:first").focus();
})
});

$(document).ready(function () {
//Estilo de los componetes

//text inputs
/* $("input:text, select, .input-group-prepend, .input-group-text").addClass("bg-dark").css({
'color' : 'white',
'border-color' : 'grey'
}); */
//Selectors
});



//Resaltar columna//
$('.table th').on('click', function () {
var $currentTable = $(this).closest('table');
var index = $(this).index();
$currentTable.find('th').removeClass('selectedTh');
$currentTable.find('td').removeClass('selectedTds');

$currentTable.find('tr').each(function () {
$(this).find('td').eq(index).addClass('selectedTds');
$(this).find('th').eq(index).addClass('selectedTh');
});
});

//Botones formulario mobiles/
$(document).ready(function () {
$('#formButton_nuevo').on('click', function () {
$('#formulario').toggleClass("d-none d-block");
$('#tableContainer').toggleClass("d-none d-block");
$(this).toggleClass("d-none");
});
$('#formButton_cancelar').on('click', function () {
$('#formulario').toggleClass("d-none d-block");
$('#tableContainer').toggleClass("d-none d-block");
$('#formButton_nuevo').toggleClass("d-none");
});
});

//Inactividad



/*Enviar Formulario con select*/
$(document).ready(function () {
  $('#sucursal').on('change', function () {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
  });
});


//Mostrar datos en el modal clienteAB>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$(document).ready(function() {

  $('.clickEditar').click(function(event){
    event.preventDefault();
    var id_cliente = $(this).attr('product');
    
    console.log(id_cliente);
    var action = 'datos_id_cliente';
    //$('#eleccion').attr('estado','editar');
   $.ajax({
     url: 'ajax.php',
     type: 'POST',
     async: true,
     data: {action:action,id_cliente:id_cliente},

   success:function(response){
        var info_cliente = JSON.parse(response);
        console.log(info_cliente);

        $('#nombre').val(info_cliente.nombre);
        $('#apt').val(info_cliente.apaterno);
        $('#apm').val(info_cliente.amaterno);
        var check = info_cliente.tipo_documento;

        if(check == 'INE'){
          $("#doccurp").attr('checked', false);
          $("#docotro").attr('checked', false); 
          $("#docine").attr('checked', true);  
        }else if(check == 'CURP'){
          $("#docotro").attr('checked', false);
          $("#docine").attr('checked', false); 
          $("#doccurp").attr('checked', true);  
        }else if(check == 'Otro'){
          $("#docine").attr('checked', false);
          $("#doccurp").attr('checked', false); 
          $("#docotro").attr('checked', true);  
        }
        $('#numdoc').val(info_cliente.numero_documento);
        $('#dir').val(info_cliente.direccion);
        $('#tel').val(info_cliente.telefono);
        $('#email').val(info_cliente.correo);
        $('#login').val(info_cliente.login);
        $('#pass').val(info_cliente.password);
        $('#estado').val(info_cliente.estado);
        $('#id_clienteab').val(info_cliente.id_clienteab);

   },
   error:function(error){
     console.log(error);
   }

  });

    
  });
  //Funcion para limpiar el modal de clientesAB al dar click
  $('.clear').click(function(e){
    e.preventDefault();
    $('#nombre').val('');
    $('#apt').val('');
    $('#apm').val('');
    $("#doccurp").attr('checked', false);
    $("#docotro").attr('checked', false); 
    $("#docine").attr('checked', true);  
    $('#numdoc').val('');
    $('#dir').val('');
    $('#tel').val('');
    $('#email').val('');
    $('#login').val('');
    $('#pass').val('');

  });

 /* $('#eleccion').click(function(e){
    e.preventDefault();
    var eleccion = $(this).attr('product');
    var nombre = document.getElementById('nombre');
    var apt = document.getElementById('apt');
    var apm = document.getElementById('apm');
    var prueva = $("#docine").attr('checked');


    if(eleccion == 'checked'){
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: {action:action,id_cliente:id_cliente},
  
        success:function(response){
  
        },
        error:function(error){
          console.log(error);
        }
      });
    }else{
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: {action:action,id_cliente:id_cliente},
  
        success:function(response){
  
        },
        error:function(error){
          console.log(error);
        }
      });
    }

  });


  function comprovar(valor){
    if(valor == "checked"){

    }
  }*/


  //>>>>>>>>>>>Modal Usuarios >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
  $('.edit_User_ab').click(function(){
    var id_usuario_ab = $(this).attr('product');
    var action = 'datos_id_usuario_ab';
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      async: true,
      data: {action:action,id_usuario_ab:id_usuario_ab},

      success:function(response){
        
        var info_usuarioAb = JSON.parse(response);
        console.log(info_usuarioAb);
        $('#id_usuario').val(info_usuarioAb.idusuariosab);
        $('#vuabnombre').val(info_usuarioAb.nombre);
        $('#vuabapt').val(info_usuarioAb.apaterno);
        $('#vuabapm').val(info_usuarioAb.amaterno);
        var acceso = info_usuarioAb.acceso;
        if(acceso == 'CEOAB'){
          $('#vuabceoab').attr('checked', true);
          $('#vuabmanager').attr('checked', false);
        }else{
          $('#vuabmanager').attr('checked', true);
          $('#vuabceoab').attr('checked', false);
        }
        $('#vuablogin').val(info_usuarioAb.login);
        $('#vuabpass').val(info_usuarioAb.password);
        var estado = info_usuarioAb.estado;
        if(estado == 'A'){
          $('#vuabA').attr('checked', true);
          $('#vuabI').attr('checked', false);
        }else{
          $('#vuabA').attr('checked', false);
          $('#vuabI').attr('checked', true);
        }
      },
      error:function(error){
        console.log(error);
      }
    });
  });
    //Funcion que limpia el modal de UsuariosAB
  $('.vuabClear').click(function(e){
    e.preventDefault();
    $('#vuabnombre').val('');
    $('#vuabapt').val('');
    $('#vuabapm').val('');
    $('#vuabceoab').attr('checked', true);
    $('#vuabmanager').attr('checked', false);
    $('#vuablogin').val('');
    $('#vuabpass').val('');
    $('#vuabA').attr('checked', true);
    $('#vuabI').attr('checked', false);
  });


  //Modal Suscripciones >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
 
  $('.vsEditmodal').click(function(){
    
    var id_suscripcion = $(this).attr('product');
    $('#id_subs').val(id_suscripcion);
    console.log(id_suscripcion);
    var action = 'datos_id_suscripcion';
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      async: true,
      data: {action:action,id_suscripcion:id_suscripcion},

      success:function(response){
        var info_suscrip = JSON.parse(response);
        console.log(info_suscrip);
        $('#vsfecha1').val(info_suscrip.fecha_activacion);
        $('#vsfecha2').val(info_suscrip.fecha_vencimiento);
        $('#vsmonto').val(info_suscrip.monto);
        var estado_sus = info_suscrip.estado;
        if(estado_sus == 'A'){
          $('#vsestadoA').attr('checked', true);
          $('#vsestadoI').attr('checked', false);
        }else{
          $('#vsestadoA').attr('checked', false);
          $('#vsestadoI').attr('checked', true);
        }
        
      },
      error:function(error){
        console.log(error);
      }
    });
  });

 

});//Leer el dom

$(document).ready(function() {
     //Modal VNegocios 

  //Extrae los datos de la base
  $('.vnEditmodal').click(function(e){
    e.preventDefault();
    console.log('llego');
    var id_negocio = $(this).attr('product');
    console.log(id_negocio);
    var action = 'datos_id_negocio';
    $.ajax({
      url: 'ajax.php',
      type: 'POST',
      async: true,
      data: {action:action,id_negocio:id_negocio},

      success:function(response){
        var info_negocio = JSON.parse(response);
        console.log(info_negocio);
        $('.id_negocio').val(info_negocio.idnegocios);
        $('#vnnombre').val(info_negocio.nombre_negocio);
        $('#vndom').val(info_negocio.domicilio);
        $('#vncd').val(info_negocio.ciudad);
        $('#nvtel').val(info_negocio.telefono_negocio);
        
        var impresora = info_negocio.impresora;
        if(impresora == 'A'){
          $('#vnimpresoraA').attr('checked', true);
          $('#vnimpresoraI').attr('checked', false);
        }else{
          $('#vnimpresoraA').attr('checked', false);
          $('#vnimpresoraI').attr('checked', true);
        }
        $('#vnincliente').val(info_negocio.nombre + " " + info_negocio.apaterno + " " + info_negocio.amaterno);
      },

      error:function(error){

      }
    });

    function clearVn(e){
      $('#vnnombre').val('');
      $('#vndom').val('');
      $('#vncd').val('');
      $('#nvtel').val('');
      $('#vnimpresoraA').attr('checked', true);
      $('#vnimpresoraI').attr('checked', false);
      $('#vnincliente').val('');
    }

    $('.vnClear').click(function(e){
      e.preventDefault();
      clearVn();
    });

/*     $('#vnguardar').click(function(e){
      alert('si llego');
      e.preventDefault();
      var vnnombre = document.getElementById('vnnombre').value;
      var vndomicilio = document.getElementById('vndom').value;
      var vnciudad = document.getElementById('vncd').value;
      var vntelefono = document.getElementById('nvtel').value;
      var vnimpresora = document.getElementById('vnsel').value;
      var vncliente = document.getElementById('vnincliente').value;
      var vnopcion = document.getElementById('vnguardar').value;
      var vnidSelect = document.getElementById('id_negocio').value;
      var action = 'postNegocio';

      console.log(vnopcion);

      $.ajax({
        url: 'formposts.php',
        type: 'POST',
        async: true,
        data: {action:action,vnnombre:vnnombre,vndomicilio:vndomicilio,vnciudad:vnciudad,vntelefono:vntelefono,
          vnimpresora:vnimpresora,vncliente:vncliente,vnopcion:vnopcion,vnidSelect:vnidSelect},

        success:function(response){
          var info = JSON.parse(response);
          console.log(info);
          e.preventDefault();
          if(info == 1){
            $(function(){
              swal({
                title: 'Exito',
                text: 'Se han registrado los datos exitosamente!',
                type: 'success'
            });
            clearVn();
            $('#modalForm').fideOut();
            });
          }else{
            $(function(){
              swal({
                title: 'Error',
                text: 'No registrado compruebe los campos unicos!',
                type: 'error'
              });
              clearVn();
            });
          }
        },
        error:function(error){
          console.log(error);
        }
      });
    });

    $('#agregarNego').click(function(){
      clearVn();
    });
*/
  });
});
