import { estadoValidado as validado } from "./ValidacionesModalNuevoCliente.js";
// import { validarEditar as valido } from "./ValidacionesModalEditarCliente.js";

let tablaCarteraClientes = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaCarteraClientes = $("#table-CarteraClientes").DataTable({
    ajax: {
      url: "../../../Vista/crud/carteraCliente/obtenerCarteraClientes.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    columns: [
      { data: "idcarteraCliente" },
      { data: "nombre" },
      { data: "rtn" },
      { data: "telefono" },
      { data: "correo" },
      { data: "direccion" },
      { data: "estadoContacto" },
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

//Crear nuevo usuario
$("#form-carteraCliente").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Usuario
  let nombre = $("#nombre").val();
  let rtn = $("#rtn").val();
  let telefono = $("#telefono").val();
  let correo = $("#correo").val();
  let direccion = $("#direccion").val();
  if (validado) {
    $.ajax({
      url: "../../../Vista/crud/carteraCliente/nuevoCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        nombre: nombre,
        rtn: rtn,
        telefono: telefono,
        correo: correo,
        direccion: direccion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "Se le ha enviado un correo al usuario!",
          "success"
        );
        tablaCarteraClientes.ajax.reload(null, false);
      },
    });
    $("#modalNuevoCliente").modal("hide");
    limpiarForm();
  }
});
let $rtn = document.getElementById('rtn');
$rtn.addEventListener('focusout', function () {
  let $mensaje = document.querySelector('.mensaje-rtn');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-cliente');
  if($rtn.value.trim() != ''){
    $.ajax({
      url: "../../../Vista/crud/Venta/validarRtnCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtnCliente: $rtn.value
      },
      success: function (estado){
        console.log(estado);
        let $objExiste = JSON.parse(estado);
        if ($objExiste){
          $mensaje.innerText = 'RTN/DNI existente';
          $mensaje.classList.add('mensaje-existe-cliente');
        } else {
          $mensaje.innerText = '';
          $mensaje.classList.remove('mensaje-existe-cliente');
        }
      }
    }); //Fin AJAX   
  }
});
//PENDIENTE TERMINAR
let setEstado = function ($estado) {
  let $select = document.getElementById("E_estadoContacto");
  //Setear tipo de tarea
  for (let i = 0; i < $select.length; i++) {
    let option = $select[i];
    // console.log(option.getAttribute("selected"));
    if (!option.getAttribute("selected") == null) {
      option.removeAttribute("selected");
    }
    if ($estado === option.textContent) {
      option.setAttribute("selected", "true");
      // console.log($estado, option.textContent);
      break;
    }
  }
};
//Editar Cliente
$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    idcarteraCliente = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    nombre = fila.find("td:eq(1)").text(),
    rtn = fila.find("td:eq(2)").text(),
    telefono = fila.find("td:eq(3)").text(),
    correo = fila.find("td:eq(4)").text(),
    direccion = fila.find("td:eq(5)").text(),
    estadoContacto = fila.find("td:eq(6)").text();

  // console.log(estadoContacto);
  $("#E_Cliente").val(idcarteraCliente);
  $("#E_Nombre").val(nombre);
  $("#E_Rtn").val(rtn);
  $("#E_Telefono").val(telefono);
  $("#E_Correo").val(correo);
  $("#E_Direccion").val(direccion);
  setEstado(estadoContacto);
  // $("#E_estadoContacto").val(estadoContacto);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarCliente").modal("show");
});

$("#form-editar-carteraCliente").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo Cliente
  let rtnCliente = $("#E_Rtn").val(),
    cliente = $("#E_Nombre").val(),
    telefono = $("#E_Telefono").val(),
    correo = $("#E_Correo").val(),
    direccion = $("#E_Direccion").val(),
    estadoContacto = $("#E_estadoContacto").val();
  if (valido) {
    $.ajax({
      url: "../../../Vista/crud/carteraCliente/editarCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtn: rtnCliente,
        nombre: cliente,
        telefono: telefono,
        correo: correo,
        direccion: direccion,
        estadoContacto: estadoContacto,
      },
      success: function (res) {
        // console.log(res);
        //Mostrar mensaje de exito
        Swal.fire("Actualizado!", "El cliente ha sido modificado!", "success");
        tablaCarteraClientes.ajax.reload(null, false);
      },
    });
    $("#modalEditarCliente").modal("hide");
  }
});

//Limpiar el modal de crear
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
  let nombre = document.getElementById("nombre"),
    rtn = document.getElementById("rtn"),
    telefono = document.getElementById("telefono"),
    correo = document.getElementById("correo"),
    direccion = document.getElementById("direccion");
  //Vaciar campos cliente
  nombre.value = "";
  rtn.value = "";
  telefono.value = "";
  correo.value = "";
  direccion.value = "";
};

//Limpiar el modal de editar
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

//Eliminar un cliente
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    carteraCliente = fila.find("td:eq(1)").text(),
    rtn = fila.find("td:eq(2)").text();
  Swal.fire({
    title: "¿Estas seguro de eliminar a " + carteraCliente + "?",
    text: "No podrá revertir esto",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Borralo!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/carteraCliente/eliminarCarteraCliente.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rtn: rtn,
          carteraCliente: carteraCliente,
        },
        success: function (data) {
          if (!JSON.parse(data).estado) {
            Swal.fire(
              "Lo sentimos",
              "<strong>" + carteraCliente + "</strong> no se puede eliminar",
              "error"
            );
            return;
          }
          Swal.fire(
            "Eliminado",
            "<strong>" + carteraCliente + "</strong> ha sido eliminado",
            "success"
          );
          tablaCarteraClientes.ajax.reload(null, false);
        },
      });
    } //Fin del AJAX
  });
});

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  let buscar = $(
    "#table-CarteraClientes_filter > label > input[type=search]"
  ).val();
  window.open(
    "../../../TCPDF/examples/reporteriaCarteraCliente.php?buscar=" + buscar,
    "_blank"
  );
});
