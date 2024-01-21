/* import {estadoValidado as valido } from './validacionesEditarComision.js'; */
let $vendedores = '';
let tablaComision = "";
let permisos; // Variable para almacenar los permisos

$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});

// Inicialización de modales

// Recibe la respuesta de la petición AJAX y la procesa
let procesarPermisoActualizar = data => {
  permisos = JSON.parse(data);
  // console.log(permisos);
  tablaComision = $('#table-Comision').DataTable({
    "ajax": {
      "url": "../../../Vista/comisiones/obtenerComision.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idComision" },
      { "data": "factura" },
      { "data": "totalVenta", "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
      {
        "data": "porcentaje",
        "render": function (data, type, row) {
          if (type === 'display') {
            return (parseFloat(data) * 100).toFixed(0) + '%'; // Formatea el porcentaje
          }
          return data; // En otras ocasiones, devuelve el valor sin formato
        }
      },
      { "data": "comisionTotal", "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
      { "data": "estadoComisionar" },
      { "data": "estadoLiquidacion" },
      // { "data": "estadoCobro" },
      // { "data": "metodoPago" },
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
      // {
      //   "data": 'fechaCobro.date',
      //   "render": function (data) {
      //     return data ? data.slice(0, 19) : '';
      //   },
      // },
      {
        "defaultContent":
          `<div>
          <button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>
          <button class="btn-editar btns btn ${(permisos.Actualizar == 'N') ? 'hidden' : ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N') ? 'hidden' : ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>
          </div>`
      }
    ],
    // Evento para manejar clics en filas
    "rowCallback": function (row, data, index) {
      $(row).on("click", "#btn_editar", function () {
        // Obtener datos de la fila clicada y abrir modalEditarComision
        // ...
        $("#modalEditarComision").modal("show");
      });

      $(row).on("click", "#btn_ver", function () {
        // Obtener datos de la fila clicada y abrir modalVerComision
        // ...
        $("#modalVerComision").modal("show");
      });
      // Otros eventos o acciones que puedas necesitar
    }
  });
}

// Resto del código...

//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) { 
  $.ajax({
      url: "../../../Vista/crud/permiso/obtenerPermisos.php",
      type: "POST",
      datatype: "JSON",
      data: {idObjeto: $idObjeto},
      success: callback
    });
}
/* {"idComision":1,"factura":13,"totalVenta":-11360.61,"porcentaje":".04","comisionTotal":"6.99","estadoComisionar":"Activa","fechaComision":{"date":"2023-09-11 00:00:00.000000","timezone_type":3,"timezone":"Europe\/Berlin"}} */
//Editar Comision
$(document).on("click", "#btn_editar", function(){
  let fila = $(this).closest("tr"),
    idComision = fila.find('td:eq(0)').text(),
    idVenta = fila.find("td:eq(1)").text(),
    monto = fila.find("td:eq(2)").text(),
    porcentaje = fila.find("td:eq(3)").text(),
    comisionTotal = fila.find("td:eq(4)").text(),
    estadoComisionar = fila.find("td:eq(5)").text(),
    estadoLiquidacion = fila.find("td:eq(6)").text(),
    // estadoCobro = fila.find("td:eq(7)").text(),
    // metodoPago = fila.find("td:eq(8)").text(),
    fechaComision = fila.find("td:eq(9)").text(),
    fechaLiquidacion = fila.find("td:eq(10)").text();
    // fechaCobro = fila.find("td:eq(11)").text(); // Agregar punto y coma aquí

  $("#idComision_E").val(idComision);
  $("#idVenta_E").val(idVenta);
  $("#monto_E").val(monto);
  $("#porcentaje-comision_E").val(porcentaje);
  $("#totalComsion_E").val(comisionTotal);
  $("#estadoComision_E").val(estadoComisionar);
  $("#estadoLiquidacion_E").val(estadoLiquidacion);
  // $("#estadoCobro_E").val(estadoCobro);
  // $("#metodoPago_E").val(metodoPago);
  $("#fecha_E").val(fechaComision);
  $("#fecha_EV").val(fechaLiquidacion);
  // $("#fecha_EC").val(fechaCobro);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-title").css("color", "white");
  $("#modalEditarComision").modal("show");
});



