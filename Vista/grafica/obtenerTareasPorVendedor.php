<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Tarea.php");
require_once("../../Controlador/ControladorTarea.php");
require_once ("../../Modelo/Metricas.php");
require_once("../../Controlador/ControladorMetricas.php");

$Metricas = ControladorMetricas::obtenerMetaMetricas();
$Metas = array(); // Crear un array para almacenar todas las metas

if(isset($_POST['idUsuario_Vendedor']) && isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])){
    $cantTareas = ControladorTarea::obtenerCantTareasPorVendedor($_POST['idUsuario_Vendedor'], $_POST['fechaDesde'], $_POST['fechaHasta']);

    foreach($Metricas as $Metrica){
     $meta = intval($Metrica['meta']);
     $Metas[] = $meta; 

    }
    $datosGrafica = [
        "metaLlamada" => $Metas[0], // Aquí puede acceder a las metas individuales del array $Metas
        "metaLead" => $Metas[1], 
        "metaCotizacion" => $Metas[2],
        "metaVentas" => $Metas[3], 
        "TotalLlamadas" => $cantTareas["Llamadas"],
        "TotalLead" => $cantTareas["Lead"],
        "TotalCotizacion" => $cantTareas["Cotizacion"],
        "TotalVenta" => $cantTareas["Venta"]
    ];

    print json_encode($datosGrafica, JSON_UNESCAPED_UNICODE);
}
