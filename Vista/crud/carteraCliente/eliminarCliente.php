 <?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");

    if(isset($_POST['nombre_cliente'])){
        $nombre = $_POST['nombre_Cliente'];
        $estadoEliminado = ControladorCarteraClientes::eliminarCliente($nombre);
        $data = array();
        if($estadoEliminado == false) {
            $data []= [
                'estadoEliminado' => 'eliminado'
            ];
            print json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
?>