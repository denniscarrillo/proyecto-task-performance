let tablaClientes = '';
$(document).ready(function () {
  tablaClientes = $('#table-VistaClientes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/cliente/obtenerClientes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "codCliente"},
      { "data": "nombreCliente"},
      { "data": "rtnCliente"},
      { "data": "telefono"},
      { "data": "direccion"}
    ]
  });
});