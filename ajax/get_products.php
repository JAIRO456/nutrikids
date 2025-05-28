<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $sqlProdutsNew = $con -> prepare("SELECT producto.nombre_prod, categorias.categoria, producto.precio FROM producto INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria ORDER BY id_producto DESC LIMIT 5");
    $sqlProdutsNew -> execute();

    $listProducts = [];

    if ($sqlProdutsNew -> rowCount() > 0) {
        while ($newProduts = $sqlProdutsNew -> fetch(PDO::FETCH_ASSOC)) {
            $listProducts[] = $newProduts;
        }
    }

    echo json_encode($listProducts);
?>