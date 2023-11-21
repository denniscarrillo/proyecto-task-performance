/* import {estadoValidado as valido } from './validacionesEditarComision.js'; */
let $vendedores = '';
let tablaComision = "";
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
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
      { "data": "totalVenta",
       "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
      {
        "data": "porcentaje",
        "render": function (data, type, row) {
          if (type === 'display') {
            return (parseFloat(data) * 100).toFixed(0) + '%'; // Formatea el porcentaje
          }
          return data; // En otras ocasiones, devuelve el valor sin formato
        }
      },
      { "data": "comisionTotal", 
      "render": $.fn.dataTable.render.number(',', '.', 2, ' Lps. ') },
      { "data": "estadoComisionar" },
      { "data": "estadoLiquidacion" },
      { "data": 'fechaComision.date',
      "render": function(data) {
        return data.slice(0, 10); },
      },
      { "data": 'fechaLiquidacion.date',
      "render": function(data) {
        return data ? data.slice(0, 10) : ''; },
      },
      {
        "defaultContent":
          `<div>
          <button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>
          <button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>
          </div>`
        }
    ]
  });
}
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
    // estadoLiquidacion = fila.find("td:eq(6)").text(),
    fechaComision = fila.find("td:eq(6)").text();
    // fechaLiquidacion = fila.find("td:eq(8)").text(); // Agregar punto y coma aquí
  $("#idComision_E").val(idComision);
  $("#idVenta_E").val(idVenta);
  $("#monto_E").val(monto);
  $("#porcentaje-comision_E").val(porcentaje);
  $("#totalComsion_E").val(comisionTotal);
  $("#estadoComision_E").val(estadoComisionar);
  $("#estadoLiquidacion_E").val(estadoLiquidacion);
  $("#fecha_E").val(fechaComision);
  // $("#fecha_EV").val(fechaLiquidacion);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-title").css("color", "white");
  $("#modalEditarComision").modal("show");
});


//Envio de datos para editar
$("#form-Edit-Comision").submit(function (e) {
  e.preventDefault();
  let idComision = $("#idComision_E").val();
  // let estadoComision = document.getElementById("estadoComision_E").value;
  let estadoLiquidacion = document.getElementById("estadoLiquidacion_E").value;
  $.ajax({
    url: "../../../Vista/comisiones/EditarComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idComision: idComision,
      // estadoComision: estadoComision,
      estadoLiquidacion: estadoLiquidacion,
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
  const fechaLiquidacionLabel = document.getElementById('V_fechaLiquidacion');
  if(idComisionVer.FechaLiquidacion !== null){
    fechaLiquidacionLabel.innerText = idComisionVer.FechaLiquidacion.date.slice(0, 19).replace("T", " ");
  } else {
    fechaLiquidacionLabel.innerText = '';
  }
  const CreadoPorLabel = document.getElementById('V_CreadoPor');
  CreadoPorLabel.innerText = idComisionVer.CreadoPor;
  const fechaComisionLabel = document.getElementById('V_fechaCreacion');
  fechaComisionLabel.innerText = idComisionVer.FechaComision.date.slice(0, 19).replace("T", " ");
  const ModificadoPorLabel = document.getElementById('V_ModificadoPor');
  ModificadoPorLabel.innerText = idComisionVer.modificadoPor;
  if(idComisionVer.modificadoPor !== null){
    ModificadoPorLabel.innerText = idComisionVer.ModificadoPor;
  }else{
    ModificadoPorLabel.innerText = '';
  }
  const fechaModificacionLabel = document.getElementById('V_FechaModificado');
  if(idComisionVer.FechaModificacion !== null){
    fechaModificacionLabel.innerText = idComisionVer.fechaModificacion.date.slice(0, 19).replace("T", " ");
  } else {
    fechaModificacionLabel.innerText = '';
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
    
/* let obtenerEstadoComision = function (idElemento) {
  //Petición para obtener los estados de las comisiones
  $.ajax({
    url: "../../../Vista/comisiones/traerEstadoComision.php",
    type: "GET",
    dataType: "JSON",
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].idComision + '">' + data[i].estadoComisionar + '</option>';
        $(idElemento).html(valores);
      }
    },
  });
}; */

/* let obtenerComisionTotal = ($porcentaje, $totalVenta) => {
  $.ajax({
    url: "../../../Vista/comisiones/obtenerComisionTotal.php",
    type: "POST",
    datatype: "JSON",
    data: {
      porcentaje: $porcentaje,
      totalVenta: $totalVenta,
    },
    success: function (comisionTotal) {
      let objComisionTotal = JSON.parse(comisionTotal);
      document.getElementById("totalComsion_E").value =
        objComisionTotal[0].comision;
    },
  }); //Fin AJAX
}; */

/* let $selectPorcentaje = document.getElementById("porcentaje-comision_E");
$selectPorcentaje.addEventListener("change", function () {
  let $porcentaje = $selectPorcentaje.value;
  let $totalVenta = document.getElementById("monto_E").value;
  obtenerComisionTotal($porcentaje, $totalVenta);
}); */

/* let obtenerPorcentajes = function (idElemento) {
  //Petición para obtener porcentajes
  $.ajax({
    url: "../../../Vista/comisiones/obtenerPorcentaje.php",
    type: "GET",
    dataType: "JSON",
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion
      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].idPorcentaje + '">' + data[i].porcentaje + '</option>';
        $(idElemento).html(valores);
      }
    },
  });
}; */
/*   $('#btnFiltrar') .click(function(){
    tablaComision.destroy();
    var fechaDesdef = $('#fechaDesdef').val();
    var fechaHastaf = $('#fechaHastaf').val();
    tablaComision = $('#table-Comision').DataTable({
      "ajax": {
        "url": "../../../Vista/crud/comision/obtenerFiltroComisiones.php",
        "dataSrc": "",
        "data":{
          "fechaDesdef":fechaDesdef,
          "fechaHastaf":fechaHastaf
        },
      success: function(data){
        console.log(data);
      },
    },
  });
}); */

// 