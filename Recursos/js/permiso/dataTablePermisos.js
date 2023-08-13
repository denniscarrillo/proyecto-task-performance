// import {estadoValidado as validado } from './validacionesModalNuevoUsuario.js';
// import {estadoValidado as valido } from './validacionesModalEditarUsuario.js';

let tablaPermisos = '';
$(document).ready(function () {
    tablaPermisos = $('#table-Permisos').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/permiso/obtenerPermiso.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "rolUsuario"},
      { "data": "objetoSistema" },
      { "data": "consultar" },
      { "data": "insertar" },
      { "data": "actualizar" },
      { "data": "eliminar" },
      {"defaultContent":
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });
});