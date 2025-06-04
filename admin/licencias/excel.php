<?php
    require '../../libraries/PhpSpreadsheet/vendor/autoload.php';

    // Use the PhpSpreadsheet namespace
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    session_start();
    require_once('../../conex/conex.php');
    require_once('../../libraries/TCPDF/tcpdf.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlLicencias = $con->prepare("SELECT * FROM licencias
    INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo
    INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
    ORDER BY licencias.id_licencia ASC;");
    $sqlLicencias->execute();
    $results = $sqlLicencias->fetchAll(PDO::FETCH_ASSOC);

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Lista de Licencias');

    // Set headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Fecha Inicio');
    $sheet->setCellValue('C1', 'Fecha Fin');
    $sheet->setCellValue('D1', 'Nombre');
    $sheet->setCellValue('E1', 'Escuela');

    // Populate data
    $rowNumber = 2;
    foreach ($results as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row['id_licencia']);
        $sheet->setCellValue('B' . $rowNumber, $row['fecha_inicio']);
        $sheet->setCellValue('C' . $rowNumber, $row['fecha_fin']);
        $sheet->setCellValue('D' . $rowNumber, $row['tipo']);
        $sheet->setCellValue('E' . $rowNumber, $row['nombre_escuela']);
        $rowNumber++;
    }

    // Auto-size columns
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Save to file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Lista_de_Licencias.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>