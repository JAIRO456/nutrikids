<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    header('Content-Type: application/json');

    $fecha_ini = isset($_GET['fecha_ini']) ? $_GET['fecha_ini'] : null;
    $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

    $sqlInfoNutriconal = $con->prepare("SELECT SUM(calorias) AS total_cal, SUM(proteinas) AS total_pro, SUM(carbohidratos) AS total_car, SUM(grasas) AS total_gras, SUM(azucares) AS total_azu, SUM(sodio) AS total_sod FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto 
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto 
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos 
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
    INNER JOIN detalles_menu ON detalles_menu.id_menu = menus.id_menu 
    WHERE pedidos.fecha_ini >= ? AND pedidos.fecha_ini <= ? AND detalles_menu.id_estado = 3");
    $sqlInfoNutriconal->execute([$fecha_ini, $fecha_fin]);
    $resultado = $sqlInfoNutriconal->fetch(PDO::FETCH_ASSOC);

    // Si no hay datos, devolver ceros para evitar errores en el gráfico
    echo json_encode(array_map(function($value) {
        return $value ?? 0;
    }, $resultado));
?>






