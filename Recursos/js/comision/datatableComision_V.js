

let tablaComisionVendedor = '';
$(document).ready(function () {
  tablaComisionVendedor = $('#table-ComisionVendedor').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/ComisionesVendedores/obtenerComisiones_V.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idComisionVendedor"},
      { "data": "idVendedor" },
      { "data": "usuario" },
      { "data": "comisionTotal" },
      { "data": "estadoComision" },
      { "data": "fechaComision" },
    ]
  });
});
