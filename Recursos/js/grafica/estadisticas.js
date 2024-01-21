
let tablaEstadistica = '';

$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
    let permisos = JSON.parse(data);

    if (tablaEstadistica !== '') {
        tablaEstadistica.destroy();
    }
  tablaEstadistica = $('#table-Estadistica').DataTable({
    "ajax": {
      "url": "../../../Vista/grafica/obtenerEstadistica.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
        { "data": "Descripcion"},
        { "data": "Meta"},
        { "data": "Alcance"},
        { "data": "Porcentaje"}      
    ],
    error: function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", status, error);
        // Agregar lógica de manejo de errores si es necesario
    }
  });
}
let $mensaje = document.querySelector(".mensaje");
$(document).ready(function () {
    $('#btnFiltrar').click(function () {
        const fechaDesde = $('#fechaDesdef').val();
        const fechaHasta = $('#fechaHastaf').val();

        if (fechaDesde === "" && fechaHasta === "" ) {
            $mensaje.innerText = '*Debe llenar ambas Fechas';
        } else{
           
            let fechadesde = document.getElementById('fechaDesdef').value;
            let fechahasta = document.getElementById('fechaHastaf').value;
            //se obtienen los datos para graficas GENERALES 
            obtenerDatosEstadisticaG(fechadesde, fechahasta);
            $mensaje.innerText = '';
            $mensaje.classList.remove('.mensaje')
        
        }
    });
});

// Obtener datos Genrales para las 4 graficas de cada tarea
let obtenerDatosEstadisticaG = function(fechaDesde, fechaHasta){
    tablaEstadistica = $('#table-Estadistica').DataTable({
        "ajax": {
          "url": "../../../Vista/grafica/obtenerEstadisticaG.php",
          "dataSrc": "",
          "type": "POST",
        "datatype": "JSON",
        "data": {
            "fechaDesde": fechaDesde,
            "fechaHasta": fechaHasta
        }
        },
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        },
        "columns": [
            { "data": "Tarea"},
            { "data": "Meta"},
            { "data": "Alcance"},
            { "data": "Porcentaje"}      
        ]
      });

}
