import { estadoValidado } from "./validacionesModalNuevoRubroComercial.js";
import { estadoValido  } from "./validacionesModalEditarRubroComercial.js";
let tablaRubroComercial = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaRubroComercial = $("#table-RubroComercial").DataTable({
    ajax: {
      url: "../../../Vista/crud/rubroComercial/obtenerRubroComercial.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id_rubroComercial']);
    },
    columns: [
      { data: "item" },
      { data: "rubro_Comercial" },
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
/* let obtenerPermisos = function ($idObjeto, callback) {
  $.ajax({
    url: "../../../Vista/crud/permiso/obtenerPermisos.php",
    type: "POST",
    datatype: "JSON",
    data: { idObjeto: $idObjeto },
    success: callback,
  });
}; */
// Crear nueva Rubro Comercial
$("#form-rubroComercial").submit(function (e) {
  e.preventDefault();
  let rubroComercial = $("#rubroComercial").val();
  let descripcion = $("#descripcion").val();
  console.log(estadoValidado);
  if (estadoValidado) {
    $.ajax({
      url: "../../../Vista/crud/rubroComercial/nuevoRubroComercial.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rubroComercial: rubroComercial,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "El Rubro Comercial ha sido registrado.",
          "success"
        );
        tablaRubroComercial.ajax.reload(null, false);
      },
    });
    $("#modalNuevoRubroComercial").modal("hide");
    limpiarForm();
  }
});

// Editar Rubro Comercial
$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    itemRubro= $(this).closest("tr").find("td:eq(0)").text(),
    idRubroComercial = $(this).closest("tr").attr("id"), //capturo el ID
    rubroComercial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();

  let inputId = document.getElementById('rubroid');
  inputId.setAttribute("class", idRubroComercial);
  $("#E_idRubroComercial").val(itemRubro);
  $("#E_rubroComercial").val(rubroComercial);
  $("#E_descripcion").val(descripcion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarRubroComercial").modal("show");
  console.log(idRubroComercial)
});

// Evento Submit que edita el Rubro Comercial
$("#form-Edit_rubroComercial").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let inputId = document.getElementById('rubroid'),
    rubroComercial = $("#E_rubroComercial").val(),
    descripcion = $("#E_descripcion").val();
    let razonid = inputId.getAttribute("class");
  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/rubroComercial/editarRubroComercial.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_RubroComercial: rubroid,
        rubroComercial: rubroComercial,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Actualizado!",
          "El Rubro Comercial ha sido modificado!",
          "success"
        );
        tablaRubroComercial.ajax.reload(null, false);

      },
    });
    $("#modalEditarRubroComercial").modal("hide");
   // limpiarFormEdit();
  }
});
//Eliminar pregunta
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    idRubroComercial = $(this).closest("tr").attr("id"),
    rubroComercial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();

  Swal.fire({
    title:
      "Estas seguro de eliminar el rubro comercial " + rubroComercial + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/rubroComercial/eliminarRubroComercial.php",
        type: "POST",
        datatype: "JSON",
        data: {
          id_RubroComercial: idRubroComercial,
          rubroComercial: rubroComercial,
          descripcion: descripcion,
        },
        success: function (data) {
          if (JSON.parse(data) == "true") {
            tablaRubroComercial.row(fila.parents("tr")).remove().draw();
            Swal.fire(
              "Rubro Eliminado!",
              "El Rubro Comercial ha sido Eliminado!.",
              "success"
            );
            tablaRubroComercial.ajax.reload(null, false);
          } else {
            Swal.fire(
              "Eliminado!",
              "El rubro comercial ha sido Eliminado!.",
              "success"
            );
            tablaRubroComercial.ajax.reload(null, false);
          }
        },
      });
    } //Fin del AJAX
  });
});

//Limpiar modal de crear
document.getElementById("btn-cerrar-Editar").addEventListener("click", () => {
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
  let rubroComercial = document.getElementById("rubroComercial"),
      descripcion = document.getElementById('descripcion');
  //Vaciar campos cliente
  rubroComercial.value = "";
  descripcion.value = "";
};

//Limpiar modal de editar
/* document.getElementById("btn-cerrarEditar").addEventListener("click", () => {
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
}; */

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  let buscar = $(
    "#table-RubroComercial_filter > label > input[type=search]"
  ).val();
  window.open(
    "../../../TCPDF/examples/reporteRubroComercial.php?buscar=" + buscar,
    "_blank"
  );
});
