<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlMenusEstudiantes = $con->prepare("SELECT * FROM estudiantes INNER JOIN estados ON estudiantes.id_estado = estados.id_estado");
    $sqlMenusEstudiantes->execute();

    $listMenus = [];

    if ($sqlMenusEstudiantes -> rowCount() > 0) {
        while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listMenus[] = $menus;
        }
    }
    
    echo json_encode($listMenus);
?>