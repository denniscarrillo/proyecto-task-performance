<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Tarea.php");
require_once ("../../Modelo/Metricas.php");
require_once ("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorMetricas.php");
require_once("../../Controlador/ControladorTarea.php");
require_once("../../Controlador/ControladorUsuario.php");

$MetaLlamadaGeneral =0 ; $MetaLeadGeneral =0 ; $MetaCotizacionGeneral =0 ; $MetaVentasGeneral =0 ;
$CantVendedores = ControladorUsuario::obtenerCantVendedores();
$Metricas = ControladorMetricas::obtenerMetaMetricas();
if(isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])){
    $CantTareas = ControladorTarea::obtenerCantTareas($_POST['fechaDesde'], $_POST['fechaHasta']);
    //Datos de tarea para la grafica general
    foreach($Metricas as $Metrica){
        switch (intval($Metrica ['id_EstadoAvenace'])){
            case 1:{
                $MetaLlamadaGeneral = intval($CantVendedores) * intval($Metrica['meta']);
                break;
            }
            case 2:{
                $MetaLeadGeneral = intval($CantVendedores) * intval($Metrica['meta']);
                break;
            }
            case 3:{
                $MetaCotizacionGeneral = intval($CantVendedores) * intval($Metrica['meta']);
                break;
            }
            case 4:{
                $MetaVentasGeneral = intval($CantVendedores) * intval($Metrica['meta']);
                break;
            }
        }
    }   
 
     $datosGrafica = [
            "metaGeneralLlamada" => $MetaLlamadaGeneral,
            "metaGeneralLead" => $MetaLeadGeneral,
            "metaGeneralCotizacion" =>$MetaCotizacionGeneral,
            "metaGeneralVentas" =>$MetaVentasGeneral,
            "TotalLlamadas" => $CantTareas["Llamadas"],
            "TotalLead" => $CantTareas["Lead"],
            "TotalCotizacion" => $CantTareas["Cotizacion"],
            "TotalVenta" => $CantTareas["Venta"]
     ];

     print json_encode($datosGrafica, JSON_UNESCAPED_UNICODE);
    
}
