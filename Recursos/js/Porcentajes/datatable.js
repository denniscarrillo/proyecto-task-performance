import { estadoValidado as validado } from "./ValidacionesModalNuevoPorcentaje.js";
import { estadoValidado as valido } from "./ValidacionesModalEditarPorcentaje.js";

let tablaPorcentajes = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  tablaPorcentajes = $("#table-Porcentajes").DataTable({
    ajax: {
      url: "../../../Vista/crud/Porcentajes/obtenerPorcentajes.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['idPorcentaje']);
    },
    columns: [
      { data: "item" },
      {
        data: "valorPorcentaje",
        render: function (data, type) {
          if (type === "display") {
            return (parseFloat(data) * 100).toFixed(0) + "%"; // Formatea el porcentaje
          }
          return data; // En otras ocasiones, devuelve el valor sin formato
        },
      },
      { data: "descripcionPorcentaje" },
      { data: "estadoPorcentaje" },
      {
        defaultContent: `<div>
          <button class="btns btn ${
            permisos.Actualizar == "N" ? "hidden" : ""
          }"" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn_eliminar btns btn ${
            permisos.Eliminar == "N" ? "hidden" : ""
          }" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>
        </div>`,
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
$("#btn_nuevoRegistro").click(function () {
  // //Petición para obtener
  // obtenerContactoCliente('#estadoContacto');
  //Petición para obtener estado de usuario
  // obtenerEstadoUsuario('#estado');
  // $(".modal-header").css("background-color", "#007bff");
  // $(".modal-header").css("color", "white");
});
//Crear nuevo usuario
$("#form-Porcentajes").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Usuario
  let valorPorcentaje = $("#valorPorcentaje").val();
  let descripcionPorcentaje = $("#descripcionPorcentaje").val();
  let estadoPorcentaje = $("#estadoPorcentaje").val();
  //  let estado = document.getElementById('estado').value;
  if (validado) {
    $.ajax({
      url: "../../../Vista/crud/Porcentajes/nuevoPorcentaje.php",
      type: "POST",
      datatype: "JSON",
      data: {
        valorPorcentaje: valorPorcentaje,
        descripcionPorcentaje: descripcionPorcentaje,
        estadoPorcentaje: estadoPorcentaje,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "El Porcentaje ha sido registrado!",
          "success"
        );
        tablaPorcentajes.ajax.reload(null, false);
      },
    });
    $("#modalNuevoPorcentaje").modal("hide");
    limpiarForm();
  }
});
$("#modalNuevoPorcentaje").on("hidden.bs.modal", function (e) {
  // Limpia los valores de los campos del formulario
  $("#form-Porcentajes")[0].reset();
});
// let obtenerContactoCliente = function (idElemento) {
//   //Petición para obtener estados contacto clientes
//   $.ajax({
//     url: '../../../Vista/crud/carteraCliente/obtenerContactoCliente.php',
//     type: 'GET',
//     dataType: 'JSON',
//     success: function (data) {
//       let valores = '<option value="">Seleccionar...</option>';
//       for (let i = 0; i < data.length; i++) {
//         valores += '<option value="' + data[i].id_estadoContacto + '">' + data[i].contacto_Cliente +'</option>';
//       }
//       $(idElemento).html(valores);
//     }
//   });
// }
document.getElementById("E_valorPorcentaje").setAttribute("disabled", true);
document
  .getElementById("E_descripcionPorcentaje")
  .setAttribute("disabled", true);
//Editar Porcentaje
$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    idPorcentaje = $(this).closest("tr").attr('id'), //capturo el ID
    valorPorcentaje = fila.find("td:eq(1)").text(),
    descripcionPorcentaje = fila.find("td:eq(2)").text(),
    estadoPorcentaje = fila.find("td:eq(3)").text();
    console.log(idPorcentaje)
  $("#E_idPorcentaje").val(idPorcentaje);
  $("#E_valorPorcentaje").val(valorPorcentaje);
  $("#E_descripcionPorcentaje").val(descripcionPorcentaje);
  $("#E_estadoPorcentaje").val(estadoPorcentaje);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarPorcentaje").modal("show");
});

$("#form-Edit-Porcentaje").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let idPorcentaje = $("#E_idPorcentaje").val(),
    estadoPorcentaje = $("#E_estadoPorcentaje").val();
  if (valido) {
    $.ajax({
      url: "../../../Vista/crud/Porcentajes/editarPorcentaje.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idPorcentaje: idPorcentaje,
        estadoPorcentaje: estadoPorcentaje,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Actualizado!",
          "El Porcentaje ha sido modificado!",
          "success"
        );
        tablaPorcentajes.ajax.reload(null, false);
      },
    });
    $("#modalEditarPorcentaje").modal("hide");
  }
});
//Limpiar el formulario de crear
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
  let valorPorcentaje = document.getElementById("valorPorcentaje"),
    descripcionPorcentaje = document.getElementById("descripcionPorcentaje");
  //Vaciar campos cliente
  valorPorcentaje.value = "";
  descripcionPorcentaje.value = "";
};

//Limpiar el formulario de editar
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

//Eliminar porcentajes
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    idPorcentaje = $(this).closest("tr").attr('id'),
    porcentaje = fila.find("td:eq(1)").text(),
    estado = "INACTIVO";

  Swal.fire({
    title: "Estas seguro de eliminar el porcentaje " + porcentaje + "?",
    text: "No podras revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/Porcentajes/eliminarPorcentajes.php",
        type: "POST",
        datatype: "JSON",
        data: {
          idPorcentaje: idPorcentaje,
          estado: estado,
        },
        success: function (data) {
          console.log(data);

          // Verificar la respuesta del servidor
          if (data.includes('INACTIVO')) {
            Swal.fire(
              "Porcentaje Inactivado!",
              "El porcentaje no se ha podido eliminar, pero en su lugar ha sido inactivado.",
              "error"
            );
          } else if(data.includes('ELIMINADO')) {
            Swal.fire(
              "Porcentaje Eliminado!",
              "El porcentaje ha sido eliminado.",
              "success"
            );
          } else {
            Swal.fire(
              "Lo sentimos!",
              "El porcentaje no puede ser eliminado.",
              "error"
            );
          }
          tablaPorcentajes.ajax.reload(null, false);
        },
        error: function () {
          Swal.fire(
            "Error!",
            "Hubo un problema al procesar la solicitud.",
            "error"
          );
        }
      });
    } // Fin del AJAX
  });
});




$(document).on("click", "#btn_Pdf", function () {
  let buscar = $(
    "#table-Porcentajes_filter > label > input[type=search]"
  ).val();
  window.open(
    "../../../TCPDF/examples/reporteriaPorcentaje.php?buscar=" + buscar,
    "_blank"
  );
});
