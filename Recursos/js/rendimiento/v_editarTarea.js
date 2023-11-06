import { sidePanel_Interaction } from '../../components/js/sidePanel.js'; //importamos la funcion del sidePanel

let tableArticulos = '';
let $idTarea = document.getElementById('id-Tarea').value;
let $idEstadoTarea = document.querySelector('.id-estado-tarea').id;
const $btnCotizacion = document.getElementById('btn-container-cotizacion');
let radioOption = document.getElementsByName('radioOption');
let estadoRTN = '';
$(document).ready(async function(){
  if($idEstadoTarea == '3'){
    $btnCotizacion.removeAttribute('hidden');
  }
    setEstadoTarea();
    obtenerComentarios($idTarea);
    obtenerDatosTarea($idTarea, $idEstadoTarea);
    estadoRTN = await $.ajax({
      url: "../../../Vista/rendimiento/cotizacion/obtenerRTN_Tarea.php",
      type: "POST",
      datatype: "JSON",
      data: {
        "idTarea": $idTarea
      }
    });
    let tipoCliente = (radioOption[1].checked) ? radioOption[1].value : radioOption[0].value;
    document.getElementById('link-nueva-cotizacion').setAttribute('href', `./cotizacion/v_cotizacion.php?idTarea=${$idTarea}&estadoCliente=${tipoCliente}`);
});

document.getElementById('btn-comment').addEventListener('click', () => {
  obtenerComentarios($idTarea);
  obtenerHistorialTarea($idTarea);
});
//Validar datos del cliente antes de redirigir al usuario a la vista cotización
document.getElementById('link-nueva-cotizacion').addEventListener('click', (e) => {
  if(JSON.parse(estadoRTN) == false) {
    e.preventDefault();
    const Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    });
    Toast.fire({
        icon: 'warning',
        title: 'Debe tener los datos del cliente'
    });
  }
});

/* ----------- Función de que le da interacción del sidepanel -------------------------*/
let $tabComments = document.getElementById('tab-comment');
let $tabHistory = document.getElementById('tab-history');
let $commentsContainer = document.getElementById('comments-container-list');
let $historyContainer = document.getElementById('history-container');
sidePanel_Interaction(document.getElementById('btn-comment'), document.getElementById('btn-close-comment'));
/* ------------------ Intercambio de tabs para el sidepanel  -------------------- */
$tabHistory.addEventListener('click', () => {
  $commentsContainer.setAttribute('style', 'z-index: -30; opacity: 0;');
  $historyContainer.setAttribute('style', 'z-index: 20; opacity: 1;');
  $tabComments.classList.remove('tab-selected')
  $tabHistory.classList.add('tab-selected');
});
$tabComments.addEventListener('click', () => {
  $tabHistory.classList.remove('tab-selected');
  $tabComments.classList.add('tab-selected');
  $commentsContainer.removeAttribute('style');
  $historyContainer.removeAttribute('style');
});

/* ------------------------------------------------------------------------------------ */

