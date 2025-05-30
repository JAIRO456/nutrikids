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
    <title>INICIO</title>
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Estudiantes</h2>
                <table class="table table-bordered table-striped" id="table-students">
                    <thead class="table-dark">
                        <tr>
                            <th>Documento</th>
                            <th>Apellidos</th>
                            <th>Nombre</th>
                            <th class="d-none d-sm-table-cell">Correo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <script>
        function getStudents() {
            fetch('../ajax/get_estudiantes.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-students tbody')
                    tbody.innerHTML = '';
            
                    data.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${student.documento_est}</td>
                            <td>${student.apellido}</td>
                            <td>${student.nombre}</td>
                            <td class="d-none d-sm-table-cell">${student.email}</td>
                            <td>
                                <a class='btn btn-primary' href="estudiantes/update_students.php?id=${student.documento_est}"><i class="bi bi-pencil-square"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error al obtener los Estudiantes:', error));
        }
        setInterval(function () {
            getStudents();
        }, 3000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>