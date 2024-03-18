import {estadoValidado as valido } from './validacionesNuevaSolicitud.js';



// Llama a la función cuando se carga la página de buscar FACTURA
window.addEventListener('load', function() {
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
  
  let $containerRTN = document.getElementById('containerrtncliente');
  if (document.getElementById('btnclientes') == null) {
    let $btnBuscar = document.createElement('div')
    $btnBuscar.classList.add('btnbuscarcliente');
    
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btnclientes" data-bs-toggle="modal" data-bs-target="#modalCarteraCliente">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerRTN.appendChild($btnBuscar);
  }

  obtenerTipoServicio('#tiposervicio');
  let fechaC = new Date().toISOString().slice(0, 10);
    $("#fechasolicitud").val(fechaC); 
  obtenerAdminCorreo('#correo');


});



$(document).on('click', '#btnfactura', function () {
  obtenerFactura();  // Lógica para obtener la factura si es necesario
  //$('#modalArticulosSolicitud').modal('show');
  $('#modalFacturaSolicitud').modal('show');  
});

$(document).on('click', '#btnclientes', function () {
  obtenerCarteraCliente(); 
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
        // { "data": 'codCliente' },
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
          console.log(correo);
        }        
    });
  }
 

////////////////MODAL DE ARTICULO  
  $('#btnarticulos').click(() => {
    if (document.getElementById('table-ArticuloSolicitud_wrapper') == null) {
      let t = $('#table-ArticuloSolicitud').DataTable({
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
  
  $(document).on("click", 'tbody tr', function (e) {
    $(this).find("button")[0].classList.toggle('select_articulo')
    e.currentTarget.classList.toggle('ArtSelec');
  });


  $('#btn_agregar').click(function () {
    agregarArticulos();
    $('#modalArticulosSolicitud').modal('hide');  
  });
  let agregarArticulos = function () {
    let $Articulos = [];
    let productosSeleccionados = $('#table-ArticuloSolicitud').DataTable().rows(".ArtSelec").data()
    for (let i=0; i<productosSeleccionados.length; i++) {
      console.log(productosSeleccionados[i])
      $Articulos.push({
        id: productosSeleccionados[i].codArticulo,
        nombre: productosSeleccionados[i].articulo,
        marca: productosSeleccionados[i].marcaArticulo
      })
    }

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
  
  let nombre = document.getElementById("nombre");
  let idFactura = $('#idfactura').val();
  let correo = $('#correo').val();
  let telefono = $('#telefono').val();
  let tiposervicio = document.getElementById('tiposervicio').value;
  let ubicacion = $('#direccion').val();
  let descripcion = $('#descripcion').val();
  let rtnclienteC = $('#rtnCliente').val();


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
  let rtn = document.querySelector('[name="rtnCliente"]');
  let codigoC = document.querySelector('[name="codC"]');
  let telefono = document.getElementById("telefono");
  let direccion = document.getElementById("direccion");
  codigoC.id= "";
  nombre.value =  nombreCarteraCliente ;
  rtn.value = rtnCartera;
  telefono.value =telefonoCartera;
  direccion.value =  direccionCartera;
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalCarteraCliente').modal('hide');
});
