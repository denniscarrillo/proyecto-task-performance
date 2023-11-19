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

    public static function eliminarPorcentaje($eliminarPorcentaje){
        return porcentajes::eliminarPorcentaje($eliminarPorcentaje);
   }
   public static function obtenerPorcentajePdf($buscar){
    return Porcentajes::obtenerPorcentajesPdf($buscar);
   }
   

}