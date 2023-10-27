

$(document).on('click', '#clienteExistente', function () {
  obtenerClientes();
 // $("#modalClienteFrecuente").modal("show");
});
let obtenerClientes = function () {
  if (document.getElementById('table-ClienteFrecuente_wrapper') == null) {
    $('#table-ClienteFrecuente').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/DataTableSolicitud/obtenerClientesFrecuentes.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": "codCliente" },
        { "data": 'nombre' },
        { "data": 'rtn' },
        { "data": 'telefono' },
        { "data": 'direccion' },
        {
          "defaultContent":
            '<div><button class="btns btn" id="btn_selectcliente"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}
$(document).on("click", "#btn_selectcliente", function () {
  let fila = $(this).closest("tr");
  let nombreCliente = fila.find("td:eq(1)").text();
  let rtnCliente = fila.find("td:eq(2)").text();
  let telefonoCliente = fila.find("td:eq(3)").text();
  let direccionCliente = fila.find("td:eq(4)").text();
  let nombre = document.getElementById("nombre");
  let rtn = document.getElementById("rntcliente");
  let telefono = document.getElementById("telefono");
  let direccion = document.getElementById("iddescripcion");

  //Setear datos del cliente
  nombre.value = nombreCliente;
  rtn.value = rtnCliente;
  telefono.value = telefonoCliente;
  direccion.value = direccionCliente;
  //Deshabilitar elementos
  //nombre.setAttribute('disabled', 'true');
  telefono.setAttribute('disabled', 'true');
  direccion.setAttribute('disabled', 'true');
  $("#modalClienteFrecuente").modal("hide");

});

let rtnCliente = document.getElementById('clienteExistente');
rtnCliente.addEventListener('change', function () {
  limpiarForm();
  let $containerRTN = document.getElementById('containerrtncliente');
  if (document.getElementById('btnclientes') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btnbuscarcliente');
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btnclientes" data-bs-toggle="modal" data-bs-target="#modalClienteFrecuente">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerRTN.appendChild($btnBuscar);
  }
  
});
//Cuando el cliente es nuevo se oculta el buscador de existir.
document.getElementById('clientenuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('containerrtncliente');
  let $btnBuscarCliente = document.querySelector('.btnbuscarcliente');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    limpiarForm();
  }
  
});
$('#btnarticulos').click(() => {
  if (document.getElementById('table-ArticuloSolicitud_wrapper') == null) {
    $('#table-ArticuloSolicitud').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/DataTableSolicitud/obtenerArticulosSolicitud.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": "codArticulo" },
        { "data": 'articulo' },
        { "data": 'detalleArticulo' },
        { "data": 'marcaArticulo' },
        {
          "defaultContent":
            '<div><button class="btns btn" id="btn_selectarticle"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
});

$(document).on('click', '#btn_selectarticle', function () {
  selectArticulos(this);
  agregarArticulos();
  $('#modalArticulosSolicitud').modal('hide');
});

// $('#btn_agregar').click(function () {
//   agregarArticulos();
//   $('#modalArticulosSolicitud').modal('hide');
  
// });

let selectArticulos = function ($elementoHtml) {
  $elementoHtml.classList.toggle('selectarticulo');
}
let agregarArticulos = function () {
  let $Articulos = [];
  let productosSeleccionados = document.querySelectorAll('.selectarticulo');
  productosSeleccionados.forEach(function (producto) {
    if (producto.classList.contains('selectarticulo')) {
      let $idArticulo = $(producto).closest('tr').find('td:eq(0)').text();
      let $nombreArticulo = $(producto).closest('tr').find('td:eq(1)').text();
      let $marca = $(producto).closest('tr').find('td:eq(3)').text();
      let $articulo = {
        id: $idArticulo,
        nombre: $nombreArticulo,
        marca: $marca
      }
      $Articulos.push($articulo);
    }
  });
  carritoArticulos($Articulos);
}
let carritoArticulos = ($productos) => {
  let productos = '';
  let $tableArticulos = document.getElementById('listarticulos');
  $productos.forEach((producto) => {
    productos += `
    <tr>
    <td><input type="text" value="${producto.id}" class="idproducto" name="idproducto"></td>
      <td>${producto.nombre}</td>
      <td>${producto.marca}</td>
      <td><input type="text" id="${producto.id}" class="cantproducto"></td>
      <td><button class="btn_eliminar btns btn" id="btn_eliminar"><i class="fas fa-times"></i></button></td>
    </tr>
  `
  });
  $tableArticulos.innerHTML = productos;
  let idsProducto = document.querySelectorAll('.idproducto');
  idsProducto.forEach(function(idProducto){
    idProducto.setAttribute('disabled', 'true');
  });
}
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let idproducto = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar el producto '+idproducto+'?',
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


/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
// Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente

//Cuando el cliente es nuevo se oculta el buscador de existir.



let limpiarForm = () => {
  let $mensaje = document.getElementById('mensaje');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  let   rtn = document.getElementById('rntcliente'),
  
    telefono = document.getElementById('telefono'),
    direccion = document.getElementById('iddescripcion'),
    Factura = document.getElementById("idfactura"),
     nombre = document.getElementById('nombre');
  //Vaciar campos cliente
    rtn.value = '';
    telefono.value = ''
    direccion.value = '';
   Factura.value = '';
   nombre.value = '';
  
  
    // rtn.removeAttribute('disabled');
  
    telefono.removeAttribute('disabled');
    direccion.removeAttribute('disabled');
  
}


let FacturaSolicitud = document.getElementById('clienteExistente');
FacturaSolicitud.addEventListener('change', function () {
  limpiarForm();
  let $containerFact = document.getElementById('containerFacturacliente');
  if (document.getElementById('btnfactura') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btnbuscarFactura');
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btnfactura"  data-bs-toggle="modal "data-bs-target="#modalFacturaSolicitud">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerFact.appendChild($btnBuscar);
  }
  let Factura = document.getElementById('containerFacturacliente');
  Factura.removeAttribute('hidden', 'false');
 
});

document.getElementById('clientenuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('containerFacturacliente');
  let $btnBuscarCliente = document.querySelector('.btnbuscarFactura');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    limpiarForm();
  }
 
  let Factura = document.getElementById('containerFacturacliente');
  Factura.setAttribute('hidden', 'true');

});

$(document).on('click', '#btnfactura', function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
  $('#modalArticulosSolicitud').modal('show');
  $('#modalFacturaSolicitud').modal('show');  

});

let obtenerFactura = function () {
  if (document.getElementById('table-FacturaSolicitud_wrapper') == null) {
    $('#table-FacturaSolicitud').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/DataTableSolicitud/obtenerFacturaSolicitud.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": 'numFactura'},
        { "data": 'codCliente' },
        { "data": 'nombreCliente' },
        { "data": 'rtnCliente' },
        {
          "defaultContent":
          '<div><button class="btns btn" id="btn_selectfactura" ><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}

$(document).on("click", "#btn_selectfactura", function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
 
 
  let fila = $(this).closest("tr");
  let FacturaCliente = fila.find("td:eq(0)").text();
  let Factura = document.getElementById("idfactura");
  
  Factura.value = FacturaCliente;
 $("#modalFacturaSolicitud").modal("hide");
});






