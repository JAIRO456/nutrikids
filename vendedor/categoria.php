<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriKids - Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; 
        }
        .content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .card {
            text-align: center;
            border: 2px solid #ddd; 
            padding: 10px;
            border-radius: 10px; 
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            cursor: pointer;
            background-color: #fff; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 10px; /* Bordes redondeados para la imagen */
            border: 3px solid #28a745; /* Borde verde alrededor de la imagen */
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            border-color: #28a745; /* Cambiar color del borde al pasar el mouse */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* Sombra más intensa */
        }
        .card:hover img {
            transform: scale(1.1); /* Efecto de zoom en la imagen */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra en la imagen */
        }
        .card h3 {
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #333; /* Color del texto */
        }
        .edit-category-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px dashed #ccc;
            padding: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            background-color: #fff;
        }
        .edit-category-card:hover {
            transform: scale(1.05);
            border-color: #28a745;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .edit-category-card i {
            font-size: 50px;
            color: #28a745;
        }
        .edit-category-card span {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="content">
        <div class="card" onclick="redirectTo('productos.php?id_categoria=1')">
            <img src="../img/categories/bebidas.jpg" alt="Bebidas Frías">
            <h3>Bebidas Frías</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=2')">
            <img src="../img/categories/cafes.jpg" alt="Bebidas Calientes">
            <h3>Bebidas Calientes</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=3')">
            <img src="../img/categories/postres.png" alt="Postres">
            <h3>Postres</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=4')">
            <img src="..\img\categories\frutas.png" alt="Frutas">
            <h3>Frutas</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=5')">
            <img src="../img/categories/panes.jpg" alt="Panadería">
            <h3>Panadería</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=6')">
            <img src="..\img\categories\snacks-2.webp" alt="Snacks">
            <h3>Snacks</h3>
        </div>
      
        <div class="edit-category-card" onclick="redirectTo('crear_producto.php')">
            <i class="bi bi-pencil-square"></i>
            <span>Crear Productos</span>

        </div>
        <div class="edit-category-card" onclick="redirectTo('Editar_producto.php')">
            <i class="bi bi-pencil-square"></i>
            <span>Editar Productos</span>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>