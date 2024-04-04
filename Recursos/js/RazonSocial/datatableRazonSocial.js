import { estadoValidado} from "./validacionesModalNuevaRazonSocial.js";
import {  estadoValido } from "./validacionesModalEditarRazonSocial.js";
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
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id_razonSocial']);
    },
    columns: [
      { data: "item" },
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
  let filtro = document.querySelector('input[type=search]');
};

$(document).on("focusout", "input[type=search]", function (e) {
  let filtro = $(this).val();
  capturarFiltroDataTable(filtro);
});
const capturarFiltroDataTable = function(filtro){
  if(filtro.trim()){
    $.ajax({
      url: "../../../Vista/crud/razonSocial/registrarBitacoraFiltroRazonSocial.php",
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
// Crear nueva Razon Social
$("#form-razonSocial").submit(function (e) {
  e.preventDefault();
  let razonSocial = $("#razonSocial").val();
  let descripcion = $("#descripcion").val();
  if (estadoValidado) {
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
          "¡Registrado!",
          "La razón Social ha sido registrada.",
          "success"
        );
        tablaRazonSocial.ajax.reload(null, false);
      },
    });
    $("#modalNuevaRazonSocial").modal("hide");
    limpiarForm();
  }
});

let $RazonSocial = document.getElementById('razonSocial');
$RazonSocial.addEventListener('focusout', function () {
  let $mensaje = document.querySelector('.mensaje-razonsocial');
  $mensaje.innerText = '';
  $mensaje.classList.remove('mensaje-existe-razonsocial');
  if($RazonSocial.value.trim() != ''){
    $.ajax({
      url: "../../../Vista/crud/razonSocial/razonSocialExistente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        razonSocial: $RazonSocial.value
      },
      success: function (estado){
        let $objExiste = JSON.parse(estado);
        if ($objExiste){
          $mensaje.innerText = 'Razón Social existente';
          $mensaje.classList.add('mensaje-existe-razonsocial');
        } else {
          $mensaje.innerText = '';
          $mensaje.classList.remove('mensaje-existe-razonsocial');
        }
      }
    }); //Fin AJAX   
  }
});

// Editar Razon Social
$(document).on("click", "#btn_editar", function () {
  let fila = $(this).closest("tr"),
    itemRazon = $(this).closest("tr").find("td:eq(0)").text(),
    idRazonSocial = $(this).closest("tr").attr('id'), //capturo el ID
    razonSocial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();
    console.log(idRazonSocial)
  let inputId = document.getElementById('razonid');
  inputId.setAttribute("class", idRazonSocial);
  $("#E_idRazonSocial").val(itemRazon);
  $("#E_razonSocial").val(razonSocial);
  $("#E_descripcion").val(descripcion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  $("#modalEditarRazonSocial").modal("show");
});

// Evento Submit que edita la Razon Social
$("#form-Edit_razonSocial").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo razonsocial
  let inputId = document.getElementById('razonid'),
    razonSocial = $("#E_razonSocial").val(),
    descripcion = $("#E_descripcion").val();
  let razonid = inputId.getAttribute("class");
  if (estadoValido) {
    $.ajax({
      url: "../../../Vista/crud/razonSocial/editarRazonSocial.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_RazonSocial: razonid,
        razonSocial: razonSocial,
        descripcion: descripcion,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "¡Actualizado!",
          "La razón social ha sido modificado!",
          "success"
        );
        tablaRazonSocial.ajax.reload(null, false);
       /*  limpiarFormEdit(); */
      },
    });
    $("#modalEditarRazonSocial").modal("hide");
    limpiarFormEdit();
  }
});
//Eliminar Rubro Comercial
$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    idRazonSocial = $(this).closest("tr").attr('id'),
    razonSocial = fila.find("td:eq(1)").text(),
    descripcion = fila.find("td:eq(2)").text();
  Swal.fire({
    title: "¿Estás seguro de eliminar la razonSocial " + razonSocial + "?",
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
        url: "../../../Vista/crud/razonSocial/eliminarRazonSocial.php",
        type: "POST",
        datatype: "JSON",
        data: {
          id_RazonSocial: idRazonSocial,
          razonSocial:razonSocial
        },
        success: function (data) {
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire(
              "Razón Social Eliminada!","La Razón Social ha sido Eliminada!.","success"
            );
          } else {
            Swal.fire(
              "Lo sentimos!",
              "La Razón Social no puede ser eliminada",
              "error"
            );
           return;
          }
            tablaRazonSocial.ajax.reload(null, false);
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
  //Vaciar campos razonsocial
  razonSocial.value = "";
  descripcion.value = "";
};

//Limpiar modal de editar
/* document.getElementById("btn-cerrar-Editar").addEventListener("click", () => {
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
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaRazonSocial.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-RazonSocial_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteRazonSocial.php?buscar=" + buscar,
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
  let datos = tablaRazonSocial.rows().data().toArray();
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

// 
