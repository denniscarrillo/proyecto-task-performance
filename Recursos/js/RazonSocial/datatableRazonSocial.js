import { estadoValidado as validado } from "./validacionesModalNuevaRazonSocial.js";
import { estadoValidado as valido } from "./validacionesModalEditarRazonSocial.js";
let tablaRazonSocial = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaRazonSocial = $("#table-RazonSocial").DataTable({
    ajax: {
      url: "../../../Vista/crud/razonSocial/obtenerRazonSocial.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    columns: [
      { data: "id_razonSocial" },
      { data: "razon_Social" },
      { data: "descripcion" },
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
// Crear nueva Razon Social
$("#form-razonSocial").submit(function (e) {
  e.preventDefault();
  let razonSocial = $("#razonSocial").val();
  let descripcion = $("#descripcion").val();
  if (validado) {
    $.ajax({
      url: "../../../Vista/crud/razonSocial/nuevaRazonSocial.php",
      type: "POST",
      datatype: "JSON",
      data: {
        razonSocial: razonSocial,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "La razon Social ha sido registrada.",
          "success"
        );
        tablaRazonSocial.ajax.reload(null, false);
      },
    });
    $("#modalNuevaRazonSocial").modal("hide");
    limpiarForm();
  }
});

// Editar Razon Social
$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    idRazonSocial = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    razonSocial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();
  $("#E_idRazonSocial").val(idRazonSocial);
  $("#E_razonSocial").val(razonSocial);
  $("#E_descripcion").val(descripcion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarRazonSocial").modal("show");
});

// Evento Submit que edita la Razon Social
$("#form-Edit_razonSocial").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let idRazonSocial = $("#E_idRazonSocial").val(),
    razonSocial = $("#E_razonSocial").val(),
    descripcion = $("#E_descripcion").val();
  if (valido) {
    $.ajax({
      url: "../../../Vista/crud/razonSocial/editarRazonSocial.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_RazonSocial: idRazonSocial,
        razonSocial: razonSocial,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Actualizado!",
          "La razon social ha sido modificado!",
          "success"
        );
        tablaRazonSocial.ajax.reload(null, false);
      },
    });
    $("#modalEditarRazonSocial").modal("hide");
  }
});
//Eliminar pregunta
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    idRazonSocial = $(this).closest("tr").find("td:eq(0)").text(),
    razonSocial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();

  Swal.fire({
    title: "Estas seguro de eliminar la razonSocial " + razonSocial + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/razonSocial/eliminarRazonSocial.php",
        type: "POST",
        datatype: "JSON",
        data: {
          id_RazonSocial: idRazonSocial,
          razonSocial: razonSocial,
          descripcion: descripcion,
        },
        success: function (data) {
          if (JSON.parse(data) == "true") {
            tablaRazonSocial.row(fila.parents("tr")).remove().draw();
            Swal.fire(
              "Lo sentimos!",
              "La razon Social no puede ser eliminada.",
              "error"
            );
            tablaRazonSocial.ajax.reload(null, false);
          } else {
            Swal.fire(
              "Eliminada!",
              "La razon Social ha sido Eliminada!.",
              "success"
            );
            tablaRazonSocial.ajax.reload(null, false);
          }
        },
      });
    } //Fin del AJAX
  });
});

//Limpiar modal de crear
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
  let razonSocial = document.getElementById("razonSocial"),
    descripcion = document.getElementById("descripcion");
  //Vaciar campos cliente
  razonSocial.value = "";
  descripcion.value = "";
};

//Limpiar modal de editar
document.getElementById("btn-cerrar").addEventListener("click", () => {
  limpiarFormEdit();
});
document.getElementById("btn-x").addEventListener("click", () => {
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

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  let buscar = $(
    "#table-RazonSocial_filter > label > input[type=search]"
  ).val();
  window.open(
    "../../../TCPDF/examples/reporteRazonSocial.php?buscar=" + buscar,
    "_blank"
  );
});
