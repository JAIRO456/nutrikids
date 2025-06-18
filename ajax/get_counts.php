<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

    $sql = "SELECT COUNT(*) AS total FROM usuarios 
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol WHERE roles.id_rol = 2";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['TotalUsers'] = $result['total'];

    $sql = "SELECT COUNT(*) AS total FROM licencias WHERE id_estado = 1";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['TotalLicencias'] = $result['total'];

    $sql = "SELECT COUNT(*) AS total FROM escuelas";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['TotalSchools'] = $result['total'];

    $sql = "SELECT COUNT(*) AS total FROM producto";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['TotalProducts'] = $result['total'];

    header('Content-Type: application/json');
    echo json_encode($response);
?>