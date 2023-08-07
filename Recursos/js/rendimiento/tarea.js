//Elementos HTML seleccionados a traves de su atributo ID
let $contenedorLlamada = document.getElementById('conteiner-llamada');
let $contadorLlamadas = document.getElementById('circle-count-llamadas');
let $contenedorLeads = document.getElementById('conteiner-lead');
let $contadorLeads = document.getElementById('circle-count-leads');
let $contenedorCotizaciones = document.getElementById('conteiner-cotizacion');
let $contadorCotizaciones = document.getElementById('circle-count-cotizaciones');
let $contenedorVentas = document.getElementById('conteiner-venta');
let $contadorVentas = document.getElementById('circle-count-ventas');
let $columnaLlamadas = document.getElementById('columna-llamadas');
let $columnaLeads = document.getElementById('columna-leads');
let $columnaCotizaciones = document.getElementById('columna-cotizaciones');
let $columnaVentas = document.getElementById('columna-ventas');
let $ArticulosInteres = [];

//Una vez este cargado el documento o pagina web se va a ejecutar lo que esta dentro
$(document).ready(function () {
  obtenerTareas($contenedorLlamada, $contadorLlamadas, 'Llamada');
  obtenerTareas($contenedorLeads, $contadorLeads, 'Lead');
  obtenerTareas($contenedorCotizaciones, $contadorCotizaciones, 'Cotizacion');
  obtenerTareas($contenedorVentas, $contadorVentas, 'Venta');

  new Sortable(document.getElementById('conteiner-llamada'), {
    group: 'shared', // set both lists to same group
    animation: 150
  });
  new Sortable(document.getElementById('conteiner-lead'), {
    group: 'shared',
    animation: 150
  });
  new Sortable(document.getElementById('conteiner-cotizacion'), {
    group: 'shared',
    animation: 150
  });
  new Sortable(document.getElementById('conteiner-venta'), {
    group: 'shared',
    animation: 150
  });

});

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
      if ($objCliente[0].estado == 'true') {
        $mensaje.innerText = 'Cliente existente'
        $mensaje.classList.add('mensaje-existe-cliente');
      } else {
        $mensaje.innerText = '';
        $mensaje.classList.remove('mensaje-existe-cliente');
      }
    }
  }); //Fin AJAX
});
//Evento
$('#btn-NuevaLLamada').click(function () {
  //Nos crea y muestra el pequeño formulario para la nueva tarea llamada
  crearNuevaTarea($columnaLlamadas, 'conteiner-form-llamada', 'form-nuevaLlamada', 'Titulo de la llamada', 'llamada');
  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-llamada');
  let $elementoEliminar = document.getElementById('conteiner-form-llamada');
  cancelarIngresoTarea($btnCancelar, $columnaLlamadas, $elementoEliminar);
  //Permite guardar la nueva tarea llamada en la DB.
  let $btnGuardar = document.getElementById('btn-submit-llamada');
  guardarTarea($btnGuardar, 'btn-submit-llamada', 1, $columnaLlamadas, $elementoEliminar);
  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
});
$('#btn-NuevoLead').click(function () {
  crearNuevaTarea($columnaLeads, 'conteiner-form-lead', 'form-nuevoLead', 'Titulo del lead', 'lead');
  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-lead');
  let $elementoEliminar = document.getElementById('conteiner-form-lead');
  cancelarIngresoTarea($btnCancelar, $columnaLeads, $elementoEliminar);
  //Permite guardar la nueva tarea lead en la DB.
  let $btnGuardar = document.getElementById('btn-submit-lead');
  guardarTarea($btnGuardar, 'btn-submit-lead', 2, $columnaLeads, $elementoEliminar);
});
$('#btn-NuevaCotizacion').click(function () {
  crearNuevaTarea($columnaCotizaciones, 'conteiner-form-cotizacion', 'form-nuevaCotizacion', 'Titulo de la Cotizacion', 'cotizacion');
  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-cotizacion');
  let $elementoEliminar = document.getElementById('conteiner-form-cotizacion');
  cancelarIngresoTarea($btnCancelar, $columnaCotizaciones, $elementoEliminar);
  //Permite guardar la nueva tarea cotizacion en la DB.
  let $btnGuardar = document.getElementById('btn-submit-cotizacion');
  guardarTarea($btnGuardar, 'btn-submit-cotizacion', 3, $columnaCotizaciones, $elementoEliminar);
});
$('#btn-NuevaVenta').click(function () {
  crearNuevaTarea($columnaVentas, 'conteiner-form-venta', 'form-nuevoVenta', 'Titulo de la Venta', 'venta');
  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-venta');
  let $elementoEliminar = document.getElementById('conteiner-form-venta');
  cancelarIngresoTarea($btnCancelar, $columnaVentas, $elementoEliminar);
  //Permite guardar la nueva tarea venta en la DB.
  let $btnGuardar = document.getElementById('btn-submit-venta');
  guardarTarea($btnGuardar, 'btn-submit-venta', 4, $columnaVentas, $elementoEliminar);
});

