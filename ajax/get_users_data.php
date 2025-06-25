<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    header('Content-Type: application/json');

    $fecha_ini = isset($_GET['fecha_ini']) ? $_GET['fecha_ini'] : null;
    $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
    $id_escuela = isset($_GET['id_escuela']) ? $_GET['id_escuela'] : null;

    // Si no se proporcionan fechas, usar la fecha actual
    if (!$fecha_ini && !$fecha_fin) {
        $fecha_ini = date('Y-m-d');
        $fecha_fin = date('Y-m-d');
    } elseif ($fecha_ini && !$fecha_fin) {
        $fecha_fin = $fecha_ini;
    } elseif (!$fecha_ini && $fecha_fin) {
        $fecha_ini = $fecha_fin;
    }

    $sqlUsers = $con -> prepare("SELECT COUNT(*) as total_users FROM usuarios
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE escuelas.id_escuela = ? AND usuarios.id_estado = 1");
    $sqlUsers -> execute([$id_escuela]);
    $users = $sqlUsers -> fetch(PDO::FETCH_ASSOC);
    $total_users = $users['total_users'];
    
    $sqlUsersActive = $con -> prepare("SELECT COUNT(DISTINCT pedidos.documento) as total_users_active FROM pedidos 
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento 
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
    WHERE escuelas.id_escuela = ? AND usuarios.id_estado = 1 AND pedidos.fecha_ini >= ? AND pedidos.fecha_fin <= ?");
    $sqlUsersActive -> execute([$id_escuela, $fecha_ini, $fecha_fin]);
    $usersActive = $sqlUsersActive -> fetch(PDO::FETCH_ASSOC);
    $total_users_active = $usersActive['total_users_active'];

    $porcentaje_users_active = ($total_users_active / $total_users) * 100;
    $porcentaje_users_active = number_format($porcentaje_users_active, 2);

    $total_users_inactive = ($total_users - $total_users_active);
    $porcentaje_users_inactive = ($total_users - $total_users_active) / $total_users * 100;
    $porcentaje_users_inactive = number_format($porcentaje_users_inactive, 2);

    echo json_encode([
        'total_users' => $total_users,
        'total_users_active' => $total_users_active,
        'porcentaje_users_active' => $porcentaje_users_active,
        'total_users_inactive' => $total_users_inactive,
        'porcentaje_users_inactive' => $porcentaje_users_inactive
    ]);
?>