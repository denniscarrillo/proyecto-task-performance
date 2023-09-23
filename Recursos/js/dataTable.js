import {estadoValidado as validado } from './validacionesModalNuevoUsuario.js';
import {estadoValidado as valido } from './validacionesModalEditarUsuario.js';

let tablaUsuarios = '';
$(document).ready(function () {
  tablaUsuarios = $('#table-Usuarios').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/usuario/obtenerUsuarios.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "IdUsuario"},
      { "data": "usuario" },
      { "data": "nombreUsuario" },
      { "data": "correo" },
      { "data": "Estado" },
      { "data": "Rol" },

      {"defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });
});
// Cuando presionamos el boton aparece el modal con los siguientes campos
$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener roles
  obtenerRoles('#rol');
  //Petición para obtener estado de usuario
  obtenerEstadoUsuario('#estado');
  let fechaC = new Date().toISOString().slice(0, 10);
  $("#fecha_C").val(fechaC);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	 
});

//Crear nuevo usuario
$('#form-usuario').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let nombre = $('#nombre').val();
     let usuario = $('#usuario').val();
     let password = $('#password').val();
     let correo = $('#correo').val();
     let rol = document.getElementById('rol').value;
    //  let estado = document.getElementById('estado').value;
    /////////////////////////////////////////////////
    //validado
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/usuario/nuevoUsuario.php",
        type: "POST",
        datatype: "JSON",
        data: {
          nombre: nombre,
          usuario: usuario,
          contrasenia: password,
          correo: correo,
          idRol: rol
        },
        success: function (res) {
          //Mostrar mensaje de exito
          console.log(res);
          Swal.fire(
           'Registrado!',
           'Se le ha enviado un correo al usuario!',
           'success',
         )
         tablaUsuarios.ajax.reload(null, false);
        }
      });

     $('#modalNuevoUsuario').modal('hide');
    } 
});

$(document).on( async function(){

});


//Eliminar usuario
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let usuario = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar a '+usuario+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/usuario/eliminarUsuario.php",
          type: "POST",
          datatype:"json",    
          data:  { usuario: usuario},    
          success: function(data) {
            // let estadoEliminado = data[0].estadoEliminado;
            // console.log(data);
            // if(estadoEliminado == 'eliminado'){
              tablaUsuarios.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'El usuario ha sido eliminado.',
                'success'
              )  
            // } else {
            //   Swal.fire(
            //     'Lo sentimos!',
            //     'El usuario no puede ser eliminado.',
            //     'error'
            //   );
            // }           
          }
          }); //Fin del AJAX
      }
    });                
});

$(document).on("click", "#btn_editar", async function(){		                
  let idUsuario = $(this).closest('tr').find('td:eq(0)').text(); //capturo el ID		            
  let usuario = await obtenerUsuariosPorId(idUsuario)
  obtenerRoles('#E_rol', usuario.Id_Rol);
  obtenerEstadoUsuario('#E_estado', usuario.Id_Estado_Usuario);
  $("#E_IdUsuario").val(idUsuario);
  $("#E_nombre").val(usuario['Nombre_Usuario']);
  $("#E_usuario").val(usuario['Usuario']);
  // $("#E_password").val(contrasenia);
  $("#E_correo").val(usuario['Correo_Electronico']);
  if (!!usuario['Fecha_Creacion']) {
    let date = new Date(usuario['Fecha_Creacion'].date)
    $("#E_fecha_C").val(date.toISOString().slice(0, 10));
  }
  if (!!usuario['Fecha_Vencimiento']) {
    let dateV = new Date(usuario['Fecha_Vencimiento'].date)
    $("#E_fecha_V").val(dateV.toISOString().slice(0, 10));
  }
  $('#modalEditarUsuario').modal('show');		   
});

$('#form-Edit-Usuario').submit(function (e) { 
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let nombre = $('#E_nombre').val(),
   idUser =  $('#E_IdUsuario').val(),
   usuario = $('#E_usuario').val(),
   correo = $('#E_correo').val(),
   rol = document.getElementById('E_rol').value,
   estado = document.getElementById('E_estado').value;
   /////////////////////////////////////////////////////////////////////////////
   //console.log(valido)
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/usuario/editarUsuario.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idUsuario: idUser,
       nombre: nombre,
       usuario: usuario,
       correo: correo,
       idRol: rol,
       idEstado: estado
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El usuario ha sido modificado!',
          'success',
        )
         tablaUsuarios.ajax.reload(null, false);
      }
    });
    $('#modalEditarUsuario').modal('hide');
   }
});

//obtener datos para el modal editar
let obtenerUsuariosPorId = async (idUsuario) => {
  try {
    let datos = await $.ajax({
      url: '../../../Vista/crud/usuario/obtenerUsuarioPorId.php',
      type: 'GET',
      dataType: 'JSON',
      data: {
        IdUsuario: idUsuario
      }
    });
    return datos
  } catch(err) {
    console.error(err)
  }
}


let obtenerRoles = function (idElemento, rol_id) {
  //Petición para obtener roles
  $.ajax({
    url: '../../../Vista/crud/usuario/obtenerRoles.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion

      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_Rol + '"'+ (data[i].id_Rol === rol_id ? 'selected': '') +'>' + data[i].rol + '</option>';
        $(idElemento).html(valores);
      }
    }
    });
}
let obtenerEstadoUsuario = function (idElemento, estado_id){
    //Petición para obtener estado de usuario
    $.ajax({
      url: '../../../Vista/crud/usuario/obtenerEstadosUsuario.php',
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        let valores = '<option value="">Seleccionar...</option>';
        //Recorremos el arreglo de roles que nos devuelve la peticion
        for (let i = 0; i < data.length; i++) {
          valores += '<option value="' + data[i].id_Estado_Usuario + '"'+ (data[i].id_Estado_Usuario === estado_id ? 'selected': '') +'   >' + data[i].descripcion + '</option>';
          $(idElemento).html(valores);
        }
      }
    });
}


