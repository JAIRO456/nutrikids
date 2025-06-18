<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    // Parámetros de paginación
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10; // Número de registros por página
    $offset = ($page - 1) * $perPage;

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlProducts = $con->prepare("SELECT * FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE nombre_prod LIKE ? OR id_producto LIKE ? ORDER BY nombre_prod ASC LIMIT ? OFFSET ?");
        $sqlProducts->execute([$searchLike, $searchLike, $perPage, $offset]);
    } elseif (!empty($category)) {
        $sqlProducts = $con->prepare("SELECT * FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE producto.id_categoria = ? ORDER BY producto.id_producto ASC LIMIT ? OFFSET ?");
        $sqlProducts->execute([$category, $perPage, $offset]);
    } else {
        $sqlProducts = $con->prepare("SELECT * FROM producto
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
        ORDER BY producto.id_producto ASC LIMIT ? OFFSET ?");
        $sqlProducts->execute([$perPage, $offset]);
    }
    
    $listProducts = [];
    while ($product = $sqlProducts->fetch(PDO::FETCH_ASSOC)) {
        $listProducts[] = $product;
    }

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlCount = $con->prepare("SELECT COUNT(*) as total FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE nombre_prod LIKE ? OR id_producto LIKE ?");
        $sqlCount->execute([$searchLike, $searchLike]);
    } elseif (!empty($category)) {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total FROM producto 
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
        WHERE producto.id_categoria = ?");
        $sqlCount->execute([$category]);
    } else {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total FROM producto
        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria");
        $sqlCount->execute();
    }

    $totalRecords = $sqlCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRecords / $perPage);

    $response = [
        'data' => $listProducts,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];

    echo json_encode($response);
    exit;
?>
