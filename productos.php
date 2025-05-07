<?php

session_start();
require_once('conex/conex.php');
include "menu.html";
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

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>