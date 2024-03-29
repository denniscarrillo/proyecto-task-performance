let tablaCotizacion = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  tablaCotizacion = $("#table-Cotizacion").DataTable({
    ajax: {
      url: "../../../../Vista/rendimiento/cotizacion/obtenerCotizaciones.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id']);
    },
    columns: [
      { data: "item" },
      { data: "creadoPor" },
      { data: "cliente" },
      { data: "subDescuento" },
      { data: "impuesto" },
      { data: "total" },
      { data: "estado" },
      {
        defaultContent: `<button class="btn-editar btns btn ${
          permisos.Reporte == "N" ? "hidden" : ""
        }" id="btn_PDFid"><i class="fas fa-file-pdf"> </i></button>`,
      },
    ],
  });
};

$(document).on("click", "#btn_PDFid", function () {
  let fila = $(this).closest("tr"),
    idCot = $(this).closest("tr").find("td:eq(0)").text(),
    creador = fila.find("td:eq(1)").text(),
    cliente = fila.find("td:eq(2)").text();
  console.log(idCot);
  console.log(creador);
  console.log(cliente);
  window.open(
    "../../../TCPDF/examples/reporteCotizacionID.php?idCotizacion=" +
      idCot +
      "&usuario=" +
      creador +
      "&nombreC=" +
      cliente,
    "_blank"
  );
});

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

$(document).on("click", "#btn_Pdf", function () {
  let estadoCliente = document.querySelector(".sorting_1").id;
  console.log("Estado del cliente:" + estadoCliente);
  let buscar = $("#table-Cotizacion_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reporteGeneralCotizacion.php?buscar=" + buscar,
    "_blank"
  );
});
