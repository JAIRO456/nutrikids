<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $id_producto = $_GET['id_producto'];
    $sqlUpdateProduts = $con -> prepare("SELECT * FROM producto INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria
    INNER JOIN marcas ON marcas.id_marca = marcas.id_marca WHERE id_producto = $id_producto");
    $sqlUpdateProduts -> execute();
    $up = $sqlUpdateProduts -> fetch();
?>

<?php

    if (isset($_POST['Actualizar'])){
        $name = $_POST['name_producto'];
        $descripcion = $_POST['descripcion_producto'];
        $precio = $_POST['precio_producto'];
        $cantidad = $_POST['cantidad_producto'];
        $marca = $_POST['id_marca'];
        $categoria = $_POST['id_categoria'];
        

        $updateProduts = $con -> prepare("UPDATE producto SET nombre_prod = '$name', descripcion = '$descripcion', precio = '$precio', cantidad_alm = '$cantidad', id_categoria = '$marca', id_marca = '$categoria' WHERE id_producto = '$id_producto'");
        $updateProduts -> execute();
        echo '<script>alert("Producto Actualizado")</script>';
        echo '<script>window.location = "productos.php"</script>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/actualizar_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <form action="" method="post">
            <h1>Actualizar datos producto:</h1>
            <table class="container-table">
                <tbody>
                    <tr class="container-tr">                    
                        <th>Nombre del Producto:</th>
                        <th>Descripcion:</th>
                        <th>Precio:</th>
                        <th>Cantidad Restante:</th>
                        <th>Categoria:</th>
                        <th>Marca:</th>                                        
                    </tr>
                    <tr class="container-tr2">
                        <td><input type="text" name="name_producto" value="<?php echo $up["nombre_prod"];?>"></td>
                        <td><input type="varchar" name="descripcion_producto" value="<?php echo $up["descripcion"];?>"></td>
                        <td><input type="number" name="precio_producto" value="<?php echo $up["precio"];?>"></td>
                        <td><input type="number" name="cantidad_producto" value="<?php echo $up["cantidad_alm"];?>"></td>
                        <td>
                            <select name="id_marca" id="id_marca">
                                <option value="<?php echo $up["id_marca"];?>"><?php echo $up["marca"];?></option>
                                <?php
                                    $sqlMarcas = $con -> prepare("SELECT * FROM marcas");
                                    $sqlMarcas -> execute();

                                    while($marc = $sqlMarcas -> fetch(PDO::FETCH_ASSOC)){
                                        echo "<option value =" . $marc["id_marca"] . ">" . 
                                        $marc["marca"] . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select name="id_categoria" id="id_categoria">
                                <option value="<?php echo $up["id_categoria"];?>"><?php echo $up["categoria"];?></option>
                                <?php
                                    $sqlCategories = $con -> prepare("SELECT * FROM categorias");
                                    $sqlCategories -> execute();

                                    while($cat = $sqlCategories -> fetch(PDO::FETCH_ASSOC)){
                                        echo "<option value =" . $cat["id_categoria"] . ">" . 
                                        $cat["categoria"] . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" class="actualizar" value="Actualizar" name="Actualizar">
        </form>  
    </main>
</body>
</html>