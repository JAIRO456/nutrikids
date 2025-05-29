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

    $sql = $con->prepare("SELECT producto.nombre_prod, detalles_pedidos_producto.subtotal, detalles_pedidos_producto.cantidad
    FROM detalles_pedidos_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    WHERE detalles_pedidos_producto.documento_est = ? AND FIND_IN_SET(?, pedidos.dia) > 0");
    $sql->execute([$id_estudiante, $dia]);
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    $response = [];
    foreach ($pedidos as $pedido) { 
        $response[] = [
            'nombre_prod' => $pedido['nombre_prod'],
            'cantidad' => $pedido['cantidad'],
            'subtotal' => number_format($pedido['subtotal'], 2),
        ];
    }
    if (empty($response)) {
        echo json_encode(['error' => 'No hay pedidos para este estudiante en este día.']);
    } 
    else {
        echo json_encode(['pedidos' => $response]);
    }
?>