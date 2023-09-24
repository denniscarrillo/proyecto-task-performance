import {estadoValidado as validado } from './ValidacionesModalNuevoPermiso.js';
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
      {"defaultContent":
        `<input type="checkbox" id="" class="check-permiso">` 
      }, 
      {"defaultContent":
        `<input type="checkbox" id="" class="check-permiso">` 
      },
      {"defaultContent":
        '<input type="checkbox">' 
      },
      {"defaultContent":
        '<input type="checkbox">' 
      },
      {"defaultContent":
      '<div><button class="btns btn" id="btn_confirm"><i class="fa-solid fa-circle-check icon-confirm"></i></button>' 
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

$('#form-permiso').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let rol = document.getElementById('rol').value;
     let objeto = document.getElementById('objeto').value;
     let consultar = document.getElementById('consultar').value;
     let insertar = document.getElementById('insertar').value;
     let actualizar = document.getElementById('actualizar').value;
     let eliminar = document.getElementById('eliminar').value;
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/usuario/nuevoPermiso.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rol: rol,
          objeto: objeto,
          consultar: consultar,
          insertar: insertar,
          actualizar: actualizar,
          eliminar: eliminar
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Registrado!',
           'Se ha creado un nuevo permiso!',
           'success',
         )
         tablaPermisos.ajax.reload(null, false);
        }
      });
     $('#modalNuevoPermiso').modal('hide');
    } 
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