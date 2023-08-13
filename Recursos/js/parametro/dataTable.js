let tablaParametro = '';
$(document).ready(function () {
  tablaParametro = $('#table-Parametro').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/parametro/obtenerParametro.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id"},
      { "data": "parametro" },
      { "data": "valorParametro" },
      { "data": "usuario" },
      {"defaultContent":
          '<div><button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button></div>'
      }
    ]
  });
});