//Envio de datos para editar
$("#form-Edit-Comision").submit(function (e) {
  e.preventDefault();
  let idComision = $("#idComision_E").val();
  // let estadoComision = document.getElementById("estadoComision_E").value;
  // let estadoCobro = document.getElementById("estadoCobro_E").value;
  let estadoLiquidacion = document.getElementById("estadoLiquidacion_E").value;
  // let metodoPago = document.getElementById("metodoPago_E").value;
  $.ajax({
    url: "../../../Vista/comisiones/EditarComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idComision: idComision,
      // estadoComision: estadoComision,
      // estadoCobro: estadoCobro,
      estadoLiquidacion: estadoLiquidacion,
      // metodoPago: metodoPago,
    },
    success: function (data) {
      console.log(data);
      Swal.fire(
        'Actualizado!',
        'La comisión ha sido modificado!',
        'success',
      )
      tablaComision.ajax.reload(null, false);
    },
  }); //Fin AJAX
      $("#modalEditarComision").modal("hide");
});
document.getElementById("btnCerrar").addEventListener("click", function () {
  let idComision = $("#idComision_E").val();
  console.log('idComision: '+idComision);
});

$(document).on("click", "#btn_ver", async function (){
  let fila = $(this).closest("tr");
  let idComision = fila.find('td:eq(0)').text();
  let idComisionVer = JSON.parse(await obtenerComisionId(idComision));
  console.log(idComisionVer);

  const idComisionLabel = document.getElementById('IdComision');
  idComisionLabel.innerText = idComisionVer.idComision;
  console.log(idComisionVer['idComision']);
  const idVentaLabel = document.getElementById('V_idFactura');
  idVentaLabel.innerText = idComisionVer.idFactura;
  const montoLabel = document.getElementById('V_Monto');
  montoLabel.innerText = 'Lps ' + parseFloat(idComisionVer.ventaTotal).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Formatear el monto
  const porcentajeLabel = document.getElementById('V_Porcentaje');
  const porcentajeDecimal = idComisionVer.valorPorcentaje; // Supongamos que porcentaje es un decimal

// Verificar si porcentajeDecimal es un número válido
if (!isNaN(porcentajeDecimal)) {
  // Convertir el porcentaje de decimal a entero
  const porcentajeEntero = Math.round(porcentajeDecimal * 100);
  // Mostrar el porcentaje con el símbolo de porcentaje
  porcentajeLabel.innerText = porcentajeEntero + '%';
}
  const comisionTotalLabel = document.getElementById('V_comisionTotal');
  comisionTotalLabel.innerText = 'Lps ' + parseFloat(idComisionVer.comisionT).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Formatear el monto
  const estadoComisionLabel = document.getElementById('V_Estado');
  estadoComisionLabel.innerText = idComisionVer.estadoComision;
  const estadoLiquidacionLabel = document.getElementById('V_EstadoLiquidar');
  estadoLiquidacionLabel.innerText = idComisionVer.estadoLiquidacion;
  // const estadoCobroLabel = document.getElementById('V_EstadoCobro');
  // estadoCobroLabel.innerText = idComisionVer.estadoCobro;
  // const metodoPagoLabel = document.getElementById('V_metodoPago');
  // metodoPagoLabel.innerText = idComisionVer.metodoPago;
  const fechaLiquidacionLabel = document.getElementById('V_fechaLiquidacion');
  if(idComisionVer.FechaLiquidacion !== null){
    fechaLiquidacionLabel.innerText = idComisionVer.FechaLiquidacion.date.slice(0, 19).replace("T", " ");
  } else {
    fechaLiquidacionLabel.innerText = 'Sin liquidar';
  }
  // const fechaCobroLabel = document.getElementById('V_fechaCobro');
  // if(idComisionVer.FechaCobro !== null){
  //   fechaCobroLabel.innerText = idComisionVer.FechaCobro.date.slice(0, 19).replace("T", " ");
  // } else {
  //   fechaCobroLabel.innerText = '';
  // }
  const CreadoPorLabel = document.getElementById('V_CreadoPor');
  CreadoPorLabel.innerText = idComisionVer.CreadoPor;
  const fechaComisionLabel = document.getElementById('V_fechaCreacion');
  fechaComisionLabel.innerText = idComisionVer.FechaComision.date.slice(0, 19).replace("T", " ");
  const ModificadoPorLabel = document.getElementById('V_ModificadoPor');
  ModificadoPorLabel.innerText = idComisionVer.ModificadoPor;
  if(idComisionVer.ModificadoPor !== null){
    ModificadoPorLabel.innerText = idComisionVer.ModificadoPor;
  }else{
    ModificadoPorLabel.innerText = 'Sin modificador';
  }
  const fechaModificacionLabel = document.getElementById('V_FechaModificado');
  if(idComisionVer.FechaModificacion !== null){
    fechaModificacionLabel.innerText = idComisionVer.FechaModificacion.date.slice(0, 19).replace("T", " ");
  } else {
    fechaModificacionLabel.innerText = 'Sin modificar';
  }
  let vendedores = idComisionVer.vendedores; // Supongamos que los datos de los vendedores están en un arreglo
  vendedores.forEach(vendedor => {
      $vendedores +=
      `<tr>
        <td>${vendedor.idVendedor}</td>
        <td>${vendedor.nombreVendedor}</td>
        <td>${'Lps ' + parseFloat(vendedor.comisionVendedor).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}</td>
      </tr>`;
  });
  document.getElementById('tbody-vendedores').innerHTML = $vendedores;
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");
  // Mostrar el modal
  $("#modalVerComision").modal("show");
});

