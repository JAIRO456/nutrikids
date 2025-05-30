<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $id_producto = $_GET['id'];
    $sqlProducto = $con->prepare("SELECT * FROM producto 
    INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
    INNER JOIN marcas ON producto.id_marca = marcas.id_marca
    INNER JOIN informacion_nutricional ON producto.id_producto = informacion_nutricional.id_producto 
    WHERE producto.id_producto = ?");
    $sqlProducto->execute([$id_producto]);
    $producto = $sqlProducto->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_prod = $_POST['nombre_prod'];
        $id_marca = $_POST['id_marca'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        $calorias = $_POST['calorias'];
        $proteinas = $_POST['proteinas'];
        $carbohidratos = $_POST['carbohidratos'];
        $grasas = $_POST['grasas'];
        $azucares = $_POST['azucares'];
        $sodio = $_POST['sodio'];


        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/products/" . $imagen);
        } 
        else {
            $imagen = $producto['imagen_prod'];
        }

        $sqlUpdateProduct = $con->prepare("UPDATE producto SET nombre_prod=?, descripcion=?, precio=?, imagen_prod=?, id_categoria=?, id_marca=? WHERE id_producto=?");
        if ($sqlUpdateProduct->execute([$nombre_prod, $descripcion, $precio, $imagen, $id_categoria, $id_marca, $id_producto])) {
            $sqlUpdateInfoNutricional = $con->prepare("UPDATE informacion_nutricional SET calorias=?, proteinas=?, carbohidratos=?, grasas=?, azucares=?, sodio=? WHERE id_producto=?");
            if ($sqlUpdateInfoNutricional->execute([$calorias, $proteinas, $carbohidratos, $grasas, $azucares, $sodio, $id_producto])) {
                echo '<script>alert("Producto actualizado exitosamente")</script>';
                echo '<script>window.location = "../productos.php"</script>';
            } 
            else {
                echo '<script>alert("Error al actualizar la información nutricional del Producto")</script>';
            }
        } 
        else {
            echo '<script>alert("Error al actualizar el Producto")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
     <!-- <script src="../JsBarcode/jsbarcode.all.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode/dist/JsBarcode.all.min.js"></script>
</head>
<body onload="formCreateProducts.documento.focus()">
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-4 text-center">Actualizar Producto</h2>
                    <form id="formCreateProducts" method="POST" action="" enctype="multipart/form-data">
                        <h3>Información del Producto</h3>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre_prod" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre_prod" name="nombre_prod" value="<?php echo $producto['nombre_prod']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_marca" class="form-label">Marca</label>
                                <select class="form-select" id="id_marca" name="id_marca" required>
                                    <option value="<?php echo $producto['id_marca']; ?>"><?php echo $producto['marca']; ?></option>
                                    <?php
                                        $sqlMarcas = $con->prepare("SELECT * FROM marcas WHERE id_marca != ?");
                                        $sqlMarcas->execute([$producto['id_marca']]);
                                        while ($marca = $sqlMarcas->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $marca['id_marca'] . '">' . $marca['marca'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="<?php echo $producto['id_categoria']; ?>"><?php echo $producto['categoria']; ?></option>
                                    <?php
                                        $sqlCategorias = $con->prepare("SELECT * FROM categorias WHERE id_categoria != ?");
                                        $sqlCategorias->execute([$producto['id_categoria']]);
                                        while ($categoria = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $categoria['id_categoria'] . '">' . $categoria['categoria'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" style="height: 195px;"><?php echo $producto['descripcion']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" value="<?php echo $producto['imagen_prod']; ?>">
                                <?php if (!empty($producto['imagen_prod'])): ?>
                                    <img src="../../img/products/<?php echo $producto['imagen_prod']; ?>" alt="Imagen del Producto" class="img-thumbnail mt-2" style="max-width: 200px;">
                                <?php else: ?>
                                    <p class="text-muted mt-2">No hay imagen disponible</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <h4>Información Nutricional</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="calorias" class="form-label">Calorías (kcal)</label>
                                <input type="number" step="0.01" class="form-control" id="calorias" name="calorias" value="<?php echo $producto['calorias']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="proteinas" class="form-label">Proteínas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="proteinas" name="proteinas" value="<?php echo $producto['proteinas']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="carbohidratos" class="form-label">Carbohidratos (g)</label>
                                <input type="number" step="0.01" class="form-control" id="carbohidratos" name="carbohidratos" value="<?php echo $producto['carbohidratos']; ?>" required>
                            </div>    
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="grasas" class="form-label">Grasas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="grasas" name="grasas" value="<?php echo $producto['grasas']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="azucares" class="form-label">Azúcares (g)</label>
                                <input type="number" step="0.01" class="form-control" id="azucares" name="azucares" value="<?php echo $producto['azucares']; ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sodio" class="form-label">Sodio (mg)</label>
                                <input type="number" step="0.01" class="form-control" id="sodio" name="sodio" value="<?php echo $producto['sodio']; ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="id_producto" class="form-label">Code</label><br>
                            <svg id="barcode-<?= $producto['id_producto']; ?>"></svg>
                        </div>              
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Actualizar Producto</button>
                            <a href="../productos.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
<script>
    JsBarcode("#barcode-<?= $producto['id_producto']; ?>", "<?= $producto['id_producto']; ?>", {
        format: "CODE128",
        width: 2,
        height: 40,
        displayValue: true
    });
</script>
</html>