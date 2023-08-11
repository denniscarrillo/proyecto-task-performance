 import {estadoValidado as validado } from './validacionesModalNuevaMetrica.js';
 import {estadoValidado as valido } from './validacionesModalEditarMetrica.js';

let tablaMetricas = '';
$(document).ready(function () {
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
        '<div><button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
        '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });

});

$('#btn_nuevoRegistro').click(function () {
//   // //Petición para obtener

obtenerEstadoAvance('#descripcion');
//   //Petición para obtener estado de usuario
//   obtenerEstadoAvance('#descripcion');
//   $(".modal-header").css("background-color", "#007bff");
//   $(".modal-header").css("color", "white");	 
 });
//Crear nuevo usuario
$('#form-Metricas').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let idEstadoAvance = document.getElementById('descripcion').value;
     let meta = $('#meta').val();

    //  let estado = document.getElementById('estado').value;
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/Metricas/nuevaMetrica.php",
        type: "POST",
        datatype: "JSON",
        data: {
          id_EstadoAvance: idEstadoAvance,
          meta: meta
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Registrada Nueva Metrica!',
           'success',
         )
         tablaMetricas.ajax.reload(null, false);
        }
      });
     $('#modalNuevaMetrica').modal('hide');
    } 
});

let obtenerEstadoAvance = function (idElemento) {
  //Petición para obtener estados contacto clientes
  $.ajax({
    url: '../../../Vista/crud/Metricas/obtenerEstadoAvance.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_EstadoAvance + '">' + data[i].descripcion +'</option>';
      }
      $(idElemento).html(valores);
    }
  });
}
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idMetrica = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  idEstadoAvance = fila.find('td:eq(1)').text(),
  meta = fila.find('td:eq(2)').text();
  $("#E_idMetrica").val(idMetrica);
  $("#E_descripcion").val(obtenerEstadoAvance('#E_descripcion'));
  $("#E_meta").val(meta);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarMetrica').modal('show');		   
});

$('#form-Edit-Metrica').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let 
   idMetrica = $('#E_idMetrica').val(),
   idEstadoAvance = document.getElementById('E_descripcion').value;
   meta =  $('#E_meta').val();
   
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/Metricas/editarMetricas.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idMetrica: idMetrica,
       idEstadoAvance: idEstadoAvance,
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
// /* // //Eliminar Cliente
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let idMetrica = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar a '+idMetrica+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/Metricas/eliminarMetrica.php",
          type: "POST",
          datatype:"json",    
          data:  { idMetrica: idMetrica},    
          success: function(data) {
            // let estadoEliminado = data[0].estadoEliminado;
            // console.log(data);
            // if(estadoEliminado == 'eliminado'){
              tablaMetricas.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'La metricas ha sido eliminado.',
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