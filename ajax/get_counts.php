<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

    // Obtener el conteo de usuarios
    $sqlRoles = $con->prepare("SELECT COUNT(*) AS TotalUser FROM usuarios");
    $sqlRoles->execute();
    $u = $sqlRoles->fetch();
    $response['TotalUsers'] = $u['TotalUsers'];

    // Obtener el conteo de licencias
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM licencias");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalLicencias'] = $p['TotalLicencias'];

    // Obtener el conteo de escuelas
    $sqlSchools = $con->prepare("SELECT COUNT(*) AS TotalSchools FROM escuelas");
    $sqlSchools->execute();
    $s = $sqlSchools->fetch();
    $response['TotalSchools'] = $s['TotalSchools'];

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>