<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    if (isset($_GET['dia']) && !empty($_GET['dia'])) {
        $dia = $_GET['dia'];
    }
    else {
        echo json_encode(['error' => 'Día no especificado']);
        exit;
    }
    
    try {
        $listPedidos = [];
        $total = 0;
        $sqlPedidos = $con->prepare("SELECT producto.nombre_prod, detalles_pedidos_producto.cantidad, detalles_pedidos_producto.subtotal 
        FROM detalles_pedidos_producto 
        INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
        INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto 
        INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos 
        WHERE pedidos.dia = ?");
        $sqlPedidos->execute([$dia]);

        while ($row = $sqlPedidos->fetch(PDO::FETCH_ASSOC)) {
            $listPedidos[] = $row;
            $total += floatval($row['subtotal']);
        }
        echo json_encode([
            'pedidos' => $listPedidos,
            'total' => number_format($total, 2, '.', '')
        ]);
    } 
    catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        exit;
    }
?>