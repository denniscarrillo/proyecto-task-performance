let tablaDataTableSolicitud = '';

$(document).ready(function () {
  tablaDataTableSolicitud = $('#table-Solicitud').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableSolicitud/obtenerDataTableSolicitud.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id_Solicitud' },
      { "data": 'servicio_Tecnico' },
      { "data": 'telefono_cliente' },
      {"data":  'EstadoAvance' },
      { "data": 'EstadoSolicitud' },
      { "data": 'motivo_cancelacion' },
      {"data":  'Fecha_Creacion' }
      
    ]
  });
});
