<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    $rol = isset($_GET['rol']) ? $_GET['rol'] : '';
    
    if ($sql->execute([$documento])) {
        $u = $sql->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($search)) {
            $searchLike = "%$search%";
            $sqlUsuarios = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, roles.rol, estados.estado FROM usuarios
            INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
            INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
            INNER JOIN roles ON usuarios.id_rol = roles.id_rol
            INNER JOIN estados ON usuarios.id_estado = estados.id_estado
            WHERE usuarios.documento != ? AND detalles_usuarios_escuela.id_escuela = ? AND (usuarios.documento LIKE ? OR usuarios.nombre LIKE ? OR usuarios.apellido LIKE ? OR roles.rol LIKE ?) ORDER BY documento ASC");
            $sqlUsuarios->execute([$documento, $u['id_escuela'], $searchLike, $searchLike, $searchLike, $searchLike]);
        }
        elseif (!empty($rol)) {
            $sqlUsuarios = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, roles.rol, estados.estado FROM usuarios
            INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
            INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
            INNER JOIN roles ON usuarios.id_rol = roles.id_rol
            INNER JOIN estados ON usuarios.id_estado = estados.id_estado
            WHERE usuarios.documento != ? AND detalles_usuarios_escuela.id_escuela = ? AND roles.id_rol = ? ORDER BY documento ASC");
            $sqlUsuarios->execute([$documento, $u['id_escuela'], $rol]);
        } 
        else {
            $sqlUsuarios = $con->prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, roles.rol, estados.estado FROM usuarios
            INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
            INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
            INNER JOIN roles ON usuarios.id_rol = roles.id_rol
            INNER JOIN estados ON usuarios.id_estado = estados.id_estado
            WHERE usuarios.documento != ? AND detalles_usuarios_escuela.id_escuela = ? ORDER BY documento ASC");
            $sqlUsuarios->execute([$documento, $u['id_escuela']]);
        }

        $listUsuarios = [];
        while ($usuario = $sqlUsuarios->fetch(PDO::FETCH_ASSOC)) {
            $listUsuarios[] = $usuario;
        }

        if (!empty($listUsuarios)) {
            echo json_encode($listUsuarios);
            exit;
        } 
        else {
            echo json_encode(['error' => 'No se encontraron usuarios']);
            exit;
        }
    } 
    else {
        echo json_encode(['error' => 'Error al obtener los datos del usuario']);
        exit;
    }
?>