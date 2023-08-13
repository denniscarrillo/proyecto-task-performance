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
        $obtenerPreguntas = $consulta->query("SELECT id_Pregunta, pregunta FROM tbl_ms_preguntas");
        $preguntas = array();
        while($fila = $obtenerPreguntas->fetch_assoc()){
            $preguntas [] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"]
                
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }

    public static function insertarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $pregunta = $insertarPregunta->pregunta;
        $CreadoPor = $insertarPregunta->CreadoPor;
        $FechaCreacion = $insertarPregunta->FechaCreacion;
        $insertarPregunta = $consulta->query("INSERT INTO tbl_ms_preguntas (pregunta, Creado_Por, Fecha_Creacion) VALUES ('$pregunta', '$CreadoPor', '$FechaCreacion')");
        mysqli_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function editarPregunta($insertarPregunta){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idPregunta = $insertarPregunta->idPregunta;
        $pregunta = $insertarPregunta->pregunta;
        $ModificadoPor = $insertarPregunta->ModificadoPor;
        $FechaModificacion = $insertarPregunta->FechaModificacion;
        $insertarPregunta = $consulta->query("UPDATE tbl_ms_preguntas SET pregunta = '$pregunta', Modificado_Por = '$ModificadoPor', Fecha_Modificacion = '$FechaModificacion'
         WHERE id_Pregunta = '$idPregunta'");
        mysqli_close($consulta); #Cerramos la conexión.
        return $insertarPregunta;
    }

    public static function eliminarPregunta($pregunta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $consultaIdPregunta = $conexion->query("SELECT id_Pregunta FROM tbl_ms_preguntas WHERE pregunta = '$pregunta'");
        $fila = $consultaIdPregunta->fetch_assoc();
        $idPregunta = $fila['id_Pregunta'];
        //Eliminamos la pregunta
        $estadoEliminado = $conexion->query("DELETE FROM tbl_ms_preguntas WHERE id_Pregunta = '$idPregunta'");
        mysqli_close($conexion); #Cerramos la conexión.
        return $estadoEliminado;
    }
}
