<?php
// Include the main TCPDF library (search for installation path).
require_once('../tcpdf.php');
require_once("../../db/Conexion.php");
require_once("../../Modelo/DataTableTarea.php");
require_once("../../Controlador/ControladorDataTableTarea.php");
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
$pdf->setTitle('ReporteTarea');
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

// set auto page breaks 16
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
$Tareas = ControladorDataTableTarea::obtenerTareasId(intval($_GET['idTarea']));

$html = '
<p style="text-align: center; font-size: 18px;"><b>Reporte de la Tarea N° '.$Tareas['id'].'</b></p>
<p><b>Nombre del Cliente: </b>'.$Tareas['nombreCliente'].'</p>
<p><b>RTN del Cliente:</b>'.$Tareas['rtnCliente'].'</p>
<p><b>Tipo de Cliente:</b>'.$Tareas['TipoCliente'].'</p>
<table border="1" cellpadding="4">
        <tr>
            <th><b>Título:</b></th>
            <th><b>Estado de Avance:</b></th>
            <th><b>Fecha de Inicio:</b></th>
            <th><b>Fecha de Finalización:</b></th>
        </tr>

        <tr>
            <th>' . $Tareas['titulo'] . '</th>
            <th>' . $Tareas['estadoAvance'] . '</th>
            <th>' . $Tareas['fecha_Inicio']->format('Y-m-d') . '</th>';

            if (!empty($Tareas['fecha_Finalizacion'])) {
                $fechaFinal = $Tareas['fecha_Finalizacion']->format('Y-m-d');
            } else {
                $fechaFinal = 'Pendiente';
            }

        $html .= '<th>' . $fechaFinal . '</th>
        </tr>
    
        <tr>
            <td><b>Rubro Comercial:</b></td>
            <td><b>Razón Social:</b></td>
            <td><b>Estado de Finalización:</b></td>
            <td><b>Días Transcurridos:</b></td>
        </tr>
  
        <tr>
            <td>'.$Tareas['rubro_Comercial'].'</td>
            <td>'.$Tareas['razon_Social'].'</td>
            <td>'.$Tareas['estado_Finalizacion'].'</td>
            <td>'.$Tareas['diasTranscurridos'].'</td>
        </tr>
</table>
';
if ($Tareas['estadoAvance'] === 'Lead') :

$html .='
    <table border="1" cellpadding="4">
        <tr>
            <td><b>Clasificación de Lead:</b></td>
            <td>'.$Tareas['ClasificacionLead'].'</td>
        </tr>
        <tr>
            <td><b>Origen del Lead:</b></td>
            <td>'.['OrigenLead'].'</td>
        </tr>
    </table>
';    
endif;
$html .='

<div >
        <p><b>Creado Por:</b> '.$Tareas['creadoPor'].'</p>
        <p><b>Fecha de Creación:</b> '.$Tareas['Fecha_Creacion']->format('Y-m-d').'</p>
        <p><b>Modificado Por:</b> '.$Tareas['Modificado_Por'].'</p>
        <p><b>Fecha de Modificación:</b> '.$Tareas['Fecha_Modificacion']->format('Y-m-d').'</p>
</div>
<table border="1" cellpadding="4">
    <tr> 
        <td style="background-color: #e54037; text-align: center;"><b>LISTA DE ARTÍCULOS DE INTERÉS</b></td>
    </tr>
</table>

<table border="1" cellpadding="4">
<tr>
<td style="background-color: #e54037;color: white; text-align: center; width: 60px;">CANT</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 100px;">CÓDIGO</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 268px;">DESCRIPCIÓN</td>
<td style="background-color: #e54037;color: white; text-align: center; width: 210px;">MARCA</td>
</tr>
';
$Datos = ControladorDataTableTarea::obtenerTareasId(intval($_GET['idTarea']));
if (!empty($Datos) && isset($Datos['productos'])) {
    $productos = $Datos['productos'];

    foreach ($productos as $producto) {   
        $idTarea = $producto['cantidad'];
        $codigo = $producto['id_Articulo']; 
        $descrip = $producto['ARTICULO'];
        $marca = $producto['MARCA'];
        $html .= '
        <tr></tr>
        <tr>
            <td style="text-align: center">' . $idTarea . '</td>
            <td>' . $codigo . '</td>
            <td>' . $descrip . '</td>
            <td>' . $marca . '</td>
        </tr>';
        
    }
}

$html .= '</table>';


//output the HTML content
$pdf->writeHTML($html, true, false, true, false);
//Close and output PDF document
ob_end_clean();
$pdf->Output('ReporteTarea.pdf', 'I');
