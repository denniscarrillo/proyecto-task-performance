<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/DataTableObjeto.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Controlador/ControladorDataTableObjeto.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    
$estadoEliminado = ControladorDataTableObjeto::eliminarObjeto($_POST['id_Objeto'], $_POST['objeto']);
print json_encode(['estadoEliminado' => $estadoEliminado], JSON_UNESCAPED_UNICODE);