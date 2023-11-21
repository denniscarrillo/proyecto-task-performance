let tablaDataTableTarea = '';

$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);     
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  tablaDataTableTarea = $('#table-Tareas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableTarea/obtenerDataTableTarea.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id' },
      { "data": 'estadoAvance' },
      { "data": 'rtnCliente' },
      {"data":  'nombreCliente' },
      {"data":  'titulo' },
      {"data":  'creadoPor' },
      {"data":  'diasTranscurridos' },
      {
        "defaultContent":
        `<button class="btn-editar btns btn ${(permisos.Reporte == 'N')?'hidden':''}" id="btn_editar"><i class="fas fa-file-pdf"> </i></button>`
      }
    ]
  });
}

//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) { 
    $.ajax({
        url: "../../../Vista/crud/permiso/obtenerPermisos.php",
        type: "POST",
        datatype: "JSON",
        data: {idObjeto: $idObjeto},
        success: callback
      });
}

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Tareas_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteConsulTarea.php?buscar='+buscar, '_blank');
});