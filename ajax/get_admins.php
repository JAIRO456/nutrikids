<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

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
?>