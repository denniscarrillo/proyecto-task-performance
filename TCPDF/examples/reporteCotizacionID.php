<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Include the main TCPDF library (search for installation path).
require_once('../tcpdf.php');
require_once("../../db/Conexion.php");
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');
require_once("../../Modelo/DataTableSolicitud.php");
require_once("../../Controlador/ControladorDataTableSolicitud.php");
require_once("../../Modelo/Parametro.php");
require_once("../../Controlador/ControladorParametro.php");
ob_start();

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
// hora y fecha
date_default_timezone_set('America/Tegucigalpa'); // Establecer la zona horaria de Tegucigalpa
$fechaActual = date('Y-m-d'); // Obtener la fecha actual en formato ISO 8601
$horaActual = date('h:i:s A'); // Obtener la hora actual en formato de 12 horas con AM/PM
$fechaFormateada = ucfirst(strftime('%A, %d de %B del %Y ', strtotime($fechaActual)));
$nombreDiaEnIngles = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$nombreDiaEnEspañol = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
$nombreMesEnIngles = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
$nombreMesEnEspañol = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$fechaFormateada = str_replace($nombreDiaEnIngles, $nombreDiaEnEspañol, $fechaFormateada);
$fechaFormateada = str_replace($nombreMesEnIngles, $nombreMesEnEspañol, $fechaFormateada);
$fechaFormateada .= ' ' . $horaActual;
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('ReporteContizacionIndiv');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$width = 64; // Define el ancho que desea para su cadena de encabezado

$PDF_HEADER_TITLE =  $nombreP;
$PDF_HEADER_STRING = $direccionP . "\n"  .'Correo: ' . $correoP ."\nTeléfono: +" . $telefonoP.  ", +" . $telefono2P ;
// $PDF_HEADER_STRING .= str_repeat(' ', $width - strlen($fechaActual)) . $fechaActual;
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

$CotizacionXid = ControladorTarea::obtenerCotizacionXId(intval($_GET['idCotizacion']));

       
$html .= '
<div style="display">
<div style="text-align: right;">' . $fechaFormateada . '</div>
<div><b style="text-align: center;font-size: 18px;">COTIZACIÓN # '.$_GET['idCotizacion'].'</b>   
<br><br>Por medio de la presente le hago cotización para:
<br>
<div><b>'.$_GET['nombreC'].'</b>
<br>
</div>
    
    <table border="1" cellpadding="4">
    <tr>
    <td style="background-color: #e54037;color: white; text-align: center; width: 50px;">Item</td>
    <td style="background-color: #e54037;color: white; text-align: center; width: 150px;">Descripcion</td>
    <td style="background-color: #e54037;color: white; text-align: center; width: 120px;">Marca</td>
    <td style="background-color: #e54037;color: white; text-align: center; width: 80px;">Cant.</td>
    <td style="background-color: #e54037;color: white; text-align: center; width: 120px;">Precio Unit.</td>
    <td style="background-color: #e54037;color: white; text-align: center; width: 120px;">Total</td>
    </tr>
    ';
    
    // Verificar si se obtuvieron datos de la cotización
    if (!empty($CotizacionXid) && isset($CotizacionXid['productos'])) {
        $productos = $CotizacionXid['productos'];
    
        foreach ($productos as $producto) {
            $item = $producto['item'];
            $descripcion = $producto['descripcion'];
            $marca = $producto['marca'];
            $cantidad = $producto['cantidad'];
            $precio = $producto['precio'];
            $total = $producto['total'];
    
            // Construir las filas HTML para la tabla
            $html .= '
                <tr>
                    <td style="text-align: center">'.$item.'</td>
                    <td>'.$descripcion.'</td>
                    <td style="text-align: center">'.$marca.'</td>
                    <td style="text-align: center">'.$cantidad.'</td>
                    <td style="text-align: center">'.$precio.'</td>
                    <td style="text-align: center">'.$total.'</td>
                </tr>';
        }
    }
    
    $html.='
    </table>
    
    ';
    //$data = ControladorTarea::obtenerDatosCotizacion(intval($_GET['idTarea']));
    $html.='
    <p></p>
    
    
    <table cellpadding="5">
    <tr>
    <td style="width: 401px; font-size: 11px;"></td>
    <td border="1" style="font-size: 12px; width: 120px;">SUB-TOTAL</td>
    <td border="1" style="text-align: center; width: 120px;">Lps.  '. $CotizacionXid['detalleC']['subTotal'].'</td>
    </tr>';
    if ($CotizacionXid['detalleC']['descuento'] > 0) :
        $html .='
        <tr>
        <td style="width: 401px; font-size: 11px;"></td>
        <td border="1" style="font-size: 12px;">DESCUENTO</td>
        <td border="1" style="text-align: center; width: 120px;">Lps.  '. $CotizacionXid['detalleC']['descuento'].'</td>
        </tr>
        
        <tr>
        <td style="width: 401px; font-size: 11px;"></td>
        <td border="1" style="font-size: 12px;">SUB DESC</td>
        <td border="1" style="text-align: center; width: 120px;">Lps.  '. $CotizacionXid['detalleC']['subDescuento'].'</td>
        </tr>
    ';    
    endif;
    $html .='
    <tr>
    <td ></td>
    <td border="1" style="font-size: 12px;">15% I.S.V.</td>
    <td border="1" style="text-align: center; width: 120px;">Lps.  '. $CotizacionXid['detalleC']['isv'].'</td>
    </tr>
    
    <tr>
    <td></td>
    <td border="1" style="font-size: 12px;">TOTAL</td>
    <td border="1" style="text-align: center; width: 120px;">Lps.  '. $CotizacionXid['detalleC']['total_Cotizacion'].'</td>
    </tr>
    </table>
    
    
        <div >Cotización valida por '.$CotizacionXid['detalleC']['validez'].' días.
        <br>Gracias por cotizar con nosotros.
        <br>Fecha de trabajo deberá programarse una vez aceptada la cotización.</b>
        <br><br>Atentamente, 
        <br><b>'.$_GET['usuario'].'</b>
        <br>Cocinas y Equipos
        <br>Apoyo Técnico
        
    
        </div>
    
       
    ';

//output the HTML content
$pdf->writeHTML($html, true, false, true, false);
//Close and output PDF document
ob_end_clean();
$pdf->Output('ReporteCotizacion'. $idSolicitud .'.pdf', 'I');