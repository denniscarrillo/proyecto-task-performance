
import {estadoValidado as validado } from './validacionesModalNuevaSolicitud.js';

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
     let idEstadoSolicitud = document.getElementById('idEstadoSolicitud').value;
     let idTipoServicio = document.getElementById('idTipoServicio').value;
     let cliente = $('#cliente').val();
     let FechaEnvio = $('#fechaEnvio').val();
     let titulo = $('#tituloMensaje').val();   
     let correo = $('#correo').val(); 
     let descripcion = $('#descripcion').val();
     let ubicacion = $('#ubicacion').val();

    if(validado){
      $.ajax({
        url: "../../../Vista/crud/solicitud/nuevaSolicitud.php",
        type: "POST",
        datatype: "JSON",
        data: {
          idUsuario: usuario,
          idEstadoSolicitud: idEstadoSolicitud,
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