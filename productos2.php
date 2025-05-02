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
    <link rel="stylesheet" href="styles/productos2.css">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container-main">
        <form action="" method="POST" id="form" class="container-form">    
            <h1>Productos:</h1>
            <div class="container-section">
                <?php
                    if (isset($_GET['categoria'])) {
                    $idCategoria = addslashes($_GET['categoria']);
                    $sqlProducts = $con->prepare("SELECT * FROM producto WHERE id_categoria = '$idCategoria'");
                    $sqlProducts->execute();
                    $p = $sqlProducts->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($p as $producto) {
                ?>
        
                <div class="container-products">
                    <img src="img/products/<?php echo $producto['imagen_prod']; ?>" alt="">
                    <div class="container-name">
                        <h3><?php echo $producto['nombre_prod']; ?><br><?php echo $producto['descripcion']; ?></h3>
                    </div>
                </div>
                <?php
                    }}
                ?>
            </div>      
        </form>
    </main>
</body>
</html>