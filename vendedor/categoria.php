<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$query_categorias = $con->prepare("SELECT * FROM categorias");
$query_categorias->execute();
$categorias = $query_categorias->fetchAll(PDO::FETCH_ASSOC);

include 'menu.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card {
            display: inline-block;
            margin: 10px;
            text-align: center;
            cursor: pointer;
        }
        .category-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .category-card h3 {
            margin-top: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Categorías</h1>
        <div class="mb-4">
            <a href="crear_producto.php" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Crear Producto
            </a>
        </div>
        <form method="POST" action="productos.php">
            <div class="row">
                <?php foreach ($categorias as $categoria): ?>
                    <div class="col-md-3 category-card">
                        <button type="submit" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>" class="btn btn-link">
                            <img src="../img/categories/<?php echo $categoria['imagen']; ?>" alt="<?php echo $categoria['categoria']; ?>">
                            <h3><?php echo $categoria['categoria']; ?></h3>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
        </form>
    </div>
</body>
</html>