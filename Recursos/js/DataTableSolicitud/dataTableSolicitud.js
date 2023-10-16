
let tablaDataTableSolicitud = ''; 
//Variable dataTable
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  
  tablaDataTableSolicitud = $('#table-Solicitud').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableSolicitud/obtenerDataTableSolicitud.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id_Solicitud' },
      { "data": 'servicio_Tecnico' },
      // { "data": 'Nombre' },
      { "data": 'telefono_cliente' },
      {"data":  'EstadoAvance' },
      { "data": 'EstadoSolicitud' },
      { "data": 'motivo_cancelacion' },
      {"data":  'Fecha_Creacion.date' },
      {
        "defaultContent":
         '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
        `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
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

$(document).on("click", "#btn_editar", async function(){		 
  // Obtener la fila más cercana al botón
  let fila = $(this).closest("tr");
  // Capturar el ID de la solicitud
  let idSolicitud = fila.find('td:eq(0)').text();
  let Solicitudes = await obtenerSolicitudesPorId(idSolicitud);
  //LLenar Campos de modal Editar Solicitud
  $("#E_IdSolicitud").val(idSolicitud);
  $("#E_descripcion").val(Solicitudes['descripcion']);
  $("#E_TipoServicio").val(Solicitudes['TipoServicio']);
  $("#E_telefono_cliente").val(Solicitudes['telefono']);
  $("#E_ubicacion").val(Solicitudes['ubicacion']);
  $("#E_AvanceSolicitud").val(Solicitudes['EstadoAvance']);
  $("#E_EstadoSolicitud").val(Solicitudes['EstadoSolicitud']);
  $("#E_Motivo").val(Solicitudes['motivoCancelacion']);
  $("#E_CreadoPor").val(Solicitudes['CreadoPor']);
  let dateS = new Date(Solicitudes['FechaCreacion'].date)
  $("#E_FechaCreacion").val(dateS.toISOString().slice(0, 10));
  // Estilizar el modal
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  // Mostrar el modal
  $('#modalEditarSolicitud').modal('show');
});

//obtener datos para el modal editar
let obtenerSolicitudesPorId = async (idSolicitud) => {
  try {
    let datosSolicitud = await $.ajax({
      url: '../../../Vista/crud/DataTableSolicitud/obtenerDataTableSolicitudId.php',
      type: 'GET',
      dataType: 'JSON',
      data: {
        IdSolicitud: idSolicitud
      }
    });
    return datosSolicitud; //Retornamos la data recibida por ajax
  } catch(err) {
    console.error(err)
  }
}

$('#form-Edit-Solicitud').submit(function (e) { 
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let idSolicitud = $('#E_IdSolicitud').val(),
   descripcion =  $('#E_descripcion').val(),
   telefono = $('#E_telefono_cliente').val(),
   ubicacion = $('#E_ubicacion').val(),
   EstadoAvance =  $('#E_AvanceSolicitud').val();
    //valido
    if(true){
      $.ajax({
        url: "../../../Vista/crud/DataTableSolicitud/editarDataTableSolicitud.php",
        type: "POST",
        datatype: "JSON",
        data: {
          idSolicitud: idSolicitud,
          descripcion: descripcion,
          telefono: telefono,
          ubicacion: ubicacion,
          EstadoAvance: EstadoAvance
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
            'Actualizado!',
            'La solicitud ha sido modificado!',
            'success',
          )
          tablaDataTableSolicitud.ajax.reload(null, false);
        }
      });
      $('#modalEditarSolicitud').modal('hide');
   }
});

$(document).on("click", "#btn_eliminar", function(){		
  // Obtener la fila más cercana al botón
  let fila = $(this).closest("tr");
  // Capturar el ID de la solicitud
  let idSolicitud = fila.find('td:eq(0)').text();
  // Establecer el estado de la solicitud
  let EstadoSolicitud = 'CANCELADO';
  // Obtener el motivo de cancelación
  
  // Establecer valores en los campos del modal
  $("#C_IdSolicitud").val(idSolicitud);
  $("#C_EstadoSolicitud").val(EstadoSolicitud);
  
  // Estilizar el modal
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  // Mostrar el modal
  $('#modalCancelacionSolicitud').modal('show');
});

$('#form-Solicitud').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let idSolicitud = $('#C_IdSolicitud').val(),
    EstadoSolicitud =  $('#C_EstadoSolicitud').val(),
    MotivoCancelacion =  $('#C_MotivoCancelacion').val()
   Swal.fire({
    title: 'Estas seguro de cancelar la Solicitud?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Cancelalo!'
  }).then((result) => {
    if (result.isConfirmed) { 
      if(true){    
      $.ajax({
        url: "../../../Vista/crud/DataTableSolicitud/editarEstadoSolicitud.php",
        type: "POST",
        datatype:"JSON",    
        data:{ 
          idSolicitud: idSolicitud,
          EstadoSolicitud: EstadoSolicitud,
          MotivoCancelacion: MotivoCancelacion
        },    
        success: function(data) {          
          console.log(data);  
            Swal.fire(
              'Cancelada!',
              'La Solicitud ha sido Cancelada.',
              'success'
            ) 
           tablaDataTableSolicitud.ajax.reload(null, false);                    
        }
        }); //Fin del AJAX
        $('#modalCancelacionSolicitud').modal('hide');
      }
    }
  });  
  
  
});
   
