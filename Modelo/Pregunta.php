<?php

class Pregunta {

    public $idPregunta;
    public $pregunta;
    public $estadoPregunta;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    public static function obtenerPreguntasUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $query = "SELECT id_Pregunta, pregunta, estado FROM tbl_ms_preguntas;";
        $obtenerPreguntas = sqlsrv_query($consulta, $query);
        $preguntas = array();
        while($fila = sqlsrv_fetch_array($obtenerPreguntas, SQLSRV_FETCH_ASSOC)){
            $preguntas [] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"],
                'estadoPregunta' => $fila["estado"]               
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }

    public static function insertarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $pregunta = $insertarPregunta->pregunta;
        $estado = $insertarPregunta->estadoPregunta;
        $CreadoPor = $insertarPregunta->CreadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_ms_preguntas (pregunta, estado, Creado_Por, Fecha_Creacion) VALUES ('$pregunta', '$estado', '$CreadoPor', '$FechaCreacion')";
        $insertarPregunta = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function editarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idPregunta = $insertarPregunta->idPregunta;
        $pregunta = $insertarPregunta->pregunta;
        $estado = $insertarPregunta->estado;
        $ModificadoPor = $insertarPregunta->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_ms_preguntas SET pregunta = '$pregunta', estado = '$estado', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = '$FechaModificacion'
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

    public static function obtenerCantPreguntas(){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query = "SELECT COUNT(id_Pregunta)as cantP FROM tbl_MS_Preguntas";
        $result = sqlsrv_query($conexion, $query);
        $resultArray = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $CantPreguntas = $resultArray['cantP'];  
        sqlsrv_close($conexion);
        return $CantPreguntas;
    } 
}
