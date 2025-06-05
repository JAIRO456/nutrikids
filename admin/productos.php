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
                                        $sqlCategorias = $con->prepare("SELECT id_categoria, categoria FROM categorias ORDER BY categoria");
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
                    <div class="card shadow mt-1">
                        <div class="card-header">
                            <h4 class='text-center'>Produtos</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table-products">
                                <thead class='text-center'>
                                    <tr>
                                        <th class="d-none d-sm-table-cell">CODE</th>
                                        <th>Nombre</th>
                                        <th>Categoria</th>
                                        <th class="d-none d-sm-table-cell">Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class='text-center'></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <nav aria-label="Page navigation" class="mt-1">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
    <script>
        let currentPage = 1;
        const perPage = 10; // Número de registros por página

        function getProdutos(page = 1) {
            const search = encodeURIComponent(document.getElementById('search-input').value);
            const category = encodeURIComponent(document.getElementById('category-select').value);
            fetch(`../ajax/get_products.php?search=${search}&category=${category}&page=${page}&perPage=${perPage}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.data.forEach(product => {
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
                    // Generar la paginación dinámica
                    renderPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Error al obtener los produtos:', error));
        }

        function renderPagination(totalPages, currentPage) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            // Botón "Previous"
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#" onclick="getAdmins(${currentPage - 1})">Previous</a>`;
            pagination.appendChild(prevLi);

            // Botones de páginas
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#" onclick="getAdmins(${i})">${i}</a>`;
                pagination.appendChild(li);
            }

            // Botón "Next"
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#" onclick="getAdmins(${currentPage + 1})">Next</a>`;
            pagination.appendChild(nextLi);
        }

        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            currentPage = 1; // Reiniciar a la primera página al buscar
            getProdutos(currentPage); // Llamar a la función para obtener los produtos
        });
        // Cargar produtos al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getProdutos(currentPage);
        });

        // setInterval(function () {
        //     getProdutos();
        // }, 5000);
    </script>
</html>