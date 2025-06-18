<?php
    session_start();
    require_once('../database/conex.php');
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
    <title>Estudiantes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #28a745;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --text-color: #333;
            --border-color: #ddd;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 75px;
            padding: 20px;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
            font-size: 15px;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .search-form {
            display: flex;
            gap: 10px;
        }

        .search-input {
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            flex: 1;
            min-width: 200px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease;
        }

        .card-header {
            padding: 15px;
            background: #2c3e50;
            border-bottom: 1px solid var(--border-color);
        }

        .card-header h4 {
            text-align: center;
            color: white;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .container-main {
                margin-top: 100px;
            }
            .header-actions {
                flex-direction: column;
            }

            .search-form {
                width: 100%;
            }

            .table th, .table td {
                padding: 8px;
            }

            .hide-mobile {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <main class="container-main">
        <div class="header-actions">
            <div class="action-buttons">
                <a href="estudiantes/pdf.php" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                <button onclick="window.location.href='estudiantes/excel.php'" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button>
            </div>
            <form id="search-form" class="search-form">
                <input class="search-input" type="search" placeholder="Buscar estudiante..." id="search-input">
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Estudiantes</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-student">
                    <thead>
                        <tr>
                            <th class="hide-mobile">Imagen</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th class="hide-mobile">Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
                            <td class="hide-mobile">${student.imagen}</td>
                            <td>${student.documento_est}</td>
                            <td>${student.nombre} ${student.apellido}</td>
                            <td class="hide-mobile">${student.estado}</td>
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