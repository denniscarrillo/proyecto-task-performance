let $btnFiltrar = document.getElementById("btn-filtro");
let $btnCerrarModalVentas = document.getElementById("btn-close-modal-ventas");
let $tablaVentas = "";

$(document).ready(function () {
  let now = new Date().toISOString().split("T")[0];
  document.getElementById("fecha-comision").setAttribute("value", now);
  document.getElementById("fecha-comision").setAttribute("disabled", "true");
  document.getElementById("id-venta").setAttribute("disabled", "true");
  document.getElementById("monto-total").setAttribute("disabled", "true");
  document.getElementById("comision-total").setAttribute("disabled", "true");
});
$btnFiltrar.addEventListener("click", function () {
  let $fechaDesde = document.getElementById("fecha-desde");
  let $fechaHasta = document.getElementById("fecha-hasta");
  iniciarDataTable($fechaDesde.value, $fechaHasta.value);
  $btnCerrarModalVentas.addEventListener("click", function () {
    $tablaVentas.rows().remove().draw();
  });
});
//Iniciar dataTable y carga las ventas filtradas segun el rango de fechas
let iniciarDataTable = function (fechaDesde, fechaHasta) {
  if (document.querySelector(".dataTables_info") !== null) {
    $tablaVentas.destroy();
  }
  //DataTable
  $tablaVentas = $("#table-ventas").DataTable({
    ajax: {
      url: "../../../Vista/comisiones/obtenerVentasFiltradas.php",
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
      { data: "numFactura" },
      { data: "fechaEmision" },
      { data: "codCliente" },
      { data: "nombreCliente" },
      { data: "rtnCliente" },
      { data: "totalBruto" },
      { data: "totalImpuesto" },
      { data: "totalVenta" },
      {
        defaultContent:
          '<button class="btns btn" id="btn_seleccionar"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>',
      },
    ],
  });
  $("#modalfiltroVenta").modal("hide");
  $("#modalVentas").modal("show");
};
$(document).on("click", "#btn_seleccionar", function () {
  let fila = $(this).closest("tr");
  let idVenta = fila.find("td:eq(0)").text(); //captura el ID DE LA FACTURA
  let rtnClienteVenta = fila.find("td:eq(4)").text();
  let montoVenta = fila.find("td:eq(7)").text(); //captura el MONTO TOTAL DE LA FACTURA
  document.getElementById("id-venta").value = idVenta;
  document.getElementById("monto-total").value = montoVenta;
  estadoClienteTarea(rtnClienteVenta);
  mostrarVendedores(idVenta);
  /* console.log(montoVenta); */
  $("#modalVentas").modal("hide");
});

let estadoClienteTarea = (rtnCliente) => {
  $.ajax({
    url: "../../../Vista/comisiones/obtenerEstadoClienteTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      rtnCliente: rtnCliente,
    },
    success: function (estadoCliente) {
      let objEstadoCliente = JSON.parse(estadoCliente);
      document.getElementById("mensaje-tipo-cliente").innerText =
        "Estado cliente: " + objEstadoCliente[0].clienteExistente;
      document
        .getElementById("mensaje-tipo-cliente")
        .classList.add("mensaje-tipo-cliente");
    },
  }); //Fin AJAX
};

let mostrarVendedores = ($idFacturaVenta) => {
  $.ajax({
    url: "../../../Vista/comisiones/obtenerVendedores.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idFacturaVenta: $idFacturaVenta
    },
    success: function (vendedores) {
      let objVendedores = JSON.parse(vendedores);
      let $selectVendedores = document.getElementById("conteiner-vendedores");
      let $vendedores = "";
      objVendedores.forEach((vendedor) => {
        $vendedores += `<p  class= "vendedores" value="${vendedor.idVendedor}">${vendedor.nombreVendedor}</p>`;
      });
      $selectVendedores.innerHTML = $vendedores;
    },
  }); //Fin AJAX
};

let obtenerComisionTotal = ($porcentaje, $totalVenta) => {
  $.ajax({
    url: "../../../Vista/comisiones/obtenerComisionTotal.php",
    type: "POST",
    datatype: "JSON",
    data: {
      porcentaje: $porcentaje,
      totalVenta: $totalVenta
    },
    success: function (comisionTotal) {
      let objComisionTotal = JSON.parse(comisionTotal);
      document.getElementById("comision-total").value = objComisionTotal[0].comision;
    },
  }); //Fin AJAX
};

let $selectPorcentaje = document.getElementById("porcentaje-comision");
$selectPorcentaje.addEventListener("change", function () {
 
  let $porcentaje = $selectPorcentaje.value;
  let $totalVenta = document.getElementById("monto-total").value;
  obtenerComisionTotal($porcentaje, $totalVenta);
});

$('#form-Comision').submit(function () { //evita el comportambiento normal del submit, es decir, recarga total de la página
  let fechaComision = document.getElementById('fecha-comision').value;
  let idVenta = document.getElementById('id-venta').value;
  let montoTotal = document.getElementById('monto-total').value;
  let porcentaje = document.getElementById('porcentaje-comision').value;
  let comisionTotal = document.getElementById('comision-total').value;
  
  $.ajax({
    url: "../../../Vista/comisiones/insertarNuevaComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      fechaComision: fechaComision,
      idVenta: idVenta,
      montoTotal: montoTotal,
      idPorcentaje: porcentaje,
      comisionTotal: comisionTotal
    },
    success: function () {
      Swal.fire(
        'Registrado!',
        'Se ha registrado la comision!',
        'success',
      )
    }
});
});
/* let $btnGuardarComision = document.getElementById('btn-guardar-comision');
  $btnGuardarComision.addEventListener('click', function(){
  let $idVenta = document.getElementById('monto-total').value;
   let $idVendedor = document.getElementById('conteiner-vendedores').value; 
  let $porcentaje = document.getElementById('porcentaje-comision').value;
  let $comision = document.getElementById('comision-total').value;
  let $fechaComision = document.getElementById('fecha-comision').value;
  guardarComision($idVenta, $porcentaje, $comision, $fechaComision);
}
); */

//crear comision
/*let guardarComision = ($idVenta, $idVendedor, $porcentaje, $comision, $fechaComision) => {
  $.ajax({

url: "../../../Vista/comisiones/guardarComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idVenta: $idVenta,
      idVendedor: $idVendedor,
      porcentaje: $porcentaje,
      comision: $comision,
      fechaComision: $fechaComision
    },
    success: function () {
      Swal.fire(
        'Registrado!',
        'Se ha registrado la comision!',
        'success',
      )
    },
  }); //Fin AJAX
 */
