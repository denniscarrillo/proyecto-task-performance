// Obtiene la tabla de comisiones de vendedores
let tablaComisionVendedor = '';
$(document).ready(function () {
  tablaComisionVendedor = $('#table-ComisionVendedor').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/ComisionesVendedores/obtenerComisiones_V.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'idComisionVendedor'},
      { "data": 'idComision'},
      { "data": 'idVendedor'},
      { "data": 'usuario'},
      { "data": 'comisionTotal', 
      "render": $.fn.dataTable.render.number( ',', '.', 2, ' Lps. ' )},
      { "data": 'estadoComision'},
      { "data": 'estadoLiquidacion'},
      { "data": 'fechaComision.date',
      "render": function(data) {
        return data.slice(0, 19); },
      },
      { "data": 'fechaLiquidacion.date',
      "render": function(data) {
        return data ? data.slice(0, 19) : '' },
      },
    ]
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
  // if (document.querySelector(".dataTables_info") !== null) {
  //   // $tablaComisionesV.destroy();
  // }
  //DataTable
  $tablaComisionesV = $("#table-comisionesVendedor").DataTable({
    ajax: {
      url: "../../../Vista/crud/ComisionesVendedores/obtenerFechasComision.php",
      type: "POST",
      datatype: "JSON",
      data: {
        fecha_Desde: fechaDesde,
        fecha_Hasta: fechaHasta
      },
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    columns: [
      { data: "idVendedor" },
      { data: "nombreVendedor" },
      // { data: "fechaDesde" },
      // { data: "fechaHasta" },
      // { data: "estadoComision" },
      { data: "totalComision",
      "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') }
    ],
});
$("#btn_liquidar").on("click", function () {
  // Obtén el rango de fechas desde los datos de la tabla (ajusta esto según tu estructura de datos)
  let fechaDesdeL = tablaComisionVendedor.rows().data()[0].fechaDesde;
  let fechaHastaL = tablaComisionVendedor.rows().data()[0].fechaHasta;

  // Realiza la solicitud AJAX para llamar al método PHP
  $.ajax({
      url: "../../../Vista/crud/ComisionesVendedores/liquidandoComisiones.php",
      type: "POST",
      dataType: "JSON",
      data: { fechaDesde: fechaDesdeL,
              fechaHasta: fechaHastaL },
      success: function (data) {
          console.log(data);
          // Maneja la respuesta del servidor (muestra la alerta)
          Swal.fire({
              icon: 'success',
              title: 'Comisiones liquidadas correctamente',
              showConfirmButton: false,
              timer: 1500  // La alerta se cerrará automáticamente después de 1.5 segundos
          });
      },
      error: function (error) {
          // Maneja cualquier error que pueda ocurrir durante la solicitud AJAX
          console.error(error);
      }
  });
});

$("#modalComisionesV").modal("show");
};

// ...



// ...


// // Función para generar el PDF
// function generarPDF(fechaDesde, fechaHasta) {
//   // Realiza una solicitud AJAX para generar el PDF
//   let datosComisiones = $tablaComisionesV.rows().data().toArray();
//   $.post("../../../TCPDF/examples/reporteSumaComiVendedores.php", {
//     $fechaDesde: fechaDesde,
//     $fechaHasta: fechaHasta,
//     comisiones: JSON.stringify(datosComisiones), // Pasa los datos de comisiones como JSON
//   })
//     .done(function (response) {
//       // La generación del PDF se ha completado, puedes realizar acciones adicionales si es necesario
//       console.log(response);
//     })
//     .fail(function (error) {
//       // Maneja cualquier error que pueda ocurrir durante la generación del PDF
//       console.error(error);
//     });
// }
// let $btnGenerarPDF = document.getElementById("btn_PDFComisiones");
// let $pdfContainer = document.getElementById("pdfContainer");
// let comisionesFiltradas = obtenerComisionesFiltradas(fechaDesde, fechaHasta); // Reemplaza esto con tu lógica para obtener las comisiones filtradas

// $btnGenerarPDF.addEventListener("click", function () {
//   // Solicita la generación del PDF a través de una solicitud AJAX
//   $.post("../../../TCPDF/examples/reporteSumaComiVendedores.php", {
//     fechaDesde: fechaDesde, // Pasa las fechas desde tu formulario
//     fechaHasta: fechaHasta,
//     contenidoHTML: '<?php echo $html; ?>', // Pasa el contenido HTML
//   })
//     .done(function (response) {
//       // Muestra el PDF en un visor o permite la descarga
//       $pdfContainer.innerHTML = response;
//     })
//     .fail(function (error) {
//       console.error(error);
//     });
// });

let obtenerComisionesFiltradas = function (fechaDesde, fechaHasta) {
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
}

$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-ComisionVendedor_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaComisionVendedores.php?buscar='+buscar, '_blank');
});

// title: 'Comisiones liquidadas correctamente',
