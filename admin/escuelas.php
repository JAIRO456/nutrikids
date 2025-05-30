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
    <title>Escuelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-3">Escuelas</h2>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <a href="escuelas/crear_escuela.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Registrar Escuela</a>
                        </div>
                        <div class="col-md-6">
                            <form id="search-form" class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Buscar licencia..." aria-label="Buscar" id="search-input">
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-none d-sm-table-cell">Imagen</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
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
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getschools() {
            fetch('../ajax/get_schools.php?search=' + encodeURIComponent(document.getElementById('search-input').value))
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(school => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="d-none d-sm-table-cell"><img class="d-none d-sm-table-cell" src="../img/schools/${school.imagen_esc}" alt="Imagen" width="50" height="50"></td>
                            <td>${school.id_escuela}</td>
                            <td>${school.nombre_escuela}</td>
                            <td>${school.email_esc}</td>
                            <td> 
                                <a href="escuelas/update_escuela.php?id=${school.id_escuela}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                <a href="escuelas/delete_escuela.php?id=${school.id_escuela}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al cargar los datos:', error));
        }
        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            getschools(); // Llamar a la función para obtener las escuelas
        });
        // Cargar la escuelas al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getschools();
        });
    </script>
</html>