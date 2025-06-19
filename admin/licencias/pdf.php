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
require_once('../../database/conex.php');
require_once('../../libraries/TCPDF/vendor/tecnickcom/tcpdf/tcpdf.php');
$conex = new Database;
$con = $conex->conectar();

$sqlLicencias = $con->prepare("SELECT * FROM licencias
INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo
INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
INNER JOIN estados ON licencias.id_estado = estados.id_estado
ORDER BY licencias.id_licencia ASC;");
$sqlLicencias->execute();
$licencias = $sqlLicencias->fetchAll(PDO::FETCH_ASSOC);

// extend TCPF with custom functions
class MYPDF extends TCPDF {
    private $titulo_reporte;
    private $fecha_reporte;
    
    public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->titulo_reporte = 'Reporte de Licencias';
        $this->fecha_reporte = date('d/m/Y H:i:s');
    }
    
    // Cabecera de página
    public function Header() {
        // Logo
        //$image_file = '../../img/logo-nutrikids2.png';
        //$this->Image($image_file, 15, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Título
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 15, $this->titulo_reporte, 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        // Fecha
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 0, 'Generado el: '.$this->fecha_reporte, 0, 1, 'C');
        
        // Línea separadora
        $this->SetLineWidth(0.5);
        $this->SetDrawColor(50, 100, 150);
        $this->Line(15, 30, 195, 30);
        
        // Espacio después del encabezado
        $this->SetY(35);
    }
    
    // Pie de página
    public function Footer() {
        // Posición a 15 mm del final
        $this->SetY(-15);
        // Fuente
        $this->SetFont('helvetica', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
        // Información de confidencialidad
        $this->SetY(-25);
        $this->SetFont('helvetica', 'I', 7);
        $this->Cell(0, 10, 'Este documento es confidencial y para uso exclusivo de NutriKids', 0, 0, 'C');
    }
    
    // Tabla mejorada con estilos profesionales
    public function generarTablaLicencias($licencias) {
        // Configuración de colores y fuentes
        $this->SetFillColor(44, 62, 80); // Azul oscuro
        $this->SetTextColor(255);
        $this->SetDrawColor(44, 62, 80);
        $this->SetLineWidth(0.3);
        $this->SetFont('helvetica', 'B', 10);
        
        // Anchuras de columnas
        $w = array(40, 50, 25, 20, 20, 20);
        
        // Cabecera de la tabla
        $header = array('ID', 'Escuela', 'Tipo', 'Fecha Inicio', 'Fecha Fin', 'Estado');
        for($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        
        // Restaurar colores y fuente para los datos
        $this->SetFillColor(232, 240, 254); // Azul claro
        $this->SetTextColor(0);
        $this->SetFont('helvetica', '', 9);
        
        // Alternar colores de fila
        $fill = false;
        
        foreach($licencias as $row) {
            // Fila con datos
            $this->Cell($w[0], 6, $row['id_licencia'], 'LR', 0, 'L', $fill);
            
            // Nombre completo
            $this->Cell($w[1], 6, $row['nombre_escuela'], 'LR', 0, 'L', $fill);
            
            // Tipo de Licencia
            $this->Cell($w[2], 6, $row['tipo'], 'LR', 0, 'L', $fill);
            
            // Fecha de Inicio
            $this->Cell($w[3], 6, $row['fecha_inicio'], 'LR', 0, 'L', $fill);
            
            // Fecha de Fin
            $this->Cell($w[4], 6, $row['fecha_fin'], 'LR', 0, 'L', $fill); 
            
            // Estado
            $this->Cell($w[5], 6, $row['estado'], 'LR', 0, 'L', $fill);
            
            $this->Ln();
            $fill = !$fill;
        }
        
        // Cierre de la tabla
        $this->Cell(array_sum($w), 0, '', 'T');
        
        // Resumen estadístico
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 6, 'Total de Licencias: '.count($licencias), 0, 1);
    }
}

// Crear nuevo documento PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Información del documento
$pdf->SetCreator('NutriKids App');
$pdf->SetAuthor('Sistema NutriKids');
$pdf->SetTitle('Reporte de Licencias');
$pdf->SetSubject('Licencias');
$pdf->SetKeywords('NutriKids, Licencias, Reporte');

// Configuración de márgenes
$pdf->SetMargins(15, 35, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(15);

// Configuración de fuente por defecto
$pdf->SetFont('helvetica', '', 10);

// Añadir página
$pdf->AddPage();

// Título del reporte
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Licencias en el Sistema', 0, 1, 'C');
$pdf->Ln(5);

// Generar tabla con datos
$pdf->generarTablaLicencias($licencias);

// Sección de observaciones
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'I', 9);
$pdf->MultiCell(0, 5, "Observaciones:\n- Este reporte incluye todas las licencias en el sistema.", 0, 'L');

// Salida del documento
$pdf->Output('reporte_licencias_'.date('Ymd_His').'.pdf', 'I');