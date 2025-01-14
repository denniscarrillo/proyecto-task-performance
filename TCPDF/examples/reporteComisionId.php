<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('ReporteComisionId');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

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
$ComisionId = ControladorComision::traerIdComision($_GET['idComision']);
$idComision = $ComisionId['idComision'];
$idFactura = $ComisionId['idFactura'];
$VentaTotal = 'Lps. ' . number_format($ComisionId['ventaTotal'], 2, '.', ',');
$valorPorcentaje = $ComisionId['valorPorcentaje'] * 100;
$ComisionT =  'Lps. ' . number_format($ComisionId['comisionT'], 2, '.', ',');
$Estado = $ComisionId['estadoComision'];
$EstadoL = $ComisionId['estadoLiquidacion'];
// $EstadoC = $ComisionId['estadoCobro'];
// $metodoPago = $ComisionId['metodoPago'];
$creadoPor = $ComisionId['CreadoPor'];
// Verificar si $fecha está definido y no es null
if (isset($ComisionId['FechaComision']) && $ComisionId['FechaComision'] !== null) {
    $fecha = $ComisionId['FechaComision'];
    $timestamp = $fecha->getTimestamp();
    // Verificar si la fecha es no nula antes de formatearla
    $fechaComision = date('Y-m-d H:i:s', $timestamp);
} else {
    $fechaComision = ''; // Otra acción si $fechaComision es nulo
}

if (isset($ComisionId['FechaLiquidacion']) && $ComisionId['FechaLiquidacion'] !== null) {
    $fechaL = $ComisionId['FechaLiquidacion'];
    $timestamp = $fechaL->getTimestamp();
    // Verificar si la fecha es no nula antes de formatearla
    $fechaLiquidacion = date('Y-m-d H:i:s', $timestamp);
} else {
    $fechaLiquidacion = 'Sin Liquidar'; // Otra acción si $fechaLiquidacion es nulo
}
// if(isset($ComisionId['FechaCobro']) && $ComisionId['FechaCobro'] !== null){
//     $fechaC = $ComisionId['FechaCobro'];
//     $timestamp = $fechaC->getTimestamp();
//     // Verificar si la fecha es no nula antes de formatearla
//     $fechaCobro = date('Y-m-d H:i:s', $timestamp);
// }else{
//     $fechaCobro = 'Sin Cobrar';
// }
$modificadoPor = $ComisionId['ModificadoPor'];
if ($modificadoPor == null) {
    $modificadoPor = "Sin modificaciones";
}
if (isset($ComisionId['FechaModificacion']) && $ComisionId['FechaModificacion'] !== null) {
    $fechaL = $ComisionId['FechaModificacion'];
    $timestamp = $fechaL->getTimestamp();
    // Verificar si la fecha es no nula antes de formatearla
    $fechaModificacion = date('Y-m-d H:i:s', $timestamp);
} else {
    $fechaModificacion = 'Sin modificaciones'; // Otra acción si $fechaLiquidacion es nulo
}
$html = '
<P style="text-align: center; font-size: 18px;"><b>Reporte de la Comision No. '.$idComision.'</b></P>
';

$html .= '

<dl>
<div style="flex: 1; text-align: left;"> <b> No. COMISIÓN:  </b>' . $idComision . '</div>
<div style="flex: 1; text-align: left;"> <b> No. FACTURA:  </b>' . $idFactura . '</div>
<div style="flex: 1; text-align: left;"> <b> VENTA TOTAL:  </b>' . $VentaTotal . '</div>
<div style="flex: 1; text-align: left;"> <b> PORCENTAJE:  </b>' . $valorPorcentaje . '%</div>
<div style="flex: 1; text-align: left;"> <b> COMISIÓN TOTAL:  </b>' . $ComisionT . '</div>
<div style="flex: 1; text-align: left;"> <b> ESTADO:  </b>' . $Estado . '</div>
<div style="flex: 1; text-align: left;"> <b> ESTADO LIQUIDACIÓN:  </b>' . $EstadoL . '</div>
<div style="flex: 1; text-align: left;"> <b> CREADO POR:  </b>' . $creadoPor . '</div>
<div style="flex: 1; text-align: left;"> <b> FECHA DE CREACION:  </b>' . $fechaComision . '</div>
<div style="flex: 1; text-align: left;"> <b> FECHA DE LIQUIDACIÓN:  </b>' . $fechaLiquidacion . '</div>
<div style="flex: 1; text-align: left;"> <b> MODIFICADO POR:  </b>' . $modificadoPor . '</div>
<div style="flex: 1; text-align: left;"> <b> FECHA MODIFICACIÓN:  </b>' . $fechaModificacion . '</div>
</dl>
    <br>
    <table cellpadding="5"  border= "1" >
    <tr>
        <th scope="col" style="background-color: #e54037; color: white;">No. VENDEDOR</th>
        <th scope="col" style="background-color: #e54037; color: white;">NOMBRE VENDEDOR</th>
        <th scope="col" style="background-color: #e54037; color: white;">COMISIÓN VENDEDOR</th>
    </tr>';
    
    foreach ($ComisionId['vendedores'] as $vendedor) {
        $idVendedor = $vendedor['idVendedor'];
        $nombreVendedor = $vendedor['nombreVendedor'];
        $comisionVendedor = 'Lps. ' . number_format($vendedor['comisionVendedor'], 2, '.', ',');
        
        $html .= '<tr>';
        $html .= '<td>'.$idVendedor.'</td>';
        $html .= '<td>'.$nombreVendedor.'</td>';
        $html .= '<td>'.$comisionVendedor.'</td>';
        $html .= '</tr>';
    }

$html .= '
    </table>
</dl>';

$html .= '

';

//output the HTML content
$pdf->writeHTML($html, true, false, true, false);
//Close and output PDF document
ob_end_clean();
$pdf->Output('ReporteriaIdComision.pdf', 'I');