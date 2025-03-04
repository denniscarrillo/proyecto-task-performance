import {estadoValidado} from "./validacionesNuevoEstadoUsuario.js";
import {estadoValido} from './validacionesEditarEstadousuario.js';

let tablaEstadoUsuario = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  tablaEstadoUsuario = $("#table-EstadoUsuarios").DataTable({
    ajax: {
      url: "../../../Vista/crud/estadoUsuario/obtenerEstadoUsuario.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['idEstado']);
    },
    columns: [
      { data: "item" },
      { data: "estado" },
      { data: "CreadoPor" },
      {
        data: "FechaCreacion.date",
        render: function (data) {
          return data.slice(0, 10);
        },
      },
      {
        defaultContent:
          `<button class="btn-editar btns btn ${
            permisos.Actualizar == "N" ? "hidden" : ""
          }" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>` +
          `<button class="btn_eliminar btns btn ${
            permisos.Eliminar == "N" ? "hidden" : ""
          }" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`,
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
      url: "../../../Vista/crud/estadoUsuario/registrarBitacoraFiltroEstadoUsuario.php",
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
    data: { idObjeto: $idObjeto },
    success: callback,
  });
};
// Crear nueva estado
$("#form-estado").submit(function (e) {
  e.preventDefault();
  let estado = $("#estado").val();
  if (estadoValidado) {
    $.ajax({
      url: "../../../Vista/crud/estadoUsuario/nuevoEstadoUsuario.php",
      type: "POST",
      datatype: "JSON",
      data: {
        estado: estado,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "¡Registrado!",
          "El estado del usuario ha sido registrado.",
          "success"
        );
        tablaEstadoUsuario.ajax.reload(null, false);
      },
    });
    $("#modalNuevoEstadoUsuario").modal("hide");
    limpiarForm();
  }
});

$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    itemEstado= $(this).closest("tr").find("td:eq(0)").text(),
    idEstadoU = $(this).closest("tr").attr("id"), //Capturar el id
    descripcion = fila.find("td:eq(1)").text();
    
  let inputId = document.getElementById('idEstado');
  inputId.setAttribute("class", idEstadoU);
    const estado = ['NUEVO', 'ACTIVO', 'INACTIVO', 'BLOQUEADO'];
  if(estado.includes(descripcion)){
    Swal.fire(
      "No permitido!",
      "El estado no puede ser editado",
      "error"
    );
  }else {
    $("#E_idEstadoU").val(itemEstado);
    $("#E_descripcion").val(descripcion);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");
    $("#modalEditarEstadoU").modal("show");
  }
});

$("#formEditEstadoU").submit(function (e) {
  e.preventDefault(); //evita el comportamiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let inputId = document.getElementById('idEstado'),
    descripcion = $("#E_descripcion").val();
  let idEstado = inputId.getAttribute("class");
  
  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/estadoUsuario/editarEstadoUsuario.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idEstadoU: idEstado,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "¡Actualizado!",
          "El estado del usuario ha sido modificado",
          "success"
        );
        tablaEstadoUsuario.ajax.reload(null, false);
      },
    });
    $("#modalEditarEstadoU").modal("hide");
    limpiarForm();
  }
});

//Eliminar Estado Usuario
$(document).on("click", "#btn_eliminar", function () {
  let idEstadoU = $(this).closest("tr").attr("id"), //Capturar el id,
    descripcion = $(this).closest("tr").find("td:eq(1)").text();
  Swal.fire({
    title: "¿Estás seguro de eliminar el estado " + descripcion + "?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Sí, bórralo!",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/estadoUsuario/eliminarEstadoU.php",
        type: "POST",
        datatype: "json",
        data: {
          idEstadoU: idEstadoU,
          estado: descripcion
        },
        success: function (data) {
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire(
             "¡Eliminado!",
              "El estado del usuario ha sido eliminado.",
              "success"
            );
          } else {
            Swal.fire(
              "¡Lo sentimos!",
              "El estado del usuario no puede ser eliminado",
              "error"
            );
            return;
          }
          tablaEstadoUsuario.ajax.reload(null, false);
        },
      }); //Fin del AJAX
    }
  });
});

// document.getElementById("button-x").addEventListener("click", () => {
//   limpiarForm();
// });
// document.getElementById("btn-editarsubmit").addEventListener("click", () => {
//   limpiarForm();
// });
document.getElementById("btn-cerrar").addEventListener("click", () => {
  limpiarForm();
});
document.getElementById("btn-x").addEventListener("click", () => {
  limpiarForm();
});
let limpiarForm = () => {
  let $inputs = document.querySelectorAll(".mensaje_error");
  let $mensajes = document.querySelectorAll(".mensaje");
  $inputs.forEach(($input) => {
    $input.classList.remove("mensaje_error");
  });
  $mensajes.forEach(($mensaje) => {
    $mensaje.innerText = "";
  });
  let estado = document.getElementById("estado"),
   descripcion = document.getElementById("E_descripcion");
  //Vaciar campos cliente
  estado.value = "";
  descripcion.value = "";
};

//Generar Pdf
$(document).on("click", "#btn_Pdf", function () {
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaEstadoUsuario.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-EstadoUsuarios_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteEstadoUsuario.php?buscar=" + buscar,
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
  let datos = tablaEstadoUsuario.rows().data().toArray();
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

