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