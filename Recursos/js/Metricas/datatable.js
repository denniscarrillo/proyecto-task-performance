import {estadoValidado as valido } from './validacionesModalEditarMetrica.js';

let tablaMetricas = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);     
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  tablaMetricas = $('#table-Metricas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Metricas/obtenerMetricas.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },  
    "columns": [
      { "data": "idMetrica"},
      { "data": "descripcion"},
      { "data": "meta"},
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

$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idMetrica = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		
  metrica = fila.find('td:eq(1)').text(),
  meta = fila.find('td:eq(2)').text();
  $("#E_idMetrica").val(idMetrica);
  $("#E_descripcion").val(metrica);
  $("#E_meta").val(meta);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarMetrica').modal('show');		   
});

$('#form-Edit-Metrica').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let idMetrica = $('#E_idMetrica').val(),
   meta =  $('#E_meta').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/Metricas/editarMetrica.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idMetrica: idMetrica,
       meta: meta
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'La metrica ha sido modificada!',
          'success',
        )
        tablaMetricas.ajax.reload(null, false);
      }
    });
    $('#modalEditarMetrica').modal('hide');
   }
});

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

//Eliminar Rol
$(document).on("click", "#btn_eliminar", function() {
     
  let fila = $(this).closest("tr"),	        
    id_Metrica = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
    metrica = $(this).closest('tr').find('td:eq(1)').text();

        Swal.fire({
          title: 'Estas seguro de eliminar la metrica  '+metrica+'?',
          text: "No podras revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/Metricas/eliminarMetricas.php",
          type: "POST",
          datatype:"json",    
          data:  { id_Metrica: id_Metrica},    
          success: function(data) {
            console.log(data)
               Swal.fire(
                 'Lo sentimos!',
                 'La metrica no puede ser eliminada.',
                 'error'
               );
               tablaMetricas.ajax.reload(null, false);
                      
            }
          }); //Fin del AJAX
      }
    });  
            
});

//Generar Pdf 

$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Metricas_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteMetrica.php?buscar='+buscar, '_blank');
}); 