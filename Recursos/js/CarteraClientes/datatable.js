import { estadoValidado as validado } from "./ValidacionesModalNuevoCliente.js";
import { validarEditar as valido } from "./ValidacionesModalEditarCliente.js";

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
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['idcarteraCliente']);
    },
    columns: [
      { data: "item" },
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
  let filtro = document.querySelector('input[type=search]');
};

$(document).on("focusout", "input[type=search]", function (e) {
  let filtro = $(this).val();
  capturarFiltroDataTable(filtro);
});
const capturarFiltroDataTable = function(filtro){
  if(filtro.trim()){
    $.ajax({
      url: "../../../Vista/crud/carteraCliente/registrarBitacoraFiltroCarteraCliente.php",
      type: "POST",
      data: {
        filtro: filtro
      }
    })
  }
}

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
          "¡Registrado!",
          "Se ha registrado un Nuevo Cliente",
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
    idcarteraCliente = $(this).closest("tr").attr('id'), //capturo el ID
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
        Swal.fire("¡Actualizado!", "El cliente ha sido modificado", "success");
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
    carteraCliente = $(this).closest("tr").attr('id'),
    nombreCliente = fila.find("td:eq(1)").text(),
    rtn = fila.find("td:eq(2)").text();
  Swal.fire({
    title: "¿Estás seguro de eliminar a " + nombreCliente + "?",
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
        url: "../../../Vista/crud/carteraCliente/eliminarCarteraCliente.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rtn: rtn,
          carteraCliente: carteraCliente,
          nombreCliente: nombreCliente,
        },
        success: function (data) {
          if (!JSON.parse(data).estado) {
            Swal.fire(
              "Lo sentimos",
              "<strong>" + nombreCliente + "</strong> no se puede eliminar",
              "error"
            );
            return;
          }
          Swal.fire(
            "Eliminado",
            "<strong>" + nombreCliente + "</strong> ha sido eliminado",
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
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaCarteraClientes.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-CarteraClientes_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteriaCarteraCliente.php?buscar=" + buscar,
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
  let datos = tablaCarteraClientes.rows().data().toArray();
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


