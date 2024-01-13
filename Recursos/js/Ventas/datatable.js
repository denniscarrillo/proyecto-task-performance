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
      { "data": "nombreCliente"},
      { "data": "rtnCliente"},
      { "data": "totalVenta"},
      { "data": "creadoPor"},
      { "data": "fechaCreacion.date" }
    ]
  });
});

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Ventas_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaVentas.php?buscar='+buscar, '_blank');
});

