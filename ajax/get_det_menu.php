<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    header('Content-Type: application/json');

    $documento = $_SESSION['documento'];

    $id_menu = $_GET['id_menu'];
    if (!$id_menu || !$documento) {
        echo json_encode(['error' => 'ID de menú o usuario no válido.']);
        exit;
    }
    
    // Verificar que el menú pertenece al usuario
    $sqlMenu = $con->prepare("SELECT id_menu FROM menus WHERE id_menu = ? AND documento = ?");
    $sqlMenu->execute([$id_menu, $documento]);
    if (!$sqlMenu->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode(['error' => 'Menú no encontrado o no autorizado.']);
        exit;
    }

    $sql = $con->prepare("SELECT producto.id_producto, producto.precio, producto.nombre_prod, detalles_menu.cantidad, detalles_menu.subtotal, detalles_menu.dias
    FROM detalles_menu
    INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_menu.id_producto = producto.id_producto
    WHERE detalles_menu.id_menu = ?");
    $sql->execute([$id_menu]);
    $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    // Validar si el menú tiene productos
    if (empty($pedidos)) {
        echo json_encode(['error' => 'Este menú no tiene productos.']);
        exit;
    }
    
    $total = 0;
    $response = [];
    foreach ($pedidos as $pedido) { 
        $subtotal = $pedido['precio'] * $pedido['cantidad'];
        $total += $subtotal;
        $response[] = [
            'nombre_prod' => $pedido['nombre_prod'],
            'cantidad' => $pedido['cantidad'],
            'subtotal' => number_format($subtotal, 2),
            'precio' => $pedido['precio'],
            'id_producto' => $pedido['id_producto'],
            'dias' => $pedido['dias']
        ];
    }
    
    echo json_encode(['pedidos' => $response, 'total' => number_format($total, 2)]);
?>