/////////Constantes Graficas///////////////
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



//////////////////////Validaciones Graficas/////////////////////////////////////////
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

// ////////////////Boton Filtrar
// let RadioGeneral = document.getElementById("RadioGeneral");
// let btnFiltrar= document.getElementById("btnFiltrar");
// RadioGeneral.addEventListener("change", function(){
//     if (RadioGeneral.checked ) {
//         // Habilitar el botón seleccionar vendedores
//         btnFiltrar.removeAttribute("disabled");
//       } else {
//         btnFiltrar.setAttribute("disabled", "true");
//     }    
// });

// let radioVendedores = document.getElementById("RadioPorVendedor");
// radioVendedores.addEventListener("change", function () {
//     if (radioVendedores.checked) {
//       // Si se deselecciona el radio rdGeneral, deshabilita el botón
//       btnFiltrar.setAttribute("disabled", "true");
//     }
// });
//////////////////////
// let $mensaje2 = document.querySelector(".grafica_Vendedor");
// let  graficasVendedor = document.getElementById("grafica_Vendedor");
// let  seleccion = document.getElementById("#btn_seleccionar");
// graficasVendedor.addEventListener("change", function () {
//     if (graficasVendedor.checked) {
//       // Si se deselecciona el radio rdGeneral, deshabilita el botón
//       seleccion.setAttribute("enable", "true");
//     }else {
//      seleccion.setAttribute("disable", "false");
//      $mensaje2.classList.remove('.grafica_Vendedor')
//     }
// }); 

////////////////////////////////////////////////////////////////////////////////////
////Validaciones de fechas
$tablaVendedores = "";
let $mensaje = document.querySelector(".mensaje");
let idUsuario_Vendedor = "";

$(document).ready(function () {
    $('#btnFiltrar').click(function () {
        const fechaDesde = $('#fechaDesdef').val();
        const fechaHasta = $('#fechaHastaf').val();

        if (fechaDesde === "" && fechaHasta === "" ) {
            $mensaje.innerText = '*Debe llenar ambas Fechas';
        } else{
           
            let fechadesde = document.getElementById('fechaDesdef').value;
            let fechahasta = document.getElementById('fechaHastaf').value;
          
            obtenerDatosGrafica(fechadesde, fechahasta);
            // obtenerMetaMetricas();
            $mensaje.innerText = '';
            $mensaje.classList.remove('.mensaje')
        
        }
    });
});

//funcion que al seleccionar me de las graficas de las tareas por un vendedor 
$(document).on("click", "#btn_seleccionar", function() {
    
    let fila = $(this).closest("tr");
    idUsuario_Vendedor = fila.find("td:eq(0)").text();
    console.log(idUsuario_Vendedor);
    $("#modalTraerVendedores").modal("hide");
    const fechaDesdes = $('#fechaDesdef').val();
    const fechaHastas = $('#fechaHastaf').val();
    
    
if (fechaDesdes === "" && fechaHastas === "" ) {
    $mensaje.innerText = 'Debe llenar ambas Fechas';
   
}else{
    let fechadesde = document.getElementById('fechaDesdef').value;
    let fechahasta = document.getElementById('fechaHastaf').value;
    // obtenerMetaMetricas();
    
    obtenerTareaVendedor(idUsuario_Vendedor,fechadesde, fechahasta);
    
    $mensaje.innerText = '';
    $mensaje.classList.remove('.mensaje')
}
});
/////////////////////////Grafica de Metas
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
//Carga la grafica Metas 
function cargarGraficaMetas() {
    obtenerMetaMetricas();
}
document.addEventListener('DOMContentLoaded', cargarGraficaMetas);


/////////////////////////////////////GRAFICAS GENERALES///////////////////////////////////
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

//funcion que genera los datos GENERALES(todos los vendedores) de cada tarea
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


////////////////////GRAFICA POR VENDENDOR////


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
            '<button class="btns btn " id="btn_seleccionar"><i class="icon-select  fa-solid fa-circle-check"></i></button>',
        },
        ],
    });
});



//////////Obtiene los datos para seleccionar las tareas de los vendedores
let obtenerTareaVendedor = function(idUsuario_Vendedor,fechaDesde,fechaHasta){
    
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
             datosGrafica= JSON.parse(resp);  
             generarGraficasVendedores(datosGrafica);
             console.log(datosGrafica) ;
      
            }
     }); 
};

let generarGraficasVendedores = function(data) {
  ////////////////////////////////////////////////////GRAFICA  LLAMADA////////////////////////////////////////////////////   
    const datosIngresos_llamada = {
        data: [data.TotalLlamadas, data.metaLlamada], 
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
    ////////////////////////////////////////////////////GRAFICA  LEAD////////////////////////////////////////////////////
    const datosIngresos_lead = {
        data: [data.TotalLead, data.metaLead], 
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
    ////////////////////////////////////////////////////GRAFICA  COTIZACION////////////////////////////////////////////////////
    const datosIngresos_Cotizacion = {
        data: [data.TotalCotizacion, data.metaCotizacion],
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
    
    ////////////////////////////////////////////////////GRAFICA  VENTAS////////////////////////////////////////////////////  
    const datosIngresos_Venta = {
        data: [data.TotalVenta, data.metaVentas], 
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








