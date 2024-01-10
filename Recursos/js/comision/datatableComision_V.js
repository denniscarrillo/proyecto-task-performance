// Inicializar tabla de comisiones de vendedores
let tablaComisionVendedor = '';
let $tablaComisionesV = "";

$(document).ready(function () {
  tablaComisionVendedor = $('#table-ComisionVendedor').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/ComisionesVendedores/obtenerComisiones_V.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'idComisionVendedor' },
      { "data": 'idComision' },
      { "data": 'idVendedor' },
      { "data": 'usuario' },
      { "data": 'comisionTotal', "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
      { "data": 'estadoComision' },
      { "data": 'estadoLiquidacion' },
      { "data": 'estadoCobro' },
      { "data": 'metodoPago' },
      {
        "data": 'fechaComision.date',
        "render": function (data) {
          return data.slice(0, 19);
        },
      },
      {
        "data": 'fechaLiquidacion.date',
        "render": function (data) {
          return data ? data.slice(0, 19) : '';
        },
      },
      {
        "data": 'fechaCobro.date',
        "render": function (data) {
          return data ? data.slice(0, 19) : '';
        },
      },
    ]
  });

  // Elementos y eventos relacionados con el botón "Filtrar"
  let $btnFiltrar = document.getElementById("btnFiltrar");

  $btnFiltrar.addEventListener("click", function () {
    let $fechaDesde = document.getElementById("fechaDesdef");
    let $fechaHasta = document.getElementById("fechaHastaf");

    if (new Date($fechaDesde.value) > new Date($fechaHasta.value)) {
      Swal.fire({
        icon: 'error',
        title: 'Error en las fechas',
        text: 'La fecha desde no puede ser mayor a la fecha hasta',
      });
      return;
    }
    iniciarDataTable($fechaDesde.value, $fechaHasta.value);
  });

  // Agregar manejador de clic para el botón "Generar PDF"
  $("#btn_PdfComisiones").on("click", function () {
    obtenerComisionesFiltradas($fechaDesde.value, $fechaHasta.value);
  });

  // Función para iniciar la tabla de comisiones filtradas
  function iniciarDataTable(fechaDesde, fechaHasta) {
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
        { data: "totalComision", "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
        {
          defaultContent: `<div>
            <button class="btns btn" id="btn_liquidar"><i class="fa-solid fa-clipboard-check"></i></button>
          </div>`
        }
      ],
      initcomplete: function () {
        // Asumiendo que tengas un elemento con el id "fechasLabel" para mostrar las fechas
        $("#fechasLabel").text('Desde el: ' + fechaDesde + ' Hasta el: ' + fechaHasta);
      }
    });

    // Manejar clic en el botón "Liquidar"
    $('#table-comisionesVendedor').on("click", "#btn_liquidar", function () {
      // Asegúrate de que haya al menos una fila seleccionada en la tabla
      if ($tablaComisionesV.rows({ selected: true }).any()) {
        // Obtén las fechas directamente de los datos de la fila seleccionada
        let fechaDesdeL = $tablaComisionesV.row({ selected: true }).data().fechaDesde; // Ajusta esto según la estructura de tus datos
        let fechaHastaL = $tablaComisionesV.row({ selected: true }).data().fechaHasta; // Ajusta esto según la estructura de tus datos
    
        // Obtén las filas seleccionadas de la tabla
        let filasSeleccionadas = $tablaComisionesV.rows({ selected: true }).data();
    
        // Obtén los ID de los vendedores seleccionados
        let idVendedores = filasSeleccionadas.map(fila => fila.idVendedor);
    
        // Envía los ID de los vendedores y las fechas al servidor para liquidar sus comisiones
        $.ajax({
          url: "../../../Vista/crud/ComisionesVendedores/liquidandoComisionesPorVendedor.php",
          type: "POST",
          dataType: "JSON",
          data: {
            idVendedores: idVendedores,
            fechaDesde: fechaDesdeL,
            fechaHasta: fechaHastaL
          },
          success: function (response) {
            console.log(response);
            if (response.success) {
              console.log(response.message);
              // Actualiza la tabla con los datos actualizados
              // $tablaComisionesV.clear().rows.add(response.datosActualizados).draw();
              // Maneja la respuesta del servidor (muestra la alerta)
              Swal.fire({
                icon: 'success',
                title: 'Comisiones liquidadas correctamente',
                showConfirmButton: true,
                timer: 3000
              });
            } else {
              console.error(response.message);
              // Muestra un mensaje de error indicando que no se pudieron liquidar las comisiones
              Swal.fire({
                icon: 'error',
                title: 'Error al liquidar comisiones',
                text: response.message,
              });
            }
          },
          error: function (error) {
            // Maneja cualquier error que pueda ocurrir durante la solicitud AJAX
            console.log(error);
    
            // Muestra un mensaje de error genérico
            Swal.fire({
              icon: 'error',
              title: 'Error al liquidar comisiones',
              text: 'Se produjo un error al intentar liquidar las comisiones.',
            });
          }
        });
      } else {
        // Muestra un mensaje indicando que no se ha seleccionado ninguna fila
        Swal.fire({
          icon: 'warning',
          title: 'Seleccione al menos una fila para liquidar sus comisiones',
          showConfirmButton: true,
          timer: 3000
        });
      }
    });

    $("#modalComisionesV").modal("show");
  }

  // Función para obtener comisiones filtradas
  function obtenerComisionesFiltradas(fechaDesde, fechaHasta) {
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
  }

  // Manejar clic en el botón "Generar PDF"
  $(document).on("click", "#btn_Pdf", function () {
    let buscar = $('#table-ComisionVendedor_filter > label > input[type=search]').val();
    window.open('../../../TCPDF/examples/reporteriaComisionVendedores.php?buscar=' + buscar, '_blank');
  });
});
