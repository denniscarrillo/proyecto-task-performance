<?php

class DataTableTarea
{
    public $idTarea;
    public $idEstadoAvance;
    public $titulo;
    public $descripcion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerTodasTareasUsuario($usuario){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $select = '';
        $tareas = array();
        if($usuario == 'SUPERADMIN'){
            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.rtn_Cliente, cc.nombre_Cliente, ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario;";
            $ejecutar = sqlsrv_query($conexion, $select);
            if(sqlsrv_has_rows($ejecutar)){
                while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                    $tareas[] = [
                        'id' => $fila['id_Tarea'],
                        'estadoAvance' => $fila['estado'],
                        'rtnCliente' =>$fila['rtn_Cliente'],
                        'nombreCliente' =>$fila['nombre_Cliente'],
                        'titulo' => $fila['titulo'],
                        'creadoPor' => $fila['Creado_Por'],
                        'diasTranscurridos' => $fila['dias_Transcurridos']
                    ];
                }
            }

            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.CIF AS rtn_Cliente, cc.NOMBRECLIENTE AS nombre_Cliente, ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN View_Clientes cc ON ta.RTN_Cliente = cc.CIF COLLATE Latin1_General_CS_AI
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario;";
            $ejecutar = sqlsrv_query($conexion, $select);
            if(sqlsrv_has_rows($ejecutar)){
                while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                    $tareas[] = [
                        'id' => $fila['id_Tarea'],
                        'estadoAvance' => $fila['estado'],
                        'rtnCliente' =>$fila['rtn_Cliente'],
                        'nombreCliente' =>$fila['nombre_Cliente'],
                        'titulo' => $fila['titulo'],
                        'creadoPor' => $fila['Creado_Por'],
                        'diasTranscurridos' => $fila['dias_Transcurridos']
                    ];
                }
            }
        }else{
            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.rtn_Cliente, cc.nombre_Cliente, ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE ta.Creado_Por = '$usuario';";
            $ejecutar = sqlsrv_query($conexion, $select);
            if(sqlsrv_has_rows($ejecutar)){
                while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                    $tareas[] = [
                        'id' => $fila['id_Tarea'],
                        'estadoAvance' => $fila['estado'],
                        'rtnCliente' =>$fila['rtn_Cliente'],
                        'nombreCliente' =>$fila['nombre_Cliente'],
                        'titulo' => $fila['titulo'],
                        'creadoPor' => $fila['Creado_Por'],
                        'diasTranscurridos' => $fila['dias_Transcurridos']
                    ];
                }
            }
            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.CIF AS rtn_Cliente, cc.NOMBRECLIENTE AS nombre_Cliente, ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN View_Clientes cc ON ta.RTN_Cliente = cc.CIF COLLATE Latin1_General_CS_AI
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE ta.Creado_Por = '$usuario';";
            $ejecutar = sqlsrv_query($conexion, $select);
            if(sqlsrv_has_rows($ejecutar)){
                while($fila = sqlsrv_fetch_array($ejecutar, SQLSRV_FETCH_ASSOC)){
                    $tareas[] = [
                        'id' => $fila['id_Tarea'],
                        'estadoAvance' => $fila['estado'],
                        'rtnCliente' =>$fila['rtn_Cliente'],
                        'nombreCliente' =>$fila['nombre_Cliente'],
                        'titulo' => $fila['titulo'],
                        'creadoPor' => $fila['Creado_Por'],
                        'diasTranscurridos' => $fila['dias_Transcurridos']
                    ];
                }
            }
        }
        sqlsrv_close($conexion);
        return $tareas;
    }


    public static function obtenerTareasPDF($User, $buscar)
    {
        $tareasUsuario = null;
        try {
            $tareasUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $consultaridUser ="SELECT id_Usuario FROM tbl_MS_Usuario WHERE usuario = '$User'";
            $resultadoId = sqlsrv_query($abrirConexion, $consultaridUser);
            $filaId = sqlsrv_fetch_array($resultadoId, SQLSRV_FETCH_ASSOC);
            $idUser = $filaId['id_Usuario'];
            $query = "SELECT t.id_Tarea, t.titulo, e.descripcion as Estado_Tarea, t.estado_Finalizacion  
            FROM tbl_vendedores_tarea AS vt
            INNER JOIN tbl_tarea AS t ON t.id_Tarea = vt.id_Tarea
            INNER JOIN tbl_estadoavance AS e ON t.id_EstadoAvance = e.id_EstadoAvance
            WHERE vt.id_usuario_vendedor = '$idUser' and 
            CONCAT(t.id_Tarea, t.titulo, e.descripcion, t.estado_Finalizacion) LIKE '%' + '$buscar' + '%';";

            $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $tareasUsuario[] = [
                    'id_Tarea' => $fila['id_Tarea'],
                    'titulo' => $fila['titulo'],
                    'descripcion' => $fila['Estado_Tarea'],
                    'estado_Finalizacion' => $fila['estado_Finalizacion']
                ];
            }
        } catch (Exception $e) {
            $tareasUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $tareasUsuario;
    } 
}