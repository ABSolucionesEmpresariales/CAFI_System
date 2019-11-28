$(document).ready(function() {
  pintarAnos();
  pintarTabla();

  function pintarAnos(){
    let template2 = "<option value=''>Elejir</option>";
    for($i=19; $i <= 30; $i++){
      template2+=`<option value="20${$i}">20${$i}</option>`;
    }
    $('.anosFiltro').html(template2);
  }

  function pintarTabla(){
    $.ajax({
      url: "../Controllers/flujoefectivo.php",
      type: "POST",
      data: "tabla=tabla",
      success: function (response) {
        console.log(response);
        let template = "";
        datos = JSON.parse(response);
        arrayTitulos = ["Ingresos por venta","Otros ingresos","Total de ingreso","Total de egresos","Flujo operacional"];
        $.each(datos, function (i, item) {
          template += ` 
          <tr>
          <td>${arrayTitulos[i]}</td>
          `;
          for(i = 0; i < 12; i++){
            template += ` 
            <td class="${i+1}">$${item[i]}</td>
            `;
          }
          template += ` 
          </tr>
          `;
        });
        $("#cuerpoFlujo").html(template);
      }
    });
  }

/*     pintarComboNegocios();

    function pintarComboNegocios() {
      $.ajax({
        url: "../Controllers/flujoefectivo.php",
        type: "POST",
        data: "combo=negocio",
        success: function(response) {
          let datos = JSON.parse(response);
          let template = "";
          template += `<option value=""></option>`;
          $.each(datos, function(i, item) {
            template += `
              <option value="${item[0]}">${item[1]}</option>   
              `;
          });
          template += `<option value="Todos">Todos</option>`;
          $(".combosucursal").html(template);
        }
      });
    } */
  

    $(document).on('click','#prueva',function(){
      console.log($('#inmes').val());
      ano_mes = $('#inmes').val();
      mes = ano_mes.split('-');
      for(i=1; i <= 12; i++){
        if(i != mes[1]){
          $("."+i).addClass('d-none');
        }else{
          $("."+i).removeClass('d-none');
        }
      }
    });
  
/*     $("#form2").submit(function(e) {
      
      e.preventDefault();
    }); */

    $(document).on("change",".anosFiltro",function(){
      const data = {
        
      };
      $.ajax({
        url: "../Controllers/flujoefectivo.php",
        type: "POST",
        data: "año:"+$('.anosFiltro').val(),

        success: function(response) {
          console.log(response);
          let template = "";
          datos = JSON.parse(response);
          arrayTitulos = ["ingresos por venta","Otros ingresos","total de ingreso","total de egresos","flujo operacional"];
          $.each(datos, function (i, item) {
            template += ` 
            <tr>
            <td>${arrayTitulos[i]}</td>
            `;
            for(i = 0; i < 12; i++){
              template += ` 
              <td class="${i+1}">$${item[i]}</td>
              `;
            }
            template += ` 
            </tr>
            `;
          });
          $("#cuerpoFlujo").html(template);
        }
      });
    });
  
/*     $(document).on("change", "#sucursal", function() {
      const postData = {
        negocio: $("#sucursal").val()
      };
      $.post("../Controllers/flujoefectivo.php", postData, function(response) {
        let datos = JSON.parse(response);
         let template = ` 
        <tr>
        <td>${datos.ventas}</td>
        <td>${datos.otros_ingresos}</td>
        <td>${datos.gastos}</td>
        <td>${datos.retiros}</td>
        <td>${datos.efectivo}</td>
        </tr>
        `;
        $("#cuerpo1").html(template);
        template = `
        <tr>
        <td>${datos.ingresos_efectivo}</td>
        <td>${datos.ingresos_banco}</td>
        <td>${datos.ingresos_credito}</td>
        <td>${datos.otros_ingresos_efectivo}</td>
        <td>${datos.otros_ingresos_banco}</td>
        </tr>
        `;
        $("#cuerpo2").html(template);
      });
    }); */

  });
  