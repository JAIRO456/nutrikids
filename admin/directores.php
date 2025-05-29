<?php
    session_start();
    require_once('../conex/conex.php');
<<<<<<< HEAD
    require_once('../include/validate_sesion.php');
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-3">Directores</h2>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <a href="directores/crear_admin.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Registrar Director</a>
                        </div>
                        <div class="col-md-6">
                            <form id="search-form" class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Buscar directores..." aria-label="Buscar" id="search-input">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
=======
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Directores</h2>
                    <a href="directores/crear_admin.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Registrar Director</a>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>Documento</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Correo</th>
                                <th>Escuela</th>
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
<<<<<<< HEAD
</body> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getAdmins() {
            fetch('../ajax/get_admins.php?search=' + encodeURIComponent(document.getElementById('search-input').value))
=======
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getAdmins() {
            fetch('../ajax/get_admins.php')
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(admin => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><img src="../users/${admin.imagen}" alt="Imagen" width="50"></td>
                            <td>${admin.documento}</td>
                            <td>${admin.apellido}</td>
                            <td>${admin.nombre}</td>
                            <td>${admin.email}</td>
                            <td>${admin.nombre_escuela}</td>
                            <td>
                                <a class='btn btn-primary' href="directores/update_admin.php?id=${admin.documento}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="directores/delete_admin.php?id=${admin.documento}"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }
<<<<<<< HEAD
        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            getAdmins(); // Llamar a la función para obtener los directores
        });
        // Cargar los directores al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getAdmins();
        });
=======
        setInterval(function () {
            getAdmins();
        }, 3000);
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    </script>
</html>