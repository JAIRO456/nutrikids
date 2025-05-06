<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlLicencias = $con -> prepare("SELECT * FROM licencias
    INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo
    INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
    ORDER BY id_licencia ASC;");
    $sqlLicencias -> execute();
    
    $listLicencias = [];

    if ($sqlLicencias -> rowCount() > 0) {
        while ($licencias = $sqlLicencias -> fetch(PDO::FETCH_ASSOC)) {
            $listLicencias[] = $licencias;
        }
    }
    echo json_encode($listLicencias);
?>