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
session_start();
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
$pdf->setTitle('ReporteComisionesVendedores');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$width = 154; // Define el ancho que desea para su cadena de encabezado

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
$pdf->setFont('Helvetica', '', 9);

// add a page
$pdf->AddPage();
// create some HTML content
$html = '
<P style="text-align: center; font-size: 18px;"><b>Reporte de comisión por vendedores</b></P>
<table border="1" cellpadding="4">
<tr>
<td style="background-color: #e54037;color: white; text-align: center; width: 50px">N°</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 90px;">N° COMISIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 100px;">N° VENDEDOR</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px;">VENDEDOR</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px;">ESTADO COMISIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 130px;">COMISION TOTAL</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 130px;">ESTADO LIQUIDACIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px;">FECHA COMISIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 110px;">FECHA LIQUIDAR </td>
</tr>
';
$ComisionVendedor = ControladorComision::getComisionesVendedorPdf(trim($_GET['buscar']));
foreach($ComisionVendedor as $ComisionV){
    // $IdComisionV = $ComisionV['idComisionVendedor'];
    $IdComision = $ComisionV['idComision'];
    $IdVendedor = $ComisionV['idVendedor'];
    $usuario = $ComisionV['usuario'];
    $Estado = $ComisionV['estadoComision'];
    $comisionTotal = 'Lps. ' . number_format($ComisionV['comisionTotal'], 2, '.', ',');
    $liquidacion = $ComisionV['estadoLiquidacion'];
   /*  $estadoCobro = $ComisionV['estadoCobro'];
    $metodoPago = $ComisionV['metodoPago']; */
    // Verificar si $fecha está definido y no es null
    if (isset($ComisionV['fechaComision']) && $ComisionV['fechaComision'] !== null) {
        $fecha = $ComisionV['fechaComision'];
        $timestamp = $fecha->getTimestamp();
        // Verificar si la fecha es no nula antes de formatearla
        $fechaComision = date('Y-m-d H:i:s', $timestamp);
    } else {
        $fechaComision = ''; // Otra acción si $fechaComision es nulo
    }
     // Verificar si $fechaL está definido y no es null
     if (isset($ComisionV['fechaLiquidacion']) && $ComisionV['fechaLiquidacion'] !== null) {
        $fechaL = $ComisionV['fechaLiquidacion'];
        $timestamp = $fechaL->getTimestamp();
        // Verificar si la fecha es no nula antes de formatearla
        $fechaLiquidacion = date('Y-m-d H:i:s', $timestamp);
    } else {
        $fechaLiquidacion = ''; // Otra acción si $fechaLiquidacion es nulo
    }
  /*   if(isset($ComisionV['fechaCobro']) && $ComisionV['fechaCobro'] !== null){
        $fechaC = $ComisionV['fechaCobro'];
        $timestamp = $fechaC->getTimestamp();
        // Verificar si la fecha es no nula antes de formatearla
        $fechaCobro = date('Y-m-d H:i:s', $timestamp);
    } else {
        $fechaCobro = ''; // Otra acción si $fechaCobro es nulo
    } */
    $Cont++;
    

    $html .= '
    <tr>
    <td style="text-align: center">'.$Cont.'</td>
    <td style="text-align: center">'.$IdComision.'</td>
    <td style="text-align: center">'.$IdVendedor.'</td>
    <td style="text-align: center">'.$usuario.'</td>
	<td style="text-align: center">'.$Estado.'</td>
    <td style="text-align: center">'.$comisionTotal.'</td>
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
$pdf->Output('Reporte Comisiones por vendedores.pdf', 'I');

if($_GET['buscar'] != ''){
    /* ========================= Evento generar reporte por filtro. ==============================*/
      $newBitacora = new Bitacora();
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s"); 
      $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('COMISIONESVENDEDORES.PHP');
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['filterQuery'];
      $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' generó el reporte de comisiones por vendedor en el filtro "'.$_GET['buscar'].'"';
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
      /* =======================================================================================*/  
}else{
    /* ========================= Evento generar reporte ====================================*/
    $newBitacora = new Bitacora();
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s"); 
    $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('COMISIONESVENDEDORES.PHP');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['Report'];
    $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' generó el reporte de comisiones por vendedor';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
}
}