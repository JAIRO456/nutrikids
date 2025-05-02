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
    if (isset($_GET['id_productos'])){
    $idproduts = addslashes($_GET['id_productos']);
    $sqlDetProducts = $con -> prepare("SELECT * FROM producto INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
    INNER JOIN marcas ON producto.id_marca = marcas.id_marca WHERE id_producto = '$idproduts'");
    $sqlDetProducts -> execute();
    $dp = $sqlDetProducts -> fetchALL(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/detalles_productos.css">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <button onclick="mostrarMenu()">MENU</button>

        <?php foreach ($dp as $detproducts) { ?>

        <form class="container-form" action="" method="post">
        
            <div class="container-img-products">
                <img src="../img/products/<?php echo $detproducts['imagen_prod']; ?>" alt="">
            </div>

            <div class="container-info-productos">
                <h2>Nombre: <?php echo $detproducts['nombre_prod']; ?></h2>
                <h2>Marca: <?php echo $detproducts['marca']; ?></h2>
                <h2>Precio: <?php echo $detproducts['precio']; ?></h2>
                <div class="container-buttons">
                    <button type="button" class="agregar" onclick="agregarProducto(<?php echo $detproducts['id_producto']; ?>, '<?php echo $detproducts['nombre_prod']; ?>', '<?php echo $detproducts['precio']; ?>')">AGREGAR</button>
                    <a href="actualizar_producto.php?id_producto=<?php echo $detproducts['id_producto']; ?>"><button type="button" class="actualizar">ACTUALIZAR</button></a>
                    <a href="delete_producto.php?id_producto=<?php echo $detproducts['id_producto']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"><button type="button" class="eliminar">ELIMINAR</button></a>
                </div>
                <h2>Categoria: <?php echo $detproducts['categoria']; ?></h2> 
                <h2>Cantidad: <?php echo $detproducts['cantidad_alm']; ?></h2>
                <h2>Descripcion: <?php echo $detproducts['descripcion']; ?></h2>  
            </div>
        </form>

        <?php }} ?>
        
    </main>
</body>
<script>
    // Función que muestra el menu al hacer clic en el botón
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