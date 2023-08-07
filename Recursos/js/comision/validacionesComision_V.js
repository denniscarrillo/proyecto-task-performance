let $btnFiltrar = document.getElementById("btn-filtroV");
/* let $btnComisiones = document.getElementById("modalComisionesV"); */
let $btnCerrarModalComisiones = document.getElementById("btn-close-modal-comisiones");
let $tablaComisionesV = "";

$(document).ready(function () {
  let now = new Date().toISOString().split("T")[0];
  document.getElementById("fecha-comisionV").setAttribute("value", now);
  document.getElementById("fecha-comisionV").setAttribute("disabled", "true");
  document.getElementById("id-comisionV").setAttribute("disabled", "true");
});
$btnFiltrar.addEventListener("click", function () {
  let $fechaDesde = document.getElementById("fecha-desdeV");
  let $fechaHasta = document.getElementById("fecha-hastaV");
  iniciarDataTable($fechaDesde.value, $fechaHasta.value);
  $btnCerrarModalComisiones.addEventListener("click", function () { 
     $tablaComisionesV.rows().remove().draw();
  });
});
//Iniciar dataTable y carga las ventas filtradas segun el rango de fechas
let iniciarDataTable = function (fechaDesde, fechaHasta) {
  if (document.querySelector(".dataTables_info") !== null) {
    $tablaComisionesV.destroy();
  }
  //DataTable
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
      { data: "fechaComision" },
      { data: "totalComision" },
      {
        defaultContent:
          '<button class="btns btn" id="btn_seleccionar"><i class="fas fa-file-pdf"></i></button>',
      },
    ],
  });
  $("#modalfiltroComisiones").modal("hide");
  $("#modalComisionesV").modal("show");
};
/* $(document).on("click", "#btn_seleccionar", function () {
  let fila = $(this).closest("tr");
  let idVendedor = fila.find("td:eq(0)").text(); //captura el ID DE LA FACTURA
  let nombreVendedor= fila.find("td:eq(4)").text();
  let totalComision = fila.find("td:eq(2)").text(); //captura el MONTO TOTAL DE LA FACTURA
  let fechaComision = fila.find("td:eq(7)").text(); //captura el MONTO TOTAL DE LA FACTURA
  document.getElementById("id-venta").value = idVendedor;
  document.getElementById("monto-total").value = montoVenta;
  estadoClienteTarea(rtnClienteVenta);
  mostrarVendedores(idVenta);
   console.log(montoVenta); 
  $("#modalVentas").modal("hide");
}); */