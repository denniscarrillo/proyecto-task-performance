import {estadoValido} from './validacionesModalEditarParametro.js';

let tablaParametro = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  tablaParametro = $("#table-Parametro").DataTable({
    ajax: {
      url: "../../../Vista/crud/parametro/obtenerParametro.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id']);
    },
    columns: [
      { data: "item" },
      { data: "parametro" },
      { data: "valorParametro" },
      { data: "descripcionParametro" },
      { data: "usuario" },
      {
        defaultContent: `<div>
        <button class="btn-editar btns btn ${
          permisos.Actualizar == "N" ? "hidden" : ""
        }" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn_eliminar btns btn ${
          permisos.Eliminar == "N" ? "hidden" : ""
        }" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>
      </div>`,
      },
    ],
  });
  let filtro = document.querySelector('input[type=search]');
};

$(document).on("focusout", "input[type=search]", function (e) {
  let filtro = $(this).val();
  capturarFiltroDataTable(filtro);
});
const capturarFiltroDataTable = function(filtro){
  if(filtro.trim()){
    $.ajax({
      url: "../../../Vista/crud/parametro/registrarBitacoraFiltroParametro.php",
      type: "POST",
      data: {
        filtro: filtro
      }
    })
  }
}
//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) {
  $.ajax({
      url: "../../../Vista/crud/permiso/obtenerPermisos.php",
      type: "POST",
      datatype: "JSON",
      data: {idObjeto: $idObjeto},
      success: callback
    });
}
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idParametro = $(this).closest('tr').attr('id'), //capturo el ID		            
  parametro = fila.find('td:eq(1)').text(),
  valor = fila.find('td:eq(2)').text(),
  descripcion = fila.find('td:eq(3)').text();
  $("#E_idParametro").val(idParametro);
  $("#E_parametro").val(parametro);
  $("#E_valor").val(valor);
  $("#E_descripcion").val(descripcion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarParametro").modal("show");
});

$("#form-Edit-Parametro").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let idParametro = $('#E_idParametro').val(),
   parametro =  $('#E_parametro').val(),
   valor = $('#E_valor').val(),
   descripcion = $('#E_descripcion').val();;
   if(estadoValido){
    $.ajax({
      url: "../../../Vista/crud/parametro/editarParametro.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idParametro: idParametro,
       parametro: parametro,
       valor: valor,
       descripcion : descripcion
      },
      success: function (data) {
        let resp = JSON.parse(data);
        let mensaje = document.querySelector(
          "#form-Edit-Parametro > div.grupo-form > div:nth-child(3) > p"
        );
        if (!resp.estado) {
          mensaje.innerText = resp.mensaje;
          mensaje.classList.add("mensaje_error");
          return;
        }
        $("#modalEditarParametro").modal("hide");
        //Mostrar mensaje de exito
        Swal.fire(
          "¡Actualizado!",
          "El parámetro ha sido modificado!",
          "success"
        );
        tablaParametro.ajax.reload(null, false);
      },
    });
  }
});

//Limpiar modal de editar
document.getElementById("button-cerrar").addEventListener("click", () => {
  limpiarFormEdit();
});
document.getElementById("button-x").addEventListener("click", () => {
  limpiarFormEdit();
});
let limpiarFormEdit = () => {
  let $inputs = document.querySelectorAll(".mensaje_error");
  let $mensajes = document.querySelectorAll(".mensaje");
  $inputs.forEach(($input) => {
    $input.classList.remove("mensaje_error");
  });
  $mensajes.forEach(($mensaje) => {
    $mensaje.innerText = "";
  });
};

//Eliminar parametro
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this);
  let parametro = $(this).closest("tr").attr('id');
  Swal.fire({
    title: "¿Estás seguro de eliminar el parámetro " + parametro + "?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, bórralo!",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/parametro/eliminarParametro.php",
        type: "POST",
        datatype: "json",
        data: { parametro: parametro },
        success: function (data) {
          let estadoEliminado = data[0].estadoEliminado;
          console.log(data);
          if (estadoEliminado == "eliminado") {
            tablaParametro.row(fila.parents("tr")).remove().draw();
            Swal.fire(
              "Eliminado!",
              "El parámetro ha sido eliminada.",
              "success"
            );
            tablaParametro.ajax.reload(null, false);
          } else {
            Swal.fire(
              "¡Lo sentimos!",
              "El parámetro no puede ser eliminado.",
              "error"
            );
            tablaParametro.ajax.reload(null, false);
          }
        },
      }); //Fin del AJAX
    }
  });
});

$(document).on("click", "#btn_nuevoRegistro", function () {
  Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "¡No se pueden ingresar nuevos parámetros!",
  });
});

//Generar Pdf
$(document).on("click", "#btn_Pdf", function () {
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaParametro.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-Parametro_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteParametros.php?buscar=" + buscar,
      "_blank"
    );
  } else {
    // Mostrar mensaje de error específico
    Swal.fire(
      "¡Error!",
      "No se puede generar el pdf si la tabla está vacía o si el filtro no coincide con ningún dato en la misma",
      "error"
    );
  }
});

// Función para verificar si hay coincidencias con el término de búsqueda
function hayCoincidencias(buscar) {
  let datos = tablaParametro.rows().data().toArray();
  for (let i = 0; i < datos.length; i++) {
    let valores = Object.values(datos[i]);
    for (let j = 0; j < valores.length; j++) {
      if (valores[j].toString().toLowerCase().includes(buscar.toLowerCase())) {
        return true;
      }
    }
  }
  return false;
}


