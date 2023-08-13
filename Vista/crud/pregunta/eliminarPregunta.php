<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once("../../../Controlador/ControladorPregunta.php");

    if(isset($_POST['pregunta'])){
        $pregunta = $_POST['pregunta'];
        $estadoEliminado = ControladorPregunta::eliminandoPregunta($pregunta);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>