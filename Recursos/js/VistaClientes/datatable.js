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
      { "data": "idCliente"},
      { "data": "nombre" },
      { "data": "rtn" },
      { "data": "telefono" },
      { "data": "correo" },
      { "data": "descripcion" }
    ]
  });

});