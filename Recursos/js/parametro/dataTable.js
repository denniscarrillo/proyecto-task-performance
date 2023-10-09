import {estadoValidado as valido } from './validacionesModalEditarParametro.js';

let tablaParametro = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaParametro = $('#table-Parametro').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/parametro/obtenerParametro.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id"},
      { "data": "parametro" },
      { "data": "valorParametro" },
      { "data": "descripcionParametro"},
      { "data": "usuario" },
      {"defaultContent":
      `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`
      }
    ]
  });
}

$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idParametro = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  parametro = fila.find('td:eq(1)').text(),
  valor = fila.find('td:eq(2)').text();
  $("#E_idParametro").val(idParametro);
  $("#E_parametro").val(parametro);
  $("#E_valor").val(valor);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarParametro').modal('show');		   
});

$('#form-Edit-Parametro').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let idParametro = $('#E_idParametro').val(),
   parametro =  $('#E_parametro').val(),
   valor = $('#E_valor').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/parametro/editarParametro.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idParametro: idParametro,
       parametro: parametro,
       valor: valor
      },
      success: function (data) {
        let resp = JSON.parse(data) 
        let mensaje = document.querySelector('#form-Edit-Parametro > div.grupo-form > div:nth-child(3) > p');
        if(!resp.estado){                   
          mensaje.innerText = resp.mensaje;
          mensaje.classList.add('mensaje_error');
          return;
        }        
        $('#modalEditarParametro').modal('hide');              
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El usuario ha sido modificado!',
          'success',
        )
        tablaParametro.ajax.reload(null, false);      
      }     
    });   
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