<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlUser = $con -> prepare("SELECT usuarios.imagen, usuarios.documento, usuarios.nombre, usuarios.apellido, roles.rol, estados.estado FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado");
    $sqlUser -> execute();

    $listRolesUsers = [];

    if ($sqlUser -> rowCount() > 0) {
        while ($users = $sqlUser -> fetch(PDO::FETCH_ASSOC)) {
            $listRolesUsers[] = $users;
        }
    }
    
    echo json_encode($listRolesUsers);
?>