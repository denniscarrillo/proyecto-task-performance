
let btnFiltrar = document.getElementById('btnFiltrar')

btnFiltrar.addEventListener('click', function(){
    let fechadesde = document.getElementById('fechaDesdef').value;
    let fechahasta = document.getElementById('fechaHastaf').value;
    obtenerDatosGrafica(fechadesde, fechahasta);
})

// Obtener una referencia al elemento canvas del DOM
const $grafica = document.querySelector("#grafica");
// Las etiquetas son las porciones de la gráfica
const etiquetas = ["Llamadas", "Leads", "Cotizaciones", "Ventas"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos = {
    data: [1500, 400, 2000, 700], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(255, 77, 77)',
        'rgba(232,233,161)',
        'rgba(128, 191, 255)',
        'rgba(71, 209, 71)',
    ],// Color de fondo
    borderColor: [
        'rgba(128, 0, 0)',
        'rgba(179, 143, 0)',
        'rgba(0, 0, 102)',
        'rgba(0, 153, 51)',
    ],// Color del borde
    borderWidth: 2,// Ancho del borde
};
new Chart($grafica, {
    type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
    data: {
        labels: etiquetas,
        datasets: [
            datosIngresos,
            // Aquí más datos...
        ]
    },

    Options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZaero:true
                }
            }]
        }
    }
});

// Obtener una referencia al elemento canvas del DOM
const $grafica_llamada = document.querySelector("#grafica_llamada");
// Las etiquetas son las porciones de la gráfica
const etiquetas_llamada = ["Llamadas"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos_llamada = {
    data: [1500,500], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(255, 77, 77)',
        'rgba(232,233,161)',
    ],// Color de fondo
    borderColor: [
        'rgba(128, 0, 0)',
        'rgba(179, 143, 0)',
    ],// Color del borde
    borderWidth: 2,// Ancho del borde
};
new Chart($grafica_llamada, {
    type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
    data: {
        labels: etiquetas_llamada,
        datasets: [
            datosIngresos_llamada,
            // Aquí más datos...
        ]
    },

    Options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZaero:true
                }
            }]
        }
    }
});


// Obtener una referencia al elemento canvas del DOM
const $grafica_lead = document.querySelector("#grafica_lead");
// Las etiquetas son las porciones de la gráfica
const etiquetas_lead = ["Leads"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos_lead = {
    data: [1500, 500], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(255, 77, 77)',
        'rgba(232,233,161)',
    ],// Color de fondo
    borderColor: [
        'rgba(128, 0, 0)',
        'rgba(179, 143, 0)',
    ],// Color del borde
    borderWidth: 2,// Ancho del borde
};
new Chart($grafica_lead, {
    type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
    data: {
        labels: etiquetas_lead,
        datasets: [
            datosIngresos_lead,
            // Aquí más datos...
        ]
    },

    Options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZaero:true
                }
            }]
        }
    }
});


// Obtener una referencia al elemento canvas del DOM
const $grafica_Cotizacion = document.querySelector("#grafica_Cotizacion");
// Las etiquetas son las porciones de la gráfica
const etiquetas_Cotizacion = ["Cotizacion"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos_Cotizacion = {
    data: [1500, 500], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(255, 77, 77)',
        'rgba(232,233,161)',
    ],// Color de fondo
    borderColor: [
        'rgba(128, 0, 0)',
        'rgba(179, 143, 0)',
    ],// Color del borde
    borderWidth: 2,// Ancho del borde
};
new Chart($grafica_Cotizacion, {
    type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
    data: {
        labels: etiquetas_Cotizacion,
        datasets: [
            datosIngresos_Cotizacion,
            // Aquí más datos...
        ]
    },

    Options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZaero:true
                }
            }]
        }
    }
});

// Obtener una referencia al elemento canvas del DOM
const $grafica_Venta = document.querySelector("#grafica_Ventas");
// Las etiquetas son las porciones de la gráfica
const etiquetas_Venta = ["Ventas"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos_Venta = {
    data: [1500, 500], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(255, 77, 77)',
        'rgba(232,233,161)',
    ],// Color de fondo
    borderColor: [
        'rgba(128, 0, 0)',
        'rgba(179, 143, 0)',
    ],// Color del borde
    borderWidth: 2,// Ancho del borde
};
new Chart($grafica_Venta, {
    type: 'doughnut',// Tipo de gráfica. Puede ser doughnut o pie 
    data: {
        labels: etiquetas_Venta,
        datasets: [
            datosIngresos_Venta,
            // Aquí más datos...
        ]
    },

    Options:{
        scales:{
            yAxes:[{
                ticks:{
                    beginAtZaero:true
                }
            }]
        }
    }
});



let obtenerDatosGrafica = function (fechaDesde, fechaHasta){
    $.ajax({
        url: "../../../Vista/grafica/obtenerCantTareas.php",
        type: "POST",
        datatype: "JSON",
        data: {
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        },
        success: function (resp) {
          //Mostrar mensaje 
          console.log(resp) 

          
        }
      });
}


