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

    $sqlInfoNutriconal = $con->prepare("SELECT 
    SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod 
    FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE pedidos.fecha_ini >= ? AND pedidos.fecha_fin <= ? AND pedidos.id_estado = 6 AND detalles_menu.id_estado = 3" . 
    ($id_escuela ? " AND escuelas.id_escuela = ?" : "") . " ORDER BY producto.nombre_prod ASC LIMIT 10");

    $params = [$fecha_ini, $fecha_fin];
    if ($id_escuela) {
        $params[] = $id_escuela;
    }

    $sqlInfoNutriconal->execute($params);
    $resultado = $sqlInfoNutriconal->fetch(PDO::FETCH_ASSOC);

    // Si fetch no devuelve resultados, es false. Lo convertimos a array vacío.
    if (!$resultado) {
        $resultado = [];
    }

    // Mapeamos los resultados a los nombres que espera el JavaScript y convertimos a float.
    $datos_mapeados = [
        'calorias'      => (float)($resultado['total_cal'] ?? 0),
        'proteinas'     => (float)($resultado['total_pro'] ?? 0),
        'carbohidratos' => (float)($resultado['total_car'] ?? 0),
        'grasas'        => (float)($resultado['total_gras'] ?? 0),
        'azucares'      => (float)($resultado['total_azu'] ?? 0),
        'sodio'         => (float)($resultado['total_sod'] ?? 0)
    ];

    echo json_encode($datos_mapeados);
?>






