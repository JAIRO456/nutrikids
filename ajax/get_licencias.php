<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

<<<<<<< HEAD
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlLicencias = $con->prepare("SELECT * FROM licencias 
        INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo 
        INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
        WHERE licencias.id_licencia LIKE ? OR escuelas.nombre_escuela LIKE ?
        ORDER BY licencias.id_licencia ASC");
        $sqlLicencias->execute([$searchLike, $searchLike]);
    } 
    elseif (!empty($tipo)) {
        $sqlLicencias = $con->prepare("SELECT * FROM licencias 
        INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo
        INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
        WHERE licencias.id_tipo = ? ORDER BY licencias.id_licencia ASC");
        $sqlLicencias->execute([$tipo]);
    } 
    else {
        $sqlLicencias = $con->prepare("SELECT * FROM licencias
        INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo
        INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
        ORDER BY licencias.id_licencia ASC;");
        $sqlLicencias->execute();
    }

    $listLicencias = [];
    while ($licencia = $sqlLicencias->fetch(PDO::FETCH_ASSOC)) {
        $listLicencias[] = $licencia;
    }

    echo json_encode($listLicencias);
    exit;
=======
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
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
?>