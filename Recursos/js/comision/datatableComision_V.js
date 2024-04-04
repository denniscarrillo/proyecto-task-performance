// Obtiene la tabla de comisiones de vendedores
let tablaComisionVendedor = "";
$(document).ready(function () {
  tablaComisionVendedor = $("#table-ComisionVendedor").DataTable({
    ajax: {
      url: "../../../Vista/crud/ComisionesVendedores/obtenerComisiones_V.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['idComisionVendedor']);
    },
    columns: [
      { data: "item" },
      { data: "idComision" },
      { data: "idVendedor" },
      { data: "usuario" },
      {
        data: "comisionTotal",
        render: $.fn.dataTable.render.number(",", ".", 2, " Lps. "),
      },
      { data: "estadoComision" },
      { data: "estadoLiquidacion" },
      {
        data: "fechaComision.date",
        render: function (data) {
          return data.slice(0, 19);
        },
      },
      {
        data: "fechaLiquidacion.date",
        render: function (data) {
          return data ? data.slice(0, 19) : "";
        },
      },
      
    ],
  });
});
let $btnFiltrar = document.getElementById("btnFiltrar");
let $tablaComisionesV = "";

// $(document).ready(function () {
//   let now = new Date().toLocaleString("en-US", {
//     timeZone: "America/Tegucigalpa",
//     hour12: true,
//     dateStyle: "short",
//   });
//   // document.getElementById("fecha-comision").value = now;
// });

$btnFiltrar.addEventListener("click", function () {
  let $fechaDesde = document.getElementById("fechaDesdef");
  let $fechaHasta = document.getElementById("fechaHastaf");
  iniciarDataTable($fechaDesde.value, $fechaHasta.value);

  // Agrega un manejador de clic para el botón "Generar PDF"
  $("#btn_PdfComisiones").on("click", function () {
    obtenerComisionesFiltradas($fechaDesde.value, $fechaHasta.value);
  });
});

let iniciarDataTable = function (fechaDesde, fechaHasta) {
  // Destroy existing DataTable before reinitialization
  var existingTable = $("#table-comisionesVendedor").DataTable();
  if (existingTable !== null) {
    existingTable.destroy();
  }

  $tablaComisionesV = $("#table-comisionesVendedor").DataTable({
    ajax: {
      url: "../../../Vista/crud/ComisionesVendedores/obtenerFechasComision.php",
      type: "POST",
      datatype: "JSON",
      data: {
        fecha_Desde: fechaDesde,
        fecha_Hasta: fechaHasta,
      },
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    columns: [
      { data: "idVendedor" },
      { data: "nombreVendedor" },
      {
        data: "totalComision",
        render: $.fn.dataTable.render.number(",", ".", 2, " Lps. "),
      },
    ],
    initComplete: function (settings, json) {
      // Obtener las fechas de la primera fila
      const fechaDesdeT = json[0].fechaDesde; // Ajusta esto según la estructura de tus datos
      const fechaHastaT = json[0].fechaHasta; // Ajusta esto según la estructura de tus datos

      // Asumiendo que tengas un elemento con el id "fechasLabel" para mostrar las fechas
      $("#fechasLabel").text(
        "Desde el: " + fechaDesdeT + " Hasta el: " + fechaHastaT
      );

      // Show the modal after initializing DataTable
      $("#modalComisionesV").modal("show");
    },
  });
};

$("#btn_liquidar").on("click", function () {
  // Obtén las fechas directamente de los datos de la tabla
  let fechaDesdeL = $tablaComisionesV.row(0).data().fechaDesde; // Ajusta esto según la estructura de tus datos
  let fechaHastaL = $tablaComisionesV.row(0).data().fechaHasta; // Ajusta esto según la estructura de tus datos

  $.ajax({
    url: "../../../Vista/crud/ComisionesVendedores/liquidandoComisiones.php",
    type: "POST",
    dataType: "JSON",
    data: {
      fechaDesde: fechaDesdeL,
      fechaHasta: fechaHastaL,
    },
    success: function () {
      console.log(response);
      if (response.success) {
        console.log(response.message);
        // Actualiza la tabla con los datos actualizados
        // $tablaComisionesV.clear().rows.add(response.datosActualizados).draw();
        // Maneja la respuesta del servidor (muestra la alerta)
        Swal.fire({
          icon: "success",
          title: "Comisiones liquidadas correctamente",
          showConfirmButton: true,
          timer: 3000,
        });
      } else {
        console.error(response.message);
        // Muestra un mensaje de error indicando que no se pudieron liquidar las comisiones
        Swal.fire({
          icon: "error",
          title: "Error al liquidar comisiones",
          text: response.message,
        });
      }
    },
    error: function (error) {
      // Maneja cualquier error que pueda ocurrir durante la solicitud AJAX
      console.log(error);

      // Muestra un mensaje de error genérico
      Swal.fire({
        icon: "success",
        title: "Comisiones liquidadas correctamente",
        showConfirmButton: true,
        timer: 3000,
      });
      tablaComisionVendedor.ajax.reload();
    },
  });
});

let obtenerComisionesFiltradas = function (fechaDesde, fechaHasta) {
  console.log("Fecha desde: " + fechaDesde);
  console.log("Fecha hasta: " + fechaHasta);
  $.ajax({
    type: "POST",
    url: "../../../Vista/crud/ComisionesVendedores/obtenerFechasComision.php",
    data: {
      fecha_Desde: fechaDesde,
      fecha_Hasta: fechaHasta,
    },
    success: function (data) {
      console.log(data);
    },
  });
};

//Generar PDF
$(document).on("click", "#btn_Pdf", function () {
  // Obtener la cantidad de registros en el DataTable
  let cantidadRegistros = tablaComisionVendedor.rows().count();

  // Obtener el valor del filtro de búsqueda
  let buscar = $("#table-ComisionVendedor_filter> label > input[type=search]").val().trim();

  // Verificar si hay datos en el DataTable y si el filtro de búsqueda no está vacío
  if (cantidadRegistros > 0 && (buscar === '' || buscar !== '' && hayCoincidencias(buscar))) {
    window.open(
      "../../../TCPDF/examples/reporteriaComisionVendedores.php?buscar=" + buscar,
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
  let datos = tablaComisionVendedor.rows().data().toArray();
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



// title: 'Comisiones liquidadas correctamente',