//En el evento submit llamamos a la función que enviara el comentario a la base de datos
document.getElementById('form-comentario').addEventListener('submit', (e) => {
  e.preventDefault();
  let $comentario = document.getElementById('input-comentario').value;
  nuevoComentario($idTarea, $comentario);
  obtenerComentarios($idTarea);
  obtenerHistorialTarea($idTarea);
});
document.getElementById('form-Edit-Tarea').addEventListener('submit', function(e){
  e.preventDefault();
  let $idTask = $('#id-Tarea').val();
  let radioOption = document.getElementsByName('radioOption');
  let tipoCliente = (radioOption[1].checked) ? radioOption[1].value : radioOption[0].value;
  let $datosTarea = validarCamposEnviar(tipoCliente);
  actualizarDatosTarea($datosTarea);
  obtenerDatosTarea($idTarea, $idEstadoTarea);
  enviarProductosInteres($idTask); //Enviamos los productos de interes a almacenar
});
// CARGAR LOS ARTICULOS A AGREGAR A LA TAREA
$('#btn-articulos').click(() => {
    if (document.getElementById('table-Articulos_wrapper') == null) {
      $('#table-Articulos').DataTable({
        "ajax": {
          "url": "../../../Vista/rendimiento/obtenerArticulos.php",
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
    console.log($productos);
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
    // if(document.getElementById('table-articulos_wrapper')){
    //   tableArticulos.destroy();
    //   //Convertimos la tabla de productos de interes a DataTable
    //   tableArticulos = $('#table-articulos').DataTable({
    //     "language": {
    //       "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    //     },
    //   });
    // } else {
    //   //Convertimos la tabla de productos de interes a DataTable
    //   tableArticulos = $('#table-articulos').DataTable({
    //     language: {
    //       "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    //     },
    //     scrollY: "29vh"
    //   });
    // }
  }
  let setEstadoTarea = function(){
    let $select = document.getElementById('estados-tarea');
    let idTareaEstado = document.querySelector('.id-estado-tarea');
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
let rtnCliente = document.getElementById('cliente-existente');
rtnCliente.addEventListener('change', function () {
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
    limpiarForm();
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
  let $mensaje = document.getElementById('mensaje');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  if($rtn.value.trim() != ''){
    $.ajax({
      url: "../../../Vista/rendimiento/validarTipoCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtnCliente: $rtn.value
      },
      success: function (cliente) {
        let $objCliente = JSON.parse(cliente);
        // console.log(cliente)
        if ($objCliente.estado == 'true') {
          $mensaje.innerText = 'Cliente existente'
          $mensaje.classList.add('mensaje-existe-cliente');
        } else {
          $mensaje.innerText = '';
          $mensaje.classList.remove('mensaje-existe-cliente');
        }
      }
    }); //Fin AJAX   
  }
});
let limpiarForm = () => {
  let $mensaje = document.getElementById('mensaje');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  let rtn = document.getElementById('rnt-cliente'),
    nombre = document.getElementById('nombre-cliente'),
    telefono = document.getElementById('telefono-cliente'),
    correo = document.getElementById('correo-cliente'),
    direccion = document.getElementById('direccion-cliente'),
    rubro = document.getElementById('rubrocomercial'),
    razon = document.getElementById('razonsocial'),
    clasificacion = document.getElementById('clasificacion-lead'),
    origen = document.getElementById('origen-lead');
  //Vaciar campos cliente
    rtn.value = '';
    nombre.value = '';
    telefono.value = '';
    correo.value = '';
    direccion.value = '';
    rubro.value = '';
    razon.value = '';
    clasificacion.value = '';
    origen.value = ''; 
  if (rtn.getAttribute('disabled')) {
    // rtn.removeAttribute('disabled');
    nombre.removeAttribute('disabled');
    telefono.removeAttribute('disabled');
    direccion.removeAttribute('disabled');
  }
}
let enviarProductosInteres = ($idTarea) => {
  let $idProductos = document.querySelectorAll('.id-producto');
  let $cantProducto = document.querySelectorAll('.cant-producto');
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
  //AJAX para almacenar los productos y su cantidad
  $.ajax({
    url: "../../../Vista/rendimiento/almacenarProductosTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "idTarea": $idTarea,
      "productos": JSON.stringify(productos)
    },
    success: function (resp) {
      Swal.fire(
        'Cambios guardados',
        'La tarea '+$idTarea+' ha sido editada!',
        'success',
      )
    }
  });//Fin AJAX
}

let nuevoComentario = ($idTarea,  $comentario) => {
  document.getElementById('input-comentario').value = '';
  //Enviamos el nuevo comentario a la base de datos
  $.ajax({
    url: "../../../Vista/rendimiento/nuevoComentario.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "id_Tarea": $idTarea,
      "comentario": $comentario 
    }
  });//Fin AJAX
}
let obtenerComentarios = ($idTarea) => {
  //Enviamos el nuevo comentario a la base de datos
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerComentarios.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "id_Tarea": $idTarea
    },
    success: function(comentarios) {
      let comments ='';
      let ObjComentarios = JSON.parse(comentarios);
      let conteinerComments = document.getElementById('comments-container-list');
      let $tabContainer = document.getElementById('tab-comment').getAttribute('name');
      // console.log($tabContainer);
      ObjComentarios.forEach((comentario) => {
        comments +=
        `<div class="card-comment ${($tabContainer == comentario.creadoPor)? 'align-right': ''}">
        <section class="info-comment">
          <section class="creadoPor-comment">${comentario.creadoPor}</section>
          <section class="data-comment">${comentario.FechaCreacion.date.split('.')[0]}</section>
        </section>
          <section class="title-comment">${comentario.comentarioTarea}</section>
        </div>`;
      conteinerComments.innerHTML = comments;
      });
    }
  });//Fin AJAX
}
let obtenerHistorialTarea = ($idTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerBitacoraTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "id_Tarea": $idTarea
    },
    success: function(historial) {
      let historialTarea = '';
      let ObjHistorial = JSON.parse(historial);
      let conteinerHistory = document.getElementById('history-container');
      ObjHistorial.forEach((historial) => {
        historialTarea +=
        `<div class="card-history">
          <section class="info-history">
            <section class="creadoPor-history">${historial.usuarioTarea}</section>
            <section class="action-history">${historial.accion}</section>
            <section class="data-history">${historial.fecha.date.split('.')[0]}</section>
          </section>
          <section class="text-history">${historial.descripcion}</section>
        </div>`;
        conteinerHistory.innerHTML = historialTarea;
      });
    }
  });//Fin AJAX
}
let actualizarDatosTarea = ($datosTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/validacionesEditarTarea.php",
    type: "POST",
    datatype: "JSON",
    data: $datosTarea
  });
}

