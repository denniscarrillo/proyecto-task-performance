<?php
// Include the main TCPDF library (search for installation path).
require_once('../tcpdf.php');
require_once("../../db/Conexion.php");
require_once("../../Modelo/Comision.php");
require_once("../../Controlador/ControladorComision.php");
require_once("../../Modelo/Parametro.php");
require_once("../../Controlador/ControladorParametro.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Controlador/ControladorUsuario.php");
require_once("../../Modelo/Bitacora.php");
require_once("../../Controlador/ControladorBitacora.php");

ob_start();
session_start(); // Reanudamos Session
if(isset($_SESSION['usuario'])){
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
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('ReporteComision');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$width = 154; // Define el ancho que desea para su cadena de encabezado

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
$pdf->setFont('Helvetica', '', 9);

// add a page
$pdf->AddPage();
// create some HTML content
$html = '
<P style="text-align: center; font-size: 18px;"><b>Reporte de Comisiones</b></P>
<table border="1" cellpadding="4">
<tr>
<td style="background-color: #e54037;color: white; text-align: center; width: 60px;">N°</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 80px;">FACTURA</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 120px;">TOTAL VENTA</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px;">PORCENTAJE</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 120px;">COMISIÓN TOTAL</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 100px;">ESTADO COMISIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 100px;">ESTADO LIQUIDACIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 125px;">FECHA COMISIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 125px;">FECHA LIQUIDAR </td>
</tr>
';
$Comisiones = ControladorComision::getComisionesPdf(trim($_GET['buscar']));
foreach($Comisiones as $Comision){
    $idFactura = $Comision['factura'];
    // Formatear $totalVenta como "Lps 2,500.99"
    $totalVenta = isset($Comision['totalVenta']) ? 'Lps. ' . number_format(floatval($Comision['totalVenta']), 2, '.', ',') : '';
    $porcentaje = isset($Comision['porcentaje']) ? $Comision['porcentaje'] * 100 : '';
    $comisionTotal = isset($Comision['comisionTotal']) ? 'Lps. ' . number_format(floatval($Comision['comisionTotal']), 2, '.', ',') : '';

    $estado = $Comision['estadoComisionar'];
    $liquidacion = $Comision['estadoLiquidacion'];
    /* $estadoCobro = $Comision['estadoCobro'];
    $metodoPago = $Comision['metodoPago']; */
    
    // Verificar si $fecha está definido y no es null
    if (isset($Comision['fechaComision']) && $Comision['fechaComision'] instanceof DateTime) {
        $fecha = $Comision['fechaComision'];
        $timestamp = $fecha->getTimestamp();
        $fechaComision = date('Y-m-d H:i:s', $timestamp);
    } else {
        $fechaComision = ''; // Otra acción si $fechaComision no es un objeto DateTime
    }
    
    if (isset($Comision['fechaLiquidacion']) && $Comision['fechaLiquidacion'] instanceof DateTime) {
        $fechaL = $Comision['fechaLiquidacion'];
        $timestamp = $fechaL->getTimestamp();
        $fechaLiquidacion = date('Y-m-d H:i:s', $timestamp);
    } else {
        $fechaLiquidacion = ''; // Otra acción si $fechaLiquidacion no es un objeto DateTime
    }
    
    $Cont++;

    $html .= '
    <tr>
    <td style="text-align: center">'.$Cont.'</td>
    <td style="text-align: center">'.$idFactura.'</td>
    <td style="text-align: center">'.$totalVenta.'</td>
    <td style="text-align: center">'.$porcentaje.'%</td>
    <td style="text-align: center">'.$comisionTotal.'</td>
    <td style="text-align: center">'.$estado.'</td>
    <td style="text-align: center">'.$liquidacion.'</td>
    <td style="text-align: center">'.$fechaComision.'</td>
    <td style="text-align: center">'.$fechaLiquidacion.'</td>
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
$pdf->Output('Reporte Comisiones.pdf', 'I');

if($_GET['buscar'] != ''){
    /* ========================= Evento generar reporte por filtro. ==============================*/
      $newBitacora = new Bitacora();
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s"); 
      $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('V_COMISION.PHP');
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['filterQuery'];
      $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' generó el reporte de comisiones por el filtro "'.$_GET['buscar'].'"';
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/  
}else{
    /* ========================= Evento generar reporte ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('V_COMISION.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Report'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' generó el reporte de comisiones';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}
}