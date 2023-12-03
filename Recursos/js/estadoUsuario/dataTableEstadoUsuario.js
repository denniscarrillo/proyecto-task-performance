// import {estadoValidado as validado} from './validacionesModalNuevoRol.js';
// import {estadoValidado as valido } from './validacionesModalEditarRol.js';
let validado = true;
let tablaEstadoUsuario = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  tablaEstadoUsuario = $('#table-EstadoUsuarios').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/estadoUsuario/obtenerEstadoUsuario.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idEstado" },
      { "data": 'estado' },
      { "data": 'CreadoPor' },
      { "data": 'FechaCreacion.date',
        "render": function (data) {
        return data.slice(0, 19);
        },
      },
      {
        "defaultContent":
        `<button class="btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        `<button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
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
// Crear nueva estado
$('#form-estado').submit(function (e) {
    e.preventDefault();
    let estado = $('#estado').val();
    console.log(estado);
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/estadoUsuario/nuevoEstadoUsuario.php",
        type: "POST",
        datatype: "JSON",
        data: { 
          estado: estado,
        },
        success: function () {
        //Mostrar mensaje de exito
          Swal.fire(
            'Registrado!',
            'El estado usuario ha sido registrado.',
            'success',
          )
          tablaEstadoUsuario.ajax.reload(null, false);
         }
       });
        $('#modalNuevoEstadoUsuario').modal('hide');
      }
  });