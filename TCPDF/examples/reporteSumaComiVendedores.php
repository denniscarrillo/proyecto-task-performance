<?php
// Include the main TCPDF library (search for installation path).
require_once('../tcpdf.php');
require_once("../../db/Conexion.php");
require_once("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");
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

date_default_timezone_set('America/Tegucigalpa');
$fechaActual = date('d/m/Y H:i:s'); // Obtén la fecha y hora actual en el formato deseado

// Procesa las comisiones filtradas por fechas
$comisionesFiltradas = ControladorComision::obtenerSumaComisionesVendedores($_POST['fechaDesde'], $_POST['fechaHasta']);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('ReporteSumaComisionesVendedores');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$width = 64; // Define el ancho que desea para su cadena de encabezado

$PDF_HEADER_TITLE =  $nombreP;
$PDF_HEADER_STRING = $direccionP . "\n"  .'Correo: ' . $correoP ."\nTeléfono: +" . $telefonoP.  ", +" . $telefono2P;
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
foreach($comisionesFiltradas as $ComiVendedor){
    $fechaDesdeR = $ComiVendedor['fechaDesde'];
    $fechaHastaR = $ComiVendedor['fechaHasta'];
}
$html = '
<P style="text-align: center; font-size: 18px;"><b>Reporte de comisiones totales de vendedores</b></P>
<p style="text-align: left; font-size: 14px;"><b>Comisiones totales por vendedores del: '.$fechaDesdeR.' al: '.$fechaHastaR.'</b></p>
<table border="1" cellpadding="4">
<tr>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px">ID VENDEDOR</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 100px;">VENDEDOR</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 130px;">COMISIÓN TOTAL</td>
</tr>
';

foreach($comisionesFiltradas as $ComiVendedor){
    $IdVendedor = $ComiVendedor['idVendedor'];
    $Vendedor = $ComiVendedor['nombreVendedor'];
    // $Estado = $ComiVendedor['estadoComision'];
    $totalComision = $ComiVendedor['totalComision'];

    $html .= '
    
    <tr>
    <td style="text-align: center">'.$IdVendedor.'</td>
    <td style="text-align: center">'.$Vendedor.'</td>
    <td style="text-align: center">'.$totalComision.'</td>
    </tr>
    ';
    

}

$html.='
</table>
';

//output the HTML content
$pdf->writeHTML($html, true, false, true, false);
//Close and output PDF document
ob_end_clean();
$pdf->Output('Reporte Comisiones Vendedores Totales.pdf', 'I');