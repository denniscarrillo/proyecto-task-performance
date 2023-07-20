let tablaCarteraClientes = '';
$(document).ready(function () {
  tablaCarteraClientes = $('#table-CarteraClientes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/carteraCliente/obtenerCarteraClientes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idcarteraCliente"},
      { "data": "nombre"},
      { "data": "rtn"},
      { "data": "telefono"},
      { "data": "correo"},
      { "data": "estadoContacto"}
    ]
  });

});