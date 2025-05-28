<?php

session_start();
require_once('conex/conex.php');
<<<<<<< HEAD
include "menu.php";
=======
include "menu.html";
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
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
=======
<body>
    <main class="container-main">
        <?php
            $sqlCategories = $con->prepare("SELECT * FROM categorias");
            $sqlCategories->execute();
            $c = $sqlCategories->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <section class="container-productos">
            <?php 
                foreach ($c as $category){ 
                    if ($category['id_categoria'] < 6){?>
                
                    <div class="productos">
                        <a href="productos2.php?categoria=<?php echo $category['id_categoria']; ?>"><img src="img/categories/<?php echo $category['imagen']; ?>" alt=""></a>
                        <h3><?php echo $category['categoria']; ?></h3>
                    </div>
            <?php
                    }}
            ?>
 
        </section>
    </main>
    
    <?php include "footer.html"; ?>

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>