<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sqlUserNew = $con -> prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");

    if ($sqlUserNew -> execute([$documento])) {
        $u = $sqlUserNew -> fetch();
        $sqlSchools = $con->prepare("SELECT usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email FROM usuarios
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ?");
        $sqlSchools->execute([$u['id_escuela']]);
        $s = $sqlSchools->fetch();
        
        $listUsers = [];
        if ($sqlSchools -> rowCount() > 0) {
            while ($newUsers = $sqlSchools -> fetch(PDO::FETCH_ASSOC)) {
                $listUsers[] = $newUsers;
            }
        }
    }
    
    echo json_encode($listUsers);
?>