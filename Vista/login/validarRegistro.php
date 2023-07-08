<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");

    $mensaje = "";
    if(isset($_POST['nuevoUsuario'])){ 
        $data = array();
        $usuario = $_POST['nuevoUsuario'];
        $userExiste = ControladorUsuario::registro($usuario);
        if($userExiste>0){
            $data [] = [
                'usuario'=> $userExiste
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }else{
            $data [] = [
                'usuario'=> 0
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
    if(isset($_POST["submit"])){
        $nuevoUsuario = new Usuario();
        $nuevoUsuario->usuario = $_POST["usuario"];
        $nuevoUsuario->nombre = $_POST["nombre"];
        $nuevoUsuario->idEstado= 1; 
        $nuevoUsuario->contrasenia = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
        $nuevoUsuario->correo = $_POST["correoElectronico"]; 
        $nuevoUsuario->idRol = 1; 
        
        ControladorUsuario::registroUsuario($nuevoUsuario);
        $mensaje = "Registro éxitoso";
    }


    /* if(isset($_POST["submit"])){
        $usuario = $_POST['usuario'];
            $existe = ControladorUsuario::registro($usuario);
            if($existe == ''){
                $usuario = $existe;
                $mensaje = '';
                header("location:registro.php");}
               
        else{
            $mensaje = "Este Usuario ya Existe";}
        }
 */
    
