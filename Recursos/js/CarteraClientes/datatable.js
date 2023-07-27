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
      let objContacto = JSON.parse(data);
      console.log(objContacto);
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de estados que nos devuelve la peticion
      objContacto.forEach(elemento => {
        valores = '<option value="'+elemento.id_estadoContacto+'">'+elemento.contacto_Cliente+'</option>';
      });
      // for (let i = 0; i < data.length; i++) {
      //   valores += '<option value="' + objContacto[i].id_estadoContacto + '">' + objContacto[i].contacto_Cliente + '</option>';
      // }
      $(idElemento).html(valores);
    }
  });
}