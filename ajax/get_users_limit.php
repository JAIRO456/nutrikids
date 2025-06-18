<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlUserNew = $con -> prepare("SELECT documento, nombre, apellido, email FROM usuarios ORDER BY documento ASC LIMIT 5");
    $sqlUserNew -> execute();

    $listUsers = [];

    if ($sqlUserNew -> rowCount() > 0) {
        while ($newUsers = $sqlUserNew -> fetch(PDO::FETCH_ASSOC)) {
            $listUsers[] = $newUsers;
        }
    }
    
    echo json_encode($listUsers);
?>