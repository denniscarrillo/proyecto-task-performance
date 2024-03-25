<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Rol.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Permiso.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorRol.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    require_once("../../../Controlador/ControladorDataTableObjeto.php");
    require_once("../../../Controlador/ControladorPermiso.php");

    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        //Se crea el nuevo rol
        $user = $_SESSION['usuario'];
        $nuevoRol = new Rol();
        $nuevoRol->rol = $_POST['rolUsuario'];
        $nuevoRol->descripcion = $_POST['descripcionRol'];
        $nuevoRol->creadoPor = $user;
        $nuevoRol->ModificadoPor = $user;
        //Se insertan los permisos del nuevo rol sobre todos los objetos del sistema
        $idRol = ControladorRol::ingresarNuevoRol($nuevoRol);
        $idObjetos = ControladorDataTableObjeto::ObtenerIdObjetos();
        ControladorPermiso::registroNuevoPermiso($idRol, $idObjetos, $user);
         /* ========================= Evento Creacion rol. ==================================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('GESTIONROL.PHP');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó el nuevo rol '.$_POST['rolUsuario'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }