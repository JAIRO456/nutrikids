<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos.css">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container-main">
        <?php
            $sqlCategories = $con->prepare("SELECT * FROM categorias");
            $sqlCategories->execute();
            $cat = $sqlCategories->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <section class="container1">
            <?php 
                foreach ($cat as $category){ ?>
                <div class="productos">
                    <a href="productos.php?id_categoria=<?php echo $category['id_categoria']; ?>"><img src="../img/categories/<?php echo $category['imagen']; ?>" alt=""></a>
                    <h3><?php echo $category['categoria']; ?></h3>
                </div>

            <?php
                }
            ?>

            <div class="productos">
                <a href="agregar_productos.php"><img src="../img/agregar_productos.png" alt=""></a>
                <h3>AGREGAR</h3>
            </div>
        </section>
    </main>
</body>
</html>