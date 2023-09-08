let tablaDataTableObjeto = '';

$(document).ready(function () {
  tablaDataTableObjeto = $('#table-Objeto').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableObjeto/obtenerDataTableObjeto.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id_Objeto' },
      { "data": 'objeto' },
      { "data": 'descripcion' },
      {"data":  'tipo_Objeto' }
    ]
  });
});