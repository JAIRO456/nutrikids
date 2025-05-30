<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-3">Produtos</h2>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <a href="produtos/crear_produtos.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Registrar Produto</a>            
                        </div>
                        <div class="col-md-6">
                            <form id="search-form" class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Buscar producto..." aria-label="Buscar" id="search-input">
                                <select class="form-select me-2" id="category-select">
                                    <option value="">Todas las categorias</option>
                                    <?php
                                        $sqlCategorias = $con->prepare("SELECT DISTINCT categorias.id_categoria, categoria FROM producto 
                                        INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria ORDER BY categoria");
                                        $sqlCategorias->execute();
                                        while ($row = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_categoria']}'>{$row['categoria']}</option>";
                                        }
                                    ?>
                                </select>
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-none d-sm-table-cell">CODE</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th class="d-none d-sm-table-cell">Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
    <script>
        function getProdutos() {
            fetch('../ajax/get_products.php?search=' + encodeURIComponent(document.getElementById('search-input').value) + 
                '&category=' + encodeURIComponent(document.getElementById('category-select').value))
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="d-none d-sm-table-cell">${product.id_producto}</td>
                            <td>${product.nombre_prod}</td>
                            <td>${product.categoria}</td>
                            <td class="d-none d-sm-table-cell">${product.precio}</td>
                            <td>
                                <a href="produtos/update_producto.php?id=${product.id_producto}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                <a href="produtos/delete_producto.php?id=${product.id_producto}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
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

        // setInterval(function () {
        //     getProdutos();
        // }, 5000);
    </script>
</html>