import { estadoValidado } from "./validacionNuevoObjeto.js";
import { estadoValido } from "./validacionesEditarObjeto.js";

let tablaDataTableObjeto = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaDataTableObjeto = $("#table-Objeto").DataTable({
    ajax: {
      url: "../../../Vista/crud/DataTableObjeto/obtenerDataTableObjeto.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    columns: [
      { data: "id_Objeto" },
      { data: "objeto" },
      { data: "descripcion" },
      { data: "tipo_Objeto" },
      // { data: "Creado_Por" },
      // {
      //   // data: "fechaCreacion.date",
      //   // render: function (data) {
      //   //   return data.slice(0, 19);
      //   // },
      // },
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

$(document).on("click", "#btn_Pdf", function () {
  let buscar = $("#table-Objeto_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reporteriaObjetos.php?buscar=" + buscar,
    "_blank"
  );
});

//Crear nuevo Objeto
$("#form-Nuevo-Objeto").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Usuario
  let objeto = $("#objeto").val();
  let descrip = $("#descripcion").val();
  if (estadoValidado) {
    $.ajax({
      url: "../../../Vista/crud/DataTableObjeto/nuevoObjeto.php",
      type: "POST",
      datatype: "JSON",
      data: {
        objeto: objeto,
        descripcion: descrip,
      },
      success: function (data) {
        console.log(data);
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "Se le ha ingresado un nuevo objeto!",
          "success"
        );
        tablaDataTableObjeto.ajax.reload(null, false);
      },
    });
    $("#modalNuevoObjeto").modal("hide");
    limpiarForm();
  }
});

$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    id_Objeto = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    descripcion = fila.find("td:eq(2)").text();

  $("#A_objeto").val(id_Objeto), $("#A_descripcion").val(descripcion);

  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarObjeto").modal("show");
});

$("#formEditarObjeto").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let id_Objeto = $("#A_objeto").val(),
    descripcion = $("#A_descripcion").val();
  console.log(estadoValido);
  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/DataTableObjeto/editarObjeto.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_Objeto: id_Objeto,
        descripcion: descripcion,
      },
      success: function (res) {
        console.log(res);
        //Mostrar mensaje de exito
        Swal.fire("Actualizado!", "El Objeto ha sido modificado!", "success");
        tablaDataTableObjeto.ajax.reload(null, false);
      },
    });
    $("#modalEditarObjeto").modal("hide");
  }
});

$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this);
  let id_Objeto = $(this).closest("tr").find("td:eq(0)").text();
  let objeto = $(this).closest("tr").find("td:eq(1)").text();
  Swal.fire({
    title: "Estas seguro de eliminar el artículo " + objeto + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/DataTableObjeto/eliminarObjeto.php",
        type: "POST",
        datatype: "json",
        data: { id_Objeto: id_Objeto, objeto: objeto },
        success: function (data) {
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire("Eliminado!", "El artículo ha sido eliminado", "success");
          } else {
            Swal.fire(
              "Lo sentimos!",
              "El artículo no puede ser eliminado",
              "error"
            );
            return;
          }
          tablaDataTableObjeto.ajax.reload(null, false);
        },
      }); //Fin del AJAX
    }
  });
});

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
  let objeto = document.getElementById("objeto"),
    descripcion = document.getElementById("descripcion");
  //Vaciar campos cliente
  objeto.value = "";
  descripcion.value = "";
};
