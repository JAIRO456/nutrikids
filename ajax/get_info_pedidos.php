<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_pedido = $_POST['id_pedido'];
    $sqlInfoPedido = $con -> prepare("SELECT * FROM detalles_pedidos_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    WHERE detalles_pedidos_producto.id_pedidos = ?");
    $sqlInfoPedido -> execute([$id_pedido]);

    $listInfoPedidos = [];

    if ($sqlInfoPedidos -> rowCount() > 0) {
        while ($InfoPedidos = $sqlInfoPedidos -> fetch(PDO::FETCH_ASSOC)) {
            $listInfoPedidos[] = $InfoPedidos;
        }
    }
    
    echo json_encode($listInfoPedidos);
?>