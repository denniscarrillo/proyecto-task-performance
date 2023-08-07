<?php
require('./fpdf.php');
require_once("../../db/Conexion.php");
require_once("../../Modelo/Venta.php");
require_once("../../Controlador/ControladorVenta.php");
require_once("./Reporte.php");


$pdf = new REPORTE();
$pdf->AddPage('Landscape'); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 25); //margen de pie de pagina

$i = 0;
$pdf->SetFont('Arial', '', 8);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


/*$consulta_reporte_alquiler = $conexion->query("  ");*/
$idVentas = ControladorVenta::obtenerIdVentas(1);
/* TABLA */
//Traer solo una venta en especifico
foreach ($idVentas as $idVenta) {
   $pdf->Cell(10, 10, mb_convert_encoding($idVenta['numFactura'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($idVenta['codCliente'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(40, 10, mb_convert_encoding($idVenta['nombreCliente'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, mb_convert_encoding($idVenta['rtnCliente'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, mb_convert_encoding($idVenta['fechaEmision'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($idVenta['totalBruto'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($idVenta['totalImpuesto'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($idVenta['totalVenta'], 'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Ln(10);
   
}
/* TABLA */

$pdf->Output('Ventas.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Header();
$pdf->Footer();