let obtenerComisionId = async (idComision) => {
  try{
    let datosVerComision = await $.ajax({
      url: '../../../Vista/comisiones/obtenerIdComision.php',
      type: 'GET',
      datatype: 'JSON',
      data: {
        IdComision: idComision
      }
    });
    // console.log(datosComision);
    // if (datosComision && datosComision.idComision) {
    //   return datosComision; // Retornamos la data recibida por ajax
    // } else {
    //   console.error("Datos de comisión no válidos");
      return datosVerComision;
  } catch (err) {
    console.error(err);
  }
}
$(document).on("click", "#btn_pdf_id",  function (){
  let idComisionR = document.querySelector('#IdComision').innerText;

  //console.log("hola")
  window.open('../../../TCPDF/examples/reporteComisionId.php?idComision='+idComisionR, '_blank');
  //await reporteComisionId(idComisionR);  
 });



 //Eliminar Comision
 $(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let idComision = $(this).closest('tr').find('td:eq(0)').text();
      Swal.fire({
        title: 'Estas seguro de eliminar la comision N° '+idComision+'?',
        text: "No podras revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrala!'
      }).then((result) => {
        if (result.isConfirmed) {      
          $.ajax({
            url: "../../../Vista/comisiones/eliminarComision.php",
            type: "POST",
            datatype:"json",    
            data:  { idComision: idComision},    
            success: function(data) {
              let estadoEliminado = data[0].estadoEliminado;
               console.log(data);
              if(estadoEliminado == 'eliminado'){
                tablaComision.row(fila.parents('tr')).remove().draw();
                Swal.fire(
                  'Eliminada!',
                  'La Comision ha sido eliminada.',
                  'success'
                ) 
                tablaComision.ajax.reload(null, false); 
              } else {
                Swal.fire(
                  'Lo sentimos!',
                  'La Comision no puede ser eliminado, en su lugar ha sido anulada.',
                  'error'
                );
                tablaComision.ajax.reload(null, false);
              }           
            }
          }); //Fin del AJAX
        }
      });
    });

    $(document).on("click", "#btn_Pdf", function() {
      let buscar = $('#table-Comision_filter > label > input[type=search]').val();
      window.open('../../../TCPDF/examples/reporteriaComision.php?buscar='+buscar, '_blank');
    });
    
  //   let $btnFiltrar = document.getElementById("btn_filtroALiquidar");
  //   let $tablaComisionesLiquidadas = "";
  //   let $fechaDesde = document.getElementById('fechaDesdef');
  //   let $fechaHasta = document.getElementById('fechaHastaf');
    
  //   $btnFiltrar.addEventListener("click", function(){
  //     // Obtener las fechas desde el modal
  // const fechaDesdeT = $fechaDesde.value;
  // const fechaHastaT = $fechaHasta.value;

  // if(new Date($fechaDesde.value) > new Date($fechaHasta.value))
  // {
  //   Swal.fire({
  //     icon: 'error',
  //     title: 'Error al filtrar comisiones',
  //     text: 'La fecha desde no puede ser mayor a la fecha hasta.',
  //   });
  //   return;
  // }


  // // Asumiendo que tengas un elemento con el id "fechasLabel" para mostrar las fechas
  // $("#fechasLabel").text('Desde el: ' + fechaDesdeT + ' Hasta el: ' + fechaHastaT);
  //     iniciarDataTable($fechaDesde.value, $fechaHasta.value);
  //   });
    
    let iniciarDataTable = function (fechaDesde, fechaHasta) {
      $tablaComisionesLiquidadas = $("#table-comisiones_ALiquidar").DataTable({
        ajax: {
          url: "../../../Vista/comisiones/Obteniendocomisiones_A_Liquidar.php",
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
          { data: "idComision" },
          { data: "idVenta" },
          { data: "comisionTotal", "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
          { data: "estadoComision" },
          { data: "estadoCobro" },
          { defaultContent: `<div>
          <button class="btns btn" id="btn_liquidar"><i class="fa-solid fa-clipboard-check"></i></button>
          </div>` }
        ]
      });
      $("#modalComisiones_Liquidar").modal("show");
    };

    // Agrega un evento click para los botones con el id "btn_liquidar"
$('#table-comisiones_ALiquidar').on('click', '#btn_liquidar', function () {
  // Obtén la fila de la tabla
  var data = $tablaComisionesLiquidadas.row($(this).parents('tr')).data();

  // Acciones que deseas realizar al liquidar la comisión
  var idComision = data.idComision;

  // Realiza la llamada AJAX para liquidar la comisión
  $.ajax({
    type: "POST",
    url: "../../../Vista/comisiones/LiquidandoComisiones.php",  // Reemplaza con la ruta correcta
    data: { idComision: idComision },
    success: function(response) {
      console.log("Comisión liquidada con éxito");
      Swal.fire(
        'Liquidada!',
        'La comisión ha sido liquidada!',
        'success',
      )
      tablaComision.ajax.reload(null, false);
      // Puedes realizar acciones adicionales aquí, como actualizar la tabla
    },
    error: function(error) {
      console.error("Error al liquidar la comisión", error);
    }
  });
});
    
    let obtenerComisionesFiltradas = function (fechaDesde, fechaHasta) {
      console.log("Fecha desde: " + fechaDesde);
      console.log("Fecha hasta: " + fechaHasta);
      $.ajax({
        type: "POST",
        url: "../../../Vista/comisiones/ObteniendoComisiones_A_Liquidar.php",
        data: {
          fecha_Desde: fechaDesde,
          fecha_Hasta: fechaHasta,
        },
        success: function (data) {
          console.log(data);
        },
      });
    }
