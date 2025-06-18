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
    <title>Licencias</title>
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
            flex-wrap: wrap;
        }

        .search-input, .search-select {
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            min-width: 200px;
        }

        .search-input {
            flex: 1;
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
                <a href="licencias/crear_licencia.php" class="btn btn-success"><i class="fa-solid fa-plus"></i> Registrar Licencia</a>
                <a href="licencias/pdf.php" class="btn btn-danger"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                <button onclick="window.location.href='licencias/excel.php'" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button>
            </div>
            <form id="search-form" class="search-form">
                <input class="search-input" type="search" placeholder="Buscar licencia..." id="search-input">
                <select class="search-select" id="tipo-select">
                    <option value="">Todas las licencias</option>
                    <?php
                        $sqlCategorias = $con->prepare("SELECT tipo_licencia.id_tipo, tipo_licencia.tipo FROM tipo_licencia ORDER BY id_tipo");
                        $sqlCategorias->execute();
                        while ($row = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['id_tipo']}'>{$row['tipo']}</option>";
                        }
                    ?>
                </select>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Licencias</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-licences">
                    <thead>
                        <tr>
                            <th class="hide-mobile">Code</th>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Escuela</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getLicencias() {
            fetch('../ajax/get_licencias.php?search=' + encodeURIComponent(document.getElementById('search-input').value) + 
                '&tipo=' + encodeURIComponent(document.getElementById('tipo-select').value))
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(licencia => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="hide-mobile">${licencia.id_licencia}</td>
                            <td>${licencia.tipo}</td>
                            <td>${licencia.fecha_inicio}</td>
                            <td>${licencia.fecha_fin}</td>
                            <td>${licencia.nombre_escuela}</td>
                            <td>
                                <a href="licencias/update_licencia.php?id=${licencia.id_licencia}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                                <a href="../ajax/delete_licencia.php?id=${licencia.id_licencia}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault();
            getLicencias();
        });

        // Cargar las licencias al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getLicencias();
        });
    </script>
</body>
</html>