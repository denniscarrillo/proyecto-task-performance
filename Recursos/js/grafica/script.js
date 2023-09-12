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


///////////////Boton editar
let btnFiltrar = document.getElementById('btnFiltrar')
    btnFiltrar.addEventListener('click', function(){
    let fechadesde = document.getElementById('fechaDesdef').value;
    let fechahasta = document.getElementById('fechaHastaf').value;
    obtenerDatosGrafica(fechadesde, fechahasta);
    obtenerMetaMetricas();
});

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





// const $grafica_llamada = document.querySelector("#grafica_llamada");
// const etiquetas_llamada = ["Llamadas"]
// const color_Llamada = ['rgba(133, 52, 0 )', 'rgb(82, 82, 82 )']

// const datosIngresos_llamada = {
//     data: [datosGrafica['metaGeneralLlamada'], datosGrafica['TotalLlamadas']], 
//     backgroundColor: color_Llamada,
// };
// new Chart($grafica_llamada, {
//     type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
//     data: {
//         labels: etiquetas_llamada,
//         datasets: [
//             datosIngresos_llamada
//         ]
//     }
// });








 
//    







