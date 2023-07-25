let tablaCarteraClientes = '';
$(document).ready(function () {
  tablaCarteraClientes = $('#table-CarteraClientes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/carteraCliente/obtenerCarteraClientes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idcarteraCliente"},
      { "data": "nombre"},
      { "data": "rtn"},
      { "data": "telefono"},
      { "data": "correo"},
      { "data": "estadoContacto"}
    ]
  });

});

$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener roles
  obtenerRoles('#rol');
  //Petición para obtener estado de usuario
  obtenerEstadoUsuario('#estado');
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
        success: function () {
          //Mostrar mensaje de exito
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

let obtenerContactoCliente = function (idElemento) {
  //Petición para obtener estados contacto clientes
  $.ajax({
    url: '../../../Vista/crud/carteracliente/obtenerContactoCliente.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de estados que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_EstadoContacto + '">' + data[i].descripcion + '</option>';
        $(idElemento).html(valores);
      }
    }
    });
}