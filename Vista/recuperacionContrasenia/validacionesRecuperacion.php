<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once("enviarCorreo.php");

    $opcion = '';
    $existe = '';
    $mensaje = '';
    session_start();
    if(isset($_POST['radioOption'])){
        $opcion = $_POST['radioOption'];
        $_SESSION['metodo'] = $opcion;
    }
    if(isset($_POST['userName'])){
        $_SESSION['usuario'] = $_POST['userName'];
    }

    if(isset($_POST['submit'])){
        if(isset($_SESSION['usuario']) && isset($_SESSION['metodo'])) {
            $usuario = $_SESSION['usuario'];
            $metodoRec = $_SESSION['metodo'];
            //Si el método es recuperación por correo
            if($metodoRec == 'correo'){
                $correo = ControladorUsuario::obCorreoUsuario($usuario);
                if($correo != ''){
                    //Generamos el token
                    $token = random_int(1000, 9999);
                    //Almacenar token en la base de datos correspondiente al usuario
                    $almacenado = ControladorUsuario::almacenarToken($usuario, $token);
                    if($almacenado){
                        $mensaje = enviarCorreo($correo, $token);
                        header("location:v_SolicitarToken.php");
                    }
                } //Si el método es recuperación por pregunta secreta
                else {
                    $mensaje = "No existe el usuario";
                }
            } else {
                header("location: preguntasResponder.php");
            }
        }
    }



    



