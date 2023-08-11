import {estadoValidado as validado } from './ValidacionesModalNuevoPorcentaje.js';

let tablaPorcentajes = '';
$(document).ready(function () {
  tablaPorcentajes = $('#table-Porcentajes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Porcentajes/obtenerPorcentajes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idPorcentaje"},
      { "data": "valorPorcentaje" },
      { "data": "descripcionPorcentaje" },
      { "data": "estadoPorcentaje" },
      {"defaultContent":
          '<div><button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button></div>'
      }
    ]
  });
});
$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener

  // obtenerContactoCliente('#estadoContacto');
  //Petición para obtener estado de usuario
  // obtenerEstadoUsuario('#estado');
  // $(".modal-header").css("background-color", "#007bff");
  // $(".modal-header").css("color", "white");	 
});
//Crear nuevo usuario
$('#form-Porcentajes').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let valorPorcentaje = $('#valorPorcentaje').val();
     let descripcionPorcentaje = $('#descripcionPorcentaje').val();
     let estadoPorcentaje= $('#estadoPorcentaje').val();
    //  let estado = document.getElementById('estado').value;
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/Porcentajes/nuevoPorcentaje.php",
        type: "POST",
        datatype: "JSON",
        data: {
          valorPorcentaje: valorPorcentaje,
          descripcionPorcentaje: descripcionPorcentaje,
          estadoPorcentaje: estadoPorcentaje          
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Porcentaje Registrado!',
           'success',
         )
         tablaPorcentajes.ajax.reload(null, false);
        }
      });
     $('#modalNuevoPorcentaje').modal('hide');
    } 
});

// let obtenerContactoCliente = function (idElemento) {
//   //Petición para obtener estados contacto clientes
//   $.ajax({
//     url: '../../../Vista/crud/carteraCliente/obtenerContactoCliente.php',
//     type: 'GET',
//     dataType: 'JSON',
//     success: function (data) {
//       let valores = '<option value="">Seleccionar...</option>';
//       for (let i = 0; i < data.length; i++) {
//         valores += '<option value="' + data[i].id_estadoContacto + '">' + data[i].contacto_Cliente +'</option>';
//       }
//       $(idElemento).html(valores);
//     }
//   });
// }

// //Editar Cliente
// $(document).on("click", "#btn_editar", function(){		        
//   let fila = $(this).closest("tr"),	        
//   idcarteraCliente = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
//   nombre = fila.find('td:eq(1)').text(),
//   rtn = fila.find('td:eq(2)').text(),
//   telefono = fila.find('td:eq(3)').text(),
//   correo = fila.find('td:eq(4)').text(),
//   idestadoContacto = fila.find('td:eq(5)').text();
//   $("#E_carteraCliente").val(idcarteraCliente);
//   $("#E_nombre").val(nombre);
//   $("#E_rtn").val(rtn);
//   $("#E_telefono").val(telefono);
//   $("#E_correo").val(correo);
//   $("#E_estado").val(obtenerContactoCliente('#E_estado'));
//   $(".modal-header").css("background-color", "#007bff");
//   $(".modal-header").css("color", "white");	
//   $('#modalEditarCliente').modal('show');		   
// });

// $('#form-Edit-Cliente').submit(function (e) {
//   e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
//    //Obtener datos del nuevo Cliente
//    let 
//    idcarteraCliente = $('#E_carteraCliente').val(),
//    nombre = $('#E_nombre').val(),
//    rtn =  $('#E_rtn').val(),
//    telefono = $('#E_telefono').val(),
//    correo = $('#E_correo').val(),
//    idestadoContacto = document.getElementById('E_estado').value;
//    if(valido){
//     $.ajax({
//       url: "../../../Vista/crud/carteraCliente/editarCliente.php",
//       type: "POST",
//       datatype: "JSON",
//       data: {
//        idcarteraCliente: idcarteraCliente,
//        nombre: nombre,
//        rtn: rtn,
//        telefono: telefono,
//        correo: correo,
//        idestadoContacto: idestadoContacto
//       },
//       success: function () {
//         //Mostrar mensaje de exito
//         Swal.fire(
//           'Actualizado!',
//           'El cliente ha sido modificado!',
//           'success',
//         )
//          tablaCarteraClientes.ajax.reload(null, false);
//       }
//     });
//     $('#modalEditarCliente').modal('hide');
//    }
// });

