<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../librerias/PHPMailer/Exception.php';
require '../../../librerias/PHPMailer/PHPMailer.php';
require '../../../librerias/PHPMailer/SMTP.php';
require_once ("../../../Modelo/Parametro.php");
require_once("../../../Controlador/ControladorParametro.php");
require_once ("../../../Modelo/Articulo.php");
require_once("../../../Controlador/ControladorArticulo.php");
require_once("../../../Modelo/TipoServicio.php");
require_once("../../../Controlador/ControladorTipoServicio.php");
require_once('../../../TCPDF/tcpdf.php');

function enviarCorreoSolicitud($nuevaSolicitud, $productosSolicitud, $idSolicitud, $nombrePDF){
    $confirmacion = '';
    $getDataServerEmail = ControladorParametro::getDataServerEmail();
    
    $data = ControladorParametro::obtenerCorreoDestino();
    $destinario = $data[0]['CorreoServicio'];
   // Crear instancia de TCPDF

   $datosParametro = ControladorParametro::obtenerDatosReporte();
        foreach($datosParametro  as $datos){
            $nombreP = $datos['NombreEmpresa'];
            $correoP = $datos['Correo'];
            $direccionP = $datos['direccion'];
            $telefonoP = $datos['Telefono'];
            $telefono2P = $datos['Telefono2'];
        }

    date_default_timezone_set('America/Tegucigalpa');
    $fechaActual = date('d/m/Y H:i:s'); // Obtén la fecha y hora actual en el formato deseado

    // create new PDF document
   $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // Puedes personalizar el contenido del PDF aquí
    $width = 64; // Define el ancho que desea para su cadena de encabezado

    $PDF_HEADER_TITLE =  $nombreP;
    $PDF_HEADER_STRING = $direccionP . "\n"  .'Correo: ' . $correoP ."\nTeléfono: +" . $telefonoP.  ", +" . $telefono2P ;
    $PDF_HEADER_STRING .= str_repeat(' ', $width - strlen($fechaActual)) . $fechaActual;
    $PDF_HEADER_LOGO = 'LOGO-reporte.jpg';
    // set default header data
    $pdf->setHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->setAutoPageBreak(TRUE, 10);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
        require_once(dirname(__FILE__).'/lang/spa.php');
        $pdf->setLanguageArray($l);
    }

    
    $pdf->SetFont('Helvetica', '', 11);
    $pdf->AddPage();

    // create some HTML content
    $html = '
    <P style="text-align: center; font-size: 18px;"><b>REPORTE DE LA SOLICITUD</b></P>
    <table cellpadding="5"  border= "1" >
    ';
    // $SolicitudesId = ControladorDataTableSolicitud::VerSolicitudesPorId($_GET['idSolicitud']);
        $id = $idSolicitud;
        $idFactura = $nuevaSolicitud->idFactura;
        $rtnCliente = $nuevaSolicitud->rtnCliente;
        if ($rtnCliente == 'NULL') {
            $rtnCliente = '';
          };
        $rtnClienteCartera = $nuevaSolicitud->rtnClienteC;
        if ($rtnClienteCartera == 'NULL') {
            $rtnClienteCartera = '';
          };
        //$NombreCliente = $nuevaSolicitud->NombreCliente;
        $descripcion = $nuevaSolicitud->descripcion;
        $servicioTecnico = $nuevaSolicitud->tipoServicio;
        $tipoServ = ControladorTipoServicio::obtenerTipoServicioID($servicioTecnico);
        $correoS = $nuevaSolicitud->correo;
        $telefono = $nuevaSolicitud->telefono;
        $ubicacion = $nuevaSolicitud->ubicacion;
        $EstadoAvance = $nuevaSolicitud->estadoAvance;
        $EstadoSolicitud = $nuevaSolicitud->estadoSolicitud;
        $creadoPor = $nuevaSolicitud->creadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $fechaHoy = new DateTime();
        $fechaFormateadaC = $fechaHoy->format('Y-m-d');
        
        
  
       
        $html .= '
        <tr>
            <td style="background-color: #c9c9c9; width: 200px;"><b>ID:</b></td>
            <td style="width: 440px;">'.$id.'</td>       
        </tr>
        <tr>
            <td style="background-color: #c9c9c9;"><b>ID FACTURA:</b></td>
            <td >'.$idFactura.'</td>
        </tr>
        <tr>
            <td style="background-color: #c9c9c9;"><b>RTN CLIENTE:</b></td>
            <td>'.$rtnCliente.''.$rtnClienteCartera.'</td>
            
        </tr>  
        
        <tr>
            <td style="background-color: #c9c9c9;"><b>NOMBRE CLIENTE:</b></td>
            <td>'.$nombrePDF.'</td>
        </tr>
        
        <tr>
            <td style="background-color: #c9c9c9;"><b>DESCRIPCION:</b></td>
            <td>'.$descripcion.'</td>       
        </tr>        
        <tr>
            <td style="background-color: #c9c9c9;"><b>SERVICIO TECNICO:</b></td>
            <td>'. $tipoServ[0]['servicioTec'].'</td>
        </tr>        
        <!--<tr>
             <td style="background-color: #c9c9c9;"><b>CORREO:</b></td>
             <td>'.$correoS.'</td>                    
        </tr>-->
        <tr>
            <td style="background-color: #c9c9c9;"><b>TELEFONO:</b></td>
            <td>'.$telefono.'</td> 
        </tr>       
        <tr>
            <td style="background-color: #c9c9c9;"><b>UBICACIÓN:</b></td>
            <td>'.$ubicacion.'</td>
        
        </tr>        
        <tr>
            <td style="background-color: #c9c9c9;"><b>ESTADO AVANCE:</b></td>
            <td>'.$EstadoAvance.'</td>
        </tr>       
        <tr>
            <td style="background-color: #c9c9c9;"><b>ESTADO DE SOLICITUD:</b></td>
            <td>'.$EstadoSolicitud.'</td>
        </tr>
        <tr>
            <td style="background-color: #c9c9c9;"><b>CREADO POR:</b></td>
            <td>'.$creadoPor.'</td>
        </tr>
        <tr>
            <td style="background-color: #c9c9c9;"><b>FECHA CREACIÓN:</b></td>
            <td>'.$fechaFormateadaC.'</td>       
        </tr>       
        
      

            ';     
    $html .= '
            </table>
                
            <table border="1" cellpadding="4">
            <tr> 
                <td style="background-color: #e54037; text-align: center;"><b>LISTA DE ARTICULOS</b></td>
            </tr>
            <tr >
                <td style="background-color: #c9c9c9; text-align: center;width: 80px;">Cant</td>
                <td style="background-color: #c9c9c9; text-align: center;width: 100px;">Codigo</td>
                <td style="background-color: #c9c9c9; text-align: center;width: 458px;">Descripción</td>
            </tr>
            ';
            $ListaArticulos = ''; 
            foreach ($productosSolicitud as $producto) {
                $Cant = $producto['CantProducto']; 
                $IdProducto = $producto['idProducto'];      
                $NombreP = ControladorArticulo::obtenerArticuloxId($IdProducto);
                $html .= '
            <tr>
                <td style="text-align: center;">'.$Cant.'</td>
                <td style="text-align: center;">'.$IdProducto.'</td>
                <td>'.$NombreP[0]['articulo'].'</td>
            </tr>
        ';
        }
        $html.='
        </table>       

        ';
    $pdf->writeHTML($html, true, false, true, false);
    //$pdf->Cell(0, 10, 'Contenido del PDF', 0, 1, 'C');

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $getDataServerEmail[1]['valorParametro'];                //SMTP username
        $mail->Password   = $getDataServerEmail[2]['valorParametro'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = intval($getDataServerEmail[3]['valorParametro']);  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

       //Recipients
       $mail->setFrom($getDataServerEmail[1]['valorParametro'], $getDataServerEmail[0]['valorParametro']);
       $mail->addAddress($destinario);  
       
       // Adjuntar el PDF al correo
       $pdfData = $pdf->Output('documento.pdf', 'S');  // Obtiene el contenido del PDF como una cadena
       $mail->addStringAttachment($pdfData, 'documento.pdf', 'base64', 'application/pdf');

        // Configurar el contenido del correo
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Nueva Solicitud N° '.$idSolicitud;
        $mail->Body    = 
        '<div>
            <h2>Se le muestra información acerca de la nueva solicitud número '. $idSolicitud .'</h2>
        </div>';
        // $mail->AltBody = 'Si funcionó!';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        $mail->send();
        $confirmacion = 'La solicitud se ha enviado al correo electrónico';
    } catch (Exception $e) {
        $confirmacion =  'No se ha podido enviar la solicitud. Mailer Error: {$mail->ErrorInfo}';
    }
    return $confirmacion;
}

