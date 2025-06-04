<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
    include 'carrito.php';

    $id_categoria = $_GET['id_categoria'];
    $query_categoria = $con->prepare("SELECT categoria FROM categorias WHERE id_categoria = ?");
    $query_categoria->execute([$id_categoria]);
    $categoria = $query_categoria -> fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Panel Admin</title> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        }

    </style>
</head>
<body>
    <main class="container mt-2">
        <a href="categorias.php" class="btn btn-secondary mb-1">Regresar</a>
        <h3 class='text-center'>Productos de la categoría: <br><?= $categoria['categoria']; ?></h1>
        <div class="row mb-1 justify-content-end">
            <div class="col-md-6">
                <form id="search-form" class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Buscar producto..." aria-label="Buscar" id="search-input">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center" id='produts'>

        </div>
        </main>
    </body>
    <html>
    <!-- <p>No hay productos disponibles para esta categoría.</p> -->
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const id_categoria = urlParams.get('id_categoria');
    
    function getProdutos() {
        fetch('../ajax/get_search_products.php?search=' + encodeURIComponent(document.getElementById('search-input').value) + 
                '&id_categoria=' + id_categoria)
            .then(response => response.json())
            .then(data => {
                const div = document.getElementById('produts');
                div.innerHTML = '';

                data.forEach(product => {
                    const row = document.createElement('div');
                    row.className = 'col-md-2';
                    row.classList.add('product-card');
                    row.style.width = '250px';
                    row.innerHTML = `
                        <a href="informacion_nutricional.php?id_producto=${product.id_producto}" style="text-decoration:none; color:inherit;">
                            <img src="../img/products/${product.imagen_prod}" alt="${product.nombre_prod}">
                            <h3>${product.nombre_prod}</h3>
                            <p>${product.precio}</p>
                        </a>
                        <button type="button" onclick="agregarProducto(${product.id_producto}, '${product.nombre_prod}', '${product.precio}')" class="btn btn-primary">Agregar</button>
                    `;
                    div.appendChild(row);
                });
            })
            .catch(error => console.error('Error al obtener los produtos:', error));
    }
    // Manejar el evento de búsqueda
    document.getElementById('search-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el envío del formulario
        getProdutos(); // Llamar a la función para obtener los produtos
    });
    // Cargar produtos al inicio
    document.addEventListener('DOMContentLoaded', function () {
        getProdutos();
    });
</script>
</html>