$(document).ready(function(){
    setEstadoTarea();
});
document.getElementById('btn-guardar').addEventListener('submit', function(e){
  // let $idTask = $('#id-Tarea').val();
  // enviarProductosInteres($idTask );
  e.preventDefault();
  console.log(e);
  alert('HOLA DANIELA');
});
$('btn-guardar').submit(function (e) {
  e.preventDefault(); 
});
// CARGAR LOS ARTICULOS A AGREGAR A LA TAREA
$('#btn-articulos').click(() => {
    if (document.getElementById('table-Articulos_wrapper') == null) {
      $('#table-Articulos').DataTable({
        "ajax": {
          "url": "../../../Vista/articulos/obtenerArticulos.php",
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
  });
  $(document).on("click", "#btn_select-cliente", function () {
    let fila = $(this).closest("tr");
    let nombreCliente = fila.find("td:eq(1)").text();
    let rtnCliente = fila.find("td:eq(2)").text();
    let telefonoCliente = fila.find("td:eq(3)").text();
    let direccionCliente = fila.find("td:eq(4)").text();
    let nombre = document.getElementById("nombre-cliente");
    let rtn = document.getElementById("rnt-cliente");
    let telefono = document.getElementById("telefono-cliente");
    let direccion = document.getElementById("direccion-cliente");
  
    //Setear datos del cliente
    nombre.value = nombreCliente;
    rtn.value = rtnCliente;
    telefono.value = telefonoCliente;
    direccion.value = direccionCliente;
    //Deshabilitar elementos
    nombre.setAttribute('disabled', 'true');
    // rtn.setAttribute('disabled', 'true');
    telefono.setAttribute('disabled', 'true');
    direccion.setAttribute('disabled', 'true');
  
    $("#modalClientes").modal("hide");
    $("#modalEditarTarea").modal("show");
  });
  //Evento al boton "Agregar"
  $('#btn_agregar').click(function () {
    agregarArticulos();
    $('#modalArticulos').modal('hide');
    $('#modalEditarTarea').modal('show');
  });
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
  let setEstadoTarea = function(){
    let $select = document.getElementById('estados-tarea');
    let idTareaEstado = document.querySelector('.id-tarea');
    let estado = idTareaEstado.getAttribute('id');
    //Setear tipo de tarea
    for (var i = 0; i < $select.length; i++) {
      let option = $select[i];
      if (estado == option.value) {
        option.setAttribute('selected', 'true');
        //Si el estado es Lead se mostraran los campos origenLead y clasificacionLead
        if (option.value == 2) {
          document.getElementById('container-clasificacion-lead').removeAttribute('hidden');
          document.getElementById('container-origen-lead').removeAttribute('hidden');
        } else {
          document.getElementById('container-clasificacion-lead').setAttribute('hidden', 'true');
          document.getElementById('container-origen-lead').setAttribute('hidden', 'true');
        }
      }
    }
  }
/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
// Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente
document.getElementById('cliente-existente').addEventListener('change', function () {
  limpiarForm();
  let $containerRTN = document.getElementById('container-rtn-cliente');
  if (document.getElementById('btn-clientes') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btn-buscar-cliente');
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btn-clientes" data-bs-toggle="modal" data-bs-target="#modalClientes">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerRTN.appendChild($btnBuscar);
  }
  let correo = document.getElementById('container-correo');
  correo.setAttribute('hidden', 'true');
});
//Cuando el cliente es nuevo se oculta el buscador de existir.
document.getElementById('cliente-nuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('container-rtn-cliente');
  let $btnBuscarCliente = document.querySelector('.btn-buscar-cliente');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    if (document.getElementById('rnt-cliente').value != '') {
      limpiarForm();
    }
  }
  let correo = document.getElementById('container-correo');
  correo.removeAttribute('hidden');
});
$(document).on('click', '#btn-clientes', function () {
  obtenerClientes();
});
let obtenerClientes = function () {
  if (document.getElementById('table-Cliente_wrapper') == null) {
    $('#table-Cliente').DataTable({
      "ajax": {
        "url": "../../../Vista/rendimiento/obtenerClientes.php",
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
let $rtn = document.getElementById('rnt-cliente');
$rtn.addEventListener('focusout', function () {
  $.ajax({
    url: "../../../Vista/rendimiento/validarTipoCliente.php",
    type: "POST",
    datatype: "JSON",
    data: {
      rtnCliente: $rtn.value
    },
    success: function (cliente) {
      let $mensaje = document.getElementById('mensaje');
      let $objCliente = JSON.parse(cliente);
      console.log(cliente)
      if ($objCliente.estado == 'true') {
        $mensaje.innerText = 'Cliente existente'
        $mensaje.classList.add('mensaje-existe-cliente');
      } else {
        $mensaje.innerText = '';
        $mensaje.classList.remove('mensaje-existe-cliente');
      }
    }
  }); //Fin AJAX
});
// document.getElementById('btn-cerrar-modal').addEventListener('click', () => {
//   limpiarForm();
// });
// document.getElementById('btn-cerrar2').addEventListener('click', () => {
//   limpiarForm();
// });
let limpiarForm = () => {
  let rtn = document.getElementById('rnt-cliente'),
    nombre = document.getElementById('nombre-cliente'),
    telefono = document.getElementById('telefono-cliente'),
    correo = document.getElementById('correo-cliente'),
    direccion = document.getElementById('direccion-cliente'),
    rubro = document.getElementById('rubrocomercial'),
    razon = document.getElementById('razonsocial'),
    clasificacion = document.getElementById('clasificacionlead'),
    origen = document.getElementById('origenlead');
  //Vaciar campos
  if (rtn.value != '') {
    rtn.value = '';
    nombre.value = '';
    telefono.value = '';
    correo.value = '';
    direccion.value = '';
    rubro.value = '';
    razon.value = '';
    clasificacion.value = '';
    origen.value = '';
  }
  if (rtn.getAttribute('disabled')) {
    // rtn.removeAttribute('disabled');
    nombre.removeAttribute('disabled');
    telefono.removeAttribute('disabled');
    direccion.removeAttribute('disabled');
  }
}
$(document).on('click', '.btn-vendedores', function () {
  obtenerVendedores();
});
let obtenerVendedores = function () {
  if (document.getElementById('table-Vendedores_wrapper') == null) {
    $('#table-Vendedores').DataTable({
      "ajax": {
        "url": "../../../Vista/rendimiento/obtenerVendedores.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": 'id' },
        { "data": 'usuario' },
        { "data": 'nombre' },
        {
          "defaultContent":
            '<div><button class="btns btn" id="btn_select-Vendedores"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}
$(document).on('click', '#btn_select-Vendedores', function () {
  $(this).classList.toggle('select-vendedor');
});
let agregarVendedores = function($id_Tarea) {
  let $Vendedores = [];
  let vendedoresSeleccionados = document.querySelectorAll('.select-vendedor');
  vendedoresSeleccionados.forEach(function (vendedor) {
    if (vendedor.classList.contains('select-vendedor')) {
      let $idVendedor = $(vendedor).closest('tr').find('td:eq(0)').text();
      let $vendedor = {
        id: $idVendedor
      }
      $Vendedores.push($vendedor);
    }
  });
  let $idTarea = {
    idTarea: $id_Tarea
  }
  $Vendedores.push($idTarea);
  //AJAX para almacenar vendedores en la base de datos
  // $.ajax({
  //   url: "../../../Vista/rendimiento/agregarVendedoresTarea.php",
  //   type: "POST",
  //   datatype: "JSON",
  //   data: $Vendedores,
  //   success: function () {
  //   }
  // }); //Fin AJAX
}
let enviarProductosInteres = ($idTarea) => {
  let $idProductos = document.querySelectorAll('.id-producto');
  let $cantProducto = document.querySelectorAll('cant-producto');
  let productos = [];
  $idProductos.forEach(id => {
    $cantProducto.forEach(cant => {
    if(id.value == cant.getAttribute('id')){
      let objProducto = {
        id: id.value,
        cant: cant.value
      }
      productos.push(objProducto);
    }
    });
    //AJAX para almacenar los productos y su cantidad
    $.ajax({
      url: "../../../Vista/rendimiento/almacenarProductosTarea.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idTarea: $idTarea,
        productos: productos
      },
      success: function () {
        console.log(productos);
      }
    });//Fin AJAX
  });
}
