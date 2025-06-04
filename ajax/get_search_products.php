<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $id_categoria = $_GET['id_categoria'];
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlProducts = $con->prepare("SELECT producto.id_producto, producto.nombre_prod, producto.precio, producto.imagen_prod FROM producto
        WHERE id_categoria = ? AND producto.nombre_prod LIKE ? ORDER BY producto.nombre_prod ASC");
        $sqlProducts->execute([$id_categoria, $searchLike]);
    }
    else {
        $sqlProducts = $con -> prepare("SELECT id_producto, nombre_prod, precio, imagen_prod FROM producto
        WHERE id_categoria = ?");
        $sqlProducts -> execute([$id_categoria]);
    }

    $listProducts = [];
    while ($product = $sqlProducts->fetch(PDO::FETCH_ASSOC)) {
        $listProducts[] = $product;
    }

    echo json_encode($listProducts);
    exit;
?>
