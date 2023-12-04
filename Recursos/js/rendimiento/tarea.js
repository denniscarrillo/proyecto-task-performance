import * as funciones from '../funcionesValidaciones.js';
const validaciones = {
  soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
  correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
  soloNumeros: /^[0-9 ]*$/,
  caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
  caracterMas5veces: /^(?=.*(...)\1)/,
  letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
  direccion: /^[a-zA-Z0-9 #.,-]+$/
}
//Elementos HTML seleccionados a traves de su atributo ID
let $contenedorLlamada = document.getElementById('conteiner-llamada');
let $contadorLlamadas = document.getElementById('circle-count-llamadas');
let $contenedorLeads = document.getElementById('conteiner-lead');
let $contadorLeads = document.getElementById('circle-count-leads');
let $contenedorCotizaciones = document.getElementById('conteiner-cotizacion');
let $contadorCotizaciones = document.getElementById('circle-count-cotizaciones');
let $contenedorVentas = document.getElementById('conteiner-venta');
let $contadorVentas = document.getElementById('circle-count-ventas');
let $columnaLlamadas = document.getElementById('conteiner-llamada');
let $columnaLeads = document.getElementById('conteiner-lead');
let $columnaCotizaciones = document.getElementById('conteiner-cotizacion');
let $columnaVentas = document.getElementById('conteiner-venta');
let $ArticulosInteres = [];
let $idTarea = '';
let item = 0;
let tableVendedor = '';
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
let validarInputTitulo = ($titleTarea) => {
  funciones.limitarCantidadCaracteres('title-task', 45);
  let estadoValidaciones = {
      estadoCV: false,
      estadoME: false,
      estadoSLN: false
  }
  estadoValidaciones.estadoCV = funciones.validarCampoVacio($titleTarea);
  (estadoValidaciones.estadoCV) ? estadoValidaciones.estadoSLN = funciones.validarSoloLetrasNumeros($titleTarea, validaciones.letrasNumeros) : '';
  (estadoValidaciones.estadoSLN) ? estadoValidaciones.estadoME = funciones.validarMasdeUnEspacio($titleTarea) : '';
  (estadoValidaciones.estadoME) ? funciones.limiteMismoCaracter($titleTarea, validaciones.caracterMas3veces) : '';
}
//Una vez este cargado el documento o pagina web se va a ejecutar lo que esta dentro
$(document).ready(function () {
  obtenerTareas($contenedorLlamada, $contadorLlamadas, 'Llamada');
  obtenerTareas($contenedorLeads, $contadorLeads, 'Lead');
  obtenerTareas($contenedorCotizaciones, $contadorCotizaciones, 'Cotizacion');
  obtenerTareas($contenedorVentas, $contadorVentas, 'Venta');

  // new Sortable(document.getElementById('conteiner-llamada'), {
  //   group: 'shared', // set both lists to same group
  //   animation: 200,
  //   easing: "cubic-bezier(1, 0, 0, 1)",
  //   chosenClass: 'seleccionado',
  //   dragClass: 'drag',
  //   onEnd: () => {
  //     actualizarContadores();
  //     $('#modal-evidencia').modal('show');
  //   }
  // });
  // new Sortable(document.getElementById('conteiner-lead'), {
  //   group: 'shared',
  //   animation: 200,
  //   easing: "cubic-bezier(1, 0, 0, 1)",
  //   chosenClass: 'seleccionado',
  //   dragClass: 'drag',
  //   onEnd: () => {
  //     actualizarContadores();
  //     $('#modal-evidencia').modal('show');
  //   },
  // });
  // new Sortable(document.getElementById('conteiner-cotizacion'), {
  //   group: 'shared',
  //   animation: 200,
  //   easing: "cubic-bezier(1, 0, 0, 1)",
  //   chosenClass: 'seleccionado',
  //   dragClass: 'drag',
  //   onEnd: () => {
  //     actualizarContadores();
  //     $('#modal-evidencia').modal('show');
  //   },
  // });
  // new Sortable(document.getElementById('conteiner-venta'), {
  //   group: 'shared',
  //   animation: 200,
  //   easing: "cubic-bezier(1, 0, 0, 1)",
  //   chosenClass: 'seleccionado',
  //   dragClass: 'drag',
  //   onEnd: () => {
  //     actualizarContadores();
  //     $('#modal-evidencia').modal('show');
  //   },
  // });
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
      // console.log(objData);
      let $tareas = '';
      let count = 0;
      //Recorremo arreglo de objetos con un forEach para mostrar tareas
      objData.forEach(tarea => {
        if (tarea.tipoTarea == tipoTarea) {
          $tareas +=
          // `<div class="card_task dragged-element" draggable="true" id="${tarea.id}" >
            `<div class="card_task dragged-element" data-id="${item+=1}" style="order: ${item+=1}">
              <div class="tarea-id">N° ${tarea.id}
                ${(tarea.idEstadoAvance != 4)? `<button class="menu-estados"><i class="fa-solid fa-arrow-right-long"></i></button>` : ''}
              </div>
                ${(tarea.idEstadoAvance != 4)?  
                  `<div class="menu-estado ${tarea.idEstadoAvance}" hidden>
                  <p class="item-menu ${tarea.id} 1" id="newEstado-llamada">Llamada</p>
                  <p class="item-menu ${tarea.id} 2" id="newEstado-lead">Lead</p>
                  <p class="item-menu ${tarea.id} 3" id="newEstado-cotizacion">Cotización</p>
                  <p class="item-menu ${tarea.id} 4" id="newEstado-venta">Venta</p>
                  </div>`
                : ''}
              <div class="conteiner-text-task">
                <p style="min-height: 2.5rem;">${tarea.tituloTarea}</p>
              </div>
              <div class="conteiner-icons-task">
              <p style="margin-right: 3rem; font-size: 14px;"> Hace ${tarea.diasAntiguedad} días</p>
              <div>
                <a href="#" class="btn-vendedor btn-vendedores" data-bs-toggle="modal" data-bs-target="#modalVendedores" id="${tarea.id}"><i class="fa-solid-btn fa-solid fa-user-plus"></i></a>
              </div>
              <div>
                <a href="../../../Vista/rendimiento/v_editarTarea.php?idTarea=${tarea.id}" class="btn-editar"><i class="fa-solid-btn fa-solid fa-pen-to-square"></i></a>
              </div>
              <i class="fa-solid-btn fa-solid fa-tag"></i>
              </div>
            </div>`;
          $elemento.innerHTML = $tareas;
          count++;
          // id = "btn_nuevoRegistro"
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
      <form action="" method="" id="${$idForm}" class="new-form">
        <div class="data-container">
        <textarea id="title-task" class="input-title" placeholder="${$placeholder}"></textarea>
        <p class="mensaje"></p>
        </div>
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
    //Validaciones textArea
    validarInputTitulo(document.getElementById('title-task'));
    //Si cumple las validaciones dejara crear la tarea
    if(document.querySelectorAll('.mensaje_error').length == 0){
      let titulo = document.getElementById('title-task').value;
      let tarea = null;
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
          data: objTarea
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
    }
  });
}
$(document).on('click', '.btn-vendedor', function () {
  $idTarea = this.getAttribute('id'); //Obtenemos el id de la tara que se le van a agregar los vendedores
  obtenerVendedores($idTarea);
  console.log($idTarea);
});
let obtenerVendedores = function () {
  console.log($idTarea);
  if (document.getElementById('table-Vendedores_wrapper') == null) {
    tableVendedor = $('#table-Vendedores').DataTable({
      "ajax": {
        "url": "../../../Vista/rendimiento/obtenerVendedores.php",
        "type": "POST",
        "data": {
          "idTarea": $idTarea 
        },
        "dataSrc": "",
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
  console.log(vendedoresSeleccionados);
  console.log(vendedoresSeleccionados.length);
  if(vendedoresSeleccionados.length > 0){
    vendedoresSeleccionados.forEach(function (vendedor) {
      if (vendedor.classList.contains('select-vendedor')) {
        let $idVendedor = $(vendedor).closest('tr').find('td:eq(0)').text();
        let $vendedor = {
          idVendedor: $idVendedor
        }
        $Vendedores.push($vendedor);
      }
    });
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
          Toast.fire({
            icon: 'success',
            title: 'Los vendedores han sido agregados en la tarea #'+$id_Tarea,
          });
          tableVendedor.destroy();
      }
    }); //Fin AJAX
  }else{
    if(tableVendedor.rows().count() < 1){
      Toast.fire({
        icon: 'error',
        title: 'No hay vendedores disponibles'
      });
    }else{
      Toast.fire({
        icon: 'error',
        title: 'No ha seleccionado vendedores'
      });
    }
  }
  
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

$(document).on("click", ".menu-estados", function() {
  if(this.parentElement.parentElement.children[1].getAttribute('hidden') != null){
    this.parentElement.parentElement.children[1].removeAttribute('hidden');
  }else{
    this.parentElement.parentElement.children[1].setAttribute('hidden', 'true');
  }
  // document.querySelectorAll('.card_task').forEach(card => {
  //   card.addEventListener('mouseenter', () => {
  //     console.log(this.parentElement.parentElement.children[1]);
  //     if(this.parentElement.parentElement.children[1].getAttribute('hidden') != null){
  //       this.parentElement.parentElement.children[1].removeAttribute('hidden');
  //     }
  //   })
  // });
  this.parentElement.parentElement.children[1].addEventListener('mouseleave', function() {
    console.log(this.parentElement.parentElement.children[1]);
    document.querySelectorAll('.menu-estado').forEach(menu => {
      menu.setAttribute('hidden', 'true');
    })
  })
});

$(document).on("click", "#newEstado-llamada", function() {
  let $idTarea = this.getAttribute('class').split(' ')[1];
  let $estadoActual = parseInt(this.parentElement.getAttribute('class').split(' ')[1]);
  let $nuevoEstado = parseInt(this.getAttribute('class').split(' ')[2]);
  console.log($estadoActual);
  console.log($nuevoEstado);
  if($nuevoEstado < $estadoActual || $nuevoEstado == $estadoActual){
    if($nuevoEstado < $estadoActual){
      Toast.fire({
        icon: 'error',
        title: 'No puedes volver a un estado anterior'
      });
    }
  }else{
    console.log('no entro')
    cambiarEstado($idTarea, $nuevoEstado);
    location.href ='./v_tarea.php';
  }
  this.parentElement.setAttribute('hidden', 'true');
})
$(document).on("click", "#newEstado-lead", function() {
  let $idTarea = this.getAttribute('class').split(' ')[1];
  let $estadoActual = parseInt(this.parentElement.getAttribute('class').split(' ')[1]);
  let $nuevoEstado = parseInt(this.getAttribute('class').split(' ')[2]);
  console.log($estadoActual);
  console.log($nuevoEstado);
  if($nuevoEstado < $estadoActual || $nuevoEstado == $estadoActual){
    if($nuevoEstado < $estadoActual){
      Toast.fire({
        icon: 'error',
        title: 'No puedes volver a un estado anterior'
      });
    }
  }else{
    cambiarEstado($idTarea, $nuevoEstado);
    location.href ='./v_tarea.php';
  }
  this.parentElement.setAttribute('hidden', 'true');
})
$(document).on("click", "#newEstado-cotizacion", function() {
  let $idTarea = this.getAttribute('class').split(' ')[1];
  let $estadoActual = parseInt(this.parentElement.getAttribute('class').split(' ')[1]);
  let $nuevoEstado = parseInt(this.getAttribute('class').split(' ')[2]);
  console.log($estadoActual);
  console.log($nuevoEstado);
  if($nuevoEstado < $estadoActual || $nuevoEstado == $estadoActual){
    if($nuevoEstado < $estadoActual){
      Toast.fire({
        icon: 'error',
        title: 'No puedes volver a un estado anterior'
      });
    }
  }else{
    cambiarEstado($idTarea, $nuevoEstado);
    location.href ='./v_tarea.php';
  }
  this.parentElement.setAttribute('hidden', 'true');
})
$(document).on("click", "#newEstado-venta", function() {
  let $idTarea = this.getAttribute('class').split(' ')[1];
  let $estadoActual = parseInt(this.parentElement.getAttribute('class').split(' ')[1]);
  let $nuevoEstado = parseInt(this.getAttribute('class').split(' ')[2]);
  console.log($estadoActual);
  console.log($nuevoEstado);
  if($nuevoEstado < $estadoActual || $nuevoEstado == $estadoActual){
    if($nuevoEstado < $estadoActual){
      Toast.fire({
        icon: 'error',
        title: 'No puedes volver a un estado anterior'
      });
    }
  }else{
    console.log('venta')
    cambiarEstado($idTarea, $nuevoEstado);
    location.href ='./v_tarea.php';
  }
  this.parentElement.setAttribute('hidden', 'true');
})
let cambiarEstado = ($idTarea, $nuevoEstado) => {
  $.ajax({
    url: "../../../Vista/rendimiento/cambiarEstadoTarea.php",
    type: "POST",
    datatype:"json",    
    data:  { 
      idTarea: $idTarea,
      nuevoEstado: $nuevoEstado
    },    
    success: function(data) {
                 
    }
  }); //Fin del AJAX
}
$(document).on("click", "#btn-close-modal-Vendedores", function(){
  tableVendedor.destroy();
})
// $(document).on("click", "#btn_agregarVendedores", function(){
//   tableVendedor.destroy();
// })
// $(document).on("click", "#btn_eliminar", function() {
//   let fila = $(this);        
//     let usuario = $(this).closest('tr').find('td:eq(1)').text();
//     let ROL = $(this).closest('tr').find('td:eq(5)').text();
//     if (ROL == 'Super Administrador'){
//       Swal.fire(
//         'Sin acceso!',
//         'Super Administrador no puede ser eliminado',
//         'error'
//       )
//     }else{
//       Swal.fire({
//         title: 'Estas seguro de eliminar a '+usuario+'?',
//         text: "No podras revertir esto!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Si, borralo!'
//       }).then((result) => {
//         if (result.isConfirmed) {      
//           $.ajax({
//             url: "../../../Vista/crud/usuario/eliminarUsuario.php",
//             type: "POST",
//             datatype:"json",    
//             data:  { usuario: usuario},    
//             success: function(data) {
//               let estadoEliminado = data[0].estadoEliminado;
//                console.log(data);
//               if(estadoEliminado == 'eliminado'){
//                 tablaUsuarios.row(fila.parents('tr')).remove().draw();
//                 Swal.fire(
//                   'Eliminado!',
//                   'El usuario ha sido eliminado.',
//                   'success'
//                 ) 
//                 tablaUsuarios.ajax.reload(null, false); 
//               } else {
//                 Swal.fire(
//                   'Lo sentimos!',
//                   'El usuario no puede ser eliminado, se ha inactivado.',
//                   'error'
//                 );
//                 tablaUsuarios.ajax.reload(null, false);
//               }           
//             }
//           }); //Fin del AJAX
//         }
//       });
//     }		                   
// });

