import {estadoValidado as valido } from './validacionesNuevaSolicitud.js';


$(document).on('click', '#clienteExistente', function () {
  obtenerClientes();
  obtenerCarteraCliente();
 // $("#modalClienteFrecuente").modal("show");

 let correoCliente = document.getElementById('containerCorreocliente');
 correoCliente .setAttribute('hidden', 'false');

 let Factura  = document.getElementById('containerFacturacliente');
 Factura .removeAttribute('hidden');
 containerFacturacliente.style.display = 'block';


 
});

$(document).on('click', '#clientenuevo', function () {

  let correoCliente = document.getElementById('containerCorreocliente');
  correoCliente.removeAttribute('hidden');
  containerCorreocliente.style.display = 'block';
 
  let Factura = document.getElementById('containerFacturacliente');
  Factura.setAttribute('hidden', 'false');

 
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
  //let rtn = document.getElementById("rtnCliente");
  let rtn = document.querySelector('[name="rtnCliente"]');
  rtn.id = "rtnClienteV";
  let telefono = document.getElementById("telefono");
  let direccion = document.getElementById("direccion");
  //Setear datos del cliente
  nombre.value = nombreCliente;
  rtn.value = rtnCliente;
  telefono.value = telefonoCliente;
  direccion.value = direccionCliente;
  //Deshabilitar elementos
  //nombre.setAttribute('disabled', 'true');
  //telefono.setAttribute('disabled', 'true');
  //direccion.setAttribute('disabled', 'true');
  $("#modalClienteFrecuente").modal("hide");
});

let rtnCliente = document.getElementById('clienteExistente');
//let rtnCliente = document.getElementById('rtnCliente');
rtnCliente.addEventListener('change', function () {

  limpiarForm();
  let $containerRTN = document.getElementById('containerrtncliente');
  if (document.getElementById('btnclientes') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btnbuscarcliente');
    
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btnclientes" data-bs-toggle="modal" data-bs-target="#modalMenuClientes">
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



/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
// Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente

//Cuando el cliente es nuevo se oculta el buscador de existir.



let limpiarForm = () => {
   //$mensaje = document.getElementById('mensaje');
  //$mensaje.innerText = '';
  //$mensaje.classList.remove('mensaje-existe-cliente');
  let   rtn = document.getElementById('rtnCliente'),
    telefono = document.getElementById('telefono'),
    direccion = document.getElementById('direccion'),
    descripcion = document.getElementById("descripcion"),
   nombre = document.getElementById('nombre'),
   correoCliente = document.getElementById('correoCliente');
  //Vaciar campos cliente
    rtn.value = '';
    telefono.value = ''
    direccion.value = '';
    descripcion.value = '';
    nombre.value = '';
    correoCliente.value = ''; 

    correoCliente.removeAttribute('disabled');
    descripcion.removeAttribute('disabled');
    rtn.removeAttribute('disabled');
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
  
 
});

document.getElementById('clientenuevo').addEventListener('change', function () {
  let $containerRTN = document.getElementById('containerFacturacliente');
  let $btnBuscarCliente = document.querySelector('.btnbuscarFactura');
  if ($btnBuscarCliente) {
    $containerRTN.removeChild($btnBuscarCliente);
    limpiarForm();
  }
 
});

$(document).on('click', '#btnfactura', function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
  //$('#modalArticulosSolicitud').modal('show');
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
 limpiarForm();
});

//Activar los campos al tocar los radio existente o nuevo
  // Agregar un controlador de eventos 'click' al elemento de radio
  clienteExistente.addEventListener("click", function() {
    obtenerTipoServicio('#tiposervicio');
    telefono.disabled = false;
    direccion.disabled = false;
    descripcion.disabled = false;
    rtnCliente.disabled = false;
     nombre.disabled=false;
    let fechaC = new Date().toISOString().slice(0, 10);
    $("#fechasolicitud").val(fechaC); 
    obtenerAdminCorreo('#correo');
  });
  clientenuevo.addEventListener("click", function() {
    obtenerTipoServicio('#tiposervicio');
    nombre.disabled = false;
    telefono.disabled = false;
    direccion.disabled = false;
    descripcion.disabled = false;
    rtnCliente.disabled = false;
    nombre.disabled=false;
    let fechaC = new Date().toISOString().slice(0, 10);
    $("#fechasolicitud").val(fechaC);
    obtenerAdminCorreo('#correo');
  });
 
  
  let obtenerTipoServicio = function (idElemento, tipoServicio_id) {
    $.ajax({
        url: '../../../Vista/crud/DataTableSolicitud/obtenerTipoServicio.php',
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          let valores = '<option value="">Seleccionar...</option>';  
          for (let i = 0; i < data.length; i++) {
            valores += '<option value="' + data[i].id_TipoServicio + '"'+ (data[i].id_TipoServicio === tipoServicio_id ? 'selected': '') +'>' + data[i].servicio_Tecnico + '</option>';
            $(idElemento).html(valores);
          }
        }
    });
  }

  let obtenerAdminCorreo = function (idElemento) {
    $.ajax({
        url: '../../../Vista/crud/DataTableSolicitud/obtenerCorreo.php',
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          let correo = data[0]['CorreoServicio'];
          // console.log('Correo obtenido:', correo);
          $(idElemento).val(correo);   
          //console.log(correo);
        }        
    });
  }



