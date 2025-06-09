<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

    // Obtener el conteo de productos
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM producto");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalProducts'] = $p['TotalProducts'];

    // Obtener el conteo de usuarios
    $doc = $_SESSION['documento'];
    $sqlRoles = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    if ($sqlRoles->execute([$doc])) {
        $u = $sqlRoles->fetch();
        $sqlUsers = $con->prepare("SELECT COUNT(*) AS TotalUsers FROM usuarios 
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ?");
        $sqlUsers->execute([$u['id_escuela']]);
        $s = $sqlUsers->fetch();
        $response['TotalUsers'] = $s['TotalUsers'];

        $sqlEstudiantes = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM estudiantes 
        INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
        INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ?");
        $sqlEstudiantes->execute([$u['id_escuela']]);
        $s = $sqlEstudiantes->fetch();
        $response['TotalEstudiantes'] = $s['TotalEstudiantes'];
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>