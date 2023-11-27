<?php

class Comision
{
    public $idComision;
    public $idVenta;
    public $idPorcentaje;
    public $comisionTotal;
    public $estadoComision;
    public $estadoLiquidacion;
    public $creadoPor;
    public $ModificadoPor;
    public $fechaComision;
    public $fechaModificacion;

    public static function obtenerTodasLasComisiones()
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision =
            $query = "SELECT co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta, co.estadoComision, 
            co.estado_Liquidacion, co.fecha_Liquidacion, co.Fecha_Creacion, co.estado_Cobro_venta, co.fecha_Cobro, co.metodo_de_Pago
            FROM tbl_Comision AS co
            INNER JOIN VIEW_FACTURASVENTA AS v ON co.id_Venta = v.NUMFACTURA
            INNER JOIN  tbl_Porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje
			WHERE v.TOTALNETO > 0;";
        $listaComision = sqlsrv_query($consulta, $query);
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaComision, SQLSRV_FETCH_ASSOC)) {
            $Comision[] = [
                'idComision' => $fila["id_Comision"],
                'factura' => $fila["id_Venta"],
                'totalVenta' => $fila["TOTALNETO"],
                'porcentaje' => $fila["valor_Porcentaje"],
                'comisionTotal' => $fila["comision_TotalVenta"],
                'estadoComisionar' => $fila["estadoComision"],
                'estadoLiquidacion' => $fila["estado_Liquidacion"],
                'fechaComision' => $fila["Fecha_Creacion"],
                'fechaLiquidacion' => $fila["fecha_Liquidacion"],
                'estadoCobro' => $fila["estado_Cobro_venta"],
                'fechaCobro' => $fila["fecha_Cobro"],
                'metodoPago' => $fila["metodo_de_Pago"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $Comision;
    }
    //funcion para registrar una Comision

    public static function registroNuevaComision($nuevaComision)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        // Preparamos la insercion en la base de datos
        $query = "INSERT INTO tbl_comision (id_Venta, id_Porcentaje, 
        comision_TotalVenta, estadoComision, estado_Liquidacion, Creado_Por, Fecha_Creacion, estado_Cobro_venta, metodo_de_Pago)  
        VALUES ('$nuevaComision->idVenta','$nuevaComision->idPorcentaje','$nuevaComision->comisionTotal', '$nuevaComision->estadoComision',
         '$nuevaComision->estadoLiquidacion', '$nuevaComision->creadoPor', GETDATE(), '$nuevaComision->estadoCobro', '$nuevaComision->metodoPago');";
        // Ejecutamos la consulta y comprobamos si fue exitosa
        sqlsrv_query($conexion, $query);
        $query2 = "SELECT SCOPE_IDENTITY() AS id_Comision";
        $resultadoId = sqlsrv_query($conexion, $query2);
        $fila = sqlsrv_fetch_array($resultadoId, SQLSRV_FETCH_ASSOC);

        $idComision = $fila['id_Comision'];


        sqlsrv_close($conexion); #Cerramos la conexión.
        return $idComision;
    }

    public static function obtenerPorcentajesComision()
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Porcentaje, valor_Porcentaje, descripcion FROM tbl_porcentaje WHERE estado_Porcentaje = 'Activo'";
        $listaPorcentajes = sqlsrv_query($conexion, $query);
        $porcentajes = array();
        while ($fila = sqlsrv_fetch_array($listaPorcentajes, SQLSRV_FETCH_ASSOC)) {
            $porcentajes[] = [
                'idPorcentaje' => $fila['id_Porcentaje'],
                'porcentaje' => $fila['valor_Porcentaje'],
                'descripcion' => $fila['descripcion']
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $porcentajes;
    }

    public static function obtenerVendedores($idTarea)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT vt.id_usuario_vendedor, u.Usuario FROM tbl_vendedores_tarea AS vt
        INNER JOIN tbl_ms_Usuario AS u ON u.id_Usuario = vt.id_usuario_vendedor WHERE vt.id_Tarea = $idTarea;";
        $listaVendedores = sqlsrv_query($conexion, $query);
        $vendedores = array();
        while ($fila = sqlsrv_fetch_array($listaVendedores, SQLSRV_FETCH_ASSOC)) {
            $vendedores[] = [
                'idVendedor' => $fila['id_usuario_vendedor'],
                'nombreVendedor' => $fila['Usuario']
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $vendedores;
    }
    public static function obtenerIdTarea($idFacturaVenta)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Tarea FROM tbl_AdjuntoEvidencia 
        WHERE evidencia = $idFacturaVenta;";
        $consulta = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC);
        $idTarea = $fila['id_Tarea'];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $idTarea;
    }

    public static function calcularComision($porcentaje, $totalVenta)
    {
        $comision[] = [
            'comision' => $totalVenta * $porcentaje
        ];
        return $comision;

    }
    public static function dividirComisionVendedores($comisionTotal, $idComision, $vendedores, $user)
    {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();

        $estadoComisionVendedor = 'Activa';
        $estadoLiquidacion = 'Pendiente';
        $estadoCobro = 'Pendiente Cobro';
        $metodoPago = 'Pendiente';
        $comisionVendedor = $comisionTotal / count($vendedores);

        foreach ($vendedores as $vendedor) {
            $idVendedor = $vendedor['idVendedor'];

            $insert = "INSERT INTO tbl_Comision_Por_Vendedor (id_Comision, id_usuario_vendedor, total_Comision, estadoComisionVendedor, estado_Liquidacion, estado_Cobro_venta, metodo_de_Pago, Creado_Por, Fecha_Creacion) 
                    VALUES ('$idComision', '$idVendedor', '$comisionVendedor', '$estadoComisionVendedor', '$estadoLiquidacion', '$estadoCobro', '$metodoPago', '$user', GETDATE());";

            sqlsrv_query($abrirConexion, $insert);
        }

        sqlsrv_close($abrirConexion);
    }


    public static function actualizarEstadoComisionVendedor($comision)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_usuario_vendedor FROM tbl_comision_por_vendedor WHERE id_Comision = '$comision->idComision';";
        $selectVendedores = sqlsrv_query($conexion, $query);
        // $vendedores = array();
        while ($fila = sqlsrv_fetch_array($selectVendedores, SQLSRV_FETCH_ASSOC)) {
            $idVendedor = intval($fila['id_usuario_vendedor']);
            $insertVendedor = "UPDATE tbl_comision_por_vendedor SET estadoComisionVendedor = '$comision->estadoComision', 
            Modificado_Por = '$comision->ModificadoPor', Fecha_Modificacion = '$comision->fechaModificacion' WHERE id_Comision = '$comision->idComision' AND id_usuario_vendedor = '$idVendedor' ;";
            $query2 = sqlsrv_query($conexion, $insertVendedor);
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
    }
    public static function obtenerComisionesPorVendedor()
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT vt.id_Comision_Por_Vendedor, vt.id_Comision, vt.id_usuario_vendedor, u.usuario, vt.total_Comision, vt.estadoComisionVendedor, 
            vt.estado_Liquidacion, vt.fecha_Liquidacion, vt.Fecha_Creacion, vt.estado_Cobro_venta, vt.fecha_Cobro, vt.metodo_de_Pago
            FROM tbl_ms_usuario AS u
            INNER JOIN tbl_comision_por_vendedor AS vt ON u.id_Usuario = vt.id_usuario_vendedor;";
        $listaComision = sqlsrv_query($consulta, $query);
        $ComisionVendedor = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaComision, SQLSRV_FETCH_ASSOC)) {
            $ComisionVendedor[] = [
                'idComisionVendedor' => $fila["id_Comision_Por_Vendedor"],
                'idComision' => $fila["id_Comision"],
                'idVendedor' => $fila["id_usuario_vendedor"],
                'usuario' => $fila["usuario"],
                'comisionTotal' => $fila["total_Comision"],
                'estadoComision' => $fila["estadoComisionVendedor"],
                'estadoLiquidacion' => $fila["estado_Liquidacion"],
                'estadoCobro' => $fila["estado_Cobro_venta"],
                'metodoPago' => $fila["metodo_de_Pago"],
                'fechaComision' => $fila["Fecha_Creacion"],
                'fechaLiquidacion' => $fila["fecha_Liquidacion"],
                'fechaCobro' => $fila["fecha_Cobro"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ComisionVendedor;
    }
    //funcion que suma todas las comisiones de un vendedor
    public static function sumarComisionesVendedor($fechaDesde, $fechaHasta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.

        $query = "SELECT vt.id_usuario_vendedor, u.usuario, 
    MIN(vt.Fecha_Creacion) AS Fecha_Inicial, MAX(vt.Fecha_Creacion) AS Fecha_Final, 
    SUM(vt.total_Comision) AS totalComision
    FROM tbl_comision_por_vendedor vt
    INNER JOIN tbl_ms_usuario AS u ON vt.id_usuario_vendedor = u.id_Usuario
    WHERE vt.estadoComisionVendedor = 'Activa' AND vt.estado_Liquidacion = 'Pendiente'
      AND vt.Fecha_Creacion BETWEEN '$fechaDesde 00:00:00:00' AND '$fechaHasta 23:59:59:59'
    GROUP BY vt.id_usuario_vendedor, u.Usuario
    ORDER BY Fecha_Inicial, Fecha_Final, totalComision;";


        $sumaComisiones = sqlsrv_query($consulta, $query);

        if (!$sumaComisiones) {
            echo "Error en la consulta SQL: " . sqlsrv_errors();
            return null;
        }

        $totalComision = array();

        while ($fila = sqlsrv_fetch_array($sumaComisiones, SQLSRV_FETCH_ASSOC)) {
            $totalComision[] = [
                'idVendedor' => $fila['id_usuario_vendedor'],
                'nombreVendedor' => $fila['usuario'],
                'fechaDesde' => $fila['Fecha_Inicial']->format('Y-m-d'),
                'fechaHasta' => $fila['Fecha_Final']->format('Y-m-d'), // 'Y-m-d
                // 'estadoComision' => $fila['estadoComisionVendedor'],
                'totalComision' => $fila['totalComision']
            ];
        }

        sqlsrv_close($consulta); #Cerramos la conexión.

        return $totalComision;
    }

    public static function fechasComisiones($fechaDesde, $fechaHasta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT * FROM tbl_comision_por_vendedor WHERE Fecha_Creacion BETWEEN '$fechaDesde' AND '$fechaHasta';
        ";
        $fechasComisiones = sqlsrv_query($consulta, $query);
        $fila = sqlsrv_fetch_array($fechasComisiones, SQLSRV_FETCH_ASSOC);
        $fechaComision = array();
        while ($fila = sqlsrv_fetch_array($fechasComisiones, SQLSRV_FETCH_ASSOC)) {
            $fechaComision[] = [
                'fechaDesde' => $fila['Fecha_Creacion'],
                'fechaHasta' => $fila['Fecha_Creacion']
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $fechaComision;
    }

    public static function obtenerEstadoComision($idVenta)
    {
        $estadoVenta = null;
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_Comision FROM tbl_comision WHERE estadoComision = 'Activa' AND id_Venta = '$idVenta';
        ";
        $estadoComision = sqlsrv_query($consulta, $query);
        $existe = sqlsrv_has_rows($estadoComision);
        if ($existe > 0) {
            $estadoVenta = true;
        } else {
            $estadoVenta = false;
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $estadoVenta;
    }

    public static function editarComision($nuevaComision)
{
    $conn = new Conexion();
    $consulta = $conn->abrirConexionDB(); // Abrimos la conexión a la DB.

    // Obtener el estado_Cobro_venta y fecha_cobro actual
    $queryEstadoActual = "SELECT estado_Cobro_venta, fecha_cobro, estado_Liquidacion, fecha_Liquidacion FROM tbl_comision WHERE id_Comision = '$nuevaComision->idComision';";
    $resultEstadoActual = sqlsrv_query($consulta, $queryEstadoActual);

    if ($resultEstadoActual === false) {
        die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    }

    $rowEstadoActual = sqlsrv_fetch_array($resultEstadoActual);
    $estadoActual = $rowEstadoActual['estado_Cobro_venta'];
    $estadoActual2 = $rowEstadoActual['estado_Liquidacion'];
    $fechaCobroActual = $rowEstadoActual['fecha_cobro'];
    $fechaLiquidacionActual = $rowEstadoActual['fecha_Liquidacion'];

    // Actualizar tbl_comision
    $query1 = "UPDATE tbl_comision 
               SET estado_Liquidacion = '$nuevaComision->estadoLiquidacion', 
                   estado_Cobro_venta = '$nuevaComision->estadoCobro', 
                   metodo_de_Pago = '$nuevaComision->metodoPago', 
                   Modificado_Por ='$nuevaComision->ModificadoPor', 
                   Fecha_Modificacion = GETDATE()";

    // Agregar la condición para actualizar la fecha_Liquidacion solo si estado_Liquidacion cambia
    if ($nuevaComision->estadoLiquidacion != $estadoActual2) {
        $query1 .= ", fecha_Liquidacion = GETDATE()";
    }

    // Agregar la condición para actualizar la fecha_cobro solo si estado_Cobro_venta cambia
    if ($estadoActual != $nuevaComision->estadoCobro) {
        $query1 .= ", fecha_Cobro = GETDATE()";
    }

    $query1 .= " WHERE id_Comision = '$nuevaComision->idComision';";

    $result1 = sqlsrv_query($consulta, $query1);

    if ($result1 === false) {
        die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    }

    // Actualizar tbl_comision_por_vendedor
    $query2 = "UPDATE tbl_comision_por_vendedor 
               SET estado_Cobro_venta = '$nuevaComision->estadoCobro', 
                   metodo_de_Pago = '$nuevaComision->metodoPago', 
                   Modificado_Por ='$nuevaComision->ModificadoPor'";

    // Agregar la condición para actualizar la fecha_cobro solo si estado_Cobro_venta cambia
    if ($estadoActual != $nuevaComision->estadoCobro) {
        $query2 .= ", fecha_cobro = GETDATE()";
    }

    $query2 .= " WHERE id_Comision = '$nuevaComision->idComision';";

    $result2 = sqlsrv_query($consulta, $query2);

    if ($result2 === false) {
        die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    }

    sqlsrv_close($consulta); // Cerramos la conexión.
}

    



    public static function ComisionPorId($idComision)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query1 = "SELECT co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta, co.estadoComision, co.estado_Liquidacion, co.estado_Cobro_venta, co.metodo_de_Pago,  co.fecha_Liquidacion, co.Creado_Por,
            co.Fecha_Creacion, co.fecha_Cobro, co.Modificado_Por, co.Fecha_Modificacion
            FROM tbl_Comision AS co INNER JOIN VIEW_FACTURASVENTA AS v ON co.id_Venta = v.NUMFACTURA
            INNER JOIN  tbl_Porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje
            WHERE co.id_Comision = '$idComision' and TOTALNETO >0;";
        $listaComision = sqlsrv_query($conexion, $query1);
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        $fila = sqlsrv_fetch_array($listaComision, SQLSRV_FETCH_ASSOC);
        $ComisionVer = [
            'idComision' => $fila["id_Comision"],
            'idFactura' => $fila["id_Venta"],
            'ventaTotal' => $fila["TOTALNETO"],
            'valorPorcentaje' => $fila["valor_Porcentaje"],
            'comisionT' => $fila["comision_TotalVenta"],
            'estadoComision' => $fila["estadoComision"],
            'estadoLiquidacion' => $fila["estado_Liquidacion"],
            'estadoCobro' => $fila["estado_Cobro_venta"],
            'metodoPago' => $fila["metodo_de_Pago"],
            'FechaLiquidacion' => $fila["fecha_Liquidacion"],
            'CreadoPor' => $fila["Creado_Por"],
            'FechaComision' => $fila["Fecha_Creacion"],
            'FechaCobro' => $fila["fecha_Cobro"],
            'ModificadoPor' => $fila["Modificado_Por"],
            'FechaModificacion' => $fila["Fecha_Modificacion"]
        ];
        $query2 = "SELECT cp.id_usuario_vendedor, u.usuario, cp.total_Comision
        FROM tbl_Comision_Por_Vendedor AS cp
        INNER JOIN tbl_MS_Usuario AS u ON cp.id_usuario_vendedor = u.id_Usuario
        WHERE cp.id_Comision = $idComision;";
        $listaVendedores = sqlsrv_query($conexion, $query2);
        $vendedores = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaVendedores, SQLSRV_FETCH_ASSOC)) {
            $vendedores[] = [
                'idVendedor' => $fila["id_usuario_vendedor"],
                'nombreVendedor' => $fila["usuario"],
                'comisionVendedor' => $fila["total_Comision"]
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        $ComisionVer += [
            'vendedores' => $vendedores
        ];
        return $ComisionVer;
    }
    public static function eliminarComision($idComision)
    {
        try {
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_Comision WHERE id_Comision = '$idComision';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
        } catch (Exception $e) {
            $estadoEliminado = 'Error SQL:' . $e;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }
    public static function anularComision($idComision)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_Comision SET estadoComision = 'Anulada', estado_Liquidacion = 'Cancelada' WHERE id_Comision = '$idComision';";
        $estadoAnulada = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoAnulada;
    }
    public static function anularComisionPorVendedor($idComision)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "UPDATE tbl_Comision_Por_Vendedor SET estadoComisionVendedor = 'Anulada', estado_Liquidacion = 'Cancelada' WHERE id_Comision = '$idComision';";
        $estadoAnulada = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoAnulada;
    }
    public static function obtenerTodasLasComisionesPdf($buscar)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $listaComision =
            $query = "SELECT co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta, co.estadoComision, co.estado_Liquidacion,
            co.estado_Cobro_Venta, co.metodo_de_Pago, co.fecha_Liquidacion,
             co.Fecha_Creacion, co.fecha_Cobro FROM tbl_Comision AS co
            INNER JOIN VIEW_FACTURASVENTA AS v ON co.id_Venta = v.NUMFACTURA
            INNER JOIN  tbl_Porcentaje AS po ON co.id_Porcentaje = po.id_Porcentaje
            WHERE CONCAT(co.id_Comision, co.id_Venta, v.TOTALNETO, po.valor_Porcentaje, co.comision_TotalVenta, co.estadoComision, co.estado_Liquidacion, co.estado_Cobro_Venta, co.metodo_de_Pago, co.fecha_Liquidacion, co.Fecha_Creacion, co.fecha_Cobro)
            LIKE '%' + '$buscar' + '%' AND v.TOTALNETO > 0;";
        $listaComision = sqlsrv_query($consulta, $query);
        $Comision = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaComision, SQLSRV_FETCH_ASSOC)) {
            $Comision[] = [
                'idComision' => $fila["id_Comision"],
                'factura' => $fila["id_Venta"],
                'totalVenta' => $fila["TOTALNETO"],
                'porcentaje' => $fila["valor_Porcentaje"],
                'comisionTotal' => $fila["comision_TotalVenta"],
                'estadoComisionar' => $fila["estadoComision"],
                'estadoLiquidacion' => $fila["estado_Liquidacion"],
                'estadoCobro' => $fila["estado_Cobro_Venta"],
                'metodoPago' => $fila["metodo_de_Pago"],
                'fechaComision' => $fila["Fecha_Creacion"],
                'fechaLiquidacion' => $fila["fecha_Liquidacion"],
                'fechaCobro' => $fila["fecha_Cobro"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $Comision;
    }
    public static function obtenerComisionesPorVendedorPdf($buscar)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT vt.id_Comision_Por_Vendedor, vt.id_Comision, vt.id_usuario_vendedor, u.usuario, vt.total_Comision,
             vt.estadoComisionVendedor, vt.estado_Liquidacion, vt.estado_Cobro_venta, vt.metodo_de_Pago ,vt.fecha_Liquidacion, vt.Fecha_Creacion, vt.fecha_Cobro FROM tbl_ms_usuario AS u
            INNER JOIN tbl_comision_por_vendedor AS vt ON u.id_Usuario = vt.id_usuario_vendedor
            WHERE CONCAT(vt.id_Comision_Por_Vendedor, vt.id_Comision, vt.id_usuario_vendedor, u.usuario, vt.total_Comision, vt.estadoComisionVendedor, vt.estado_Liquidacion, vt.estado_Cobro_venta, vt.metodo_de_Pago ,vt.fecha_Liquidacion, vt.Fecha_Creacion, vt.fecha_Cobro)
            LIKE '%' + '$buscar' + '%';";
        $listaComision = sqlsrv_query($consulta, $query);
        $ComisionVendedor = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while ($fila = sqlsrv_fetch_array($listaComision, SQLSRV_FETCH_ASSOC)) {
            $ComisionVendedor[] = [
                'idComisionVendedor' => $fila["id_Comision_Por_Vendedor"],
                'idComision' => $fila["id_Comision"],
                'idVendedor' => $fila["id_usuario_vendedor"],
                'usuario' => $fila["usuario"],
                'comisionTotal' => $fila["total_Comision"],
                'estadoComision' => $fila["estadoComisionVendedor"],
                'estadoLiquidacion' => $fila["estado_Liquidacion"],
                'estadoCobro' => $fila["estado_Cobro_venta"],
                'metodoPago' => $fila["metodo_de_Pago"],
                'fechaComision' => $fila["Fecha_Creacion"],
                'fechaLiquidacion' => $fila["fecha_Liquidacion"],
                'fechaCobro' => $fila["fecha_Cobro"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ComisionVendedor;
    }
    public static function liquidarComisiones($fechaDesde, $fechaHasta)
    {
        $conn = new Conexion();
        $abrirConexion = $conn->abrirConexionDB();
        $estadoLiquidacion = 'Liquidada';
        $mensaje = '';

        try {
            // Configura el manejo de fechas de SQL Server
            // $querySetDateFormat = "SET DATEFORMAT ymd;";
            // sqlsrv_query($abrirConexion, $querySetDateFormat);

            // Inicia una transacción
            sqlsrv_begin_transaction($abrirConexion);

            // Actualiza el estado de liquidación en la tabla tbl_comision_por_vendedor
            $query2 = "UPDATE tbl_Comision_Por_Vendedor 
                       SET estado_Liquidacion = '$estadoLiquidacion', fecha_Liquidacion = GETDATE() 
                       WHERE id_Comision IN (
                           SELECT id_Comision
                           FROM tbl_Comision
                           WHERE estadoComision = 'Activa' AND estado_Liquidacion = 'Pendiente'
                             AND fecha_Creacion BETWEEN '$fechaDesde 00:00:00:000' AND '$fechaHasta 23:59:59:999'
                       );";
            // var_dump($query2);

            $result2 = sqlsrv_query($abrirConexion, $query2);

            if ($result2 === false) {
                throw new Exception("Error en la consulta 1: " . print_r(sqlsrv_errors(), true));
            }

            // Actualiza el estado de liquidación en la tabla tbl_comision
            $query3 = "UPDATE tbl_Comision 
                       SET estado_Liquidacion = '$estadoLiquidacion', fecha_Liquidacion = GETDATE() 
                       WHERE estadoComision = 'Activa' AND estado_Liquidacion = 'Pendiente'
                         AND fecha_Creacion BETWEEN '$fechaDesde 00:00:00:000' AND '$fechaHasta 23:59:59:999';";

            $result3 = sqlsrv_query($abrirConexion, $query3);

            if ($result3 === false) {
                throw new Exception("Error en la consulta 2: " . print_r(sqlsrv_errors(), true));
            }

            // Si ambos updates fueron exitosos, confirma la transacción
            sqlsrv_commit($abrirConexion);
            $mensaje = "Comisiones liquidadas correctamente update";

        } catch (Exception $e) {
            // Maneja excepciones
            $mensaje = "Error: " . $e->getMessage();
            sqlsrv_rollback($abrirConexion);

        } finally {
            // Cierra la conexión después de la transacción
            sqlsrv_close($abrirConexion);

            // Devuelve el mensaje al final
            echo json_encode(array('success' => true, 'message' => $mensaje));
        }

    }
    public static function Comisiones_a_Liquidar($fechaDesde, $fechaHasta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.

        $query = "SELECT id_Comision, id_Venta, comision_TotalVenta, estadoComision, estado_Liquidacion, estado_Cobro_venta FROM tbl_Comision
        WHERE estadoComision = 'Activa' AND estado_Liquidacion = 'Pendiente' AND estado_Cobro_venta = 'Cobrada' 
        AND Fecha_Creacion BETWEEN '$fechaDesde 00:00:00:00' AND '$fechaHasta 23:59:59:59';";
        $fechasComisiones = sqlsrv_query($consulta, $query);
        $comisiones_a_Liquidar = array();

        while ($fila = sqlsrv_fetch_array($fechasComisiones, SQLSRV_FETCH_ASSOC)) {
            $comisiones_a_Liquidar[] = [
                'idComision' => $fila['id_Comision'],
                'idVenta' => $fila['id_Venta'],
                'comisionTotal' => $fila['comision_TotalVenta'],
                'estadoComision' => $fila['estadoComision'],
                'estadoCobro' => $fila['estado_Cobro_venta']
            ];
        }

        sqlsrv_close($consulta); #Cerramos la conexión.

        return $comisiones_a_Liquidar;
    }



}

#Fin de la clase