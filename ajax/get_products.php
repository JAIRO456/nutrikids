<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

<<<<<<< HEAD
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlProducts = $con->prepare("SELECT * FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE nombre_prod LIKE ? OR id_producto LIKE ? ORDER BY nombre_prod ASC");
        $sqlProducts->execute([$searchLike, $searchLike]);
    }
    elseif (!empty($category)) {
        $sqlProducts = $con->prepare("SELECT * FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE producto.id_categoria = ? ORDER BY producto.id_producto ASC");
        $sqlProducts->execute([$category]);
    }
    else {
        $sqlProducts = $con->prepare("SELECT * FROM producto
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
        ORDER BY producto.id_producto ASC");
        $sqlProducts->execute();
    }

    $listProducts = [];
    while ($product = $sqlProducts->fetch(PDO::FETCH_ASSOC)) {
        $listProducts[] = $product;
    }

    echo json_encode($listProducts);
    exit;
?>
=======
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
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
