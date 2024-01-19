// import {estadoValidado as validado} from './validacionesModalNuevaVenta.html';
let tablaVentas = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  tablaVentas = $('#table-Ventas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Venta/obtenerVenta.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "numFactura"},
      { "data": "nombreCliente"},
      { "data": "rtnCliente"},
      { "data": "totalVenta",
        "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. '),
      },
      { "data": "creadoPor"},
      { "data": "fechaCreacion.date",
        "render": function (data) {
          return data.slice(0, 19);
        }, 
      },
      { "defaultContent":
        `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        `<button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
      }
    ]
  });
};

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
// Crear nueva venta
$('#form-New-Venta').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo tipo servicio
     let rtnCliente = $('#rtn').val();
     let totalVenta = $('#totalVenta').val();
    /* if(validado){ */
      $.ajax({
        url: "../../../Vista/crud/Venta/nuevaVenta.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rtn: rtnCliente,
          venta: totalVenta,
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Registrado!',
           'Se ha registrado una nueva venta!',
           'success',
         )
         tablaVentas.ajax.reload(null, false);
        }
      });
    /* }  */
});

let $rtn = document.getElementById('rtn');
$rtn.addEventListener('focusout', function () {
  let $mensaje = document.querySelector('.mensaje-rtn');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  if($rtn.value.trim() != ''){
    $.ajax({
      url: "../../../Vista/crud/Venta/validarRtnCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtnCliente: $rtn.value
      },
      success: function (cliente){
        let $objCliente = JSON.parse(cliente);
        console.log($objCliente);
        if (!$objCliente){
          $mensaje.innerText = 'El cliente no existe';
          $mensaje.classList.add('mensaje-existe-cliente');
        } else {
          $mensaje.innerText = '';
          $mensaje.classList.remove('mensaje-existe-cliente');
          document.getElementById('cliente').value = $objCliente.nombre;
        }
      }
    }); //Fin AJAX   
  }
});

$(document).on("click", "#btn_editar", function() {
  Swal.fire(
    'No permitido!',
    'La venta no puede ser editada',
    'error'
  )
});

$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this).closest("tr"),	        
  factura = $(this).closest('tr').find('td:eq(0)').text(); //capturo el ID
  Swal.fire({
    title: 'Estas seguro de eliminar la venta #'+factura+'?',
    text: "No podras revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, borralo!'
  }).then((result) => {
    if (result.isConfirmed) {             
      $.ajax({
        url: "../../../Vista/crud/Venta/eliminarVenta.php",
        type: "POST",
        datatype:"json",    
        data:  { numFactura : factura},    
        success: function(data) {
          let estadoEliminado = data.estadoEliminado;
          // console.log(data);
          // console.log(estadoEliminado);
          if(estadoEliminado == 'eliminado'){
            tablaVentas.row(fila.parents('tr')).remove().draw();
            Swal.fire(
              'Eliminado!',
              'La venta ha sido eliminada',
              'success'
            ) 
            tablaVentas.ajax.reload(null, false);
          } else {
            Swal.fire(
              'Lo sentimos!',
              'La venta no puede ser eliminada',
              'error'
            );
            tablaVentas.ajax.reload(null, false);
          }           
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
  let $mensajeRTN = document.querySelector('.mensaje-rtn')
  $mensajeRTN.innerText = '';
  $inputs.forEach($input => {
    $input.classList.remove('mensaje_error');
  });
  $mensajes.forEach($mensaje =>{
    $mensaje.innerText = '';
  });
  $mensajeRTN.classList.remove('.mensaje-existe-cliente');
  let rtnCliente = document.getElementById('rtn'),
  nombreCliente = document.getElementById('cliente'),
  venta = document.getElementById('totalVenta');
  //Vaciar campos cliente
  rtnCliente.value = '';
  nombreCliente.value = '';
  venta.value = '';
}

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Ventas_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaVentas.php?buscar='+buscar, '_blank');
});

