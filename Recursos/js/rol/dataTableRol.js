import {estadoValidado as validado} from './validacionesModalNuevoRol.js';
import {estadoValidado as valido } from './validacionesModalEditarRol.js';
let tablaRol = '';

$(document).ready(function () {
  tablaRol = $('#table-Rol').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/rol/obtenerRoles.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Rol" },
      { "data": 'rol' },
      { "data": 'descripcion' },
      {
        "defaultContent":
        '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>'
      }
    ]
  });

  // Crear nuevo rol
  $('#form-Rol').submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
       //Obtener datos del nuevo Usuario
       let rol = $('#rol').val();
       let descripcion = $('#descripcion').val();
      if(validado){
        $.ajax({
          url: "../../../Vista/crud/rol/nuevoRol.php",
          type: "POST",
          datatype: "JSON",
          data: {
            rolUsuario: rol,
            descripcionRol: descripcion,
          },
          success: function () {
            //Mostrar mensaje de exito
            Swal.fire(
             'Registrado!',
             'Se ha registrado un nuevo Rol de Usuario!',
             'success',
           )
           tablaRol.ajax.reload(null, false);
          }
        });
       $('#modalNuevoRol').modal('hide');
      } 
  });
  
  // Eliminar rol
  $(document).on("click", "#btn_eliminar", function () {
    let fila = $(this);
    let rol = fila.closest('tr').find('td:eq(1)').text();

    Swal.fire({
      title: '¿Estás seguro de eliminar a ' + rol + '?',
      text: "¡Esta acción no se puede revertir!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../../Vista/crud/rol/eliminarRol.php",
          type: "POST",
          datatype: "json",
          data: { rol: rol },
          success: function (data) {
            tablaRol.row(fila.parents('tr')).remove().draw();
            Swal.fire(
              'Eliminado',
              'El rol ha sido eliminado.',
              'success'
            );
          }
        });
      }
    });
  });
  //Editar un rol
  $(document).on("click", "#btn_editar", function(){		        
    let fila = $(this).closest("tr"),	        
    id_Rol = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
    rol = fila.find('td:eq(1)').text(),
    descripcion = fila.find('td:eq(2)').text();
    $("#E_IdRol").val(id_Rol);
    $("#E_rol").val(rol);
    $("#E_descripcion").val(descripcion);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");	
    $('#modalEditarRol').modal('show');		   
  });
  
  $('#form-Edit-Rol').submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let idRol = $('#E_IdRol').val(),
     rol =  $('#E_rol').val(),
     descripcion = $('#E_descripcion').val();
     console.log(rol);
     if(valido){
      $.ajax({
        url: "../../../Vista/crud/rol/editarRol.php",
        type: "POST",
        datatype: "JSON",
        data: {
         idRol: idRol,
         rol: rol,
         descripcion: descripcion
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
            'Actualizado!',
            'El Rol ha sido modificado!',
            'success',
          )
          tablaRol.ajax.reload(null, false);
        }
      });
      $('#modalEditarRol').modal('hide');
     }
  });
});
