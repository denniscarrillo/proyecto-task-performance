<?php

class Pregunta
{

    public $idPregunta;
    public $pregunta;
    public $estadoPregunta;
    public $respuesta;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    public static function obtenerPreguntasUsuario()
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT ROW_NUMBER() OVER(ORDER BY id_Pregunta ASC) AS Num, id_Pregunta, pregunta, estado FROM tbl_ms_preguntas;";
        $obtenerPreguntas = sqlsrv_query($consulta, $query);
        $preguntas = array();
        while ($fila = sqlsrv_fetch_array($obtenerPreguntas, SQLSRV_FETCH_ASSOC)) {
            $preguntas[] = [
                'item' => $fila["Num"],
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"],
                'estadoPregunta' => $fila["estado"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }

    public static function insertarPregunta($insertarPregunta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $pregunta = $insertarPregunta->pregunta;
        $estado = $insertarPregunta->estadoPregunta;
        $CreadoPor = $insertarPregunta->CreadoPor;
        $ModificadorPor = $insertarPregunta->ModificadoPor;
        $query = "INSERT INTO tbl_ms_preguntas (pregunta, estado, Creado_Por, Fecha_Creacion, Modificado_Por, Fecha_Modificacion) VALUES ('$pregunta', '$estado', '$CreadoPor', GETDATE(), '$ModificadorPor', GETDATE())";
        $insertarPregunta = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function editarPregunta($insertarPregunta)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idPregunta = $insertarPregunta->idPregunta;
        $pregunta = $insertarPregunta->pregunta;
        $estado = $insertarPregunta->estado;
        $ModificadoPor = $insertarPregunta->ModificadoPor;
        $query = "UPDATE tbl_ms_preguntas SET pregunta = '$pregunta', estado = '$estado', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE()
         WHERE id_Pregunta = '$idPregunta'";
        $insertarPregunta = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }
    public static function eliminarPregunta($pregunta)
    {
        try {
            $conn = new Conexion();
            $conexion = $conn->abrirConexionDB();
            $query = "DELETE FROM tbl_MS_Preguntas WHERE id_Pregunta = '$pregunta';";
            $estadoEliminado = sqlsrv_query($conexion, $query);
            if (!$estadoEliminado) {
                return false;
            }
            sqlsrv_close($conexion); //Cerrar conexion
            return true;
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
    }

    public static function preguntaExistente($pregunta)
    {
        $existePregunta = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT pregunta FROM tbl_MS_Preguntas WHERE pregunta = '$pregunta'";
        $preguntas = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($preguntas);
        if ($existe) {
            $existePregunta = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existePregunta;
    }

    public static function obtenerCantPreguntas()
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT COUNT(id_Pregunta)as cantP FROM tbl_MS_Preguntas WHERE estado = 'Activa'";
        $result = sqlsrv_query($conexion, $query);
        $resultArray = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $CantPreguntas = $resultArray['cantP'];
        sqlsrv_close($conexion);
        return $CantPreguntas;
    }


    public static function obtenerPreguntasXusuario($Usuario)
    {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT p.id_Pregunta, p.pregunta, pu.respuesta FROM tbl_MS_Preguntas AS p
            INNER JOIN tbl_MS_Preguntas_X_Usuario AS pu ON p.id_Pregunta = pu.id_Pregunta
            INNER JOIN tbl_MS_Usuario AS u ON u.id_Usuario = pu.id_Usuario
            WHERE u.usuario = '$Usuario';";
        $listaP = sqlsrv_query($conexion, $query);
        $listaPreguntas = array();
        while ($arrayPreguntas = sqlsrv_fetch_array($listaP, SQLSRV_FETCH_ASSOC)) { 
            $listaPreguntas[]=[
            'idpregunta' =>$arrayPreguntas['id_Pregunta'],
            'preguntas' =>$arrayPreguntas['pregunta'],
            'respuestas' =>$arrayPreguntas['respuesta'],
            ];
        }
        sqlsrv_close($conexion); // Cerramos la conexión.
        return $listaPreguntas;
    }

    public static function actualizarRespuesta($respuestas,$user) {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        foreach ($respuestas as $respuesta) {
            $idPreguntaRespuesta = $respuesta['idpregunta'];
            $respuestaTexto = $respuesta['respuesta'];
            // Construir la consulta SQL para actualizar la respuesta
            $query = "UPDATE tbl_MS_Preguntas_X_Usuario SET respuesta = '$respuestaTexto', Modificado_Por = '$user', Fecha_Modificacion = GETDATE()  WHERE id_Pregunta = '$idPreguntaRespuesta'";
            // Ejecutar la consulta SQL
            $resultado = sqlsrv_query($consulta, $query);
        }
        sqlsrv_close($consulta); // Cerramos la conexión.
    }
    
    
      
    
    public static function obtenerPreguntasUsuarioPDF($buscar)
    {
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT id_Pregunta, pregunta, estado FROM tbl_ms_preguntas
        WHERE CONCAT(id_Pregunta, pregunta, estado) LIKE '%' + '$buscar' + '%';";
        $obtenerPreguntas = sqlsrv_query($consulta, $query);
        $preguntas = array();
        while ($fila = sqlsrv_fetch_array($obtenerPreguntas, SQLSRV_FETCH_ASSOC)) {
            $preguntas[] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"],
                'estadoPregunta' => $fila["estado"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }
    public static function validarPreguntaExistente($pregunta){
        $estadoPregunta = false;
        try{
            $preguntaExistente = array();
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $selectCliente = "SELECT pregunta FROM tbl_MS_Preguntas WHERE pregunta = '$pregunta';";
            $consulta = sqlsrv_query($abrirConexion, $selectCliente);
            if(sqlsrv_has_rows($consulta)){
                while($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
                    $preguntaExistente = [
                        'pregunta' => $fila['pregunta']
                    ];
                }
                sqlsrv_close($abrirConexion); //Cerrar conexion
                return $preguntaExistente;
            } else {
               return $estadoPregunta;
            }
        }catch(Exception $e){
            echo 'Error SQL:' . $e;
        }
    }


    // ControladorPregunta.php




    // public static function verificarPreguntaActiva($idPregunta) {
    //     try {
    //         $conn = new Conexion();
    //         $conexion = $conn->abrirConexionDB();

    //         $query = "SELECT estado FROM tbl_MS_Preguntas WHERE id_Pregunta = '$idPregunta';";

    //         $stmt = sqlsrv_prepare($conexion, $query, array(&$idPregunta));

    //         if (sqlsrv_execute($stmt)) {
    //             if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    //                 $estado = $row['estado'];
    //                 return $estado == 'Activo';
    //             }
    //         }
    //     } catch (Exception $e) {
    //         // Manejar el error, loggearlo, etc.
    //     } finally {
    //         sqlsrv_close($conexion);
    //     }

    //     return false;
    // }

    // ...






    // public static function actualizarRespuesta($Usuario, $respuestas) {
    //      $conn = new Conexion();
    //      $conexion = $conn->abrirConexionDB();

    //      // Recorre las respuestas y actualiza cada una
    //      foreach ($respuestas as $idPregunta => $respuesta) {
    //          // Evita la posibilidad de inyección SQL utilizando sentencias preparadas
    //          $query = "UPDATE tbl_MS_Preguntas_X_Usuario SET respuesta = '$respuesta' WHERE Creado_Por = '$Usuario' AND id_Pregunta = '$idPregunta';";

    //          $params = array($respuesta, $Usuario->usuario, $idPregunta);

    //          $stmt = sqlsrv_prepare($conexion, $query, $params);

    //          if (sqlsrv_execute($stmt) === false) {
    //              die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    //          }
    //      }

    //      sqlsrv_close($conexion);
    //  }

}