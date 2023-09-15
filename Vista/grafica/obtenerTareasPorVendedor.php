<?php
require_once ("../../db/Conexion.php");
require_once ("../../Modelo/Tarea.php");
require_once("../../Controlador/ControladorTarea.php");



if(isset($_POST['idUsuario_Vendedor']) && isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])){
    $TareasXvendedor = ControladorTarea::obtenerCantTareasPorVendedor($_POST['idUsuario_Vendedor'], $_POST['fechaDesde'], $_POST['fechaHasta']);
    
    $datosGraficaVend = [
        "TotalLlamadasV" => $TareasXvendedor["LlamadasV"],
        "TotalLeadV" => $TareasXvendedor["LeadV"],
        "TotalCotizacionV" => $TareasXvendedor["CotizacionV"],
        "TotalVentaV" => $TareasXvendedor["VentaV"]
    ];

print json_encode($datosGraficaVend, JSON_UNESCAPED_UNICODE);

}