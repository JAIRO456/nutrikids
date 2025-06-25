<?php
    require '../../libraries/PhpSpreadsheet/vendor/autoload.php';

    // Use the PhpSpreadsheet namespace
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    session_start();
    require_once('../../../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);
    // $name_esc = str_replace(' ', '_', $u["escuela"]);

    $sqlUsuarios = $con->prepare("SELECT usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, roles.rol, estados.estado FROM usuarios
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
    WHERE usuarios.documento != ? AND usuarios.id_rol > 2 AND detalles_usuarios_escuela.id_escuela = ? ORDER BY usuarios.documento ASC");
    $sqlUsuarios->execute([$documento, $u['id_escuela']]);
    $results = $sqlUsuarios->fetchAll(PDO::FETCH_ASSOC);

    // Create new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Lista de Usuarios');

    // Set headers
    $sheet->setCellValue('A1', 'Documento');
    $sheet->setCellValue('B1', 'Nombres');
    $sheet->setCellValue('C1', 'Apellidos');
    $sheet->setCellValue('D1', 'Correo');
    $sheet->setCellValue('E1', 'Rol');
    $sheet->setCellValue('F1', 'Estado');

    // Populate data
    $rowNumber = 2;
    foreach ($results as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row['documento']);
        $sheet->setCellValue('B' . $rowNumber, $row['nombre']);
        $sheet->setCellValue('C' . $rowNumber, $row['apellido']);
        $sheet->setCellValue('D' . $rowNumber, $row['email']);
        $sheet->setCellValue('E' . $rowNumber, $row['rol']);
        $sheet->setCellValue('F' . $rowNumber, $row['estado']);
        $rowNumber++;
    }

    // Auto-size columns
    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Save to file and download
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Lista_de_Usuarios.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
?>