  //Grafica general Llamadas
const $grafica_llamada = document.querySelector("#grafica_llamada");
const etiquetas_llamada = ["Llamadas", "Meta"]
const color_Llamada = ['rgba(133, 52, 0 )', 'rgb(82, 82, 82 )']
  //Grafica general Lead
const $grafica_lead = document.querySelector("#grafica_lead");
const etiquetas_lead = ["Leads", "Meta"]
const color_Lead = ['rgba( 202, 117, 24)', 'rgb(82, 82, 82 )']

  //Grafica general Cotizaciones
const $grafica_Cotizacion = document.querySelector("#grafica_Cotizacion");
const etiquetas_Cotizacion = ["Cotizacion", "Meta"]
const color_Cotizacion =['rgba(255, 152, 0)','rgb(82, 82, 82 )']

  //Grafica general Ventas
const $grafica_Venta = document.querySelector("#grafica_Ventas");
const etiquetas_Venta = ["Ventas", "Meta"]
const color_Venta = ['rgba(255, 212, 120)','rgb(82, 82, 82 )']

let $tablaVendedores = "";

let idUsuario_Vendedor = "";
/// funcion habilita el boton seleccionar vendedores
let rdVendedores = document.getElementById("RadioPorVendedor");
let btnSelecVendedores = document.getElementById("btnVendedores");
rdVendedores.addEventListener("change", function(){
    if (rdVendedores.checked ) {
        // Habilitar el botón seleccionar vendedores
        btnSelecVendedores.removeAttribute("disabled");
      } else {
          btnSelecVendedores.setAttribute("disabled", "true");
      }    
});

/// funcion que deshabilita el boton seleccionar vendedores
let rdGeneral = document.getElementById("RadioGeneral");
rdGeneral.addEventListener("change", function () {
    if (rdGeneral.checked) {
      // Si se deselecciona el radio rdGeneral, deshabilita el botón
      btnSelecVendedores.setAttribute("disabled", "true");
    }
});


  ////////////Boton Seleccionar
// $(document).on("click", "#btn_seleccionar", function () {
//     let fila = $(this).closest("tr");
//     document.getElementById("idUsuario_Vendedor").value = idUsuario_Vendedor;
//     idUsuario_Vendedor(idUsuario_Vendedor);
   
// });

///////////////Boton Filtrar
// let btnFiltrar = document.getElementById('btnFiltrar')
//     btnFiltrar.addEventListener('click', function(){
//     let idUsuario_Vendedor = 2;
//     let fechadesde = document.getElementById('fechaDesdef').value;
//     let fechahasta = document.getElementById('fechaHastaf').value;

//     // if (fechadesde && fechahasta === "") {
//     //     alert('Por favor, complete el campo de fecha antes de enviar el formulario.');
//     //     return false; // Evitar que el formulario se envíe si la fecha está vacía
//     // }
//     obtenerDatosGrafica(fechadesde, fechahasta);
//     obtenerMetaMetricas();
//     obtenerTareaVendedor(idUsuario_Vendedor, fechadesde, fechahasta);
// });

///////////////Boton Filtrar
$(document).ready(function () {
    $('#btnFiltrar').click(function () {
        const fechadesde = $('#fechaDesdef').val();
        const fechahasta = $('#fechaHastaf').val();

        // Verificar si la fecha se ha llenado
        if (fechadesde === "" && fechahasta === "" ) {
            alert('LLenar campos de fecha.');
        } else {
            // let btnFiltrar = document.getElementById('btnFiltrar')
            // btnFiltrar.addEventListener('click', function(){
            // let idUsuario_Vendedor = ;
            console.log(idUsuario_Vendedor);
            let fechadesde = document.getElementById('fechaDesdef').value;
            let fechahasta = document.getElementById('fechaHastaf').value;
            obtenerDatosGrafica(fechadesde, fechahasta);
            obtenerMetaMetricas();
            obtenerTareaVendedor(idUsuario_Vendedor, fechadesde, fechahasta);
        // });

        }
    });
});


// Obtener datos Genrales para las 4 graficas de cada tarea
let obtenerDatosGrafica = function(fechaDesde, fechaHasta){
    $.ajax({
        url: "../../../Vista/grafica/obtenerCantTareas.php",
        type: "POST",
        datatype: "JSON",
        data: {
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        },
        success: function (resp) {
            
            datosGrafica = JSON.parse(resp);   
            generarGraficas(datosGrafica);
            console.log(datosGrafica);
        }
    });
}

