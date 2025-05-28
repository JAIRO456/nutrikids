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
    <title>Escuelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Escuelas</h2>
                    <a href="escuelas/crear_escuela.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Registrar Escuela</a>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Telefono</th>
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
            fetch('../ajax/get_schools.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(school => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><img src="../img/schools/${school.imagen_esc}" alt="Imagen" width="50" height="50"></td>
                            <td>${school.id_escuela}</td>
                            <td>${school.nombre_escuela}</td>
                            <td>${school.email_esc}</td>
                            <td>${school.telefono_esc}</td>
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
        setInterval(function () {
            getschools();
        }, 3000);
    </script>
</html>