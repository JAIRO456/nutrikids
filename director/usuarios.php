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
    <title>Usuarios</title>
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
            overflow-x: auto;
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

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            text-decoration: none;
            color: var(--text-color);
            transition: var(--transition);
        }

        .pagination a:hover {
            background-color: var(--primary-color);
            color: white;
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

            .icon-down {
                width: 100%;
            }

            .search-form {
                width: 100%;
            }

            .table th, .table td {
                padding: 8px;
            }

            .hide-mobile {
                display: none;
            }
        }
    </style>
</head>
<body>
    <main class="container-main">
        <div class="header-actions">
            <div class="action-buttons">
                <button onclick="window.location.href='usuarios/pdf.php'" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> PDF</button>
                <button onclick="window.location.href='usuarios/excel.php'" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button>
            </div>
            <form id="search-form" class="search-form">
                <input class="search-input" type="search" placeholder="Buscar usuarios..." id="search-input">
                <select class="form-select icon-down" id="rol-select">
                    <option value="">Todas los roles</option>
                    <?php
                        $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol > 2 ORDER BY id_rol");
                        $sqlRoles->execute();
                        while ($row = $sqlRoles->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['id_rol']}'>{$row['rol']}</option>";
                        }
                    ?>
                </select>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Usuarios</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-users">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>

        <nav class="pagination-container">
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </main>
</body>
    <script>
        function getAllUsers() {
            fetch('../ajax/get_allusers.php?search=' + encodeURIComponent(document.getElementById('search-input').value) + 
            '&rol=' + encodeURIComponent(document.getElementById('rol-select').value))
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-users tbody')
                    tbody.innerHTML = '';
            
                    data.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><img src='../img/usuarios/${user.imagen}' alt='${user.nombre} ${user.apellido}' style='width: 50px; height: 50px; border-radius: 50%;'></td>
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td>${user.rol}</td>
                            <td>${user.estado}</td>
                            <td>
                                <a class='btn btn-primary' href='usuarios/update_users.php?id=${user.documento}'><i class='fa-solid fa-pencil'></i></a>
                                <a class='btn btn-danger' href='usuarios/delete_users.php?id=${user.documento}'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los Usuarios:', error));
        }
        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            getAllUsers(); // Llamar a la función para obtener los licencias
        });
        // Cargar las licencias al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getAllUsers();
        });
    </script>
</html>