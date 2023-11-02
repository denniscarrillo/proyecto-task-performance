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


// set font
$pdf->setFont('Helvetica', '', 11);

// add a page
$pdf->AddPage();
// create some HTML content
$html = '
<P style="text-align: center; font-size: 18px;"><b>Reporte de la Comision id</b></P>
';


$ComisionId = ControladorComision::traerIdComision($_GET['idComision']);
        $idComision = $ComisionId['idComision'];
        $idFactura = $ComisionId['$idFactura'];
        $VentaTotal = $ComisionId['ventaTotal'];
        $valorPorcentaje = $ComisionId['valorPorcentaje'];
        $ComisionT = $ComisionId['comisionT'];
        $Estado = $ComisionId['estadoComision'];
        $creadoPor = $ComisionId['CreadoPor'];
        $fechaComision = $ComisionId['FechaCreacion'];
        $fechaFormateadaC = $fechaComision->format('Y/m/d H:i:s');
        $modifacadoPor = $ComisionId['ModificadoPor'];
        $FechaModificacion = $ComisionId['FechaModificacion'];
        $fechaFormateadaM = $FechaModificacion->format('Y/m/d H:i:s');
        $idComisionVendedor = $ComisionId['idComisionVendedor'];
        $idVendedor = $ComisionId['idVendedor'];
        $nombreVendedor = $ComisionId['nombreVendedor'];
        $comisionVendedor = $ComisionId['comisionVendedor'];
        
        $html .= '

        <dl>
            <dt><b>ID Comision:</b></dt>
            <dd>'.$idComision.'</dd><br>
            <dt><b>ID FACTURA:</b></dt>
            <dd>'.$idFactura.'</dd><br>
            <dt><b>VENTA TOTAL:</b></dt>
            <dd>'.$VentaTotal.'</dd><br>
            <dt><b>PORCENTAJE:</b></dt>
            <dd>'.$valorPorcentaje.'</dd><br>
            <dt><b>ESTADO COMISION:</b></dt>
            <dd>'.$Estado.'</dd><br>
            <dt><b>CREADO POR:</b></dt>
            <dd>'.$creadoPor.'</dd><br>
            <dt><b>FECHA DE CREACION:</b></dt>
            <dd>'.$fechaFormateadaC.'</dd><br>
            <dt><b>MODIFICADO POR:</b></dt>
            <dd>'.$modifacadoPor.'</dd><br>
            <dt><b>FECHA MODIFICACION:</b></dt>
            <dd>'.$fechaFormateadaM.'</dd><br>
            <dt><b>ID COMISION VENDEDOR:</b></dt>
            <dd>'.$idComisionVendedor.'</dd><br>
            <dt><b>VENDORES:</b></dt>
            <dd>'.$idVendedor.'</dd><br>
            <dt><b>NOMBRE DEL VENDEDOR:</b></dt>
            <dd>'.$nombreVendedor.'</dd><br>
            <dt><b>COMISION DEL VENDEDOR:</b></dt>
            <dd>'.$comisionVendedor.'</dd><br>
        </dl>
        
        
        
        ';
  


$html.='

';

//output the HTML content
$pdf->writeHTML($html, true, false, true, false);
//Close and output PDF document
ob_end_clean();
$pdf->Output('ReporteriaIdComision.pdf', 'I');