<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    
    if ($sql->execute([$documento])) {
        $u = $sql->fetch(PDO::FETCH_ASSOC);
        $sqlUserAll = $con -> prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, roles.rol, usuarios.email, estados.estado FROM usuarios
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        INNER JOIN estados ON usuarios.id_estado = estados.id_estado
        WHERE usuarios.documento != ? AND detalles_usuarios_escuela.id_escuela = ? ORDER BY documento ASC");
        $sqlUserAll -> execute([$documento, $u['id_escuela']]);

        $listAllUsers = [];

        if ($sqlUserAll -> rowCount() > 0) {
            while ($allUsers = $sqlUserAll -> fetch(PDO::FETCH_ASSOC)) {
                $listAllUsers[] = $allUsers;
            }
        }

        echo json_encode($listAllUsers);
    } 
    else {
        echo '<script>alert("Error al obtener los datos del usuario")</script>';
        exit;
    }
?>