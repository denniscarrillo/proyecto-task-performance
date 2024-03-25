<?php

class DataTableObjeto
{
    public $id_Objeto;
    public $objeto;
    public $descripcion;
    public $tipo_Objeto;
    
    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerObjetos()
    {
        $ObjetoUsuario = null;
        try {
            $objetoUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = " SELECT ROW_NUMBER() OVER(ORDER BY id_Objeto ASC) AS Num, id_Objeto,objeto,descripcion,tipo_Objeto FROM tbl_MS_Objetos";
           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $ObjetoUsuario[] = [
                    'item' => $fila['Num'],
                    'id_Objeto' => $fila['id_Objeto'],
                    'objeto' => $fila['objeto'],
                    'descripcion' => $fila['descripcion'],
                    'tipo_Objeto' => $fila['tipo_Objeto'],
                    // 'Creado_Por' => $fila['Creado_Por'],
                    // 'fechaCreacion' => $fila['Fecha_Creacion']

                ];
            }
        } catch (Exception $e) {
            $ObjetoUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $ObjetoUsuario;
    } 
    public static function obtenerIdObjetos()
    {
        $idObjeto = array();
        try {
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT id_Objeto FROM tbl_MS_Objetos WHERE objeto NOT IN('login.php', 'configRespuestas.php', 'v_nuevaContrasenia.php', 'preguntasResponder.php', 'index.php');";
            $resultado = sqlsrv_query($abrirConexion, $query);
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $idObjeto[] = [
                    'id_Objeto' => $fila['id_Objeto']
                ];
            }
        } catch (Exception $e) {
            $idObjeto = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $idObjeto;
    }
    public static function obtenerObjetosPdf($buscar)
    {
        $ObjetoUsuario = null;
        try {
            
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT id_Objeto, objeto, descripcion, tipo_Objeto
            FROM tbl_MS_Objetos
            WHERE CONCAT(id_Objeto, objeto, descripcion, tipo_Objeto)
            LIKE '%' + '$buscar' + '%';";
           $resultado = sqlsrv_query($abrirConexion, $query);
           $ObjetoUsuario = array();
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $ObjetoUsuario[] = [
                    'id_Objeto' => $fila['id_Objeto'],
                    'objeto' => $fila['objeto'],
                    'descripcion' => $fila['descripcion'],
                    'tipo_Objeto' => $fila['tipo_Objeto']

                ];
            }
        } catch (Exception $e) {
            $ObjetoUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $ObjetoUsuario;
    } 

    public static function CrearObjeto($nuevoObjeto){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $objeto = $nuevoObjeto->objeto;
        $descripcion = $nuevoObjeto->descripcion;
        $CreadoPor = $nuevoObjeto->CreadoPor;
        $query = "INSERT INTO tbl_MS_Objetos (objeto, descripcion, tipo_Objeto, Creado_Por, Fecha_Creacion) 
        VALUES ('$objeto', '$descripcion', 'PANTALLA', '$CreadoPor', GETDATE())";
        $insertarObjeto= sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarObjeto;
    }

    public static function editarObjeto($editarObjeto){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $update = "UPDATE tbl_MS_Objetos SET descripcion='$editarObjeto->descripcion',Modificado_Por='$editarObjeto->Modificado_Por', Fecha_Modificacion = GETDATE() 
            WHERE id_Objeto='$editarObjeto->id_Objeto'";
            sqlsrv_query($abrirConexion, $update);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
    }

    public static function eliminarObjeto($id_Objeto){
        try {
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_MS_Objetos WHERE id_Objeto = '$id_Objeto' 
                AND objeto NOT IN('LOGIN.PHP','CONFIGRESPUESTAS.PHP', 'V_NUEVACONTRASENIA.PHP', 'PREGUNTASRESPONDER.PHP', 'INDEX.PHP');";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if ($estadoEliminado === false) {
                return false;
            }
            $rowsAffected = sqlsrv_rows_affected($estadoEliminado);
            if ($rowsAffected == 0) {
                return false; // No hay filas afectadas, no se elimina nada
            }
            sqlsrv_close($conexion); // Close the connection
            return true;
        } catch (Exception $e) {
            // Handle other exceptions if needed
            $estadoEliminado = 'Error SQL:' . $e;
            return false;
        }
    }
    
}