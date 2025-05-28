<?php

session_start();
require_once('conex/conex.php');
include "menu.php";
$conex = new Database;
$con = $conex->conectar();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index_productos.css">
    <title>Productos</title>
</head>
..
<body>
    <div class="container mt-4">
        <?php if ($categoria_nombre): ?>
            <h2 class="mb-4">Productos de la categoría: <?php echo htmlspecialchars($categoria_nombre); ?></h2>
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="card-img-top" alt="Imagen de <?php echo htmlspecialchars($producto['nombre_prod']); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                                <a href="especificacione_produ.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-primary">Ver especificaciones</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Selecciona una categoría para ver los productos.</div>
        <?php endif; ?>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>