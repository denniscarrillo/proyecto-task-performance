let $btnFiltrar = document.getElementById('btn-filtro');
let $btnCerrarModalVentas = document.getElementById('btn-close-modal-ventas');
let $tablaVentas = '';
$btnFiltrar.addEventListener('click', function () {
  let $fechaDesde = document.getElementById('fecha-desde');
  let $fechaHasta = document.getElementById('fecha-hasta');
  iniciarDataTable($fechaDesde.value, $fechaHasta.value);
  $btnCerrarModalVentas.addEventListener('click', function () {
    $tablaVentas.rows().remove().draw();
  });
});
//Iniciar dataTable y carga las ventas filtradas segun el rango de fechas
let iniciarDataTable = function (fechaDesde, fechaHasta) {
  if (document.querySelector('.dataTables_info') !== null) {
    $tablaVentas.destroy();
  }
  //DataTable
  $tablaVentas = $('#table-ventas').DataTable({
    ajax: {
      url: "../../../Vista/comisiones/obtenerVentasFiltradas.php",
      type: "POST",
      datatype: "JSON",
      data: {
        fecha_Desde: fechaDesde,
        fecha_Hasta: fechaHasta
      },
      dataSrc: ""
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    // data: objVentas,
    columns: [
      { data: 'idventa' },
      { data: 'fechaEmision' },
      { data: 'nombreCliente' },
      { data: 'subTotalVenta' },
      { data: 'totalDescuento' },
      { data: 'totalVenta' },
      { data: 'estadoVenta' },
      {
        defaultContent:
          '<button class="btns btn" id="btn_seleccionar"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
      }
    ]
  });
  $('#modalfiltroVenta').modal('hide');
  $('#modalVentas').modal('show');

  $(document).on("click", "#btn_seleccionar", function() {
    let fila = $(this).closest("tr");
    let idVenta = fila.find('td:eq(0)').text()//capturo el ID	
    document.getElementById('id-venta').value = idVenta;
    console.log(idVenta);
    $('#modalVentas').modal('hide');
  });

  
  // let $btnID = document.getElementById('btn_seleccionar');
  // obtenerIdVenta($btnID);
}

// let obtenerIdVenta = function () {
//   $('#btn_seleccionar').click(function () {
//     let fila = $(this).closest("tr");
//     let idVenta = fila.find('td:eq(0)').text()//capturo el ID	
//     document.getElementById('id-venta').value = idVenta;
//     console.log(idVenta);
//     $('#modalVentas').modal('hide');
//   });
// }
