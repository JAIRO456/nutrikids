<!-- filepath: c:\xampp\htdocs\nutrikids\vendedor\productos\productos.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }
    </style>
</head>
<body>
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
</body>
</html>