<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    if (isset($_GET['id_estudiante']) && !empty($_GET['id_estudiante']) && isset($_GET['dia']) && !empty($_GET['dia'])) {
        $dia = $_GET['dia'];
        $id_estudiante = $_GET['id_estudiante'];
    } 
    else {
        echo json_encode(['error' => 'ID de estudiante o día no especificado']);
        exit;
    }

    try {
        $listHorarios = [];
        $total = 0;
        $sqlHorarios = $con->prepare("SELECT producto.nombre_prod, detalles_pedidos_producto.cantidad, detalles_pedidos_producto.subtotal
        FROM detalles_pedidos_producto
        INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
        INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
        INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
        INNER JOIN detalles_estudiantes_escuela ON pedidos.id_detalle_estudiante = detalles_estudiantes_escuela.id_detalle_estudiante
        WHERE detalles_estudiantes_escuela.documento_est = ? AND pedidos.dia = ?");
        $sqlHorarios->execute([$id_estudiante, $dia]);
        while ($row = $sqlHorarios->fetch(PDO::FETCH_ASSOC)) {
            $listHorarios[] = $row;
            $total += floatval($row['subtotal']);
        }
        echo json_encode([
            'pedido' => $listHorarios,
            'total' => number_format($total, 2, '.', '')
        ]);
    } 
    catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        exit;
    }
?>