//funcion que genera los datos por tarea
let generarGraficas = function(data) {
    ///////////////////////////////////////////////////GRAFICA GENERAL LLAMADA//////////////////////////////////////////////////// 
    const datosIngresos_llamada = {
        data: [data.TotalLlamadas, data.metaGeneralLlamada], 
        backgroundColor: color_Llamada,
    };
    new Chart($grafica_llamada, {
        type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
        data: {
            labels: etiquetas_llamada,
            datasets: [
                datosIngresos_llamada
            ]
        }
    });
    ////////////////////////////////////////////////////GRAFICA GENERAL LEAD////////////////////////////////////////////////////
    const datosIngresos_lead = {
        data: [data.TotalLead, data.metaGeneralLead], 
        backgroundColor: color_Lead,
    }
    new Chart($grafica_lead, {
        type: 'doughnut',
        data: {
            labels: etiquetas_lead,
            datasets: [
                datosIngresos_lead
            ]
        }
    });   
    ////////////////////////////////////////////////////GRAFICA GENERAL COTIZACION////////////////////////////////////////////////////
    const datosIngresos_Cotizacion = {
        data: [data.TotalCotizacion, data.metaGeneralCotizacion],
        backgroundColor: color_Cotizacion,
    };
    new Chart($grafica_Cotizacion, {
        type: 'doughnut',
        data: {
            labels: etiquetas_Cotizacion,
            datasets: [
                datosIngresos_Cotizacion,
            ]
        },       
    });
    
    ////////////////////////////////////////////////////GRAFICA GENERAL VENTAS////////////////////////////////////////////////////  
    const datosIngresos_Venta = {
        data: [data.TotalVenta, data.metaGeneralVentas], 
        backgroundColor: color_Venta,
    };
    new Chart($grafica_Venta, {
        type: 'doughnut',
        data: {
            labels: etiquetas_Venta,
            datasets: [
                datosIngresos_Venta,
            ]
        },
    });
}

//funcion que obtiene y manda datos a la primera grafica de meta
let obtenerMetaMetricas = function(){
    $.ajax({
        url: "../../../Vista/grafica/obtenerDatosMetrica.php",
        type: "POST",
        datatype: "JSON",
        data: {
        },
        success: function (resp) {
            datosGrafica = JSON.parse(resp);  
            console.log(datosGrafica) ;
           
            const $grafica = document.querySelector("#grafica");
            const etiquetas = ["Meta Llamadas" ,"Meta Lead" ,"Meta Cotizacion","Meta Ventas" ]
            const color = ['rgba(133, 52, 0 )','rgba( 202, 117, 24)','rgba(255, 152, 0)','rgba(255, 212, 120)']

            const datosIngresos = {
                data: [datosGrafica[0].meta, datosGrafica[1].meta, datosGrafica[2].meta, datosGrafica[3].meta],
                backgroundColor: color,
            };
            new Chart($grafica, {
                type: 'pie',
                data: {
                    labels: etiquetas,
                    datasets: [
                        datosIngresos,
                    ]
                },
            });
        }
    });
}

//funcion para llenar el modal de vendedores
$(document).ready(function () {
    $tablaVendedores = $("#table-Traer-Vendedor").DataTable({
        "ajax": {
            "url": "../../../Vista/grafica/obtenerFiltroVendedores.php",
            "type": "POST",
            "datatype": "JSON",
            "dataSrc": "",
        },
        "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        },
        "columns": [
            { "data": "idUsuario_Vendedor" },
            { "data": "nombreVendedor" },
        {
            "defaultContent":
            '<button class="btns btn" id="btn_seleccionar"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>',
        },
        ],
    });
});


//funcion que Obtiene los las tareas por vendedor
let obtenerTareaVendedor = function(idUsuario_Vendedor,fechaDesde, fechaHasta){
    $.ajax({
        url: "../../../Vista/grafica/obtenerTareasPorVendedor.php",
        type: "POST",
        datatype: "JSON",
        data: {
            idUsuario_Vendedor:idUsuario_Vendedor,
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        },
        success: function (resp) {
            // traerTareasVendedor = JSON.parse(resp);
            console.log(resp);
        }
    });
}

$(document).on("click", "#btn_seleccionar", function() {
    let fila = $(this).closest("tr");
    idUsuario_Vendedor = fila.find("td:eq(0)").text(); //captura el ID DEL vendedor
    console.log(idUsuario_Vendedor);
    $("#modalTraerVendedores").modal("hide");
});

  


// vendedoresSeleccionados.forEach(function (vendedor) {
//     if (vendedor.classList.contains('select-vendedor')) {
//       let $idVendedor = $(vendedor).closest('tr').find('td:eq(0)').text();
//       let $vendedor = {
//         idVendedor: $idVendedor
//       }
//       $Vendedores.push($vendedor);
//     }
// });
 
  






