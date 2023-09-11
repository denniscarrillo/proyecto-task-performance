let tablaVentas = '';
$(document).ready(function () {
  tablaVentas = $('#table-Ventas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Venta/obtenerVenta.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "numFactura"},
      { "data": 'codCliente' },
      { "data": 'nombreCliente' },
      { "data": 'rtnCliente' },
      { "data": 'fechaEmision.date'},
      { "data": 'totalBruto' },
      { "data": 'totalImpuesto'},
      { "data": 'totalNeto' }
    ]
  });

  $('#btn_ver').click(function () {
    let numFactura = $(this).closest('tr').find('td:eq(0)').text();
    GenerarReporte(numFactura);
  });

  let GenerarReporte = (numFactura) => {
    $.ajax({
      url: "../../../Vista/fpdf/Reporte_Venta.php",
      type: "POST",
      datatype: "JSON",
      data: {
        numFactura: numFactura
      }
    }); //Fin AJAX
  }

});

