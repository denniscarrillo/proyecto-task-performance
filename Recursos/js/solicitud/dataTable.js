
let tablaSolicitudes = '';
$(document).ready(function () {
  tablaSolicitudes = $('#table-Solicitudes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/solicitud/obtenerSolicitudes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "IdSolicitud"},
      { "data": "Fecha_Envio" },
      { "data": "Descripcion" },
      { "data": "Correo" },
      { "data": "Ubicacion" },
      { "data": "EstadoSolicitud" },
      { "data": "ServicioTecnico" },
      { "data": "NombreCliente" },
      { "data": "Usuario" },

      {
        "defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });

});
