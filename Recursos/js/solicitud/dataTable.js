
import { estadoValidado as validado } from './validacionesModalNuevaSolicitud.js';
import {estadoValidado as valido } from './validacionesModalEditarSolicitud.js';

let tablaSolicitudes = '';
$(document).ready(function () {
  tablaSolicitudes = $('#table-Solicitudes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/solicitud/obtenerSolicitudes.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "IdSolicitud" },
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


$('#btn_nuevoRegistro').click(function () {
  //Petición para obtener estado
  obtenerEstadoSolicitudes('#idEstadoSolicitud');
  // //Petición para obtener tipo solicitudes
  obtenerTipoSolicitudes('#idTipoServicio');

  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");

});
//Crear nueva solicitud
$('#form-solicitud').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos de la nueva Solicitud
  let usuario = $('#usuario').val();
  let idTipoServicio = document.getElementById('idTipoServicio').value;
  let cliente = $('#cliente').val();
  let FechaEnvio = $('#fechaEnvio').val();
  let titulo = $('#tituloMensaje').val();
  let correo = $('#correo').val();
  let descripcion = $('#descripcion').val();
  let ubicacion = $('#ubicacion').val();

  if (validado) {
    $.ajax({
      url: "../../../Vista/crud/solicitud/nuevaSolicitud.php",
      type: "POST",
      datatype: "JSON",
      data: {
        /* idUsuario: usuario, */
        idUsuario: usuario,
        idTipoServicio: idTipoServicio,
        idCliente: cliente,
        fechaEnvio: FechaEnvio,
        titulo: titulo,
        correo: correo,
        descripcion: descripcion,
        ubicacion: ubicacion
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Registrada!',

        )
        tablaSolicitudes.ajax.reload(null, false);
      }
    });
    $('#modalNuevaSolicitud').modal('hide');
  }
});

let obtenerTipoSolicitudes = function (idElemento) {
  //Petición para obtener tipo solicitudes
  $.ajax({
    url: '../../../Vista/crud/solicitud/obtenerTiposSolicitudes.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_TipoServicio + '">' + data[i].servicio_Tecnico + '</option>';
        $(idElemento).html(valores);
      }
    }
  });
}

let obtenerEstadoSolicitudes = function (idElemento) {
  //Petición para obtener estods solicitudes
  $.ajax({
    url: '../../../Vista/crud/solicitud/obtenerEstadosSolicitud.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_EstadoSolicitud + '">' + data[i].estadoSolicitud + '</option>';
        $(idElemento).html(valores);
      }
    }
  });
}


$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    IdSolicitud = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
    fechaEnvio = fila.find('td:eq(1)').text(),
    descripcion = fila.find('td:eq(2)').text(),
    correo = fila.find('td:eq(3)').text(),
    ubicacion = fila.find('td:eq(4)').text(),
    idEstadoSolicitud = fila.find('td:eq(5)').text(),
    idTipoServicio = fila.find('td:eq(6)').text(),
    cliente = fila.find('td:eq(7)').text(),
    idUsuario = fila.find('td:eq(8)').text();
  $("#E_IdSolicitud").val(IdSolicitud);
  $("#E_fechaEnvio").val(fechaEnvio);
  $("#E_descripcion").val(descripcion);
  $("#E_correo").val(correo);
  $("#E_ubicacion").val(ubicacion);
  $("#E_idEstadoSolicitud").val(obtenerEstadoSolicitudes('#E_idEstadoSolicitud'));
  $("#E_idTipoServicio").val(obtenerTipoSolicitudes('#E_idTipoServicio'));
  $("E_cliente").val(cliente);
  $("E_idUsuario").val(idUsuario);

  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $('#modalEditarSolicitud').modal('show');
});

$('#form-Edit-Solicitud').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos de la solicitud
    let descripcion = $('#E_descripcion').val(),
    IdSolicitud = $('#E_IdSolicitud').val(),
    fechaEnvio = $('#E_fechaEnvio').val(),
    correo = $('#E_correo').val(),
    ubicacion = $('#E_ubicacion').val(),
    estadoSolicitud = document.getElementById('E_idEstadoSolicitud').value,
    tipoServicio = document.getElementById('E_idTipoServicio').value,
    usuario = $('#E_idUsuario').val(),
    cliente = $('#E_cliente').val();
  if (valido) {
    $.ajax({
      url: "../../../Vista/crud/solicitud/editarSolicitud.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idSolicitud: IdSolicitud,
        fechaEnvio: fechaEnvio,
        descripcion: descripcion,
        correo: correo,
        ubicacion: ubicacion,
        idEstadoSolicitud: estadoSolicitud,
        idTipoServicio: tipoServicio,
        idCliente: cliente,
        idUsuario: usuario
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'La solicitud ha sido modificada!',
          'success',
        )
        tablaSolicitudes.ajax.reload(null, false);
      }
    });
    $('#modalEditarSolicitud').modal('hide');
  }
});

//Eliminar solicitud
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let solicitud = $(this).closest('tr').find('td:eq(2)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar a '+solicitud+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/solicitud/eliminarSolicitud.php",
          type: "POST",
          datatype:"json",    
          data:  { solicitud: solicitud},    
          success: function(data) {
              tablaSolicitudes.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminada!',
                'La solicitud ha sido eliminada.',
                'success'
              )         
          }
          }); //Fin del AJAX
      }
    });                
});
