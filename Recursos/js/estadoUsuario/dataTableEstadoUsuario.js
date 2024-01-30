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
    columns: [
      { data: "idEstado" },
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
};
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
          "Registrado!",
          "El estado usuario ha sido registrado.",
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
    idEstadoU = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    descripcion = fila.find("td:eq(1)").text();
  $("#E_idEstadoU").val(idEstadoU);
  $("#E_descripcion").val(descripcion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarEstadoU").modal("show");
});

$("#formEditEstadoU").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let idEstadoU = $("#E_idEstadoU").val(),
    descripcion = $("#E_descripcion").val();
  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/estadoUsuario/editarEstadoUsuario.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idEstadoU: idEstadoU,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Actualizado!",
          "La estado Usuario ha sido modificado!",
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
  let fila = $(this),
    idEstadoU = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    descripcion = $(this).closest("tr").find("td:eq(1)").text();
  Swal.fire({
    title: "Estas seguro de eliminar el estado " + descripcion + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/estadoUsuario/eliminarEstadoU.php",
        type: "POST",
        datatype: "json",
        data: {
          idEstadoU: idEstadoU,
        },
        success: function (data) {
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire(
              "Eliminado!",
              "El estado usuario ha sido eliminado",
              "success"
            );
          } else {
            Swal.fire(
              "Lo sentimos!",
              "El estado usuario no puede ser eliminado",
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
  let buscar = $("#table-EstadoUsuarios_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reporteEstadoUsuario.php?buscar=" + buscar,
    "_blank"
  );
});