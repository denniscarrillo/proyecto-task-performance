import {estadoValidado as validado } from './validacionesModalEliminarSolicitud.js';
import {estadoValidado as valido } from './validacionesModalEditarSolicitud.js';



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
      { "data": 'Nombre' },
      { "data": 'servicio_Tecnico' },
      { "data": 'telefono' },
      {"data":  'EstadoAvance' },
      {"data": 'Fecha_Creacion.date',
        "render": function(data) {
          return data.slice(0, 10);
        }
      },
      {
        "defaultContent":
        `<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>
        <button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>  
        <button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
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



$(document).on("click", "#btn_ver", async function (){
   // Obtener la fila más cercana al botón
  let fila = $(this).closest("tr");
  let idSolicitud = fila.find('td:eq(0)').text();
  let SolicitudXid = await obtenerSolicitudesVerPorId(idSolicitud);
  
  const idSolicitudLabel = document.getElementById('V_IdSolicitud');
  idSolicitudLabel.innerText = SolicitudXid.idSolicitud;
  const idFacturaLabel = document.getElementById('V_IdFactura');
  idFacturaLabel.innerText = SolicitudXid.idFactura; 
  const rtnClienteLabel = document.getElementById('V_rtnCliente');
  rtnClienteLabel.innerText = SolicitudXid.rtnCliente;
  const rtnClienteCarteraLabel = document.getElementById('V_rtnClienteCartera');
  rtnClienteCarteraLabel.innerText = SolicitudXid.rtnClienteCartera;
  const nombreLabel = document.getElementById('V_NombreC');
  nombreLabel.innerText = SolicitudXid.NombreCliente;
  const descripcionLabel = document.getElementById('V_descripcion');
  descripcionLabel.innerText = SolicitudXid.Descripcion;
  const idTipoServicioLabel = document.getElementById('V_idTipoServicio');
  idTipoServicioLabel.innerText = SolicitudXid.TipoServicio;
  const correoLabel = document.getElementById('V_correo');
  correoLabel.innerText = SolicitudXid.Correo;
  const telefonoLabel = document.getElementById('V_telefono');
  telefonoLabel.innerText = SolicitudXid.telefono;
  const ubicacionLabel = document.getElementById('V_ubicacion');
  ubicacionLabel.innerText = SolicitudXid.ubicacion;
  const AvanceSolicitudLabel = document.getElementById('V_AvanceSolicitud');
  AvanceSolicitudLabel.innerText = SolicitudXid.EstadoAvance;
  const EstadoSolicitudLabel = document.getElementById('V_EstadoSolicitud');
  EstadoSolicitudLabel.innerText = SolicitudXid.EstadoSolicitud;
  if (SolicitudXid.EstadoSolicitud === 'CANCELADO') {
    EstadoSolicitudLabel.style.color = 'red';
  }
  const MotivoLabel = document.getElementById('V_Motivo');
  MotivoLabel.innerText = SolicitudXid.motivoCancelacion;
  const CreadoPorLabel = document.getElementById('V_CreadoPor');
  CreadoPorLabel.innerText = SolicitudXid.CreadoPor;
  const FechaCreacionLabel = document.getElementById('V_FechaCreacion');
  FechaCreacionLabel.innerText = SolicitudXid.FechaCreacion.date.slice(0, 10);
  const ModificadoPorLabel = document.getElementById('V_ModificadoPor');
  ModificadoPorLabel.innerText = SolicitudXid.ModificadoPor;
  const FechaModificadoLabel = document.getElementById('V_FechaModificado');
  if (SolicitudXid.FechaModificacion !== null) {
    FechaModificadoLabel.innerText = SolicitudXid.FechaModificacion.date.slice(0, 10);
  } else {
    FechaModificadoLabel.innerText = '';
  };
 
  let ProductosS = await obtenerProductosS(idSolicitud);
  const productos = document.getElementById('ListaArticulos');
  // Función para limpiar la lista
  function limpiarLista(lista) {
    while (lista.firstChild) {
      lista.removeChild(lista.firstChild);
    }
  }
  if (productos) {
    // Limpiar la lista antes de agregar nuevos elementos
    limpiarLista(productos);
    // Agrega elementos de lista (li) para cada artículo y cantidad
    for (var i = 0; i < ProductosS.length; i++) {
      var item = ProductosS[i];
      var li = document.createElement('li');
      li.textContent = item.Articulo + ' - Cantidad: ' + item.Cant;
      li.style.color = 'black';
      productos.appendChild(li);
    }
  }


   // Estilizar el modal
   $(".modal-header").css("background-color", "#007bff");
   $(".modal-header").css("color", "white");
   // Mostrar el modal
   $('#modalVerSolicitud').modal('show');  
});

//obtener datos para el modal editar
let obtenerSolicitudesVerPorId = async (idSolicitud) => {
  try {
    let datosVerSolicitud = await $.ajax({
      url: '../../../Vista/crud/DataTableSolicitud/obtenerSolicitudesVerId.php',
      type: 'GET',
      dataType: 'JSON',
      data: {
        IdSolicitud: idSolicitud
      }
    });
    return datosVerSolicitud; //Retornamos la data recibida por ajax
  } catch(err) {
    console.error(err)
  }
}

//obtener datos para el modal editar
let obtenerProductosS = async (idSolicitud) => {
  try {
    let datosProductS = await $.ajax({
      url: '../../../Vista/crud/DataTableSolicitud/obtenerProductosS.php',
      type: 'GET',
      dataType: 'JSON',
      data: {
        IdSolicitud: idSolicitud
      }
      // success: function (data) {
      //     console.log(data.Articulo)
      // }
    });
    console.log(datosProductS);    
    return datosProductS; //Retornamos la data recibida por ajax
  } catch(err) {
    console.error(err)
    return null;
  }
}

$(document).on("click", "#btn_pdf_id",  function (){
  let idSolicitudR = document.querySelector('#V_IdSolicitud').innerText;

  //console.log("hola")
  window.open('../../../TCPDF/examples/reporteSolicitudXId.php?idSolicitud='+idSolicitudR, '_blank');
  //await reporteSolicitudesPorId(idSolicitudR);  
 });

$(document).on("click", "#btn_editar", async function(){	
  
  // Obtener la fila más cercana al botón
  let fila = $(this).closest("tr");
  // Capturar el ID de la solicitud
  let idSolicitud = fila.find('td:eq(0)').text();
  let Solicitudes = await obtenerSolicitudesPorId(idSolicitud);

  if (Solicitudes.EstadoSolicitud === 'CANCELADO') {
    // Aquí puedes mostrar un mensaje o tomar alguna acción específica
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "No se puede editar una solicitud cancelada!",
    });
    //alert('No se puede editar una solicitud cancelada');
    return; // Detiene la ejecución si la solicitud está cancelada
  }	 
  //LLenar Campos de modal Editar Solicitud
  $("#E_IdSolicitud").val(idSolicitud);
  const idSolicitudLabel = document.getElementById('E_IdSolicitud');
  idSolicitudLabel.innerText = Solicitudes.idSolicitud;
  const nombreLabel = document.getElementById('E_NombreC');
  nombreLabel.innerText = Solicitudes.NombreCliente;
  $("#E_descripcion").val(Solicitudes['Descripcion']);
  const idTipoServicioLabel = document.getElementById('E_TipoServicio');
  idTipoServicioLabel.innerText = Solicitudes.TipoServicio;
  $("#E_telefono_cliente").val(Solicitudes['telefono']);
  $("#E_ubicacion").val(Solicitudes['ubicacion']); 
  const EstadoSolicitudLabel = document.getElementById('E_EstadoSolicitud');
  EstadoSolicitudLabel.innerText = Solicitudes.EstadoSolicitud; 
  const CreadoPorLabel = document.getElementById('E_CreadoPor');
  CreadoPorLabel.innerText = Solicitudes.CreadoPor;
  const FechaCreacionLabel = document.getElementById('E_FechaCreacion');
  FechaCreacionLabel.innerText = Solicitudes.FechaCreacion.date.slice(0, 10);
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
      url: '../../../Vista/crud/DataTableSolicitud/obtenerSolicitudesVerId.php',
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
    if(valido){
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

$(document).on("click", "#btn_eliminar", async function(){		
  // Obtener la fila más cercana al botón
  let fila = $(this).closest("tr");
  // Capturar el ID de la solicitud
  let idSolicitud = fila.find('td:eq(0)').text();
  let SolicitudesC = await obtenerSolicitudesPorId(idSolicitud);
  if (SolicitudesC.EstadoSolicitud === 'CANCELADO') {
    // Aquí puedes mostrar un mensaje o tomar alguna acción específica
    Swal.fire({
      icon: "error",
      title: "La solicitud ya fue cancelada!",     
    });
    //alert('No se puede editar una solicitud cancelada');
    return; // Detiene la ejecución si la solicitud está cancelada
  }	 
  // Establecer el estado de la solicitud
  let EstadoSolicitud = 'CANCELADO';
  // Obtener el motivo de cancelación
  //let EstadoAvance = 'CANCELADO';
  // Establecer valores en los campos del modal
  $("#C_IdSolicitud").val(idSolicitud);
  $("#C_EstadoSolicitud").val(EstadoSolicitud);
  //$("#C_MotivoCancelacion").val(motivo);
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
    confirmButtonText: 'Si, Cancelalo!',
   });
      if(validado){    
      $.ajax({
        url: "../../../Vista/crud/DataTableSolicitud/editarEstadoSolicitud.php",
        type: "POST",
        datatype:"JSON",    
        data:{ 
          idSolicitud: idSolicitud,
          EstadoAvance: 'CANCELADO',
          EstadoSolicitud: EstadoSolicitud,
          MotivoCancelacion: MotivoCancelacion
        },    
        success: function() {          
         // console.log(data);  
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
    
  });  

  
//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Solicitud_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaSolicitud.php?buscar='+buscar, '_blank');
});  



  


  
  

      
