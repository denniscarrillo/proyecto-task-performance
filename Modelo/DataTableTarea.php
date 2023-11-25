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

    public static function obtenerTareasPDF($usuario, $buscar){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $select = '';
        $tareas = array();
        if($usuario == 'SUPERADMIN'){
            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.rtn_Cliente COLLATE Latin1_General_CI_AI AS rtn_Cliente, cc.nombre_Cliente COLLATE Latin1_General_CI_AI AS nombre_Cliente, ta.titulo, 
            us.nombre_Usuario AS Creado_Por, 
            DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE CONCAT(ta.id_Tarea, ea.descripcion, cc.rtn_Cliente, cc.nombre_Cliente, ta.titulo,
            us.nombre_Usuario, DATEDIFF(day, ta.Fecha_Creacion, GETDATE())) COLLATE Latin1_General_CI_AI LIKE '%' + '$buscar' + '%'
            UNION
            SELECT ta.id_Tarea, ea.descripcion AS estado, cc.CIF AS rtn_Cliente, cc.NOMBRECLIENTE AS nombre_Cliente, 
            ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN View_Clientes cc ON ta.RTN_Cliente = cc.CIF COLLATE Latin1_General_CI_AI
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE CONCAT(ta.id_Tarea, ea.descripcion, cc.CIF, cc.NOMBRECLIENTE, 
            ta.titulo, us.nombre_Usuario , DATEDIFF(day, ta.Fecha_Creacion, GETDATE())) COLLATE Latin1_General_CI_AI
            LIKE '%' + '$buscar' + '%' COLLATE Latin1_General_CI_AI;";
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
            $select = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.rtn_Cliente, cc.nombre_Cliente , 
            ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE ta.Creado_Por = '$usuario'
            AND CONCAT(ta.id_Tarea, ea.descripcion, cc.rtn_Cliente, cc.nombre_Cliente, 
            ta.titulo, us.nombre_Usuario, DATEDIFF(day, ta.Fecha_Creacion, GETDATE())) COLLATE Latin1_General_CI_AI 
            LIKE '%' + '$buscar' + '%'
            UNION
            SELECT ta.id_Tarea, ea.descripcion AS estado, cc.CIF COLLATE Latin1_General_CS_AI AS rtn_Cliente, 
            cc.NOMBRECLIENTE COLLATE Latin1_General_CS_AI AS nombre_Cliente, 
            ta.titulo, us.nombre_Usuario AS Creado_Por, 
            DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos 
            FROM tbl_Tarea ta
            INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
            INNER JOIN View_Clientes cc ON ta.RTN_Cliente = cc.CIF COLLATE Latin1_General_CS_AI
            INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
            WHERE ta.Creado_Por = '$usuario'
            AND CONCAT(ta.id_Tarea, ea.descripcion, cc.CIF, 
            cc.NOMBRECLIENTE, ta.titulo, us.nombre_Usuario, 
            DATEDIFF(day, ta.Fecha_Creacion, GETDATE())) COLLATE Latin1_General_CI_AI 
            LIKE '%' + '$buscar' + '%' COLLATE Latin1_General_CI_AI;";
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

    
    public static function obtenerTareasId($idTarea){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query1 = "SELECT ta.id_Tarea, ea.descripcion AS estado, cc.rtn_Cliente COLLATE Latin1_General_CI_AI AS rtn_Cliente, cc.nombre_Cliente COLLATE Latin1_General_CI_AI AS nombre_Cliente, 
        ta.titulo, us.nombre_Usuario AS Creado_Por, DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos,ta.estado_Cliente_Tarea AS TipoCliente,
        ta.fecha_Inicio,ta.fecha_Finalizacion,ta.id_ClasificacionLead,cl.nombre AS ClasificacionLead,ta.id_OrigenLead,ol.descripcion AS OrigenLead,
        ta.rubro_Comercial,ta.razon_Social,ta.estado_Finalizacion,ta.Fecha_Creacion,ta.Modificado_Por,ta.Fecha_Modificacion
        FROM tbl_Tarea ta
        INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
        INNER JOIN tbl_CarteraCliente cc ON ta.RTN_Cliente = cc.rtn_Cliente
        INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
        FULL JOIN tbl_ClasificacionLead cl ON ta.id_ClasificacionLead = cl.id_ClasificacionLead
        FULL JOIN tbl_OrigenLead ol ON ta.id_OrigenLead = ol.id_OrigenLead
        WHERE ta.id_Tarea = $idTarea
        UNION
        SELECT ta.id_Tarea, ea.descripcion AS estado,cc.CIF AS rtn_Cliente, cc.NOMBRECLIENTE AS nombre_Cliente, ta.titulo, us.nombre_Usuario AS Creado_Por, 
        DATEDIFF(day, ta.Fecha_Creacion, GETDATE()) AS dias_Transcurridos,ta.estado_Cliente_Tarea AS TipoCliente,ta.fecha_Inicio,ta.fecha_Finalizacion,
        ta.id_ClasificacionLead,cl.nombre AS ClasificacionLead,ta.id_OrigenLead,ol.descripcion AS OrigenLead,ta.rubro_Comercial,ta.razon_Social,
        ta.estado_Finalizacion,ta.Fecha_Creacion,ta.Modificado_Por,ta.Fecha_Modificacion
        FROM tbl_Tarea ta
        INNER JOIN tbl_EstadoAvance ea ON ta.id_EstadoAvance = ea.id_EstadoAvance
        INNER JOIN View_Clientes cc ON ta.RTN_Cliente = cc.CIF COLLATE Latin1_General_CI_AI
        INNER JOIN tbl_MS_Usuario us ON ta.Creado_Por = us.usuario
        FULL JOIN tbl_ClasificacionLead cl ON ta.id_ClasificacionLead = cl.id_ClasificacionLead
        FULL JOIN tbl_OrigenLead ol ON ta.id_OrigenLead = ol.id_OrigenLead
        WHERE ta.id_Tarea = $idTarea";
        $listaTarea = sqlsrv_query($conexion, $query1);
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        $fila = sqlsrv_fetch_array($listaTarea, SQLSRV_FETCH_ASSOC);
        $DatosTarea = [
            'id' => $fila['id_Tarea'],
            'estadoAvance' => $fila['estado'],
            'rtnCliente' =>$fila['rtn_Cliente'],
            'nombreCliente' =>$fila['nombre_Cliente'],
            'titulo' => $fila['titulo'],
            'creadoPor' => $fila['Creado_Por'],
            'diasTranscurridos' => $fila['dias_Transcurridos'],
            'TipoCliente' => $fila["TipoCliente"],
            'fecha_Inicio' => $fila["fecha_Inicio"],
            'fecha_Finalizacion' => $fila["fecha_Finalizacion"],
            'ClasificacionLead' => $fila["ClasificacionLead"],
            'OrigenLead' => $fila["OrigenLead"],
            'rubro_Comercial' => $fila["rubro_Comercial"],
            'razon_Social' => $fila["razon_Social"],
            'estado_Finalizacion' => $fila["estado_Finalizacion"],
            'Fecha_Creacion' => $fila["Fecha_Creacion"],
            'Modificado_Por' => $fila["Modificado_Por"],
            'Fecha_Modificacion' => $fila["Fecha_Modificacion"]
        ];
        $query2= "SELECT id_ProductoInteres, cantidad, id_Articulo, a.ARTICULO, a.MARCA, a.DETALLE, id_Tarea
        FROM tbl_ProductoInteres p
        INNER JOIN view_ARTICULOS a ON p.id_Articulo = a.CODARTICULO 
        WHERE id_Tarea = $idTarea";
        $listaArticulos = sqlsrv_query($conexion, $query2);
        $productos = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaArticulos , SQLSRV_FETCH_ASSOC)){
            $productos [] = [
                'id_ProductoInteres' => $fila["id_ProductoInteres"],
                'cantidad' => $fila["cantidad"],
                'id_Articulo' => $fila["id_Articulo"],
                'ARTICULO' => $fila["ARTICULO"],
                'MARCA' => $fila["MARCA"],
                'DETALLE' => $fila["DETALLE"],
                'id_Tarea' => $fila["id_Tarea"],
            ];
         }
        sqlsrv_close($conexion); #Cerramos la conexión.
        $DatosTarea += [
            'productos' => $productos
        ];
        return $DatosTarea;
    }
    
}