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
      { "data": "estadoContacto"},
      {
        "defaultContent":
        '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });

});

$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener

  obtenerContactoCliente('#estadoContacto');
  //Petición para obtener estado de usuario
  // obtenerEstadoUsuario('#estado');
  // $(".modal-header").css("background-color", "#007bff");
  // $(".modal-header").css("color", "white");	 
});
//Crear nuevo usuario
$('#form-CarteraClientes').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let nombre = $('#nombre').val();
     let rtn = $('#rtn').val();
     let telefono= $('#telefono').val();
     let correo = $('#correo').val();
     let idestadoContacto = document.getElementById('estadoContacto').value;
    //  let estado = document.getElementById('estado').value;
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
          idestadoContacto: idestadoContacto
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

let obtenerContactoCliente = function (idElemento) {
  //Petición para obtener estados contacto clientes
  $.ajax({
    url: '../../../Vista/crud/carteraCliente/obtenerContactoCliente.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_estadoContacto + '">' + data[i].contacto_Cliente +'</option>';
      }
      $(idElemento).html(valores);
    }
  });
}

//Editar Cliente
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idcarteraCliente = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  nombre = fila.find('td:eq(1)').text(),
  rtn = fila.find('td:eq(2)').text(),
  telefono = fila.find('td:eq(3)').text(),
  correo = fila.find('td:eq(4)').text(),
  idestadoContacto = fila.find('td:eq(5)').text();
  $("#E_carteraCliente").val(idcarteraCliente);
  $("#E_nombre").val(nombre);
  $("#E_rtn").val(rtn);
  $("#E_telefono").val(telefono);
  $("#E_correo").val(correo);
  $("#E_estado").val(obtenerContactoCliente('#E_estado'));
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarCliente').modal('show');		   
});

$('#form-Edit-Cliente').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let 
   idcarteraCliente = $('#E_carteraCliente').val(),
   nombre = $('#E_nombre').val(),
   rtn =  $('#E_rtn').val(),
   telefono = $('#E_telefono').val(),
   correo = $('#E_correo').val(),
   idestadoContacto = document.getElementById('E_estado').value;
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/carteraCliente/editarCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idcarteraCliente: idcarteraCliente,
       nombre: nombre,
       rtn: rtn,
       telefono: telefono,
       correo: correo,
       idestadoContacto: idestadoContacto
      },
      success: function () {
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

//Eliminar Cliente
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let nombre = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar a '+nombre+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/carteraCliente/eliminarCliente.php",
          type: "POST",
          datatype:"json",    
          data:  { nombre: nombre},    
          success: function(data) {
            // let estadoEliminado = data[0].estadoEliminado;
            // console.log(data);
            // if(estadoEliminado == 'eliminado'){
              tablaCarteraClientes.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'El Cliente ha sido eliminado.',
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