let $btnFiltrar = document.getElementById('btn-filtro');
let tablaVentas = null;
$btnFiltrar.addEventListener('click', function(){
    let $fechaDesde = document.getElementById('fecha-desde');
    let $fechaHasta = document.getElementById('fecha-hasta');
    enviarFechas($fechaDesde.value, $fechaHasta.value);
    // console.log('Desde: '+$fechaDesde.value+' Hasta: '+$fechaHasta.value);
});

let enviarFechas = function(fechaDesde, fechaHasta){
    let fechas = {
        fecha_Desde: fechaDesde,
        fecha_Hasta: fechaHasta
    }
    tablaVentas = $('#table-ventas').DataTable({
        "ajax": {
          "url": "../../../Vista/comisiones/obtenerVentasFiltradas.php",
          "dataSrc": ""
        },
        "language":{
          "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        },
        "columns": [
          { "data": "idventa"},
          { "data": "'fechaEmision" },
          { "data": "nombreCliente" },
          { "data": "subtotalVenta" },
          { "data": "totalDescuento" },
          { "data": "totalVenta" },
          { "data": "estadoVenta"},
          {"defaultContent":
              '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button></div>'
          }
        ]
      });
      $('#modalVentas').modal('show');

    // $.ajax({
    //     url: "../../../Vista/comisiones/obtenerVentasFiltradas.php",
    //     type: "POST",
    //     datatype: "JSON",
    //     data: fechas,
    //     success: function(data) {
    //         let objVentas = JSON.parse(data);

    //         // 'idventa' => $fila["id_Venta"],
    //         // 'fechaEmision' => $fila["fecha_Emision"],
    //         // 'nombreCliente'=> $fila["nombre_Cliente"],
    //         // 'totalDescuento'=> $fila["total_Descuento"],
    //         // 'subtotalVenta' => $fila["subtotal_Venta"],   
    //         // 'totalVenta' => $fila["total_Venta"],   
    //         // 'estadoVenta' => $fila["estado_Venta"]  
    //     }
    // });
}