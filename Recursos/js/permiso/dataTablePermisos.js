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
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' 
      }
    ]
  });
});
$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener roles
  obtenerRoles('#rol');
  //Petición para obtener estado de usuario
  obtenerObjeto('#objeto');
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	 
});
let obtenerRoles = function (idElemento) {
  //Petición para obtener roles
  $.ajax({
    url: '../../../Vista/crud/usuario/obtenerRoles.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_Rol + '">' + data[i].rol + '</option>';
        $(idElemento).html(valores);
      }
    }
    });
}
let obtenerObjeto = function (idElemento) {
  //Petición para obtener roles
  $.ajax({
    url: '../../../Vista/crud/permiso/obtenerObjetos.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_Objeto + '">' + data[i].objeto + '</option>';
        $(idElemento).html(valores);
      }
    }
    });
}