let tablaDataTableTarea = '';

$(document).ready(function () {
  tablaDataTableTarea = $('#table-Tareas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableTarea/obtenerDataTableTarea.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id_Tarea' },
      { "data": 'titulo' },
      { "data": 'descripcion' },
      {"data":  'estado_Finalizacion' }
      
    ]
  });
});

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Tareas_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteConsulTarea.php?buscar='+buscar, '_blank');
});