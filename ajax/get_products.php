<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlProducts = $con->prepare("SELECT * FROM producto
    INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
    ORDER BY producto.id_producto ASC");
    $sqlProducts->execute();
    
    $listProducts = [];

    if ($sqlProducts->rowCount() > 0) {
        while ($product = $sqlProducts->fetch(PDO::FETCH_ASSOC)) {
            $listProducts[] = $product;
        }
    }
    echo json_encode($listProducts);
?>