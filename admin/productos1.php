<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
include "crear_menu.php";
$conex =new Database;
$con = $conex->conectar();
 
?>

<?php
    $sqlUser = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela");
    $sqlUser -> execute();
    $u = $sqlUser -> fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos1.css">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container-main">
        <div class="contenido">
            <input type="search" class="search" name="search" placeholder="search">
            <i class="bi bi-search"></i>
        </div>

        <button onclick="mostrarMenu()">MENU</button>

        <form action="" method="POST" id="form" class="form">    
            <h1>Productos:</h1>
            <div class="container-section">
                <?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                    if (isset($_GET['categoria'])) {
                    $idCategoria = addslashes($_GET['categoria']);
                    $sqlProducts = $con->prepare("SELECT * FROM producto WHERE id_categoria = '$idCategoria'");
                    $sqlProducts->execute();
                    $p = $sqlProducts->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($p as $producto) {
<<<<<<< HEAD
=======
=======
                    // if (isset($_GET['categoria'])) {
                    // $idCategoria = addslashes($_GET['categoria']);
                    // $sqlProducts = $con->prepare("SELECT * FROM producto WHERE id_categoria = '$idCategoria'");
                    // $sqlProducts->execute();
                    // $p = $sqlProducts->fetchAll(PDO::FETCH_ASSOC);
                    // foreach ($p as $producto) {
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                ?>
        
                <div class="container-products">
                    <img src="../img/products/<?php echo $producto['imagen_prod']; ?>" alt="">
                    <div class="container-name">
                        <a href="detalles_productos.php?id_productos=<?php echo $producto['id_producto']; ?>">
                        <h3><?php echo $producto['nombre_prod']; ?><br>$<?php echo $producto['precio']; ?></h3></a>
                    </div>
                    <button type="button" onclick="agregarProducto(<?php echo $producto['id_producto']; ?>, '<?php echo $producto['nombre_prod']; ?>', '<?php echo $producto['precio']; ?>')">Agregar</button>
                </div>
<<<<<<< HEAD
                <?php 
                    }}
                    ?>
=======
<<<<<<< HEAD
                <?php 
                    }}
                    ?>
=======
                
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
            </div>      
        </form>
    </main>
</body>
<script>
    function productCategories() {
        fetch('../ajax/product_categories.php')
        .then(response => response.json())
    }

    function agregarProducto(idProducto, nombre, precio) {
        fetch('../ajax/list_menu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_producto: idProducto })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto agregado exitosamente');
            } else {
                alert('Error al agregar el producto');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function mostrarMenu() {
        const usermenu = document.getElementById('user_menu');
        if (usermenu.style.display === "none" || usermenu.style.display === "") {
            usermenu.style.display = "block";
        } else {
            usermenu.style.display = "none";
        }
    }
</script>
</html>