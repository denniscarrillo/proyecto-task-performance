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
      let tarea = '';
      let count = 0;
      //Recorremo arreglo de objetos con un forEach para mostrar tareas
      objData.forEach(tareas => {
        if (tareas.tipoTarea == tipoTarea) {
          tarea +=
            `<div class="card_task dragged-element" draggable="true">
              <div class="conteiner-text-task">
                <p>${tareas.tituloTarea}</p>
                <p>${tareas.fechaInicio}</p>
              </div>
              <div class="conteiner-icons-task">
              <div>
                <a href="#" id="btn_nuevoRegistro" data-bs-toggle="modal" data-bs-target="#modalEditarTarea"><i class="fa-solid-btn fa-solid fa-pen-to-square"></i></a>
              </div>
              <i class="fa-solid-btn fa-solid fa-tag"></i>
              </div>
            </div>`;
          $elemento.innerHTML = tarea;
          count++;
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
          <button type="button" class="btn btn-secondary"  id="btn-cancelar-${$tarea}">Cancelar</button>
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


//Arrastrar y soltar (Tareas)
// const dragElements = document.querySelectorAll(".dragged-element");
// const dragConteiners = document.querySelectorAll(".dragged-conteiner");
// let draggableTodo = null;

// dragElements.forEach((dragElement) => {
//   dragElement.addEventListener("dragstart", dragStart);
//   dragElement.addEventListener("dragend", dragEnd);
// });

// function dragStart() {
//   draggableTodo = this;
//   setTimeout(() => {
//     this.style.display = "none";
//   }, 0);
//   console.log("dragStart");
// }

// function dragEnd() {
//   draggableTodo = null;
//   setTimeout(() => {
//     this.style.display = "block";
//   }, 0);
//   console.log("dragEnd");
// }

// dragConteiners.forEach((dragConteiner) => {
//   dragConteiner.addEventListener("dragover", dragOver);
//   dragConteiner.addEventListener("dragenter", dragEnter);
//   dragConteiner.addEventListener("dragleave", dragLeave);
//   dragConteiner.addEventListener("drop", dragDrop);
// });
// function dragOver(e) {
//   e.preventDefault();
//   console.log("dragOver");
// }
// function dragEnter() {
//   this.style.border = "2px dashed #ccc";
//   console.log("dragEnter");
// }

// function dragLeave() {
//   this.style.border = "none";
//   console.log("dragLeave");
// }

// function dragDrop() {
//   this.style.border = "none";
//   this.appendChild(draggableTodo);
//   console.log("dropped");
// }