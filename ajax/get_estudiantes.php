<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sqlStudents = $con -> prepare("SELECT documento_est, nombre, apellido, email FROM estudiantes WHERE documento = ? ORDER BY documento_est ASC");
    $sqlStudents -> execute([$documento]);

    $listStudents = [];

    if ($sqlStudents -> rowCount() > 0) {
        while ($Students = $sqlStudents -> fetch(PDO::FETCH_ASSOC)) {
            $listStudents[] = $Students;
        }
    }
    
    echo json_encode($listStudents);
?>