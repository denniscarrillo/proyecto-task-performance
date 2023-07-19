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
      { "data": "idventa"},
      { "data": "fechaEmision" },
      { "data": "nombreCliente" },
      { "data": "nombreUsuario" },
      { "data": "totalDescuento" },
      { "data": "subtotalVenta" },
      { "data": "totalImpuesto" },
      { "data": "totalVenta" },
      { "data": "estadoVenta" }
    ]
  });

});

