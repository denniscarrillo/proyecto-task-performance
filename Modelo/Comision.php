<?php

class Comision {
    public $idComision;
    public $idVenta;
    public $idPorcentaje;
    public $comisionTotal;

    public static function obtenerTodasLasComision(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision = 
            $consulta->query("SELECT co.id_Comision, v.total_Venta, po.valor_Porcentaje,
            co.comision_TotalVenta
            FROM tbl_comision AS co
            INNER JOIN tbl_vista_venta AS v ON co.id_Venta = v.id_Venta
            INNER JOIN  tbl_porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje;
            ");
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = $listaComision->fetch_assoc()){
            $Comision [] = [
                'IdComision' => $fila["id_Comision"],
                'Venta' => $fila["id_Venta"],
                'Porcentaje'=> $fila["id_Porcentaje"],
                'ComisionTotal' => $fila["comision_TotalVenta"],
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $Comision;
    }
    //Método para crear nueva comision desde Autoregistro.
    public static function registroNuevaComision($nuevaComision){
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
    $$idComision = $nuevaComision->$idComision;
    $idVenta = $nuevaComision->idVenta;
    $idPorcentaje =$nuevaComision->idPorcentaje;
    $comisionTotal = $nuevaComision->comisionTotal;
    $nuevaComision = $consulta->query("INSERT INTO `cocinas_y_equipos`.`tbl_comision` SET `comision_TotalVenta` = '110' WHERE (`id_Comision` = '1');)");
    mysqli_close($consulta); #Cerramos la conexión.
    return $Comision;
}

}#Fin de la clase