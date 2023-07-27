
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
});
//Evento
$('#btn-NuevaLLamada').click(function(){
  crearNuevaTarea($columnaLlamadas , 'conteiner-form-llamada','form-nuevaLlamada', 'Titulo de la llamada', 'llamada');
  let $btnGuardar = document.getElementById('btn-submit-llamada');
  guardarTarea($btnGuardar, 'btn-submit-llamada');

  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-llamada');
  let $elementoEliminar = document.getElementById('conteiner-form-llamada');
  cancelarIngresoTarea($btnCancelar,$columnaLlamadas, $elementoEliminar);
  
});
$('#btn-NuevoLead').click(function(){
  crearNuevaTarea($columnaLeads, 'conteiner-form-lead', 'form-nuevoLead','Titulo del lead', 'lead');
  let $btnGuardar = document.getElementById('btn-submit-lead');
  guardarTarea($btnGuardar);
   //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-lead');
  let $elementoEliminar = document.getElementById('conteiner-form-lead');
  cancelarIngresoTarea($btnCancelar,$columnaLeads, $elementoEliminar);
});
$('#btn-NuevaCotizacion').click(function(){
  crearNuevaTarea($columnaCotizaciones, 'conteiner-form-cotizacion', 'form-nuevaCotizacion', 'Titulo de la Cotizacion', 'cotizacion');
     //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
     let $btnCancelar = document.getElementById('btn-cancelar-cotizacion');
     let $elementoEliminar = document.getElementById('conteiner-form-cotizacion');
     cancelarIngresoTarea($btnCancelar,$columnaCotizaciones, $elementoEliminar);
});
$('#btn-NuevaVenta').click(function(){
  crearNuevaTarea($columnaVentas, 'conteiner-form-venta', 'form-nuevoVenta', 'Titulo de la Venta', 'venta');

  //Añadimos el evento que ejecuta funcion cancelar el ingreso de la nueva tarea
  let $btnCancelar = document.getElementById('btn-cancelar-venta');
  let $elementoEliminar = document.getElementById('conteiner-form-venta');
  cancelarIngresoTarea($btnCancelar,$columnaVentas, $elementoEliminar);
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
            '<div class="card_task">' +
            '<p>' + tareas.tituloTarea + '</p>' +
            '<p>' + tareas.fechaInicio + '</p>' +
            '</div>'
            $elemento.innerHTML = tarea;
          count++;
        }
      });
      //Si no hay tareas del tipo buscado el contador se mantiene en cero y se indica en el HTML
      (count == 0) ? $contador.innerText = '0' : $contador.innerText = count;
    }
  });
}

let crearNuevaTarea = ($contenedor, $idConteinerForm, $idForm,  $placeholder, $tarea) =>{
    // Validamos si no existe el formulrio para nueva tarea, solo entonces se agrega.
  if(document.getElementById($idForm) == null){
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
let cancelarIngresoTarea = ($btnCancelar,$elementoPadre, $elementoEliminar) => {
  $btnCancelar.addEventListener('click', function(){
     $elementoPadre.removeChild($elementoEliminar);
  });
};
let guardarTarea = ($btnGuardar, $tarea) =>{
  //Agregamos el evento click al boton de guardar tarea
  $btnGuardar.addEventListener('click', function(e){
  e.preventDefault();
  let titulo = document.getElementById('title-task').value;
  let tarea = null;
    if($btnGuardar.getAttribute('id') == $tarea){
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
    // console.log(objTarea);
  });
}