import { estadoValidado } from "./ValidacionesModalNuevoArticulo.js";
import { estadoValido } from "./ValidacionesModalEditarArticulo.js";

let tablaArticulo = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaArticulo = $("#table-Articulos").DataTable({
    ajax: {
      url: "../../../Vista/crud/articulo/obtenerArticulo.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['codigo']);
    },
    columns: [
      { data: "codigo" },
      { data: "articulo" },
      { data: "detalle" },
      { data: "precio" },
      { data: "existencias" },
      { data: "marcaArticulo" },
      { data: "creadoPor" },
      {
        data: "fechaCreacion.date",
        render: function (data) {
          return data.slice(0, 16);
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

// registro de nuevo Articulo
$("#form_Articulo").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo articulo
  let Articulo = $("#Articulo").val();
  let Detalle = $("#Detalle").val();
  let Marca = $("#Marca").val();
  let precio = $("#precio").val();
  let existencias = $("#existencias").val();

  if (estadoValidado) {
    $.ajax({
      url: "../../../Vista/crud/articulo/nuevoArticulo.php",
      type: "POST",
      datatype: "JSON",
      data: {
        Articulo: Articulo,
        Detalle: Detalle,
        Marca: Marca,
        Precio: precio,
        Existencias: existencias
      },
      success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
            "Registrado!",
            "Se ha registrado un Nuevo Articulo!",
            "success"
          );
          tablaArticulo.ajax.reload(null, false);
      },
    });
    $("#modalNuevoArticulo").modal("hide");
    limpiarForm();
  }
});

$(document).on("click", "#btn_Pdf", function () {
  let buscar = $("#table-Articulos_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reporteriaArticulos.php?buscar=" + buscar,
    "_blank"
  );
});

$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    itemArticulo = $(this).closest("tr").find("td:eq(0)").text(),
    CodArticulo = $(this).closest("tr").attr('id'), //capturo el ID
    Articulo = fila.find("td:eq(1)").text(),
    Detalle = fila.find("td:eq(2)").text(),
    Precio = fila.find("td:eq(3)").text(),
    Existencias = fila.find("td:eq(4)").text(),
    Marca = fila.find("td:eq(5)").text();

  let inputId = document.getElementById('codigo');
  inputId.setAttribute("class", CodArticulo);
  $("#A_CodArticulo").val(itemArticulo);
  $("#A_Articulo").val(Articulo);
  $("#A_Detalle").val(Detalle);
  $("#idPrecio").attr('class', Precio);
  $("#A_Existencias").val(Existencias);
  $("#A_Marca").val(Marca);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarArticulo").modal("show");
});

$("#form_EditarArticulo").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let codArticulo = $('#A_CodArticulo').val(),
      articulo = $("#A_Articulo").val(),
      detalle = $("#A_Detalle").val(),
      marca = $("#A_Marca").val(),
      precio = $("#precios").val(),
      existencias = $("#A_Existencias").val();

  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/articulo/editarArticulo.php",
      type: "POST",
      datatype: "JSON",
      data: {
        codArticulo: codArticulo,
        articulo: articulo,
        detalle: detalle,
        marca: marca,
        precio: precio,
        existencias: existencias
      },
      success: function (res) {
        //Mostrar mensaje de exito
        Swal.fire("Actualizado!", "El Articulo ha sido modificado!", "success");
        tablaArticulo.ajax.reload(null, false);
      },
    });
    $("#modalEditarArticulo").modal("hide");
  }
});

$(document).on("click", "#btn_eliminar", function () {
  let codArticulo = $(this).closest("tr").attr('id');
  let nombreArticulo = $(this).closest("tr").find("td:eq(1)").text();
  Swal.fire({
    title: "Estas seguro de eliminar el artículo " + nombreArticulo + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/articulo/eliminarArticulo.php",
        type: "POST",
        datatype: "JSON",
        data: { codArticulo: codArticulo },
        success: function (data) {
          console.log(JSON.parse(data).estadoEliminado)
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire("Eliminado!", "El artículo ha sido eliminado", "success");
            tablaArticulo.ajax.reload(null, false);
          } else {
            Swal.fire(
              "Lo sentimos",
              "El artículo no puede ser eliminado",
              "error"
            );
          }
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

document.getElementById("btn-cerrar-modal-editar").addEventListener("click", () => {
  limpiarForm();
});

document.getElementById("btn-x-modal-editar").addEventListener("click", () => {
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

  //Vaciar campos cliente
  $("#Articulo").val('')
  $("#Detalle").val('')
  $("#Marca").val('')
  $("#precio").val('')
  $("#existencias").val('')
};
//Limpiar modal de editar
// document.getElementById('button-cerrar').addEventListener('click', ()=>{
//   limpiarFormEdit();
// })
// document.getElementById('button-x').addEventListener('click', ()=>{
//   limpiarFormEdit();
// })
// let limpiarFormEdit = () => {
//   let $inputs = document.querySelectorAll('.mensaje_error');
//   let $mensajes = document.querySelectorAll('.mensaje');
//   $inputs.forEach($input => {
//     $input.classList.remove('mensaje_error');
//   });
//   $mensajes.forEach($mensaje =>{
//     $mensaje.innerText = '';
//   });
// }
