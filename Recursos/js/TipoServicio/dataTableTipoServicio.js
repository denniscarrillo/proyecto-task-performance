 import {estadoValidado as validado} from './validacionesModalNuevoTipoServicio.js';
 import {estadoValidado as valido } from './validacionesModalEditarTipoServicio.js';
let tablaTipoServicio = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
    tablaTipoServicio = $('#table-TipoServicio').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/TipoServicio/obtenerTipoServicio.php",
        "dataSrc": "" 
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": "id_TipoServicio" },
        { "data": "servicio_Tecnico" },
        {
          "defaultContent":
          `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
          `<button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
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
  // Crear nuevo Tipo Servicio
  $('#form-TipoServicio').submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
       //Obtener datos del nuevo tipo servicio
       let servicio_Tecnico = $('#servicio_Tecnico').val();
      if(validado){
        $.ajax({
          url: "../../../Vista/crud/TipoServicio/nuevoTipoServicio.php",
          type: "POST",
          datatype: "JSON",
          data: {
            servicio_Tecnico: servicio_Tecnico,
          },
          success: function () {
            //Mostrar mensaje de exito
            Swal.fire(
             'Registrado!',
             'Se ha registrado un nuevo servicio tecnico!',
             'success',
           )
           tablaTipoServicio.ajax.reload(null, false);
          }
        });
       $('#modalNuevoTipoServicio').modal('hide');
      } 
  });

  //Editar Tipo de Servicio
  $(document).on("click", "#btn_editar", function(){		        
    let fila = $(this).closest("tr"),	        
    id_TipoServicio = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
    servicio_Tecnico = fila.find('td:eq(1)').text();
    $("#E_idTipoServicio").val(id_TipoServicio);
    $("#E_servicio_Tecnico").val(servicio_Tecnico);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");	
    $('#modalEditarTipoServicio').modal('show');		   
  });


  $('#form-Edit-TipoServicio').submit(function (e) {
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos de Tipo Servicio
     let id_TipoServicio = $('#E_idTipoServicio').val(),
     servicio_Tecnico = $('#E_servicio_Tecnico').val();
     if(valido){
      $.ajax({
        url: "../../../Vista/crud/TipoServicio/editarTipoServicio.php",
        type: "POST",
        datatype: "JSON",
        data: {
         id_TipoServicio: id_TipoServicio,
         servicio_Tecnico: servicio_Tecnico,
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
            'Actualizado!',
            'El Tipo de Servicio ha sido modificado!',
            'success',
          )
          tablaTipoServicio.ajax.reload(null, false);
        }
      });
      $('#modalEditarTipoServicio').modal('hide');
     }
  });

  //Limpiar modal de crear
  document.getElementById('btn-cerrar').addEventListener('click', ()=>{
    limpiarForm();
  })
  document.getElementById('btn-x').addEventListener('click', ()=>{
    limpiarForm();
  })
  let limpiarForm = () => {
    let $inputs = document.querySelectorAll('.mensaje_error');
    let $mensajes = document.querySelectorAll('.mensaje');
    $inputs.forEach($input => {
      $input.classList.remove('mensaje_error');
    });
    $mensajes.forEach($mensaje =>{
      $mensaje.innerText = '';
    });
    let servicioTecnico = document.getElementById('servicio_Tecnico');
    //Vaciar campos cliente
      servicioTecnico.value = '';
  }

  //Limpiar modal de editar
  document.getElementById('button-cerrar').addEventListener('click', ()=>{
    limpiarFormEdit();
  })
  document.getElementById('button-x').addEventListener('click', ()=>{
    limpiarFormEdit();
  })
  let limpiarFormEdit = () => {
    let $inputs = document.querySelectorAll('.mensaje_error');
    let $mensajes = document.querySelectorAll('.mensaje');
    $inputs.forEach($input => {
      $input.classList.remove('mensaje_error');
    });
    $mensajes.forEach($mensaje =>{
      $mensaje.innerText = '';
    });
  }


  //Eliminar usuario
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
  let idTipoServicio = $(this).closest('tr').find('td:eq(1)').text();		
      Swal.fire({
        title: 'Estas seguro de eliminar a '+ idTipoServicio +'?',
        text: "No podras revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borralo!'
      }).then((result) => {
        if (result.isConfirmed) {      
          $.ajax({
            url: "../../../Vista/crud/TipoServicio/eliminarTipoServicio.php",
            type: "POST",
            datatype:"json",    
            data:  { idTipoServicio : idTipoServicio },    
            success: function(data) {
              let estadoEliminado = data[0].estadoEliminado;
               console.log(data);
              if(estadoEliminado == 'eliminado'){
                tablaTipoServicio.row(fila.parents('tr')).remove().draw();
                Swal.fire(
                  'Eliminado!',
                  'El tipo de Servicio ha sido eliminado.',
                  'success'
                ) 
                tablaTipoServicio.ajax.reload(null, false); 
              } else {
                Swal.fire(
                  'Lo sentimos!',
                  'El tipo de Servicio no puede ser eliminado',
                  'error'
                );
                tablaTipoServicio.ajax.reload(null, false);
              }           
            }
          }); //Fin del AJAX
        }
      });
    	    
                    
});

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-TipoServicio_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteServicioTecnico.php?buscar='+buscar, '_blank');
}); 
