<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 * @group table
 * @group color
 * @group pdf
 */

// Include the main TCPDF library (search for installation path).
session_start();
require_once('../../conex/conex.php');
require_once('../../libraries/TCPDF/tcpdf.php');
$conex = new Database;
$con = $conex->conectar();

$sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela FROM usuarios 
INNER JOIN roles ON usuarios.id_rol = roles.id_rol
INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
WHERE roles.id_rol = 2 AND usuarios.id_estado = 1 ORDER BY usuarios.documento ASC");
$sqlDirectores->execute();

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	// public function LoadData($file) {
	// 	// Read file lines
	// 	$lines = file($file);
	// 	$data = array();
	// 	foreach($lines as $line) {
	// 		$data[] = explode(';', chop($line));
	// 	}
	// 	return $data;
	// }

	// Colored table
	public function ColoredTable($header,$sqlDirectores) {
		// Colors, line width and bold font
		$this->setFillColor(255, 0, 0);
		$this->setTextColor(255);
		$this->setDrawColor(128, 0, 0);
		$this->setLineWidth(0.3);
		$this->setFont('', 'B');
		// Header
		$w = array(25, 35, 35, 45, 40);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->setFillColor(224, 235, 255);
		$this->setTextColor(0);
		$this->setFont('');
		// Data
		$fill = 0;
		foreach($sqlDirectores as $row) {
			$this->Cell($w[0], 6, $row['documento'], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row['nombre'], 'LR', 0, 'L', $fill);
			$this->Cell($w[2], 6, $row['apellido'], 'LR', 0, 'L', $fill);
			$this->Cell($w[3], 6, $row['email'], 'LR', 0, 'L', $fill);
            $this->Cell($w[4], 6, $row['nombre_escuela'], 'LR', 0, 'L', $fill);
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 011');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->setHeaderData('/nutrikids/img/logo-nutrikids2.png', 30, 'Lista de Directores'.' 01', 'www.nutrikids');

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
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('helvetica', '', 8);

// add a page
$pdf->AddPage();

// column titles
$header = array('Documento', 'Nombres', 'Apellidos', 'Correo', 'Escuela');

// data loading
// $data = $pdf->LoadData('data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $sqlDirectores);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('directores_usuarios.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
