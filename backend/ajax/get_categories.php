<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $listProductCategories = [];

    $sqlCategories = $con->prepare("SELECT imagen_prod, id_producto, nombre_prod, precio FROM producto WHERE id_categoria = 2");
    $sqlCategories->execute();

        if ($sqlCategories -> rowCount() > 0) {
            while ($Categories = $sqlCategories -> fetch(PDO::FETCH_ASSOC)) {
                $listCategories[] = $Categories;
            }
        }
    
    echo json_encode($listCategories);
?>