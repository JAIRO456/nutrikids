<?php
<<<<<<< HEAD
<<<<<<< HEAD
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_producto = $_POST['id_producto'];
        $nombre_prod = $_POST['nombre_prod'];
        $id_marca = $_POST['id_marca'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];
        $cantidad_alm = $_POST['cantidad_alm'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        $calorias = $_POST['calorias'];
        $proteinas = $_POST['proteinas'];
        $carbohidratos = $_POST['carbohidratos'];
        $grasas = $_POST['grasas'];
        $azucares = $_POST['azucares'];
        $sodio = $_POST['sodio'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/products/" . $imagen);
        } 
        else {
            $imagen = null;
        }

        $sqlInsertProduct = $con->prepare("INSERT INTO producto (id_producto, nombre_prod, descripcion, precio, imagen_prod, cantidad_alm, id_categoria, id_marca) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertProduct->execute([$id_producto, $nombre_prod, $descripcion, $precio, $imagen, $cantidad_alm, $id_categoria, $id_marca])) {
            $sqlInsertInfoNutricional = $con->prepare("INSERT INTO informacion_nutricional (id_producto, calorias, proteinas, carbohidratos, grasas, azucares, sodio) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($sqlInsertInfoNutricional->execute([$id_producto, $calorias, $proteinas, $carbohidratos, $grasas, $azucares, $sodio])) {
                echo '<script>alert("Producto creado exitosamente")</script>';
                echo '<script>window.location = "categoria.php"</script>';
            } 
            else {
                echo '<script>alert("Error al crear la informacion nutricional al Producto")</script>';
            }
        } 
        else {
            echo '<script>alert("Error al crear el Producto")</script>';
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
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-4 text-center">Agregar Nuevo Producto</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <h3>Información del Producto</h3>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_producto" class="form-label">Codigo del Porducto</label>
                                <input type="number" class="form-control" id="id_producto" name="id_producto" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre_prod" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_prod" name="nombre_prod" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_marca" class="form-label">Marca</label>
                                <select class="form-select" id="id_marca" name="id_marca" required>
                                    <option value="">Seleccione una marca</option>
                                    <?php
                                        $sqlMarcas = $con->prepare("SELECT * FROM marcas");
                                        $sqlMarcas->execute();
                                        while ($row = $sqlMarcas->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_marca']}'>{$row['marca']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoria</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoria</option>
                                    <?php
                                        $sqlCategorias = $con->prepare("SELECT * FROM categorias");
                                        $sqlCategorias->execute();
                                        while ($row = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_categoria']}'>{$row['categoria']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cantidad_alm" class="form-label">Cantidad almacenada</label>
                                <input type="number" class="form-control" id="cantidad_alm" name="cantidad_alm" required>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" required>
                            </div>
                        </div>

                        <h4>Información Nutricional</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="calorias" class="form-label">Calorías</label>
                                <input type="number" class="form-control" id="calorias" name="calorias" required>
                            </div>
                            <div class="col-md-4">
                                <label for="proteinas" class="form-label">Proteínas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="proteinas" name="proteinas" required>
                            </div>
                            <div class="col-md-4">
                                <label for="carbohidratos" class="form-label">Carbohidratos (g)</label>
                                <input type="number" step="0.01" class="form-control" id="carbohidratos" name="carbohidratos" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="grasas" class="form-label">Grasas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="grasas" name="grasas" required>
                            </div>
                            <div class="col-md-4">
                                <label for="azucares" class="form-label">Azúcares (g)</label>
                                <input type="number" step="0.01" class="form-control" id="azucares" name="azucares" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sodio" class="form-label">Sodio (mg)</label>
                                <input type="number" step="0.01" class="form-control" id="sodio" name="sodio" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger"href="">Registrar Producto</button>
                

                        <a href="categoria.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
=======
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

// Generar un código de barras aleatorio
$codigo_barras = rand(100000000000, 999999999999);


$query_categorias = "SELECT id_categoria, categoria FROM categorias";
$result_categorias = $con->query($query_categorias);
if (!$result_categorias) {
    die("Error al obtener categorías: " . $con->error);
}

$query_marcas = "SELECT id_marca, marca FROM marcas";
$result_marcas = $con->query($query_marcas);
if (!$result_marcas) {
    die("Error al obtener marcas: " . $con->error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $id_categoria = $_POST['id_categoria'];
    $id_marca = $_POST['id_marca'];
    $imagen = $_FILES['imagen']['name'];
    $codigo_barras = $_POST['codigo_barras'];


    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($imagen);
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
        echo("Error al subir la imagen.");
    }

  
    $query_insert = "INSERT INTO producto (nombre_prod, descripcion, precio, imagen_prod, cantidad_alm, id_categoria, id_marca, id_producto)
                     VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$cantidad', '$id_categoria', '$id_marca', '$codigo_barras')";
    if ($con->query($query_insert)) {
        echo "<div class='alert alert-success'>Producto creado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al crear el producto: " . $con->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Crear Producto</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="codigo_barras" class="form-label">Código de Barras</label>
                <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" value="<?php echo $codigo_barras; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad en Almacén</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select class="form-select" id="id_categoria" name="id_categoria" required>
                    <option value="" selected disabled>Seleccione una categoría</option>
                    <?php while ($row = $result_categorias->fetch_assoc()): ?>
                        <option value="<?php echo $row['id_categoria']; ?>"><?php echo $row['categoria']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_marca" class="form-label">Marca</label>
                <select class="form-select" id="id_marca" name="id_marca" required>
                    <option value="" selected disabled>Seleccione una marca</option>
                    <?php while ($row = $result_marcas->fetch_assoc()): ?>
                        <option value="<?php echo $row['id_marca']; ?>"><?php echo $row['marca']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</html>