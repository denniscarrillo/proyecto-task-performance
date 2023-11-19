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

$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Objeto_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaObjetos.php?buscar='+buscar, '_blank');
});