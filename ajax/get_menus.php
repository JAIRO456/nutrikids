<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlMenusEstudiantes = $con->prepare("SELECT DISTINCT menus.id_menu, estudiantes.nombre, menus.nombre_menu, estados.estado FROM detalles_pedidos_producto
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
    INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est");
    $sqlMenusEstudiantes->execute();

    $listMenus = [];

    if ($sqlMenusEstudiantes -> rowCount() > 0) {
        while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listMenus[] = $menus;
        }
    }
    
    echo json_encode($listMenus);
?>