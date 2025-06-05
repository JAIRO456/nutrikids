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
    <title>Directores</title>
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
                            <a href="directores/crear_admin.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Registrar Director</a>
                            <a href="directores/pdf.php" class='btn btn-danger'><i class="bi bi-file-earmark-pdf-fill"></i> PDF</a>
                            <button onclick="window.location.href='directores/excel.php'" class="btn btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                        </div>
                        <div class="col-md-6">
                            <form id="search-form" class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Buscar directores..." aria-label="Buscar" id="search-input">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mt-1">
                        <div class="card-header">
                            <h4 class='text-center'>Directores</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table-users">
                                <thead>
                                    <tr>
                                        <th class="d-none d-sm-table-cell">Imagen</th>
                                        <th>Documento</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th class="d-none d-sm-table-cell">Correo</th>
                                        <th>Escuela</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <nav aria-label="Page navigation mt-1" class="mt-1">
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        let currentPage = 1;
        const perPage = 10; // Número de registros por página

        function getAdmins(page = 1) {
            const search = encodeURIComponent(document.getElementById('search-input').value);
            fetch(`../ajax/get_admins.php?search=${search}&page=${page}&perPage=${perPage}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    // Llenar la tabla con los datos
                    data.data.forEach(admin => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="d-none d-sm-table-cell"><img class="d-none d-sm-table-cell" src="../users/${admin.imagen}" alt="Imagen" width="50"></td>
                            <td>${admin.documento}</td>
                            <td>${admin.nombre}</td>
                            <td>${admin.apellido}</td>
                            <td class="d-none d-sm-table-cell">${admin.email}</td>
                            <td>${admin.nombre_escuela}</td>
                            <td>
                                <a class='btn btn-primary' href="directores/update_admin.php?id=${admin.documento}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="directores/delete_admin.php?id=${admin.documento}"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                    // Generar la paginación dinámica
                    renderPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Error al cargar los datos:', error));
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
            e.preventDefault();
            currentPage = 1; // Reiniciar a la primera página al buscar
            getAdmins(currentPage);
        });

        // Cargar los directores al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getAdmins(currentPage);
        });
    </script>
</body>
</html>