import { estadoValidado as validado } from "./validacionesNuevaVenta.js";
let tablaVentas = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  tablaVentas = $("#table-Ventas").DataTable({
    ajax: {
      url: "../../../Vista/crud/Venta/obtenerVenta.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    columns: [
      { data: "numFactura" },
      { data: "nombreCliente" },
      { data: "rtnCliente" },
      {
        data: "totalVenta",
        render: $.fn.dataTable.render.number(",", ".", 2, " Lps. "),
      },
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
  let filtro = document.querySelector('input[type=search]');
};

$(document).on("focusout", "input[type=search]", function (e) {
  let filtro = $(this).val();
  capturarFiltroDataTable(filtro);
});
const capturarFiltroDataTable = function(filtro){
  if(filtro.trim()){
    $.ajax({
      url: "../../../Vista/crud/estadoUsuario/registrarBitacoraFiltroEstadoUsuario.php",
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
// Crear nueva venta
$("#form-New-Venta").submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  //Obtener datos del nuevo tipo servicio
  let rtnCliente = $("#rtn").val();
  let totalVenta = $("#totalVenta").val();
  if (validado) {
    $.ajax({
      url: "../../../Vista/crud/Venta/nuevaVenta.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtn: rtnCliente,
        venta: totalVenta,
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          "Registrado!",
          "Se ha registrado una nueva venta!",
          "success"
        );
        tablaVentas.ajax.reload(null, false);
      },
    });
    $("#modalNuevaVenta").modal("hide");
    limpiarForm();
    // validado = false;
  }
});

let $rtn = document.getElementById("rtn");
$rtn.addEventListener("focusout", function () {
  let $mensaje = document.querySelector(".mensaje-rtn");
  $mensaje.innerText = "";
  $mensaje.classList.remove("mensaje-existe-cliente");
  if ($rtn.value.trim() != "") {
    $.ajax({
      url: "../../../Vista/crud/Venta/validarRtnCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtnCliente: $rtn.value,
      },
      success: function (cliente) {
        let $objCliente = JSON.parse(cliente);
        if (!$objCliente) {
          $mensaje.innerText = "El cliente no existe";
          $mensaje.classList.add("mensaje-existe-cliente");
        } else {
          $mensaje.innerText = "";
          $mensaje.classList.remove("mensaje-existe-cliente");
          document.getElementById("cliente").value = $objCliente.nombre;
        }
      },
    }); //Fin AJAX
  }
});

$(document).on("click", "#btn_editar", function () {
  Swal.fire("No permitido!", "La venta no puede ser editada", "error");
});

$(document).on("click", "#btn_eliminar", function () {
  let fila = $(this).closest("tr"),
    factura = $(this).closest("tr").find("td:eq(0)").text(), //capturo el ID
    cliente = $(this).closest("tr").find("td:eq(1)").text(),
    rtn = $(this).closest("tr").find("td:eq(2)").text();
  Swal.fire({
    title: "¿Estás seguro de eliminar la venta #" + factura + "?",
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
        url: "../../../Vista/crud/Venta/eliminarVenta.php",
        type: "POST",
        datatype: "json",
        data: { 
          numFactura: factura,
          nombreCliente: cliente,
          rtnCliente: rtn,
        },
        success: function (data) {
          if (JSON.parse(data).estadoEliminado) {
            Swal.fire("¡Eliminado!", "La venta ha sido eliminada", "success");
          } else {
            Swal.fire(
              "¡Lo sentimos!",
              "La venta no puede ser eliminada",
              "error"
            );
            return;
          }
          tablaVentas.ajax.reload(null, false);
        },
      }); //Fin del AJAX
    }
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
  let $mensajeRTN = document.querySelector(".mensaje-rtn");
  $mensajeRTN.innerText = "";
  $inputs.forEach(($input) => {
    $input.classList.remove("mensaje_error");
  });
  $mensajes.forEach(($mensaje) => {
    $mensaje.innerText = "";
  });
  $mensajeRTN.classList.remove(".mensaje-existe-cliente");
  let rtnCliente = document.getElementById("rtn"),
    nombreCliente = document.getElementById("cliente"),
    venta = document.getElementById("totalVenta");
  //Vaciar campos cliente
  rtnCliente.value = "";
  nombreCliente.value = "";
  venta.value = "";
};

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaVentas.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-Ventas_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteriaVentas.php?buscar=" + buscar,
      "_blank"
    );
  } else {
    // Mostrar mensaje de que no se puede generar el PDF si el DataTable está vacío o si el filtro está vacío y no hay coincidencias
    Swal.fire(
      "¡Error!",
      "No se puede generar el pdf si la tabla está vacía o si el filtro no coincide con ningún dato en la misma",
      "error"
    );
  }
});

// Función para verificar si hay coincidencias con el término de búsqueda
function hayCoincidencias(buscar) {
  let datos = tablaVentas.rows().data().toArray();
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


