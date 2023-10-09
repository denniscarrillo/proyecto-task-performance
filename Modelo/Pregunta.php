<?php

class Pregunta {

    public $idPregunta;
    public $pregunta;
    public $respuesta;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    public static function obtenerPreguntasUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT id_Pregunta, pregunta FROM tbl_ms_preguntas";
        $obtenerPreguntas = sqlsrv_query($consulta, $query);
        $preguntas = array();
        while($fila = sqlsrv_fetch_array($obtenerPreguntas, SQLSRV_FETCH_ASSOC)){
            $preguntas [] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"]               
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }

    public static function insertarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $pregunta = $insertarPregunta->pregunta;
        $CreadoPor = $insertarPregunta->CreadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_ms_preguntas (pregunta, Creado_Por, Fecha_Creacion) VALUES ('$pregunta', '$CreadoPor', '$FechaCreacion')";
        $insertarPregunta = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function editarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idPregunta = $insertarPregunta->idPregunta;
        $pregunta = $insertarPregunta->pregunta;
        $ModificadoPor = $insertarPregunta->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_ms_preguntas SET pregunta = '$pregunta', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = '$FechaModificacion'
         WHERE id_Pregunta = '$idPregunta'";
        $insertarPregunta = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function eliminarPregunta($pregunta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT id_Pregunta FROM tbl_ms_preguntas WHERE pregunta = '$pregunta'";
        $consultaIdPregunta = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($consultaIdPregunta, SQLSRV_FETCH_ASSOC);
        $idPregunta = $fila['id_Pregunta'];
        //Eliminamos la pregunta
        $query2 = "DELETE FROM tbl_ms_preguntas WHERE id_Pregunta = '$idPregunta'";
        $estadoEliminado = sqlsrv_query($conexion, $query2);
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }

    public static function preguntaExistente($pregunta){
        $existePregunta = false;
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT pregunta FROM tbl_MS_Preguntas WHERE pregunta = '$pregunta'";
        $preguntas = sqlsrv_query($conexion, $query);
        $existe = sqlsrv_has_rows($preguntas);
        if($existe){
            $existePregunta = true;
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $existePregunta;
    }

    public static function obtenerPreguntasXusuario($Usuario) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT p.pregunta, pu.respuesta FROM tbl_MS_Preguntas AS p
            INNER JOIN tbl_MS_Preguntas_X_Usuario AS pu ON p.id_Pregunta = pu.id_Pregunta
            INNER JOIN tbl_MS_Usuario AS u ON u.id_Usuario = pu.id_Usuario
            WHERE u.usuario = '$Usuario';";   
        $listaP = sqlsrv_query($conexion, $query);
        $listaPreguntas = array();
        while ($arrayPreguntas = sqlsrv_fetch_array($listaP, SQLSRV_FETCH_ASSOC)) {
            $listaPreguntas['preguntas'][] = $arrayPreguntas['pregunta'];
            $listaPreguntas['respuestas'][]= $arrayPreguntas['respuesta'];
            
        }
        sqlsrv_close($conexion); // Cerramos la conexión.
        return $listaPreguntas;
    }

    //  public static function actualizarRespuesta($Usuario, $respuestas) {
    //       $conn = new Conexion();
    //    $conexion = $conn->abrirConexionDB();
    //       $respuesta=$Usuario->respuesta;
    //       $idPregunta=$Usuario->idPregunta;
    //       $query = "UPDATE tbl_MS_Preguntas_X_Usuario SET respuesta = '$respuesta' 
    //       WHERE Creado_Por = '$Usuario' AND id_Pregunta = '$idPregunta';";
    //       sqlsrv_query($conexion, $query);
    //       sqlsrv_close($conexion);
    //   }
      public static function actualizarRespuesta($Usuario, $respuestas) {
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
    
        // Recorrer la matriz de respuestas y actualizar cada respuesta
        foreach ($respuestas as $indice => $nuevaRespuesta) {
            $idPregunta = $Usuario[$indice]['idPregunta']; // Supongo que tienes un índice para relacionar las respuestas con las preguntas
    
            // Realizar la actualización para cada respuesta
            $query = "UPDATE tbl_MS_Preguntas_X_Usuario SET respuesta ='$respuesta'  WHERE Creado_Por = '$Usuario' AND id_Pregunta = '$idPregunta';";
            $params = array($nuevaRespuesta, $Usuario, $idPregunta);
    
            $stmt = sqlsrv_prepare($conexion, $query, $params);
            if (sqlsrv_execute($stmt)) {
                // Éxito: la respuesta se actualizó correctamente
            } else {
                // Manejar errores en la actualización
                echo "Error en la actualización: " . sqlsrv_errors();
            }
    
            sqlsrv_free_stmt($stmt);
        }
    
        sqlsrv_close($conexion);
    }
    




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
