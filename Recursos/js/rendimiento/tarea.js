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
let $idTarea = '';

//Una vez este cargado el documento o pagina web se va a ejecutar lo que esta dentro
$(document).ready(function () {
  obtenerTareas($contenedorLlamada, $contadorLlamadas, 'Llamada');
  obtenerTareas($contenedorLeads, $contadorLeads, 'Lead');
  obtenerTareas($contenedorCotizaciones, $contadorCotizaciones, 'Cotizacion');
  obtenerTareas($contenedorVentas, $contadorVentas, 'Venta');
  obtenerVendedores();

  new Sortable(document.getElementById('conteiner-llamada'), {
    group: 'shared', // set both lists to same group
    animation: 200,
    easing: "cubic-bezier(1, 0, 0, 1)",
    chosenClass: 'seleccionado',
    dragClass: 'drag',
    onEnd: () => {
      actualizarContadores();
      // $('#modalVendedores').modal('show');
    }
  });
  new Sortable(document.getElementById('conteiner-lead'), {
    group: 'shared',
    animation: 200,
    easing: "cubic-bezier(1, 0, 0, 1)",
    chosenClass: 'seleccionado',
    dragClass: 'drag',
    onEnd: () => {
      actualizarContadores();
      // $('#modalVendedores').modal('show');
    }
  });
  new Sortable(document.getElementById('conteiner-cotizacion'), {
    group: 'shared',
    animation: 200,
    easing: "cubic-bezier(1, 0, 0, 1)",
    chosenClass: 'seleccionado',
    dragClass: 'drag',
    onEnd: () => {
      actualizarContadores();
      // $('#modalVendedores').modal('show');
    }
  });
  new Sortable(document.getElementById('conteiner-venta'), {
    group: 'shared',
    animation: 200,
    easing: "cubic-bezier(1, 0, 0, 1)",
    chosenClass: 'seleccionado',
    dragClass: 'drag',
    onEnd: () => {
      actualizarContadores();
      // $('#modalVendedores').modal('show');
    }
  });
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
                <a href="#" class="btn-vendedor btn-vendedores" data-bs-toggle="modal" data-bs-target="#modalVendedores" id="${tarea.id}"><i class="fa-solid-btn fa-solid fa-user-plus"></i></a>
              </div>
              <div>
                <a href="../../../Vista/rendimiento/v_editarTarea.php?idTarea=${tarea.id}&estadoTarea=${tarea.idEstadoAvance}" class="btn-editar"><i class="fa-solid-btn fa-solid fa-pen-to-square"></i></a>
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
    }
  });
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
            '<div><button class="btns btn btn_select-Vendedores"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}
$(document).on('click', '.btn_select-Vendedores', function () {
  selectVendedores(this);
});
$(document).on('click', '.btn-vendedor', function () {
  $idTarea = this.getAttribute('id'); //Obtenemos el id de la tara que se le van a agregar los vendedores
});
$(document).on('click', '#btn_agregarVendedores', function () {
  //Tiendiendo los vendedores y el idTarea enviamos los datos al servidor
  agregarVendedores($idTarea);
});
let selectVendedores = function ($elementoHtml) {
  $elementoHtml.classList.toggle('select-vendedor');
}
//Guardamos los vendedores que se desean agregar a una tarea
let agregarVendedores = function ($id_Tarea) {
  let $Vendedores = [];
  let vendedoresSeleccionados = document.querySelectorAll('.select-vendedor');
  vendedoresSeleccionados.forEach(function (vendedor) {
    if (vendedor.classList.contains('select-vendedor')) {
      let $idVendedor = $(vendedor).closest('tr').find('td:eq(0)').text();
      let $vendedor = {
        idVendedor: $idVendedor
      }
      $Vendedores.push($vendedor);
    }
  });
  console.log($Vendedores);
  //AJAX para almacenar vendedores en la base de datos
  $.ajax({
    url: "../../../Vista/rendimiento/agregarVendedoresTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      "idTarea": $id_Tarea,
      "vendedores": JSON.stringify($Vendedores)
    },
    success: function (res) {
      $('#modalVendedores').modal('hide');
      Swal.fire(
        'Exito!',
        'Los vendedores han sido agregados',
        'success',
      )
    }
  }); //Fin AJAX
}
let actualizarContadores = () => {
  //Actualizar contador llamadas
  let contLlamadas = document.getElementById('circle-count-llamadas'); //Contado de llamadas
  divPadre = document.getElementById('conteiner-llamada');
  contLlamadas.textContent = divPadre.querySelectorAll('.card_task').length;
  //Actualizar contador Leads
  let contLeads = document.getElementById('circle-count-leads'); //Contado de llamadas
  divPadre = document.getElementById('conteiner-lead');
  contLeads.textContent = divPadre.querySelectorAll('.card_task').length;
  //Actualizar contador cotizaciones
  let contCotz = document.getElementById('circle-count-cotizaciones'); //Contado de llamadas
  divPadre = document.getElementById('conteiner-cotizacion');
  contCotz.textContent = divPadre.querySelectorAll('.card_task').length;
  //Actualizar contador ventas
  let contVentas = document.getElementById('circle-count-ventas'); //Contado de llamadas
  divPadre = document.getElementById('conteiner-venta');
  contVentas.textContent = divPadre.querySelectorAll('.card_task').length;
}