$(document).ready(function() {

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
  
    $("#form1").submit(function(e) {
      $.post("../Controllers/flujoefectivo.php",$("#form1").serialize(),function(response) {
          console.log(response);
          let template = "";
          datos = JSON.parse(response);
          arrayTitulos = ["ingresos por venta","total de ingreso","total de egresos","flujo operacional"];
          $.each(datos, function (i, item) {
            template = ` 
            <tr>
            <td>${arrayTitulos[i]}</td>
            </tr>
            `;
            for(i = 0; i < 12; i++){
              template = ` 
              <td id="${i+1}">${item[i]}</td>
              `;
            }
            template = ` 
            </tr>
            `;
          });
          $("#cuerpo1").html(template);
        });
      e.preventDefault();
    });

    $(document).on('click','#prueva',function(){
      console.log($('#inmes').val());
      ano_mes = $('#inmes').val();
      mes = ano_mes.split('-');
      for(i=1; i <= 12; i++){
        if(i != mes[1]){
          $("#"+i).addClass('d-none');
        }
      }
    });
  
/*     $("#form2").submit(function(e) {
      
      e.preventDefault();
    }); */
  
    $(document).on("change", "#sucursal", function() {
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
    });

  });
  