//Función AJAX que trae las tareas y las muestra en el HTML ya filtradas
let obtenerTareas = ($elemento, $contador, tipoTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerTareasAJAX.php",
    type: "GET",
    datatype: "JSON",
    success: function (data) {
      let objData = JSON.parse(data); //Convertimos JSON a objeto javascript
      let $tareas = '';
      let count = 0;
      //Recorremo arreglo de objetos con un forEach para mostrar tareas
      objData.forEach(tarea => {
        if (tarea.tipoTarea == tipoTarea) {
          $tareas +=
            `<div class="card_task dragged-element" draggable="true">
              <div class="conteiner-text-task">
                <p>${tarea.tituloTarea}</p>
                <p>${tarea.fechaInicio}</p>
              </div>
              <div class="conteiner-icons-task">
              <div>
                <a href="#" class="btn-editar btn-vendedores" data-bs-toggle="modal" data-bs-target="#modalVendedores" id="${tarea.id}-${tarea.idEstadoAvance}"><i class="fa-solid-btn fa-solid fa-user-plus"></i></a>
              </div>
              <div>
                <a href="#" class="btn-editar" id="${tarea.id}-${tarea.idEstadoAvance}" data-bs-toggle="modal" data-bs-target="#modalEditarTarea"><i class="fa-solid-btn fa-solid fa-pen-to-square"></i></a>
              </div>
              <i class="fa-solid-btn fa-solid fa-tag"></i>
              </div>
            </div>`;
          $elemento.innerHTML = $tareas;
          count++;
          id = "btn_nuevoRegistro"
        }
      });
      //Si no hay tareas del tipo buscado el contador se mantiene en cero y se indica en el HTML
      (count == 0) ? $contador.innerText = '0' : $contador.innerText = count;
      //Añade evento click a todos los botones de las tareas, que trea los estados tareas.
      document.querySelectorAll('.btn-editar').forEach((btnEditar) => {
        btnEditar.addEventListener('click', (e) => {
          obtenerEstadosTarea(document.getElementById('estados-tarea'), btnEditar);
        });
      });
    }
  });
  // id="btn_nuevoRegistro" 
}
let crearNuevaTarea = ($contenedor, $idConteinerForm, $idForm, $placeholder, $tarea) => {
  // Validamos si no existe el formulrio para nueva tarea, solo entonces se agrega.
  if (document.getElementById($idForm) == null) {
    let newFormulario = document.createElement("div");
    newFormulario.setAttribute('class', 'form-nuevaTarea'); //Añadimos clase al div
    newFormulario.setAttribute('id', $idConteinerForm); //Añadimos clase al div
    newFormulario.innerHTML = `
      <form action="" method="POST" id="${$idForm}" class="new-form">
        <textarea id="title-task" class="input-title" placeholder="${$placeholder}"></textarea>
        <div class="btns">
          <button type="submit" class="btn btn-primary" id="btn-submit-${$tarea}">Guardar</button>
          <button type="button" class="btn btn-secondary" id="btn-cancelar-${$tarea}">Cancelar</button>
        </div>
      </form>
    `;
    $contenedor.appendChild(newFormulario);
  }
}
//Para cancelar el ingreso de nueva tarea
let cancelarIngresoTarea = ($btnCancelar, $elementoPadre, $elementoEliminar) => {
  $btnCancelar.addEventListener('click', function () {
    $elementoPadre.removeChild($elementoEliminar);
  });
};
//Cierra el formulario cuando se guarda la nueva tarea
let cerrarFormTarea = ($elementoPadre, $elementoCerrar) => {
  $elementoPadre.removeChild($elementoCerrar);
}
let guardarTarea = ($btnGuardar, $tarea, $actualizarTarea, $elementoPadre, $elementoCerrar) => {
  //Agregamos el evento click al boton de guardar tarea
  $btnGuardar.addEventListener('click', function (e) {
    e.preventDefault();
    let titulo = document.getElementById('title-task').value;
    let tarea = null;
    console.log(titulo);
    if (document.getElementById('title-task').value.trim() == '' || document.getElementById('title-task').value.trim() == null) {
      document.getElementById('title-task').setAttribute('placeholder', 'Debe poner un titulo!');
    } else {
      if ($btnGuardar.getAttribute('id') == $tarea) {
        const str = $btnGuardar.getAttribute('id').split('-');
        tarea = str[2];
      }
      let objTarea = {
        tipoTarea: tarea,
        titulo: titulo,
      }
      $.ajax({
        url: "../../../Vista/rendimiento/nuevaTarea.php",
        type: "POST",
        datatype: "JSON",
        data: objTarea,
        success: function () {
        }
      });
      /*
        LLamamos a la funcion correspondiente para obtener la actualizacion del contenedor de tarea,
        además de cerrar el formulario en el que se creo la tarea.
      */
      switch ($actualizarTarea) {
        case 1: {
          cerrarFormTarea($elementoPadre, $elementoCerrar)
          obtenerTareas($contenedorLlamada, $contadorLlamadas, 'Llamada');
          break;
        }
        case 2: {
          cerrarFormTarea($elementoPadre, $elementoCerrar)
          obtenerTareas($contenedorLeads, $contadorLeads, 'Lead');
          break;
        }
        case 3: {
          cerrarFormTarea($elementoPadre, $elementoCerrar)
          obtenerTareas($contenedorCotizaciones, $contadorCotizaciones, 'Cotizacion');
          break;
        }
        case 4: {
          cerrarFormTarea($elementoPadre, $elementoCerrar)
          obtenerTareas($contenedorVentas, $contadorVentas, 'Venta');
          break;
        }
      } //Fin de los casos
    }
  });
}
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
  rtn.setAttribute('disabled', 'true');
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
      <td>${producto.id}</td>
      <td>${producto.nombre}</td>
      <td>${producto.marca}</td>
    </tr>
  `
  });
  $tableArticulos.innerHTML = productos;
}
let obtenerEstadosTarea = ($elemento, $btn) => {
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerEstadosTarea.php",
    type: "GET",
    datatype: "JSON",
    success: function (tareas) {
      let objTareas = JSON.parse(tareas); //Convertimos JSON a objeto javascript
      let estadosTarea = '<option value="" disabled>Seleccionar...</option>';
      //Recorremo arreglo de objetos con un forEach para mostrar tareas
      objTareas.forEach(tarea => {
        estadosTarea += `
          <option value="${tarea.idEstado}">${tarea.estado}</option>
        `;
      });
      $elemento.innerHTML = estadosTarea;
      let idTareaEstado = $btn.getAttribute('id').split('-');
      //Setear tipo de tarea
      for (var i = 0; i < $elemento.length; i++) {
        var option = $elemento[i];
        if (idTareaEstado[1] == option.value) {
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
      document.getElementById('id-Tarea').innerText = idTareaEstado[0];
    }
  }); //Fin AJAX
}
/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
//Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente
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
document.getElementById('btn-cerrar-modal').addEventListener('click', () => {
  limpiarForm();
});
document.getElementById('btn-cerrar2').addEventListener('click', () => {
  limpiarForm();
});
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
    rtn.removeAttribute('disabled');
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
  $.ajax({
    url: "../../../Vista/rendimiento/agregarVendedoresTarea.php",
    type: "POST",
    datatype: "JSON",
    data: $Vendedores,
    success: function () {
    }
  }); //Fin AJAX
}