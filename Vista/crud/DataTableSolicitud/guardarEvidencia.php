<?php
 require_once ("../../../db/Conexion.php");
 require_once ("../../../Modelo/Usuario.php");
 require_once ("../../../Modelo/DataTableSolicitud.php");
 require_once("../../../Controlador/ControladorUsuario.php");
 require_once("../../../Controlador/ControladorDataTableSolicitud.php");
 require_once ("../../../Modelo/Parametro.php");
 require_once("../../../Controlador/ControladorParametro.php");


// Validar si se ha enviado un archivo
if (isset($_FILES['evidencia_garantia']) && $_FILES['evidencia_garantia']['error'] === UPLOAD_ERR_OK) {
    $nombre_temporal = $_FILES['evidencia_garantia']['tmp_name'];
    $nombre = $_FILES['evidencia_garantia']['name'];
    $TipoExtensiones = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

   // Carpeta se llama por parametro
    $data = ControladorParametro::obtenerCarpetaDestino();
    $directorio_destino = $data[0]['CarpetaGarantia'];
  
    $Extensiones = ['pdf', 'doc', 'jpg', 'jpeg', 'png', 'gif']; 
    if (!in_array($TipoExtensiones, $Extensiones)){
        die("Error: Tipo de archivo no permitido.");
    }
  
    $nombre_unico = uniqid('archivo_', true) . '.' . $TipoExtensiones;
    // Ruta completa del archivo
    $ruta_archivo = $directorio_destino . $nombre_unico;
    // Mover el archivo al directorio de destino
    move_uploaded_file($nombre_temporal, $ruta_archivo);    
   var_dump($ruta_archivo);
   ControladorDataTableSolicitud::insertarEvidenciaPDF(intval($_POST['id_solicitud']), $ruta_archivo);
   
} else {
    // Manejar el caso en que no se haya enviado un archivo
    $response = array('success' => false, 'message' => 'Error: No se ha enviado ningún archivo.');
    print json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>
