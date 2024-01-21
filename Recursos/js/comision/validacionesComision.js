let $btnFiltrar = document.getElementById("btn-filtro");
let $btnCerrarModalVentas = document.getElementById("btn-close-modal-ventas");
let $tablaVentas = "";

$(document).ready(function () {
  //necesito que me muestre la hora en zona horaria de Honduras solo la fecha nada mas en el input de fecha
  let now = new Date().toLocaleString("en-US", {
    timeZone: "America/Tegucigalpa",
    hour12: true,
    dateStyle: "short",
  });
  //Que muetre la fecha actual en el input de fecha
  document.getElementById("fecha-comision").value = now;
  document.getElementById("fecha-comision").setAttribute("disabled", "true");
  document.getElementById("id-venta").setAttribute("disabled", "true");
  // document.getElementById("fecha_V").value = now;
  // document.getElementById("fecha_V").setAttribute("disabled", "true");
  document.getElementById("monto-total").setAttribute("disabled", "true");
  document.getElementById("comision-total").setAttribute("disabled", "true");
});

  $btnFiltrar.addEventListener("click", function () {
    let $fechaDesde = document.getElementById("fecha-desde");
    let $fechaHasta = document.getElementById("fecha-hasta");
  
    // Verificar si la fecha de inicio es mayor que la fecha final
    if (new Date($fechaDesde.value) > new Date($fechaHasta.value)) {
      // Muestra un mensaje de error o realiza la acción que consideres adecuada
      Swal.fire(
        'Error!',
        '¡La fecha de inicio no puede ser mayor que la fecha final!',
        'error',
      );
      return;
    }
  
    // Si las fechas son válidas, llama a la función para iniciar el DataTable
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
      { data: "nombreCliente" },
      { data: "rtnCliente" },
      { data: "totalVenta" },
      { data: "creadoPor" },
      { data: "fechaCreacion"
      },
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
  let rtnClienteVenta = fila.find("td:eq(2)").text();
  let montoVenta = fila.find("td:eq(3)").text(); //captura el MONTO TOTAL DE LA FACTURA
   
  document.getElementById("id-venta").value = idVenta;
  document.getElementById("monto-total").value = montoVenta;
  estadoClienteTarea(rtnClienteVenta);
  mostrarVendedores(idVenta); 
  obtenerEstadoComision(idVenta);
  
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

$('#form-Comision').submit(function (e) {
  e.preventDefault();

  // Validar campos antes de proceder con el guardado
  if (!validarCampos()) {
    // Mostrar un mensaje de error o realizar la acción que consideres adecuada
    Swal.fire(
      'Error!',
      '¡Por favor, completa todos los campos!',
      'error',
    );
    return;
  }

  if (document.getElementById("mensaje").classList.contains("mensaje-estado")) {
    Swal.fire(
      'Error!',
      '¡Factura ya comisionada!',
      'error',
    )
  } else {
    // Verificar si el cliente es elegible para la comisión
    if (document.getElementById("mensaje-tipo-cliente").innerText.includes("No Aplica Comision")) {
      Swal.fire(
        'Error!',
        '¡El cliente no aplica para comisión!',
        'error',
      )
    } else {
      guardarNuevaComision();
      // window.location.href = "../../../Vista/comisiones/v_Comision.php";
    }
  }
});


let guardarNuevaComision = function () {
  // let fechaComision = document.getElementById('fecha-comision').value;
  let idVenta = document.getElementById('id-venta').value;
  let montoTotal = document.getElementById('monto-total').value;
  let porcentaje = document.getElementById('porcentaje-comision').value;
  let comisionTotal = document.getElementById('comision-total').value;

  // // Obtener la cantidad de días de vigencia desde la función obtenerLiquidacion
  // let vigencia = obtenerLiquidacion();

  // // Convertir la fecha de texto a un objeto Date
  // let fechaV = new Date(fechaComision);

  // // Sumar la cantidad de días de vigencia a la fecha
  // fechaV.setDate(fechaV.getDate() + parseInt(vigencia['liquidacion']));

  // // Actualizar el valor del campo fecha_V con la nueva fecha
  // $("#fecha_V").val(fechaV.toISOString().slice(0, 10));
  // let fechaLiqui = fechaV.getTime();

  // Continuar con el resto de tu código...
  $.ajax({
    url: "../../../Vista/comisiones/insertarNuevaComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      // fechaComision: fechaComision,
      idVenta: idVenta,
      montoTotal: montoTotal,
      idPorcentaje: porcentaje,
      comisionTotal: comisionTotal
      // fechaV: fechaLiqui
    },
    success: function () {
      Swal.fire(
        'Registrado!',
        'Se ha registrado la comision!',
        'success',
      ).then((result) => {
        // Redirigir solo si se hizo clic en "Aceptar" en el mensaje de Swal
        if (result.isConfirmed || result.isDismissed) {
          window.location.href = "../../../Vista/comisiones/v_Comision.php";
        }
      });
    }
  });
}
// }

let obtenerEstadoComision = ($idVenta) => {
  $.ajax({
    url: "../../../Vista/comisiones/obtenerEstadoComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idVenta: $idVenta
    },
    success: function (idVenta) {
      let $mensajeEstado = document.getElementById("mensaje");
      let $objEstadoVenta = JSON.parse(idVenta);

      // Condición para verificar si la comisión ya está registrada
      if ($objEstadoVenta.estado == 'true') {
        $mensajeEstado.innerText = 'Factura ya comisionada';
        $mensajeEstado.classList.add('mensaje-estado');

        // Deshabilitar campos cuando la comisión ya está registrada
        document.getElementById("monto-total").disabled = true;
        document.getElementById("porcentaje-comision").disabled = true;
        document.getElementById("comision-total").disabled = true;
      } else {
        $mensajeEstado.innerText = '';
        $mensajeEstado.classList.remove('mensaje-estado');

        // Habilitar campos si la comisión no está registrada
        document.getElementById("monto-total").disabled = false;
        document.getElementById("porcentaje-comision").disabled = false;
        document.getElementById("comision-total").disabled = false;
      }
    }
  });
}
let $btnCancelar = document.getElementById("btn-cancelar");

$btnCancelar.addEventListener("click", function () {
  // Redirige a la pantalla principal de comisiones
  window.location.href = "../../../Vista/comisiones/v_Comision.php";
});
function validarCampos() {
  // Agrega aquí la lógica de validación para cada campo
  let idVenta = document.getElementById('id-venta').value;
  let montoTotal = document.getElementById('monto-total').value;
  let porcentaje = document.getElementById('porcentaje-comision').value;
  let comisionTotal = document.getElementById('comision-total').value;

  // Verifica si algún campo está vacío
  if (idVenta === '' || montoTotal === '' || porcentaje === '' || comisionTotal === '') {
    return false;
  }

  // Agrega más condiciones de validación si es necesario

  return true;
}

 let obtenerLiquidacion = async () =>{
  try {
    let dato = await $.ajax({
      url: '../../../Vista/comisiones/obtenerfechaLiquidacion.php',
      type: 'GET',
      dataType: 'JSON'
    });
    return dato;
  } catch(err) {
    console.error(err)
}
}//Fin AJAX
