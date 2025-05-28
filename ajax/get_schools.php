<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlSchools = $con -> prepare("SELECT * FROM escuelas ORDER BY nombre_escuela ASC;");
    $sqlSchools -> execute();

    $listAdmins = [];

    if ($sqlSchools -> rowCount() > 0) {
        while ($Schools = $sqlSchools -> fetch(PDO::FETCH_ASSOC)) {
            $listSchools[] = $Schools;
        }
    }
    
    echo json_encode($listSchools);
?>