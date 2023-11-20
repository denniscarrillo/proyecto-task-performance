let tablaCotizacion = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);     
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  tablaCotizacion = $('#table-Cotizacion').DataTable({
    "ajax": {
      "url": "../../../../Vista/rendimiento/cotizacion/obtenerCotizaciones.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },  
    "columns": [
      { "data": "id"},
      { "data": "creadoPor"},
      { "data": "cliente"},
      { "data": "subDescuento"},
      { "data": "impuesto"},
      { "data": "total"},
      { "data": "estado"},
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