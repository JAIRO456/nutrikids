<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $listProductCategories = [];

    $sqlProducts = $con->prepare("SELECT imagen_prod, id_producto, nombre_prod, precio FROM producto WHERE id_categoria = 2");
    $sqlProducts->execute();

        if ($sqlProducts -> rowCount() > 0) {
            while ($Produts = $sqlProducts -> fetch(PDO::FETCH_ASSOC)) {
                $listProductCategories[] = $Produts;
            }
        }
    
    echo json_encode($listProductCategories);
?>