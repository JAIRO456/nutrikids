<?php
    require '../../libraries/PhpSpreadsheet/vendor/autoload.php';

    // Use the PhpSpreadsheet namespace
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    session_start();
    require_once('../../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);
    // $name_esc = str_replace(' ', '_', $u["escuela"]);

    $sqlestudiantes = $con->prepare("SELECT estudiantes.documento_est, estudiantes.nombre AS nombre_est, estudiantes.apellido AS apellido_esc, estudiantes.email, usuarios.nombre AS nombre_acu, usuarios.apellido AS apellido_acu, estados.estado FROM estudiantes
    INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
    INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
    INNER JOIN estados ON estudiantes.id_estado = estados.id_estado
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento
    WHERE detalles_estudiantes_escuela.id_escuela = ? ORDER BY documento_est ASC");
    $sqlestudiantes->execute([$u['id_escuela']]);
    $results = $sqlestudiantes->fetchAll(PDO::FETCH_ASSOC);

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Lista de Estudiantes');

    // Set headers
    $sheet->setCellValue('A1', 'Documento');
    $sheet->setCellValue('B1', 'Nombres');
    $sheet->setCellValue('C1', 'Apellidos');
    $sheet->setCellValue('D1', 'Correo');
    $sheet->setCellValue('E1', 'Nonmbres Acudiente');
    $sheet->setCellValue('F1', 'Apellidos Acudiente');
    $sheet->setCellValue('G1', 'Estado');

    // Populate data
    $rowNumber = 2;
    foreach ($results as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row['documento_est']);
        $sheet->setCellValue('B' . $rowNumber, $row['nombre_est']);
        $sheet->setCellValue('C' . $rowNumber, $row['apellido_esc']);
        $sheet->setCellValue('D' . $rowNumber, $row['email']);
        $sheet->setCellValue('E' . $rowNumber, $row['nombre_acu']);
        $sheet->setCellValue('F' . $rowNumber, $row['apellido_acu']);
        $sheet->setCellValue('G' . $rowNumber, $row['estado']);
        $rowNumber++;
    }

    // Auto-size columns
    foreach (range('A', 'G') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Save to file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Lista_de_Estudiantes.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>