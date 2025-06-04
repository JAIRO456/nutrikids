<?php
    require '../../libraries/PhpSpreadsheet/vendor/autoload.php';

    // Use the PhpSpreadsheet namespace
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    session_start();
    require_once('../../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela FROM usuarios 
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
    WHERE roles.id_rol = 2 AND usuarios.id_estado = 1 ORDER BY usuarios.documento ASC");
    $sqlDirectores->execute();
    $results = $sqlDirectores->fetchAll(PDO::FETCH_ASSOC);

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Lista de Directores');

    // Set headers
    $sheet->setCellValue('A1', 'Documento');
    $sheet->setCellValue('B1', 'Nombres');
    $sheet->setCellValue('C1', 'Apellidos');
    $sheet->setCellValue('D1', 'Correo');
    $sheet->setCellValue('E1', 'Escuela');

    // Populate data
    $rowNumber = 2;
    foreach ($results as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row['documento']);
        $sheet->setCellValue('B' . $rowNumber, $row['nombre']);
        $sheet->setCellValue('C' . $rowNumber, $row['apellido']);
        $sheet->setCellValue('D' . $rowNumber, $row['email']);
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
    header('Content-Disposition: attachment;filename="Lista_de_Directores.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>