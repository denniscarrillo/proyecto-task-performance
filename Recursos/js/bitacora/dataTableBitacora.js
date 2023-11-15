let tablaBitacora = '';
$(document).ready(function () {
  tablaBitacora = $('#table-Bitacora').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/bitacora/obtenerBitacora.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Bitacora"},
      { "data": "fecha.date" },
      { "data": "Usuario" },
      { "data": "Objeto" },
      { "data": "accion" },
      { "data": "descripcion" },
    ]
  });

  $('#btn_ver').click(function () {
    let id_Bitacora = $(this).closest('tr').find('td:eq(0)').text();
    GenerarReporte(id_Bitacora);
  });

  let GenerarReporte = (id_Bitacora) => {
    $.ajax({
      url: "../../../Vista/fpdf/Reporte_rol.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_Bitacora: id_Bitacora
      }
    }); //Fin AJAX
  }
});

$(document).on("click", "#btn_depurar", function() { 
  let $fechaDesde = document.getElementById('fecha-desde').value;
  let $fechaHasta = document.getElementById('fecha-hasta').value; 
  console.log($fechaDesde, $fechaHasta);
  $.ajax({
    url: "../../../Vista/crud/bitacora/depurarBitacora.php",
    type: "POST",
    datatype:"json",    
    data:  { 
      fechaDesde: $fechaDesde,
      $fechaHasta:$fechaHasta
    },    
    success: function(data) {          
    }
    }); //Fin del AJAX               
});

$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Bitacora_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaBitacora.php?buscar='+buscar, '_blank');
});
