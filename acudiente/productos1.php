<?php

session_start();
require_once('../conex/conex.php');
// include "adm_menu.html";
// include "header_user.php";
// include "crear_menu.php";
$conex =new Database;
$con = $conex->conectar();
 
?>

<?php
    $sqlUser = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela");
    $sqlUser -> execute();
    $u = $sqlUser -> fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos1.css">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container-main">
        <div class="contenido">
            <input type="search" class="search" name="search" placeholder="search">
            <i class="bi bi-search"></i>
        </div>

        <button onclick="mostrarMenu()">MENU</button>

        <div action="" method="POST" id="form" class="form">    
            <h1>Productos:</h1>
            <div class="container-section">
                <div class="container-products" id="container-products">
                
                </div>
            </div>      
        </div>
    </main>
</body>
<script>
    const productsContainer = document.getElementById('container-products');
    async function fetchProducts() {
        try {
            const response = await fetch('../ajax/product_categories.php');
            const data = await response.json();
            products(data);
        } 
        catch (error) {
            console.error('Error al cargar productos:', error);
            productsContainer.innerHTML = '<p class="error">Error al cargar los productos. Por favor, intenta nuevamente.</p>';
        }
    }

    function products(data) {
        productsContainer.innerHTML = '';

        data.forEach(product => {
            const div = document.createElement('div');
            div.classList.add('container-products');
            div.innerHTML = `
                <img src="../img/products/${product.imagen_prod}" alt="">
                <div class="container-name">
                    <a href="detalles_productos.php?id_productos=${product.id_producto}">
                        <h3>${product.nombre_prod}<br>$${product.precio}</h3>
                    </a>
                </div>
                <button type="button" onclick="agregarProducto(${product.id_producto}, '${product.nombre_prod}', '${product.precio}')">Agregar</button>
            `;
            productsContainer.appendChild(div);
        });
    }

    setInterval(fetchProducts, 1000);

    function agregarProducto(idProducto, nombre, precio) {
        fetch('../ajax/list_menu.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_producto: idProducto })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto agregado exitosamente');
            } else {
                alert('Error al agregar el producto');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function mostrarMenu() {
        const usermenu = document.getElementById('user_menu');
        if (usermenu.style.display === "none" || usermenu.style.display === "") {
            usermenu.style.display = "block";
        } else {
            usermenu.style.display = "none";
        }
    }
</script>
</html>