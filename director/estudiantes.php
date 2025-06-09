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
    <main class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="row mb-1 justify-content-end">
                    <div class="col-md-6">
                        <a href="estudiantes/pdf.php" class='btn btn-danger'><i class="bi bi-file-earmark-pdf-fill"></i> PDF</a>
                        <button onclick="window.location.href='estudiantes/excel.php'" class="btn btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                    </div>
                    <div class="col-md-6">
                        <form id="search-form" class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Buscar estudiante..." aria-label="Buscar" id="search-input"> 
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
                <div class="card shadow mt-1">
                    <div class="card-header">
                        <h4 class='text-center'>Estudiantes</h4>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table-student">
                            <thead class='text-center'>
                                <tr>
                                    <th class="d-none d-sm-table-cell">Imagen</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th class="d-none d-sm-table-cell">Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="table-body" class='text-center'></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getAllStudents() {
            fetch('../ajax/get_allestudiantes.php?search=' + encodeURIComponent(document.getElementById('search-input').value))
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-student tbody')
                    tbody.innerHTML = '';
            
                    data.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="d-none d-sm-table-cell"><img class="d-none d-sm-table-cell" src="../img/users/${student.imagen}" alt="Imagen" class="img-fluid" style="width: 50px; height: 50px;"></td>
                            <td>${student.documento_est}</td>
                            <td>${student.nombre} ${student.apellido}</td>
                            <td class="d-none d-sm-table-cell">${student.estado}</td>
                            <td>
                                <a class='btn btn-primary' href="estudiantes/update_estudiantes.php?id=${student.documento_est}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="estudiantes/delete_estudiantes.php?id=${student.documento_est}"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los estudiantes:', error));
        }
        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            getAllStudents(); // Llamar a la función para obtener los licencias
        });
        // Cargar las licencias al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getAllStudents();
        });
    </script>
</html>