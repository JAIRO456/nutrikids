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
    $sqlRoles = $con->prepare("SELECT usuarios.documento FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    if ($sqlRoles->execute([$doc])) {
        $u = $sqlRoles->fetch();
        $sqlSchools = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM escuelas 
        INNER JOIN detalles_estudiantes_escuela ON escuelas.id_escuela = detalles_estudiantes_escuela.id_escuela
        WHERE escuelas.id_escuela = ?");
        $sqlSchools->execute([$u['id_escuela']]);
        $s = $sqlSchools->fetch();
        $response['TotalEstudiantes'] = $s['TotalEstudiantes'];
    } 

    // Obtener el conteo de estudiantes
    $sqlEstudiantes = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM estudiantes");
    $sqlEstudiantes->execute();
    $e = $sqlEstudiantes->fetch();
    $response['TotalEstudiantes'] = $e['TotalEstudiantes'];

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>