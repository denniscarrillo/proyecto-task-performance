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
      { data: "item" },
      { data: "articulo" },
      { data: "detalle" },
      { data: "marcaArticulo" },
      { data: "creadoPor" },
      {
        data: "fechaCreacion.date",
        render: function (data) {
          return data.slice(0, 19);
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
  //Obtener datos del nuevo Usuario
  let Articulo = $("#Articulo").val();
  let Detalle = $("#Detalle").val();
  let Marca = $("#Marca").val();
console.log(estadoValidado);
  if (estadoValidado) {
    $.ajax({
      url: "../../../Vista/crud/articulo/nuevoArticulo.php",
      type: "POST",
      datatype: "JSON",
      data: {
        Articulo: Articulo,
        Detalle: Detalle,
        Marca: Marca,
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
    Marca = fila.find("td:eq(3)").text();
    console.log(CodArticulo)

  let inputId = document.getElementById('codigo');
  inputId.setAttribute("class", CodArticulo);
  $("#A_CodArticulo").val(itemArticulo);
  $("#A_Articulo").val(Articulo);
  $("#A_Detalle").val(Detalle);
  $("#A_Marca").val(Marca);

  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarArticulo").modal("show");
});

$("#form_EditarArticulo").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let inputId = document.getElementById('codigo'),
    Articulo = $("#A_Articulo").val(),
    Detalle = $("#A_Detalle").val(),
    Marca = $("#A_Marca").val();
    let codigo = inputId.getAttribute("class");
    console.log(estadoValido);
  if (estadoValido) {
    
    $.ajax({
      url: "../../../Vista/crud/articulo/editarArticulo.php",
      type: "POST",
      datatype: "JSON",
      data: {
        CodArticulo: codigo,
        Articulo: Articulo,
        Detalle: Detalle,
        Marca: Marca,
      },
      success: function (res) {
        console.log(res);
        //Mostrar mensaje de exito
        Swal.fire("Actualizado!", "El Artículo ha sido modificado!", "success");
        tablaArticulo.ajax.reload(null, false);
      },
    });
    $("#modalEditarArticulo").modal("hide");
  }
});

$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this);
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
        datatype: "json",
        data: { codArticulo: codArticulo},
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
          tablaArticulo.ajax.reload(null, false);
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
  let articulo = document.getElementById("Articulo"),
    detalle = document.getElementById("Detalle"),
    marca = document.getElementById("Marca");
  //Vaciar campos cliente
  articulo.value = "";
  detalle.value = "";
  marca.value = "";
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
