<?php 
    include "../../db/Conexion.php";
    
    include "mail_reset.php";
    if (isset($_POST['email'])){
        $email = $_POST['email'];
        $bytes = random_bytes(16);
        $token2 = bin2hex($bytes);
        /* if ($enviado) { */
            $conexion = new Conexion ();
            $abrirconexion = $conexion->abrirConexionDB();
            $abrirconexion->query("INSERT INTO tbl_contrasena(email, token, codigo) 
                              VALUES ('$email', '$token2', '$token')") or die($abrirconexion->error);
            echo '<p>Verifica tu email para restablecer tu cuenta</p>';
    }else {
        echo 'no se pudo correo';
    }
    
  /*   } */
?>