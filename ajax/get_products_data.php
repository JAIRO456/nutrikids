<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    header('Content-Type: application/json');

    $fecha_ini = isset($_GET['fecha_ini']) ? $_GET['fecha_ini'] : null;
    $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
    $id_escuela = isset($_GET['id_escuela']) ? $_GET['id_escuela'] : null;

    // Si no se proporcionan fechas, usar la fecha actual
    if (!$fecha_ini && !$fecha_fin) {
        $fecha_ini = date('Y-m-d');
        $fecha_fin = date('Y-m-d');
    } elseif ($fecha_ini && !$fecha_fin) {
        $fecha_fin = $fecha_ini;
    } elseif (!$fecha_ini && $fecha_fin) {
        $fecha_ini = $fecha_fin;
    }

    $sqlInfoProductos = $con -> prepare("SELECT producto.nombre_prod, SUM(detalles_pedidos_producto.cantidad) AS total_cantidad
    FROM producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE pedidos.fecha_ini >= ? AND pedidos.fecha_fin <= ? AND pedidos.id_estado = 6 AND escuelas.id_escuela = ? 
    GROUP BY producto.nombre_prod
    ORDER BY total_cantidad DESC LIMIT 10");
    
    $sqlInfoProductos -> execute([$fecha_ini, $fecha_fin, $id_escuela]);
    $InfoProductos = $sqlInfoProductos -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($InfoProductos);
?>