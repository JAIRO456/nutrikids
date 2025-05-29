<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

<<<<<<< HEAD
<<<<<<< HEAD
=======
// Generar un código de barras aleatorio
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
=======
// Generar un código de barras aleatorio
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
</html>