let obtenerDatosTarea = ($idTarea, $idEstadoTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/validacionesEditarTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "idTarea": $idTarea,
      "idEstado": $idEstadoTarea
    },
    success: function($datosTarea){
      let datos = JSON.parse($datosTarea);
      (Object.keys(datos).length > 1) ? setearDatosTarea(datos) : document.getElementsByName('estadoEdicion')[0].id = datos.data;
    }
  });
}
let setearDatosTarea = ($datosTarea) => {
    let nuevo = document.getElementById('cliente-nuevo');
    let existe =  document.getElementById('cliente-existente');
    let nombre = document.getElementById('nombre-cliente');
    let rtn = document.getElementById('rnt-cliente'); 
    let correo = document.getElementById('correo-cliente');
    document.getElementById('input-titulo-tarea').value = $datosTarea.titulo;
    rtn.value = $datosTarea.RTN_Cliente;
    rtn.disabled =true;
    nombre.value = $datosTarea.NOMBRECLIENTE;
    nombre.disabled = true;
    document.getElementById('telefono-cliente').value = $datosTarea.TELEFONO,
    ($datosTarea.estado_Cliente_Tarea == 'Nuevo') ? correo.value = $datosTarea.correo: '';
    // ($datosTarea.estado_Cliente_Tarea == 'Nuevo') ? document.getElementById('container-correo').removeAttribute('hidden'): '';
    document.getElementById('direccion-cliente').value = $datosTarea.DIRECCION,
    document.getElementById('clasificacion-lead').value = $datosTarea.id_ClasificacionLead,
    document.getElementById('origen-lead').value = $datosTarea.id_OrigenLead,
    document.getElementById('rubrocomercial').value = $datosTarea.rubro_Comercial,
    document.getElementById('razonsocial').value = $datosTarea.razon_Social
    if(($datosTarea.estado_Cliente_Tarea == 'Existente')) {
      nuevo.removeAttribute('checked');
      nuevo.disabled = true;
      existe.setAttribute('checked', 'true');
      existe.disabled = true;
    }else{
      existe.removeAttribute('checked');
      existe.disabled = true;
      nuevo.setAttribute('checked','true');
      nuevo.disabled = true;
    }
}

let validarCamposEnviar = (tipoCliente) => {
  let $datosTarea;
  if(document.getElementsByName('estadoEdicion')[0].id == 'false'){
    if($idEstadoTarea == '2'){
      $datosTarea = {
        "idTarea": $idTarea,
        "idEstado": $idEstadoTarea,
        "tipoCliente": tipoCliente,
        "titulo": document.getElementById('input-titulo-tarea').value,
        "rtnCliente": document.getElementById('rnt-cliente').value,
        "nombre": document.getElementById('nombre-cliente').value, 
        "telefono": document.getElementById('telefono-cliente').value,
        "correo": document.getElementById('correo-cliente').value,
        "direccion": document.getElementById('direccion-cliente').value,
        "clasificacionLead": document.getElementById('clasificacion-lead').value,
        "origenLead": document.getElementById('origen-lead').value,
        "rubrocomercial": document.getElementById('rubrocomercial').value,
        "razonsocial": document.getElementById('razonsocial').value
      };
    } else {
      $datosTarea = {
        "idTarea": $idTarea,
        "idEstado": $idEstadoTarea,
        "tipoCliente": tipoCliente,
        "titulo": document.getElementById('input-titulo-tarea').value,
        "rtnCliente": document.getElementById('rnt-cliente').value,
        "nombre": document.getElementById('nombre-cliente').value, 
        "telefono": document.getElementById('telefono-cliente').value,
        "correo": document.getElementById('correo-cliente').value,
        "direccion": document.getElementById('direccion-cliente').value,
        "rubrocomercial": document.getElementById('rubrocomercial').value,
        "razonsocial": document.getElementById('razonsocial').value
      };
    }
  } else {
    if($idEstadoTarea == '2'){
      $datosTarea = {
        "idTarea": $idTarea,
        "idEstado": $idEstadoTarea,
        "tipoCliente": tipoCliente,
        "titulo": document.getElementById('input-titulo-tarea').value,
        "rtn": document.getElementById('rnt-cliente').value,
        "telefono": document.getElementById('telefono-cliente').value,
        "correo": document.getElementById('correo-cliente').value,
        "direccion": document.getElementById('direccion-cliente').value,
        "clasificacionLead": document.getElementById('clasificacion-lead').value,
        "origenLead": document.getElementById('origen-lead').value,
        "rubrocomercial": document.getElementById('rubrocomercial').value,
        "razonsocial": document.getElementById('razonsocial').value
      };
    } else {
      $datosTarea = {
        "idTarea": $idTarea,
        "idEstado": $idEstadoTarea,
        "tipoCliente": tipoCliente,
        "titulo": document.getElementById('input-titulo-tarea').value,
        "rtn": document.getElementById('rnt-cliente').value,
        "telefono": document.getElementById('telefono-cliente').value,
        "correo": document.getElementById('correo-cliente').value,
        "direccion": document.getElementById('direccion-cliente').value,
        "rubrocomercial": document.getElementById('rubrocomercial').value,
        "razonsocial": document.getElementById('razonsocial').value
      };
    }
  }
  return $datosTarea;
}