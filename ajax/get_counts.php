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
    $sqlRoles = $con->prepare("SELECT COUNT(*) AS TotalUser FROM usuarios");
    $sqlRoles->execute();
    $u = $sqlRoles->fetch();
    $response['TotalUser'] = $u['TotalUser'];

    // Obtener el conteo de estudiantes
    $sqlEstudiantes = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM estudiantes");
    $sqlEstudiantes->execute();
    $e = $sqlEstudiantes->fetch();
    $response['TotalEstudiantes'] = $e['TotalEstudiantes'];

    // Obtener el conteo de escuelas
    $sqlSchools = $con->prepare("SELECT COUNT(*) AS TotalSchools FROM escuelas");
    $sqlSchools->execute();
    $s = $sqlSchools->fetch();
    $response['TotalSchools'] = $s['TotalSchools'];

    // Obtener el conteo de ventas, pero como no hay pues no :v

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>