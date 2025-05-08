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
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Directores</h2>
                    <a href="directores/crear_admin.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Registrar Director</a>
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
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getAdmins() {
            fetch('../ajax/get_admins.php')
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
        setInterval(function () {
            getAdmins();
        }, 3000);
    </script>
</html>