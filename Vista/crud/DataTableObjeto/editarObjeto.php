<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $editarObjeto = new DataTableObjeto();
        $editarObjeto->id_Objeto = $_POST['id_Objeto'];
        $editarObjeto->descripcion= $_POST['descripcion'];
        $editarObjeto->Modificado_Por = $user;
        DataTableObjeto::editarObjeto($editarObjeto);
       
    }
?>
