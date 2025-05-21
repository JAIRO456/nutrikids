<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_estudiante = $_GET['id_estudiante'];
    $dia = $_GET['dia'];

    if (empty($id_estudiante) || empty($dia)) {
        echo json_encode(['error' => 'ID de estudiante o día no proporcionados.']);
        exit;
    }

    $sql = $con->prepare("SELECT producto.precio, producto.nombre_prod, detalles_pedidos_producto.cantidad, detalles_pedidos_producto.subtotal 
    FROM detalles_pedidos_producto 
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto 
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos 
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = detalles_pedidos_producto.documento_est 
    WHERE estudiantes.documento_est = ? AND pedidos.dia = ?");
    $sql->execute([$id_estudiante, $dia]);
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    $total = 0;
    $response = [];
    foreach ($pedidos as $pedido) { 
        $subtotal = $pedido['precio'] * $pedido['cantidad'];
        $total += $subtotal;
        $response[] = [
            'nombre_prod' => $pedido['nombre_prod'],
            'cantidad' => $pedido['cantidad'],
            'subtotal' => number_format($subtotal, 2)
        ];
    }
    if (empty($response)) {
        echo json_encode(['error' => 'No hay pedidos para este estudiante en este día.']);
    } 
    else {
        echo json_encode(['pedidos' => $response, 'total' => number_format($total, 2)]);
    }
?>