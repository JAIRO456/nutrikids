<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

<<<<<<< HEAD
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela FROM usuarios
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE roles.id_rol = 2 AND (usuarios.documento LIKE ? OR usuarios.nombre LIKE ? OR usuarios.apellido LIKE ? OR usuarios.email LIKE ? OR escuelas.nombre_escuela LIKE ?)
        ORDER BY usuarios.documento ASC");
        $sqlDirectores->execute([$searchLike, $searchLike, $searchLike, $searchLike, $searchLike]);
    } 
    else {
        $sqlDirectores = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela FROM usuarios 
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
        WHERE roles.id_rol = 2 ORDER BY usuarios.documento ASC");
        $sqlDirectores->execute();
    }

    $listDirectores = [];

    while ($director = $sqlDirectores->fetch(PDO::FETCH_ASSOC)) {
        $listDirectores[] = $director;
    }

    echo json_encode($listDirectores);
    exit;
=======
    $sqlUserRol = $con -> prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, usuarios.email, escuelas.nombre_escuela FROM usuarios 
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela 
    WHERE roles.id_rol = 2 ORDER BY usuarios.documento ASC;");
    $sqlUserRol -> execute();

    $listAdmins = [];

    if ($sqlUserRol -> rowCount() > 0) {
        while ($UserRol = $sqlUserRol -> fetch(PDO::FETCH_ASSOC)) {
            $listRol[] = $UserRol;
        }
    }
    
    echo json_encode($listRol);
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
?>