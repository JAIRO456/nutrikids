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

    $sqlSchools = $con->prepare("SELECT * FROM escuelas ORDER BY nombre_escuela ASC");
    $sqlSchools->execute();
    $results = $sqlSchools->fetchAll(PDO::FETCH_ASSOC);

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Lista de Escuelas Asociadas');

    // Set headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Correo');
    $sheet->setCellValue('D1', 'Telefono');

    // Populate data
    $rowNumber = 2;
    foreach ($results as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row['id_escuela']);
        $sheet->setCellValue('B' . $rowNumber, $row['nombre_escuela']);
        $sheet->setCellValue('C' . $rowNumber, $row['email_esc']);
        $sheet->setCellValue('D' . $rowNumber, $row['telefono_esc']);
        $rowNumber++;
    }

    // Auto-size columns
    foreach (range('A', 'D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Save to file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Lista_de_Escuelas_Asociadas.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>