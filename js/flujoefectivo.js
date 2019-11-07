$(document).ready(function() {
    pintarComboNegocios();
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
    }
  
    $("#form1").submit(function(e) {
      $.post(
        "../Controllers/flujoefectivo.php",
        $("#form1").serialize(),
        function(response) {
          console.log(response);
          datos = JSON.parse(response);
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
          $("#modalForm").modal("hide");
        }
      );
      e.preventDefault();
    });
  
    $("#form2").submit(function(e) {
      $.post(
        "../Controllers/flujoefectivo.php",
        $("#form2").serialize(),
        function(response) {
          console.log(response);
          datos = JSON.parse(response);
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
          $("#modalForm").modal("hide");
        }
      );
      e.preventDefault();
    });
  
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
  