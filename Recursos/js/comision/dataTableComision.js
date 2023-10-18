/* import {estadoValidado as valido } from './validacionesEditarComision.js'; */

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
      { "data": "totalVenta" },
      {
        "data": "porcentaje",
        "render": function (data, type, row) {
          if (type === 'display') {
            return (parseFloat(data) * 100).toFixed(0) + '%'; // Formatea el porcentaje
          }
          return data; // En otras ocasiones, devuelve el valor sin formato
        }
      },
      { "data": "comisionTotal" },
      { "data": "estadoComisionar" },
      { "data": "fechaComision.date" },
      {
        "defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fas fa-file-pdf"></i></button>' +
          `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`
      }
    ]
  });
}
// Configurar Child Rows para mostrar vendedores
$('#table-Comision').on('click', 'td.details-control', function () {
  var tr = $(this).closest('tr');
  var row = tablaComision.row(tr);

  if (row.child.isShown()) {
    // Esta fila ya se ha expandido, por lo que la ocultamos
    row.child.hide();
    tr.removeClass('shown');
  } else {
    // Expandir esta fila para mostrar los vendedores
    var vendedoresHTML = '<p>Aquí puedes listar los vendedores relacionados a esta comisión.</p>';
    row.child(vendedoresHTML).show();
    tr.addClass('shown');
  }
});
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
    idComision = $(this).closest('tr').find('td:eq(0)').text(),
    idVenta = fila.find("td:eq(1)").text(),
    monto = fila.find("td:eq(2)").text(),
    porcentaje = fila.find("td:eq(3)").text(),
    comisionTotal = fila.find("td:eq(4)").text(),
    estadoComisionar = fila.find("td:eq(5)").text(),
    fechaComision = fila.find("td:eq(6)").text();
  $("#idComision_E").val(idComision);
  $("#idVenta_E").val(idVenta);
  $("#monto_E").val(monto);
  $("#porcentaje-comision_E").val(porcentaje);
  $("#totalComsion_E").val(comisionTotal);
  /* $("#estadoComision_E").val(estadoComisionar); */
  $("#fecha_E").val(fechaComision);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-title").css("color", "white");
  $("#modalEditarComision").modal("show");
});

//Envio de datos para editar
$("#form-Edit-Comision").submit(function (e) {
  e.preventDefault();
  let idComision = $("#idComision_E").val();
  let estadoComision = document.getElementById("estadoComision_E").value;
  $.ajax({
    url: "../../../Vista/comisiones/EditarComision.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idComision: idComision,
      estadoComision: estadoComision
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
  let estadoComision = document.getElementById("estadoComision_E").value;
  console.log('idComision: '+idComision+' estadoComision: '+estadoComision);
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
