<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    if (isset($_POST['agregar'])){
        $name = $_POST['nombre'];
        $desc = $_POST['descripcion'];
        $precio = $_POST['precio'];
        
        $cant = $_POST['cant'];
        $cat = $_POST['cat'];
        $marc = $_POST['marc'];

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $fileTmp = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileType = $_FILES['imagen']['type'];

        // Definir el directorio donde se guardarán las imágenes
            $ruta = '../img/products/';
            $newruta = $ruta . basename($fileName);

        // Validar la extensión de la imagen
            $formatType = array("jpg", "jpeg", "png");
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $formatType)) {
                // Mover la imagen al directorio de subida
                if (move_uploaded_file($fileTmp, $newruta)) {
                    // Si la imagen se ha subido correctamente, guardamos el nombre de la imagen en la base de datos
                    $sqlInsert = $con->prepare("INSERT INTO producto (nombre_prod, descripcion, precio, imagen, cantidad_alm, id_categoria, id_marca) 
                    VALUES ('$name', '$desc', '$precio', '$fileName', '$cant', '$cat', '$marc')");
                    $sqlInsert->execute();
                    echo '<script>alert("Producto agregado")</script>';
                    echo '<script>window.location = "productos.php"</script>'; 
                } else {
                    echo '<script>alert("Error al subir la imagen. Inténtelo de nuevo.")</script>';
                }
            } 
            
            else {
                echo '<script>alert("Formato de imagen no válido.")</script>';
            }

        } 
        
        else {
            echo '<script>alert("No se ha subido ninguna imagen.")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/agregar_productos.css">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container-main">

        <form action="" method="POST" id="form" class="form" enctype="multipart/form-data">
            <div class="x_imagen" id="x_imagen">
                <img class="agregar_productos" src="../img/agregar_productos.png" alt="">
                <div class="container-input">
                    <input class="input-file" type="file" name="imagen">
                </div>
            </div>

            <div class="container-columns">
                <div class="x_grupo" id="x_names">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="varchar" id="nombre" name="nombre">
                </div>
                <div class="x_grupo" id="x_names">
                    <label for="descripcion">Descripcion</label>
                    <input type="varchar" id="descripcion" name="descripcion">
                </div>
                <div class="x_grupo" id="x_names">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio">
                </div>
                <div class="x_grupo" id="x_names">
                    <label for="cant">Cantidad almacenada</label>
                    <input type="varchar" id="cant" name="cant">
                </div>
                <div class="x_grupo" id="x_names">
                    <label for="cat">Categoria</label>
                    <select name="cat" id="cat">
                        <option value="">Seleccione la categoria</option>
                        <?php
                            $sqlCategorias = $con -> prepare("SELECT * FROM categorias");
                            $sqlCategorias -> execute();

                            while($c = $sqlCategorias -> fetch(PDO::FETCH_ASSOC)){
                                echo "<option value=" . $c["id_categoria"] . ">" . 
                                $c["categoria"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="x_grupo" id="x_names">
                    <label for="marc">Marca</label>
                    <select name="marc" id="marc">
                        <option value="">Seleccione la marca</option>
                        <?php
                            $sqlMarcas = $con -> prepare("SELECT * FROM marcas");
                            $sqlMarcas -> execute();

                            while($m = $sqlMarcas -> fetch(PDO::FETCH_ASSOC)){
                                echo "<option value=" . $m["id_marcas"] . ">" . 
                                $m["marca"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="agregar" name="agregar">AGREGAR</button>
        </form>
        
    </main>
</body>
</html>