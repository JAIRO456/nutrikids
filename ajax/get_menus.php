<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlMenusEstudiantes = $con->prepare("SELECT detalles_pedidos_producto.id_det_ped_prod, estudiantes.nombre, menus.nombre_menu, estados.estado FROM detalles_pedidos_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
    INNER JOIN estados ON pedidos.id_estado = estados.id_estado");
    $sqlMenusEstudiantes->execute();

    $listMenus = [];

    if ($sqlMenusEstudiantes -> rowCount() > 0) {
        while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listMenus[] = $menus;
        }
    }
    
    echo json_encode($listMenus);
?>