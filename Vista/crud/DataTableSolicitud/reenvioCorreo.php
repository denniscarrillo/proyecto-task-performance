<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../../librerias/PHPMailer/Exception.php';
require '../../../librerias/PHPMailer/PHPMailer.php';
require '../../../librerias/PHPMailer/SMTP.php';
require_once('../../../TCPDF/tcpdf.php');
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/DataTableSolicitud.php");
require_once("../../../Controlador/ControladorDataTableSolicitud.php");
require_once("../../../Modelo/Parametro.php");
require_once("../../../Controlador/ControladorParametro.php");
ob_start();


    $confirmacion = '';
    $getDataServerEmail = ControladorParametro::getDataServerEmail();
    
    $data = ControladorParametro::obtenerCorreoDestino();
    $destinario = $data[0]['CorreoServicio'];
   // Crear instancia de TCPDF
        //cargar el encabezado
        $datosParametro = ControladorParametro::obtenerDatosReporte();
        foreach($datosParametro  as $datos){
            $nombreP = $datos['NombreEmpresa'];
            $correoP = $datos['Correo'];
            $direccionP = $datos['direccion'];
            // $sitioWebP = str_replace("http://", "", $datos['sitioWed']);
            $telefonoP = $datos['Telefono'];
            $telefono2P = $datos['Telefono2'];
        }

        date_default_timezone_set('America/Tegucigalpa');
        $fechaActual = date('d/m/Y H:i:s'); // Obtén la fecha y hora actual en el formato deseado
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $width = 64; // Define el ancho que desea para su cadena de encabezado

        $PDF_HEADER_TITLE =  $nombreP;
        $PDF_HEADER_STRING = $direccionP . "\n"  .'Correo: ' . $correoP ."\nTeléfono: +" . $telefonoP.  ", +" . $telefono2P ;
        $PDF_HEADER_STRING .= str_repeat(' ', $width - strlen($fechaActual)) . $fechaActual;
        $PDF_HEADER_LOGO = '../../../Recursos/' . ControladorParametro::obtenerUrlLogoReporte();
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

        // set font
        $pdf->setFont('Helvetica', '', 11);

        // add a page
        $pdf->AddPage();
        // create some HTML content
        $html = '
        <P style="text-align: center; font-size: 18px;"><b>REPORTE DE LA SOLICITUD</b></P>
        <table cellpadding="5"  border= "1" >
        ';

        $SolicitudesId = ControladorDataTableSolicitud::VerSolicitudesPorId($_GET['idSolicitud']);
                $idSolicitud = $SolicitudesId['idSolicitud'];
                $idFactura = $SolicitudesId['idFactura'];

                $rtnClienteCartera = $SolicitudesId['rtnClienteCartera'];
    
                $NombreCliente = $SolicitudesId['NombreCliente'];
                $descripcion = $SolicitudesId['Descripcion'];
                $servicioTecnico = $SolicitudesId['TipoServicio'];
                $correoS = $SolicitudesId['Correo'];
                $telefono = $SolicitudesId['telefono'];
                $ubicacion = $SolicitudesId['ubicacion'];
                $EstadoAvance = $SolicitudesId['EstadoAvance'];
                $EstadoSolicitud = $SolicitudesId['EstadoSolicitud'];
                $motivo = $SolicitudesId['motivoCancelacion'];
                $creadoPor = $SolicitudesId['CreadoPor'];
                $FechaCreacion = $SolicitudesId['FechaCreacion'];
                $modifacadoPor = $SolicitudesId['ModificadoPor'];
                $fechaFormateadaC = $FechaCreacion->format('Y/m/d');
                $FechaModificacion = $SolicitudesId['FechaModificacion'];       
                if ($FechaModificacion !== null) {
                    $fechaFormateadaM = $FechaModificacion->format('Y/m/d');
                } else {
                    $fechaFormateadaM = '';
                };
                
                $ArticulosS = ControladorDataTableSolicitud::obtenerProductosS($_GET['idSolicitud']);
                
                
            
                $html .= '
                <tr>
                    <td style="background-color: #c9c9c9; width: 200px;"><b>ID:</b></td>
                    <td style="width: 440px;">'.$idSolicitud.'</td>       
                </tr>
                <tr>
                    <td style="background-color: #c9c9c9;"><b>ID FACTURA:</b></td>
                    <td >'.$idFactura.'</td>
                </tr>
                <tr>
                    <td style="background-color: #c9c9c9;"><b>RTN CLIENTE:</b></td>
                    <td>'.$rtnClienteCartera.'</td>
                    
                </tr>        
                <tr>
                    <td style="background-color: #c9c9c9;"><b>NOMBRE CLIENTE:</b></td>
                    <td>'.$NombreCliente.'</td>
                </tr>        
                <tr>
                    <td style="background-color: #c9c9c9;"><b>DESCRIPCION:</b></td>
                    <td>'.$descripcion.'</td>       
                </tr>        
                <tr>
                    <td style="background-color: #c9c9c9;"><b>SERVICIO TECNICO:</b></td>
                    <td>'.$servicioTecnico.'</td>
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
                <tr>
                    <td style="background-color: #c9c9c9;"><b>MODIFICADO POR:</b></td>
                    <td>'.$modifacadoPor.'</td>
                </tr>       
                <tr>
                    <td style="background-color: #c9c9c9;"><b>FECHA MODIFICACIÓN:</b></td>
                    <td>'.$fechaFormateadaM.'</td>     
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
                    //$ListaArticulos = ''; 
                    foreach ($ArticulosS as $producto) {
                        $Articulo = $producto['Articulo'];
                        $Cant = $producto['Cant'];
                        $CodArticulo = $producto['CodArticulo'];
                        //$ListaArticulos .= '<li>'.$Cant.' - '. $Articulo .'</li>';
                    
                        $html .= '
                    <tr>
                        <td style="text-align: center;">'.$Cant.'</td>
                        <td style="text-align: center;">'.$CodArticulo.'</td>
                        <td>'.$Articulo.'</td>
                    </tr>
                ';
                }
                $html.='
            </table>
            '; 
    $pdf->writeHTML($html, true, false, true, false);            
    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                                       //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $getDataServerEmail['ADMIN_CORREO'];                //SMTP username
        $mail->Password   = $getDataServerEmail['ADMIN_PASSWORD'];                      //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = intval($getDataServerEmail['ADMIN_PUERTO']);  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

       //Recipients
       $mail->setFrom($getDataServerEmail['ADMIN_CORREO'], $getDataServerEmail['ADMIN_USER']);
       //$mail->setFrom($getDataServerEmail[1]['valorParametro'], $getDataServerEmail[0]['valorParametro']);
       $mail->addAddress($destinario);  
       
       // Adjuntar el PDF al correo
       $pdfData = $pdf->Output('documento.pdf', 'S');  // Obtiene el contenido del PDF como una cadena
       $mail->addStringAttachment($pdfData, 'documento.pdf', 'base64', 'application/pdf');

        // Configurar el contenido del correo
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Nueva Solicitud N° '.$idSolicitud;
        $mail->Body    = 
        '<div>
            <h2>Se le muestra información acerca de la solicitud número '. $idSolicitud .'</h2>
        </div>';
        // $mail->AltBody = 'Si funcionó!';
        $mail->CharSet = 'UTF-8'; // Setear UTF-8 para caracteres especiales
        $mail->send();
        $confirmacion = 'La solicitud se ha enviado al correo electrónico';
    } catch (Exception $e) {
        //$confirmacion =  'No se ha podido enviar la solicitud. Mailer Error: {$mail->ErrorInfo}';
        $confirmacion = 'No se ha podido enviar la solicitud. Mailer Error: ' . $mail->ErrorInfo;
    
    }
    return $confirmacion;



