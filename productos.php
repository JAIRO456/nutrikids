<?php
    session_start();
    require_once('database/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.html';

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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 100%;
            margin: 20px auto;
            padding: 0 15px;
        }

        .row-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-outline-success {
            background-color: transparent;
            border: 1px solid #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .mb-1 {
            margin-bottom: 10px;
        }

        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .search-form {
            display: flex;
            width: 50%;
        }

        .search-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .product-card {
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            width: 250px;
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

        .product-link {
            text-decoration: none;
            color: inherit;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
            }

            .search-container {
                flex-direction: column;
            }

            .search-form {
                width: 100%;
            }

            .search-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="row-container">
                <a href="categorias.php" class="btn btn-secondary mb-1">Regresar</a>
            </div>
            <h3 class="text-center" style="text-align: center;">Productos de la categoría: <br><?= $categoria['categoria']; ?></h3>
        </div>
        <div class="search-container">
            <form id="search-form" class="search-form">
                <input class="search-input" type="search" placeholder="Buscar producto..." aria-label="Buscar" id="search-input">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
        
        <div class="products-grid" id="products">
        </div>
    </main>
</body>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const id_categoria = urlParams.get('id_categoria');
    
    function getProdutos() {
        fetch('ajax/get_search_products.php?search=' + encodeURIComponent(document.getElementById('search-input').value) + 
                '&id_categoria=' + id_categoria)
            .then(response => response.json())
            .then(data => {
                const div = document.getElementById('products');
                div.innerHTML = '';

                if (data.length === 0) {
                    div.innerHTML = '<p class="text-center"><i class="bi bi-exclamation-circle"></i> No hay productos disponibles para esta categoría.</p>';
                }

                data.forEach(product => {
                    const row = document.createElement('div');
                    row.className = 'col-md-2';
                    row.classList.add('product-card');
                    row.style.width = '250px';
                    row.innerHTML = `
                        <a onclick="window.location.href='informacion_nutricional?id_producto=${product.id_producto}'" style="text-decoration:none; color:inherit;">
                            <img src="img/products/${product.imagen_prod}" alt="${product.nombre_prod}">
                            <h3>${product.nombre_prod}</h3>
                            <p>${product.precio}</p>
                        </a>
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