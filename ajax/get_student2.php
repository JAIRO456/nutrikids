<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sqlUserNew = $con -> prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");

    if ($sqlUserNew -> execute([$documento])) {
        $u = $sqlUserNew -> fetch();
        $sqlSchools = $con->prepare("SELECT estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido, estudiantes.email FROM estudiantes
        INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
        INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ? ORDER BY estudiantes.documento_est DESC LIMIT 5");
        $sqlSchools->execute([$u['id_escuela']]);
        $s = $sqlSchools->fetch();
        
        $listStudents = [];
        if ($sqlSchools -> rowCount() > 0) {
            while ($newStudents = $sqlSchools -> fetch(PDO::FETCH_ASSOC)) {
                $listStudents[] = $newStudents;
            }
        }
    }
    
    echo json_encode($listStudents);
?>