////////////////MODAL DE ARTICULO  
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
  
  $(document).on("click", '#btn_selectarticle', function () {
    selectArticulo(this);
  });

  let selectArticulo = function ($selector) {
    $selector.classList.toggle('select_articulo');
  };

  $('#btn_agregar').click(function () {
    agregarArticulos();
    $('#modalArticulosSolicitud').modal('hide');  
  });
  
  let agregarArticulos = function () {
    let $Articulos = [];
    let productosSeleccionados = document.querySelectorAll('.select_articulo');
    productosSeleccionados.forEach(function (producto) {
      if (producto.classList.contains('select_articulo')) {
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
  };

  let carritoArticulos = ($productos) => {
    let productos = '';
    let $tableArticulos = document.getElementById('listarticulos');

    $productos.forEach((producto) => {
        productos += `
        <tr>
            <td><input type="text" value="${producto.id}" class="idproducto" name="idproducto" disabled></td>
            <td>${producto.nombre}</td>
            <td>${producto.marca}</td>
            <td>
                <input type="number" id="${producto.id}" class="cantproducto" name="cantProducto" min="1" max="50">
                <p class="mensaje"></p>
            </td>
            <td><button class="btn_eliminar btns btn" id="btn_eliminar"><i class="fas fa-times"></i></button></td>
        </tr>
        `;
    });

    $tableArticulos.innerHTML = productos;

    let idsProducto = document.querySelectorAll('.idproducto');
    idsProducto.forEach(function (idProducto) {
        idProducto.setAttribute('disabled', 'true');
    });

    // Validación al inicializar
    validarCantidades();

    // Agregar validación al evento change de los campos cantProducto
    let cantProductos = document.querySelectorAll('.cantproducto');
    cantProductos.forEach(function (cantProducto) {
        cantProducto.addEventListener('change', validarCantidades);
    });
};

function validarCantidades() {
    let cantProductos = document.querySelectorAll('.cantproducto');
    cantProductos.forEach(function (cantProducto) {
        if (cantProducto.value.trim() === '' || isNaN(cantProducto.value) || parseInt(cantProducto.value) < 0) {
            // Mostrar mensaje de error y agregar clase de estilo
            cantProducto.nextElementSibling.textContent = 'Ingrese una cantidad válida';
            cantProducto.nextElementSibling.classList.add('error-message');
        } else {
            // Limpiar mensaje de error si la cantidad es válida
            cantProducto.nextElementSibling.textContent = '';
            cantProducto.nextElementSibling.classList.remove('error-message');
        }
    });
}


  $(document).on("click", "#btn_eliminar", function() {
    let nombreProd = $(this).closest('tr').find('td:eq(1)').text();
    let filaproducto = this.parentElement.parentElement; 
      Swal.fire({
        title: 'Estas seguro de quitar el producto '+nombreProd+'?',
        text: "No podras revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borralo!'
      }).then((result) => {
        if (result.isConfirmed) {      
          filaproducto.remove();
                Swal.fire(
                  'Eliminado!',
                  'El producto ha sido eliminado.',
                  'success'
                ) 
            }; //Fin del AJAX
        
      });                
  });

///////////GUARDAR NUEVA SOLICITUD
$('#form-solicitud').submit(function (e) {
  e.preventDefault(); 
  //para reporte
  let nombre = document.getElementById("nombre");
  let idFactura = $('#idfactura').val();
  let correo = $('#correo').val();
  let telefono = $('#telefono').val();
  let tiposervicio = document.getElementById('tiposervicio').value;
  let ubicacion = $('#direccion').val();
  let descripcion = $('#descripcion').val();
  let rtncliente = $('#rtnClienteV').val();
  let rtnclienteC = $('#rtnCliente').val();

// var radio = document.getElementById("clienteExistente");
// if (radio.checked) {
//   rtnclienteC = $('#rtnCliente').val();
//   rtncliente = 'NULL'; 
//   idFactura = null;
//} 

let $idProductos = document.querySelectorAll('.idproducto');
let $cantProducto = document.querySelectorAll('.cantproducto');
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
});
  if (valido) {
      $.ajax({
          url: "../../../Vista/crud/DataTableSolicitud/nuevaSolicitud.php",
          type: "POST",
          datatype: "JSON",
          data: {
              idFactura: idFactura,
              RTNcliente: rtncliente,
              RTNclienteC: rtnclienteC,
              telefono: telefono,
              correo: correo,
              tipoServicio: tiposervicio,
              ubicacion: ubicacion,
              descripcion: descripcion,
              nombre: nombre.value,
              "productos": JSON.stringify(productos)
          },
          success: function () {
           
            Swal.fire({
              title: 'Guardado!',
              text: '¡Tu solicitud ha sido registrada con éxito! Pronto se enviará un correo a Servicio Técnico.',
              icon: 'success',
              // El tiempo se especifica en milisegundos (en este caso, 3000 ms o 3 segundos)
              showConfirmButton: false // Esto oculta el botón "Aceptar" para que la notificación se cierre automáticamente
            });               
            redirigirADataTable();           
          }                      
      });
  } else {
      // Manejar la validación fallida, por ejemplo, mostrar un mensaje de error
      Swal.fire(
          'Error!',
          'Por favor, cumpla todos los parámetros.',
          'error'
      );
  }
});

function redirigirADataTable() {
  setTimeout(function () {
      window.location.href = "../../../Vista/crud/DataTableSolicitud/gestionDataTableSolicitud.php";
  }, 3000); // Redirige después de 3 segundos (ajusta el tiempo según tus necesidades)
}




$('#form-solicitud').submit(function (e) {
  e.preventDefault(); // Evita el comportamiento normal del submit, es decir, la recarga total de la página
  // Verifica si el radio "Nuevo Cliente" está seleccionado
  if ($('#clientenuevo').is(':checked')) {
    let nombreN = $('#nombre').val();
    let rtnN = $('#rtnCliente').val();
    let telefonoN = $('#telefono').val();
    let correoN = $('#correoCliente').val();
    let direccionN = $('#direccion').val();
    if (valido) {
      $.ajax({
        url: "../../../Vista/crud/carteraCliente/nuevoCliente.php",
        type: "POST",
        datatype: "JSON",
        data: {
          nombre: nombreN,
          rtn: rtnN,
          telefono: telefonoN,
          correo: correoN,
          direccion: direccionN
        },
        success: function () {
  
        }
      });

    }
  }
});


let obtenerCarteraCliente = function () {
  if (document.getElementById('table-CarteraCliente_wrapper') == null) {
    $('#table-CarteraCliente').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/DataTableSolicitud/obtenerCarteraCliente.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
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
          '<div><button class="btns btn" id="btn_selectcarteraCliente"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
      }
      ]
    });
  }
}
$(document).on("click", "#btn_selectcarteraCliente", function () {
  let fila = $(this).closest("tr");        
  let nombreCarteraCliente = fila.find('td:eq(1)').text();
  let rtnCartera = fila.find('td:eq(2)').text();
  let telefonoCartera = fila.find('td:eq(3)').text();
  let direccionCartera = fila.find('td:eq(5)').text();
  let nombre = document.getElementById("nombre");
  //let rtn = document.getElementById("rtnCliente");
  let rtn = document.querySelector('[name="rtnCliente"]');
  //rtn.id = "rtnClienteC";
  let telefono = document.getElementById("telefono");
  let direccion = document.getElementById("direccion");
  nombre.value =  nombreCarteraCliente ;
  rtn.value = rtnCartera;
  telefono.value =telefonoCartera;
  direccion.value =  direccionCartera;
  // $("#E_estadoContacto").val(estadoContacto);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalCarteraCliente').modal('hide');
});
