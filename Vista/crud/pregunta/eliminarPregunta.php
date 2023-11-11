<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once("../../../Controlador/ControladorPregunta.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");

    if(isset($_POST['Pregunta'])){
        $pregunta = $_POST['Pregunta'];
        $estadoEliminado = ControladorPregunta::eliminarPregunta($pregunta);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'inactivado'
            ];
            ControladorPregunta::SimularInactivarPregunta($pregunta);
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>