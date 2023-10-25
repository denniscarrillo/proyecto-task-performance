

$(document).on('click', '#cliente-existente', function () {
  obtenerClientes();
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
            '<div><button class="btns btn" id="btn_select-cliente"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}
$(document).on("click", "#btn_select-cliente", function () {
  let fila = $(this).closest("tr");
  let nombreCliente = fila.find("td:eq(1)").text();
  let rtnCliente = fila.find("td:eq(2)").text();
  let telefonoCliente = fila.find("td:eq(3)").text();
  let direccionCliente = fila.find("td:eq(4)").text();
  let nombre = document.getElementById("nombre");
  let rtn = document.getElementById("rnt-cliente");
  let telefono = document.getElementById("telefono");
  let direccion = document.getElementById("id-descripcion");

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

let rtnCliente = document.getElementById('cliente-existente');
rtnCliente.addEventListener('change', function () {
  limpiarForm();
  let $containerRTN = document.getElementById('container-rtn-cliente');
  if (document.getElementById('btn-clientes') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btn-buscar-cliente');
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btn-clientes" data-bs-toggle="modal" data-bs-target="#modalClienteFrecuente">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerRTN.appendChild($btnBuscar);
  }
  
});
//Cuando el cliente es nuevo se oculta el buscador de existir.
document.getElementById('cliente-nuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('container-rtn-cliente');
  let $btnBuscarCliente = document.querySelector('.btn-buscar-cliente');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    limpiarForm();
  }
  
});
$('#btn-articulos').click(() => {
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
            '<div><button class="btns btn" id="btn_select-article"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
});

$(document).on('click', '#btn_select-article', function () {
  selectArticulos(this);
  agregarArticulos();
  $('#modalArticulosSolicitud').modal('hide');
});

// $('#btn_agregar').click(function () {
//   agregarArticulos();
//   $('#modalArticulosSolicitud').modal('hide');
  
// });

let selectArticulos = function ($elementoHtml) {
  $elementoHtml.classList.toggle('select-articulo');
}
let agregarArticulos = function () {
  let $Articulos = [];
  let productosSeleccionados = document.querySelectorAll('.select-articulo');
  productosSeleccionados.forEach(function (producto) {
    if (producto.classList.contains('select-articulo')) {
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
  let $tableArticulos = document.getElementById('list-articulos');
  $productos.forEach((producto) => {
    productos += `
    <tr>
    <td><input type="text" value="${producto.id}" class="id-producto" name="id-producto"></td>
      <td>${producto.nombre}</td>
      <td>${producto.marca}</td>
      <td><input type="text" id="${producto.id}" class="cant-producto"></td>
    </tr>
  `
  });
  $tableArticulos.innerHTML = productos;
  let idsProducto = document.querySelectorAll('.id-producto');
  idsProducto.forEach(function(idProducto){
    idProducto.setAttribute('disabled', 'true');
  });
}


/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
// Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente

//Cuando el cliente es nuevo se oculta el buscador de existir.



let limpiarForm = () => {
  let $mensaje = document.getElementById('mensaje');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  let   rtn = document.getElementById('rnt-cliente'),
  
    telefono = document.getElementById('telefono'),
    direccion = document.getElementById('id-descripcion'),
    Factura = document.getElementById("id-factura"),
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


let FacturaSolicitud = document.getElementById('cliente-existente');
FacturaSolicitud.addEventListener('change', function () {
  limpiarForm();
  let $containerFact = document.getElementById('container-Factura-cliente');
  if (document.getElementById('btn-factura') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btn-buscar-cliente');
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btn-factura"  data-bs-toggle='modal' data-bs-target='#modalFacturaSolicitud'>
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerFact.appendChild($btnBuscar);
  }
  let Factura = document.getElementById('container-Factura-cliente');
  Factura.removeAttribute('hidden', 'false');
 
});

document.getElementById('cliente-nuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('container-Factura-cliente');
  let $btnBuscarCliente = document.querySelector('.btn-buscar-cliente');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    limpiarForm();
  }
 
  let Factura = document.getElementById('container-Factura-cliente');
  Factura.setAttribute('hidden', 'true');

});

$(document).on('click', '#btn-factura', function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
 // $('#modalArticulosSolicitud').modal('show');
 // $('#modalFacturaSolicitud').modal('show');  

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
          '<div><button class="btns btn" id="btn_select-factura" ><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}

$(document).on("click", "#btn_select-factura", function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
 
 
  let fila = $(this).closest("tr");
  let FacturaCliente = fila.find("td:eq(0)").text();
  let Factura = document.getElementById("id-factura");
  
  Factura.value = FacturaCliente;
 $("#modalFacturaSolicitud").modal("hide");
});






