import {estadoValidado as validado } from './ValidacionesModalNuevoCliente.js';
import {estadoValidado as valido } from './ValidacionesModalEditarCliente.js';

let tablaCarteraClientes = '';
$(document).ready(function () {
  tablaCarteraClientes = $('#table-CarteraClientes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/carteraCliente/obtenerCarteraClientes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idcarteraCliente"},
      { "data": "nombre"},
      { "data": "rtn"},
      { "data": "telefono"},
      { "data": "correo"},
      { "data": "direccion"},
      { "data": "estadoContacto"},
      {
        "defaultContent":
        '<div><button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' 
      }
    ]
  });

});

//Crear nuevo usuario
$('#form-carteraCliente').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let nombre = $('#nombre').val();
     let rtn = $('#rtn').val();
     let telefono= $('#telefono').val();
     let correo = $('#correo').val();
     let direccion = $('#direccion').val();
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/carteraCliente/nuevoCliente.php",
        type: "POST",
        datatype: "JSON",
        data: {
          nombre: nombre,
          rtn: rtn,
          telefono: telefono,
          correo: correo,
          direccion: direccion
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Registrado!',
           'Se le ha enviado un correo al usuario!',
           'success',
         )
         tablaCarteraClientes.ajax.reload(null, false);
        }
      });
     $('#modalNuevoCliente').modal('hide');
    } 
});

//Editar Cliente
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idcarteraCliente = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  nombre = fila.find('td:eq(1)').text(),
  rtn = fila.find('td:eq(2)').text(),
  telefono = fila.find('td:eq(3)').text(),
  correo = fila.find('td:eq(4)').text(),
  direccion = fila.find('td:eq(5)').text(),
  estadoContacto = fila.find('td:eq(6)').text();
  $("#E_Cliente").val(idcarteraCliente);
  $("#E_Nombre").val(nombre);
  $("#E_Rtn").val(rtn);
  $("#E_Telefono").val(telefono);
  $("#E_Correo").val(correo);
  $("#E_Direccion").val(direccion);
  $("#E_estadoContacto").val(estadoContacto);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarCliente').modal('show');		   
});

$('#form-editar-carteraCliente').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let idcarteraCliente = $('#E_Cliente').val(),
   nombre = $('#E_Nombre').val(),
   rtn =  $('#E_Rtn').val(),
   telefono = $('#E_Telefono').val(),
   correo = $('#E_Correo').val(),
   direccion = $('#E_Direccion').val(),
   estadoContacto = $('#E_estadoContacto').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/carteraCliente/editarCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
       id: idcarteraCliente,
       nombre: nombre,
       rtn: rtn,
       telefono: telefono,
       correo: correo,
       direccion: direccion,
       estadoContacto: estadoContacto
      },
      success: function (res) {
        console.log(res);
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El cliente ha sido modificado!',
          'success',
        )
         tablaCarteraClientes.ajax.reload(null, false);
      }
    });
    $('#modalEditarCliente').modal('hide');
   }
});
