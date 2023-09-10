// Obtener una referencia al elemento canvas del DOM
const $grafica_llamada = document.querySelector("#grafica_llamada");
// Las etiquetas son las porciones de la gráfica
const etiquetas_llamada = ["Llamadas", "Leads"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos_llamada = {
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