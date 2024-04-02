<?php
class ControladorPorcentajes
{

    public static function getPorcentaje()
    {
        return Porcentajes::obtenerPorcentajes();
    }

    public static function registroNuevoPorcentaje($nuevoPorcentaje)
    {
        return Porcentajes::registroPorcentaje($nuevoPorcentaje);
    }
    public static function dividiendoPorcentaje($porcentaje)
    {
        return Porcentajes::dividirPorcentaje($porcentaje);
    }

    public static function editarPorcentaje($nuevoPorcentaje)
    {
        Porcentajes::editarPorcentaje($nuevoPorcentaje);
    }
    public static function porcentajeExiste($valorPorcentaje)
    {
        return Porcentajes::porcentajeExistente($valorPorcentaje);
    }
    public static function verificarUtilizacionEnComision($idPorcentaje)
    {
    return Porcentajes::verificarUtilizacionEnComision($idPorcentaje);
    }
    public static function inactivarPorcentaje($eliminarPorcentaje)
    {
        return Porcentajes::inactivarPorcentaje($eliminarPorcentaje);
    }
    public static function eliminarPorcentaje($eliminarPorcentaje){
        return Porcentajes::eliminarPorcentaje($eliminarPorcentaje);
   }
   public static function obtenerPorcentajePdf($buscar){
    return Porcentajes::obtenerPorcentajesPdf($buscar);
   }
   public static function VerificarRelaciones($idPorcentaje){
    return Porcentajes::verificandoRelaciones($idPorcentaje);
   }

}