<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlEstudiantes = $con -> prepare("SELECT estudiantes.imagen_est, estudiantes.documento_est, estudiantes.nombre_est, estudiantes.apellido_est, estados.estado FROM estudiantes 
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento INNER JOIN estados ON estudiantes.id_estado = estados.id_estado WHERE usuarios.documento = ?");
    $sqlEstudiantes -> execute([$_SESSION['documento']]);

    $listEstudiants = [];

    if ($sqlEstudiantes -> rowCount() > 0) {
        while ($estudiantes = $sqlEstudiantes -> fetch(PDO::FETCH_ASSOC)) {
            $listEstudiants[] = $estudiantes;
        }
    }
    
    echo json_encode($listEstudiants);
?>