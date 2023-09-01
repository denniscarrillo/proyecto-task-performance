<?php

class Pregunta {

    public $idPregunta;
    public  $pregunta;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    public static function obtenerPreguntasUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $obtenerPreguntas = "SELECT id_Pregunta, pregunta FROM tbl_ms_preguntas";
        $query = sqlsrv_query($consulta, $obtenerPreguntas);
        $preguntas = array();
        while($fila = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
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
        $FechaCreacion = $insertarPregunta->FechaCreacion;
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
        $FechaModificacion = $insertarPregunta->FechaModificacion;
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
}
