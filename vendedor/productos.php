<<<<<<< HEAD
<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

$productos = [];
$categoria_nombre = "";

// Si viene por POST, redirecciona a GET (para evitar el reenvío del formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_categoria'])) {
    $id_categoria = $_POST['id_categoria'];
    header("Location: productos.php?id_categoria=" . urlencode($id_categoria));
    exit;
}

// Si viene por GET, carga los productos normalmente
if (isset($_GET['id_categoria'])) {
    $id_categoria = $_GET['id_categoria'];

    // Obtener los productos de la categoría seleccionada
    $query_productos = $con->prepare("SELECT * FROM producto WHERE id_categoria = :id_categoria");
    $query_productos->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    $query_productos->execute();
    $productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

    // Obtener el nombre de la categoría
    $query_categoria = $con->prepare("SELECT categoria FROM categorias WHERE id_categoria = :id_categoria");
    $query_categoria->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    $query_categoria->execute();
    $categoria_nombre = $query_categoria->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .product-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .product-card h3 {
            margin-top: 10px;
            font-size: 18px;
        }
        .product-card p {
            font-size: 16px;
=======
<<<<<<< HEAD
<!-- filepath: c:\xampp\htdocs\nutrikids\vendedor\productos\productos.php -->
=======
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            width: 200px;
            height: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .card h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .card .price {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card:hover .price {
            opacity: 1;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        }
    </style>
</head>
<body>
<<<<<<< HEAD
<div class="container mt-5">
    <h1>Productos de la categoría: <?php echo htmlspecialchars($categoria_nombre); ?></h1>
    <div class="row">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-3 product-card">
                    <a href="especificacione_produ.php?id_producto=<?php echo $producto['id_producto']; ?>" style="text-decoration:none; color:inherit;">
                        <img src="../img/products/<?php echo $producto['imagen_prod']; ?>" alt="<?php echo $producto['nombre_prod']; ?>">
                        <h3><?php echo $producto['nombre_prod']; ?></h3>
                        <p>$<?php echo number_format($producto['precio'], 2); ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles para esta categoría.</p>
        <?php endif; ?>
    </div>
</div>
=======
    <div class="container">
        <?php
        // Conexión a la base de datos
        $conn = new mysqli("localhost", "root", "", "nutrikids");

        // Verificar conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Obtener el id_categoria de la URL
        $id_categoria = isset($_GET['id_categoria']) ? intval($_GET['id_categoria']) : 0;

        // Consulta para obtener el nombre de la categoría
        $categoria_sql = "SELECT categoria FROM categorias WHERE id_categoria = $id_categoria";
        $categoria_result = $conn->query($categoria_sql);
        $categoria_nombre = $categoria_result->num_rows > 0 ? $categoria_result->fetch_assoc()['categoria'] : "Productos";

        echo "<h1>$categoria_nombre</h1>";


        $sql = "SELECT nombre_prod, descripcion, precio, imagen_prod FROM producto WHERE id_categoria = $id_categoria";
        $result = $conn->query($sql);

        echo '<div class="products">';
        if ($result->num_rows > 0) {
           
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="../img/products/' . $row["imagen_prod"] . '" alt="' . $row["nombre_prod"] . '">';
                echo '<h3>' . $row["nombre_prod"] . '</h3>';
                echo '<div class="price">$' . $row["precio"] . '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No hay productos disponibles en esta categoría.</p>";
        }
        echo '</div>';

     
        $conn->close();
        ?>
    </div>
=======
    <title>Document</title>
</head>
<body>
    
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</body>
</html>