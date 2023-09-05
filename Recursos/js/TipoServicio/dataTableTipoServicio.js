 import {estadoValidado as validado} from './validacionesModalNuevoTipoServicio.js';
 import {estadoValidado as valido } from './validacionesModalEditarTipoServicio.js';
let tablaTipoServicio = '';

$(document).ready(function () {

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
          "<button class='btns btn' id='btn_editar'><i class='fa-solid fa-pen-to-square'></i></button>"
        }
      ]
    });
});


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


