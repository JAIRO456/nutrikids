<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlProducts = $con->prepare("SELECT id_producto, nombre_prod, categoria FROM producto
    INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
    ORDER BY producto.id_producto ASC LIMIT 5");
    $sqlProducts->execute();

    $listProducts = [];
    while ($product = $sqlProducts->fetch(PDO::FETCH_ASSOC)) {
        $listProducts[] = $product;
    }

    echo json_encode($listProducts);
    exit;
?>
