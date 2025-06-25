<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();  

    include 'menu.php';    

    $productos = [];
    $categoria_nombre = ""; 

    if (isset($_GET['id_categoria'])) {
        $id_categoria = $_GET['id_categoria'];  

        // Obtener los productos de la categoría seleccionada
        $query_productos = $con->prepare("SELECT * FROM producto WHERE id_categoria = :id_categoria");
        $query_productos->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $query_productos->execute();
        $productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);  

        // Obtener el nombre de la categoría
        $query_categoria = $con->prepare("SELECT categoria FROM categorias WHERE id_categoria = :id_categoria");
        $query_categoria->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $query_categoria->execute();
        $categoria_nombre = $query_categoria->fetchColumn();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .product-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .product-card h3 {
            margin-top: 10px;
            font-size: 18px;
        }
        .product-card p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <main class="container mt-2">
        <a href="categorias.php" class="btn btn-secondary mb-3">Regresar</a>
        <h3 class='text-center'>Productos de la categoría: <br><?php echo htmlspecialchars($categoria_nombre); ?></h1>
        <div class="row">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-3 product-card">
                        <a href="especificacione_produ.php?id_producto=<?php echo $producto['id_producto']; ?>" style="text-decoration:none; color:inherit;">
                            <img src="../img/products/<?php echo htmlspecialchars($producto['imagen_prod']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_prod']); ?>">
                            <h3><?php echo htmlspecialchars($producto['nombre_prod']); ?></h3>
                            <p>$<?php echo number_format($producto['precio'], 2); ?></p>
                        </a>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles para esta categoría.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>