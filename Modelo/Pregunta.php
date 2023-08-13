<?php

class Pregunta {

    public static function obtenerPreguntasUsuario(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $obtenerPreguntas = $consulta->query("SELECT id_Pregunta, pregunta FROM tbl_ms_preguntas");
        $roles = array();
        while($fila = $obtenerPreguntas->fetch_assoc()){
            $preguntas [] = [
                'id_Pregunta' => $fila["id_Pregunta"],
                'pregunta' => $fila["pregunta"]
                
            ];
        }
        mysqli_close($consulta); #Cerramos la conexión.
        return $preguntas;
    }
}
