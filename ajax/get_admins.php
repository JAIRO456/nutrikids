<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

    // Parámetros de paginación
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10; // Número de registros por página
    $offset = ($page - 1) * $perPage;

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela 
        FROM usuarios
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        WHERE roles.id_rol = 2 
        AND (usuarios.documento LIKE ? OR usuarios.nombre LIKE ? OR usuarios.apellido LIKE ? OR usuarios.email LIKE ? OR escuelas.nombre_escuela LIKE ?)
        ORDER BY usuarios.documento ASC
        LIMIT ? OFFSET ?");
        $sqlDirectores->execute([$searchLike, $searchLike, $searchLike, $searchLike, $searchLike, $perPage, $offset]);
    } else {
        $sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela 
        FROM usuarios 
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
        WHERE roles.id_rol = 2 
        ORDER BY usuarios.documento ASC
        LIMIT ? OFFSET ?");
        $sqlDirectores->execute([$perPage, $offset]);
    }

    $listDirectores = [];
    while ($director = $sqlDirectores->fetch(PDO::FETCH_ASSOC)) {
        $listDirectores[] = $director;
    }

    // Obtener el total de registros para calcular el número de páginas
    if (!empty($search)) {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total 
        FROM usuarios
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE roles.id_rol = 2 
        AND (usuarios.documento LIKE ? OR usuarios.nombre LIKE ? OR usuarios.apellido LIKE ? OR usuarios.email LIKE ? OR escuelas.nombre_escuela LIKE ?)");
        $sqlCount->execute([$searchLike, $searchLike, $searchLike, $searchLike, $searchLike]);
    } else {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total 
        FROM usuarios 
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
        WHERE roles.id_rol = 2");
        $sqlCount->execute();
    }

    $totalRecords = $sqlCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRecords / $perPage);

    $response = [
        'data' => $listDirectores,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];

    echo json_encode($response);
    exit;
?>