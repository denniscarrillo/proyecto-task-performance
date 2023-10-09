import {estadoValidado as validado } from './validacionesModalNuevaPregunta.js';
import {estadoValidado as valido } from './validacionesModalEditarPregunta.js';
let tablaPregunta = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaPregunta = $('#table-Pregunta').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/pregunta/obtenerPregunta.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Pregunta" },
      { "data": 'pregunta' },
      { "data": 'estadoPregunta' },
      {
        "defaultContent":
        `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>` 
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

// Crear nueva Pregunta
$('#form-Pregunta').submit(function (e) {
  e.preventDefault();
  let pregunta = $('#pregunta').val(),
      estadoPregunta = $('#estadoPregunta').val();
  if(validado){
    $.ajax({
      url: "../../../Vista/crud/pregunta/insertarPregunta.php",
      type: "POST",
      datatype: "JSON",
      data: { 
        pregunta: pregunta,
        estadoPregunta: estadoPregunta
      },
      success: function () {
      //Mostrar mensaje de exito
        Swal.fire(
          'Registrado!',
          'La pregunta ha sido registrada.',
          'success',
        )
        tablaPregunta.ajax.reload(null, false);
       }
     });
      $('#modalNuevaPregunta').modal('hide');
    }
});

// Editar Pregunta
$(document).on('click', '#btn_editar', function () {
  let fila = $(this).closest("tr"),
  idPregunta = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		   
  pregunta = fila.find('td:eq(1)').text(),
  estado = fila.find('td:eq(2)').text();
  $('#idPregunta_E').val(idPregunta);
  $('#pregunta_E').val(pregunta);
  $('#E_estado').val(estado);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarPregunta').modal('show');
});

// Evento Submit que edita la pregunta
$('#form-Pregunta-Editar').submit(function (e) {
  e.preventDefault();
//obtener datos al editar la pregunta
  let pregunta = $('#pregunta_E').val(),
    idPregunta = $('#idPregunta_E').val(),
    estado = $('#E_estado').val();
  if(valido){
    $.ajax({
      url: "../../../Vista/crud/pregunta/editarPreguntas.php",
      type: "POST",
      datatype: "JSON",
      data: { 
        idPregunta: idPregunta,
        pregunta: pregunta,
        estado: estado
      },
      success: function () {
        Swal.fire(
          'Actualizado!',
          'La pregunta ha sido actualizada.',
          'success',
        )
        tablaPregunta.ajax.reload(null, false);
      }
    });
    $('#modalEditarPregunta').modal('hide');
  }
});

//Eliminar pregunta
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let pregunta = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar la pregunta '+pregunta+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/pregunta/eliminarPregunta.php",
          type: "POST",
          datatype:"json",    
          data:  { pregunta: pregunta},    
          success: function() {
            // let estadoEliminado = data[0].estadoEliminado;
            // console.log(data);
            // if(estadoEliminado == 'eliminado'){
              tablaPregunta.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'La pregunta ha sido eliminada.',
                'success'
              ) 
            // } else {
            //   Swal.fire(
            //     'Lo sentimos!',
            //     'la pregunta no puede ser eliminado.',
            //     'error'
            //   );
            // }           
          }
          }); //Fin del AJAX
      }
    });                
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
  let pregunta = document.getElementById('pregunta');
  //Vaciar campos cliente
    pregunta.value = '';
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