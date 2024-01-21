
let tablaEstadistica;

    if (tablaEstadistica && $.fn.DataTable.isDataTable('#table-Estadistica')) {
        tablaEstadistica.clear().destroy();
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
//}


let $mensaje = document.querySelector(".mensaje");
//let tablaEstadistica; // Variable para almacenar la instancia de DataTable
$(document).ready(function () {
    let rdGeneral = document.getElementById("RadioGeneral");
    let rdVendedores = document.getElementById("RadioPorVendedor");
    let btnSelecVendedores = document.getElementById("btnVendedores");
    
    rdVendedores.addEventListener("change", function(){
        if (rdVendedores.checked) {      
            // Habilitar el botón seleccionar vendedores
            btnSelecVendedores.removeAttribute("disabled");
        } else {
            btnSelecVendedores.setAttribute("disabled", "true");        
        }    
    });

    
    rdGeneral.addEventListener("change", function () {
        if (rdGeneral.checked) {
        // Si se deselecciona el radio rdGeneral, deshabilita el botón
        btnSelecVendedores.setAttribute("disabled", "true");
        }
    });
  


    $('#btnFiltrar').click( function () {
        const fechaDesde = $('#fechaDesdef').val();
        const fechaHasta = $('#fechaHastaf').val();

        if (fechaDesde === "" && fechaHasta === "") {
            $mensaje.innerText = '*Debe llenar ambas Fechas';
        } else {

            if(rdGeneral.checked){                
                // Destruir la DataTable existente antes de volver a inicializar
                if ($.fn.DataTable.isDataTable('#table-Estadistica')) {
                    tablaEstadistica.clear();
                }
                // Obtener datos para graficas GENERALES
                obtenerDatosEstadisticaG(fechaDesde, fechaHasta);
                console.log('primera opcion')
            }else if(rdVendedores.checked){
                console.log('holaaaa');

            }            
            $mensaje.innerText = '';
            $mensaje.classList.remove('.mensaje');
        }
    });

});



// Obtener datos Generales filtrados
let obtenerDatosEstadisticaG = function (fechaDesde, fechaHasta) {
    $.ajax({
        url: "../../../Vista/grafica/obtenerEstadisticaG.php",
        type: "POST",
        dataType: "json",
        data: {
            "fechaDesde": fechaDesde,
            "fechaHasta": fechaHasta
        },
        success: function (data) {
            console.log(data); // Verificar los datos en la consola
                tablaEstadistica.clear().rows.add(data).draw();           
            },
               
        error: function (xhr, status, error) {
            console.error("Error al obtener datos: " + error);
        }
    });
};

$tablaVendedores = "";

 //funcion para llenar el modal de vendedores
$(document).ready(function () {
    $tablaVendedores = $("#table-Traer-Vendedor").DataTable({
        "ajax": {
            "url": "../../Vista/grafica/obtenerFiltroVendedores.php",
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

/////////////////
let idUsuario_Vendedor; // Variable para almacenar el idUsuario_Vendedor

$(document).on("click", "#btn_seleccionar", function() {
    let fila = $(this).closest("tr");
    idUsuario_Vendedor = fila.find("td:eq(0)").text();
    // console.log(idUsuario_Vendedor);
    $("#modalTraerVendedores").modal("hide");
    const fechaDesde = $('#fechaDesdef').val();
    const fechaHasta = $('#fechaHastaf').val();

    if (fechaDesde === "" && fechaHasta === "") {
        $mensaje.innerText = '*Debe llenar ambas Fechas';
    } else {
    obtenerEstadisticasVendedor(idUsuario_Vendedor,fechaDesde,fechaHasta);
    }
});

//////////Obtiene los datos para seleccionar las tareas de los vendedores
// let obtenerEstadisticasVendedor =  function(idUsuario_Vendedor,fechaDesde,fechaHasta){   
//      $.ajax({
//         url: "../../Vista/grafica/obtenerEstadisticasVend.php",
//         type: "POST",
//         datatype: "JSON",
//             data: {
//              idUsuario:idUsuario_Vendedor,
//              fechaDesde: fechaDesde,
//              fechaHasta: fechaHasta
//             },
//             success: function (data) {
//                 console.log(data); // Verificar los datos en la consola
                
//                     tablaEstadistica.clear().rows.add(data).draw();
                
//                 },
//             error: function (xhr, status, error) {
//                 console.error("Error al obtener datos: " + error);
//             }
//      }); 
// };

let obtenerEstadisticasVendedor = function(idUsuario_Vendedor, fechaDesde, fechaHasta) {
    $.ajax({
        url: "../../Vista/grafica/obtenerEstadisticasVend.php",
        type: "POST",
        dataType: "json", // Cambiado de datatype a dataType
        data: {
            idUsuario: idUsuario_Vendedor,
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        },
        success: function(data) {
            console.log(data); // Verificar los datos en la consola

            // Asegúrate de que data es un arreglo de objetos con las propiedades esperadas
            tablaEstadistica.clear().rows.add(data).draw();
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener datos: " + error);

            // Puedes mostrar un mensaje al usuario o tomar otras acciones aquí
        }
    });
};
















// Obtener datos Generales filtrados
// let obtenerDatosEstadisticaG = function (fechaDesde, fechaHasta) {
//     $.ajax({
//         url: "../../../Vista/grafica/obtenerEstadisticaG.php",
//         type: "POST",
//         dataType: "json",
//         data: {
//             "fechaDesde": fechaDesde,
//             "fechaHasta": fechaHasta
//         },
//         success: function (data) {
//             // Limpiar y actualizar datos en la tabla existente
//             tablaEstadistica.destroy();
//             tablaEstadistica = $('#table-Estadistica').DataTable({
//                 // Configuración de DataTables...
//             });
//             tablaEstadistica.rows.add(data).draw();
//         },
//         // success: function (data) {
//         //     // Limpiar y actualizar datos en la tabla existente
//         //     tablaEstadistica.clear().rows.add(data).draw();
//         // },
//         error: function (xhr, status, error) {
//             console.error("Error al obtener datos: " + error);
//         }
//     });
// };

// // Obtener datos Generales filtrados
// let obtenerDatosEstadisticaG = function (fechaDesde, fechaHasta) {
//     $.ajax({
//         url: "../../../Vista/grafica/obtenerEstadisticaG.php",
//         type: "POST",
//         dataType: "json",
//         data: {
//             "fechaDesde": fechaDesde,
//             "fechaHasta": fechaHasta
//         },
//         success: function (data) {
//             // Verificar si la DataTable ya existe
//             if ($.fn.DataTable.isDataTable('#table-Estadistica')) {
//                 // Limpiar y actualizar datos en la tabla existente
//                 tablaEstadistica.clear().rows.add(data).draw();
//             } else {
//                 // Si la DataTable no existe, inicializarla
//                 tablaEstadistica = $('#table-Estadistica').DataTable({
//                     "language": {
//                         "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
//                     },
//                     "columns": [
//                         { "data": "Tarea" },
//                         { "data": "Meta" },
//                         { "data": "Alcance" },
//                         { "data": "Porcentaje" }
//                     ]
//                 });
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error("Error al obtener datos: " + error);
//         }
//     });
// };