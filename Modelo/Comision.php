<?php

class Comision
{
    public $idComision;
    public $idVenta;
    public $idPorcentaje;
    public $comisionTotal;
    public $estadoComision;
    public $creadoPor;

    public $ModificadoPor;

    public $fechaComision;

    public $fechaModificacion;

    public static function obtenerTodasLasComisiones()
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision =
            $consulta->query("SELECT co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta, co.estadoComision, co.Creado_Por, co.Fecha_Creacion
            FROM tbl_comision AS co
            INNER JOIN view_facturasventa AS v ON co.id_Venta = v.NUMFACTURA
            INNER JOIN  tbl_porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje;");
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = $listaComision->fetch_assoc()) {
            $Comision[] = [
                'idComision' => $fila["id_Comision"],
                'factura' => $fila["id_Venta"],
                'totalVenta' => $fila["TOTALNETO"],
                'porcentaje' => $fila["valor_Porcentaje"],
                'comisionTotal' => $fila["comision_TotalVenta"],
                'estadoComisionar' => $fila["estadoComision"],
                'fechaComision' => $fila["Fecha_Creacion"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $Comision;
    }
    //funcion para registrar una Comision

    public static function registroNuevaComision($nuevaComision)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        // Preparamos la insercion en la base de datos
        $consulta->query("INSERT INTO `tbl_comision` (`id_Venta`, `id_Porcentaje`, 
        `comision_TotalVenta`, `estadoComision`, `Creado_Por`, `Fecha_Creacion`)  
        VALUES ('$nuevaComision->idVenta','$nuevaComision->idPorcentaje','$nuevaComision->comisionTotal', '$nuevaComision->estadoComision', '$nuevaComision->creadoPor', '$nuevaComision->fechaComision')");
        $idComision = mysqli_insert_id($consulta);
        // Ejecutamos la consulta y comprobamos si fue exitosa
        mysqli_close($consulta); #Cerramos la conexión.
        return $idComision;

    }

    public static function obtenerPorcentajesComision()
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaPorcentajes = $conexion->query("SELECT id_Porcentaje, valor_Porcentaje FROM tbl_porcentaje WHERE estado_Porcentaje = 'Activo'");
        $porcentajes = array();
        while ($fila = $listaPorcentajes->fetch_assoc()) {
            $porcentajes[] = [
                'idPorcentaje' => $fila['id_Porcentaje'],
                'porcentaje' => $fila['valor_Porcentaje']
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $porcentajes;
    }

    public static function obtenerVendedores($idTarea)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaVendedores = $conexion->query("SELECT vt.id_usuario_vendedor, u.Usuario FROM tbl_vendedores_tarea AS vt
        INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = vt.id_usuario_vendedor WHERE vt.id_Tarea = $idTarea;");
        $vendedores = array();
        while ($fila = $listaVendedores->fetch_assoc()) {
            $vendedores[] = [
                'idVendedor' => $fila['id_usuario_vendedor'],
                'nombreVendedor' => $fila['Usuario']
            ];
        }
        mysqli_close($conexion); #Cerramos la conexión.
        return $vendedores;
    }
    public static function obtenerIdTarea($idFacturaVenta)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consulta = $conexion->query("SELECT id_Tarea FROM tbl_AdjuntoEvidencia WHERE evidencia = $idFacturaVenta;");
        $fila = $consulta->fetch_assoc();
        $idTarea = $fila['id_Tarea'];
        mysqli_close($conexion); #Cerramos la conexión.
        return $idTarea;
    }

    public static function calcularComision($porcentaje, $totalVenta)
    {
        $comision[] = [
            'comision' => $totalVenta * $porcentaje
        ];
        return $comision;

    }
    public static function dividirComisionVendedores($comisionVenta, $idComision, $vendedores, $user, $fechaComision)
    {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        
        $estadoComisionVendedor = 'Activa';
        $comisionVendedor = $comisionVenta / count($vendedores);
        foreach ($vendedores as $vendedor) {
        $idVendedor = $vendedor['idVendedor'];
        $insert = "INSERT INTO `tbl_comision_por_vendedor`(`id_Comision`, `id_usuario_vendedor`, `total_Comision`, `estadoComisionVendedor`, `Creado_Por`, `Fecha_Creacion`) 
        VALUES ('$idComision', '$idVendedor', '$comisionVendedor', '$estadoComisionVendedor', '$user', '$fechaComision');";
    
        $abrirConexion->query($insert);
        }
        mysqli_close($abrirConexion); #Cerramos la conexión.
    }

    public static function actualizarEstadoComisionVendedor($comision){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $selectVendedores = $conexion->query("SELECT id_usuario_vendedor FROM tbl_comision_por_vendedor WHERE id_Comision = '$comision->idComision';");
        for ($i = 0; $i < $selectVendedores->num_rows; $i++){
            $id = $selectVendedores->fetch_assoc();
            $idVendedor = $id['id_usuario_vendedor'];
            $conexion->query("UPDATE tbl_comision_por_vendedor SET estadoComisionVendedor = '$comision->estadoComision', 
        Modificado_Por = '$comision->ModificadoPor', Fecha_Modificacion = '$comision->fechaModificacion' WHERE id_usuario_vendedor = '$idVendedor';");
        }
        mysqli_close($conexion); #Cerramos la conexión.
    }
    public static function obtenerComisionesPorVendedor()
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision =
            $consulta->query("SELECT vt.id_Comision_Por_Vendedor, vt.id_usuario_vendedor, u.Usuario, vt.total_Comision, vt.Fecha_Creacion
            FROM tbl_ms_usuario AS u
            INNER JOIN tbl_comision_por_vendedor AS vt ON u.id_Usuario = vt.id_usuario_vendedor;");
        $ComisionVendedor = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = $listaComision->fetch_assoc()) {
            $ComisionVendedor[] = [
                'idComisionVendedor' => $fila["id_Comision_Por_Vendedor"],
                'idVendedor' => $fila["id_usuario_vendedor"],
                'usuario' => $fila["Usuario"],
                'comisionTotal' => $fila["total_Comision"],
                'fechaComision' => $fila["Fecha_Creacion"]
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $ComisionVendedor;
    }
    //funcion que suma todas las comisiones de un vendedor
    public static function sumarComisionesVendedor($fechaDesde, $fechaHasta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $sumaComisiones = $consulta->query("SELECT vt.id_usuario_vendedor, u.Usuario, vt.Fecha_Creacion, SUM(vt.total_Comision) AS totalComision FROM tbl_comision_por_vendedor vt 
        inner join tbl_ms_usuario AS u ON vt.id_usuario_vendedor = u.id_Usuario WHERE vt.Fecha_Creacion BETWEEN '$fechaDesde' AND '$fechaHasta'
        group by vt.id_usuario_vendedor, u.Usuario, vt.Fecha_Creacion ORDER BY totalComision;
        ");
        $fila = $sumaComisiones->fetch_assoc();
        $totalComision = array();
        while ($fila = $sumaComisiones->fetch_assoc()) {
            $totalComision[] = [
                'idVendedor' => $fila['id_usuario_vendedor'],
                'nombreVendedor' => $fila['Usuario'],
                'totalComision' => $fila['totalComision'],
                'fechaComision' => $fila['Fecha_Creacion']
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $totalComision;
    }
    public static function fechasComisiones ($fechaDesde, $fechaHasta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $fechasComisiones = $consulta->query("SELECT * FROM tbl_comision_por_vendedor WHERE Fecha_Creacion BETWEEN '$fechaDesde' AND '$fechaHasta';
        ");
        $fila = $fechasComisiones->fetch_assoc();
        $fechaComision = array();
        while ($fila = $fechasComisiones->fetch_assoc()) {
            $fechaComision[] = [
                'fechaDesde' => $fila['Fecha_Creacion'],
                'fechaHasta' => $fila['Fecha_Creacion']
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $fechaComision;
    }

    Public static function obtenerEstadoComision($idVenta){
        $estadoVenta = null;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $estadoComision = $consulta->query("SELECT id_Comision FROM tbl_comision WHERE estadoComision = 'Activa' AND id_Venta = '$idVenta';
        ");
        $existe = $estadoComision->num_rows;
        if($existe > 0){
            $estadoVenta = true;
        }
        else{
            $estadoVenta = false;
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $estadoVenta;
    }

    public static function editarComision ($nuevaComision) {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $consulta->query("UPDATE tbl_comision SET estadoComision = '$nuevaComision->estadoComision', Modificado_Por ='$nuevaComision->ModificadoPor', 
        Fecha_Creacion ='$nuevaComision->fechaModificacion' WHERE id_Comision = '$nuevaComision->idComision';");
        mysqli_close($consulta); #Cerramos la conexión.
    }
    /* public static function obteniendoEstadoComision(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $estadoComisionar = $consulta->query("SELECT estadoComision FROM tbl_comision;
        ");
        $fila = $estadoComisionar->fetch_assoc();
        $estadoComision = array();
        while ($fila = $estadoComisionar->fetch_assoc()) {
            $estadoComision[] = [
                'estadoComisionar' => $fila['estadoComision']
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $estadoComision;

    } */
}
    //convertir la fecha de comision totalm por vendedor en texto

    
    /* public static function obtenerVendedoresComision(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaVendedores = $conexion->query("SELECT rtnCliente, nombre_Usuario FROM tbl_usuario WHERE id_Rol = 2");
        $vendedores = array();
        while ($fila = $listaVendedores->fetch_assoc()) {
            $vendedores[] = [
            'idVendedor' => $fila['id_Usuario'],
            'nombreVendedor' => $fila['nombre_Usuario']
            ];
        }
    
        mysqli_close($conexion); #Cerramos la conexión.
        return $vendedores;
    } */







#Fin de la clase