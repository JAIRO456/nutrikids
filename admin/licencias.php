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
    <title>Licencias</title>
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
                            <a href="licencias/crear_licencia.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Registrar Licencia</a>
                            <a href="licencias/pdf.php" class='btn btn-danger'><i class="bi bi-file-earmark-pdf-fill"></i> PDF</a>
                            <button onclick="window.location.href='licencias/excel.php'" class="btn btn-success"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                        </div>
                        <div class="col-md-6">
                            <form id="search-form" class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Buscar licencia..." aria-label="Buscar" id="search-input">
                                <select class="form-select me-2" id="tipo-select">
                                    <option value="">Todas las licencias</option>
                                    <?php
                                        $sqlCategorias = $con->prepare("SELECT tipo_licencia.id_tipo, tipo_licencia.tipo FROM tipo_licencia ORDER BY id_tipo");
                                        $sqlCategorias->execute();
                                        while ($row = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_tipo']}'>{$row['tipo']}</option>";
                                        }
                                    ?>
                                </select>
                                <button class="btn btn-outline-success" type="submit">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mt-1">
                        <div class="card-header">
                            <h4 class='text-center'>Licencias</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table-licences">
                                <thead class='text-center'>
                                    <tr>
                                        <th class="d-none d-sm-table-cell">Code</th>
                                        <th>Nombre</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Escuela</th>
                                        <!-- <th>Estado</th> -->
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class='text-center'>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
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
                            <td class="d-none d-sm-table-cell">${licencia.id_licencia}</td>
                            <td>${licencia.tipo}</td>
                            <td>${licencia.fecha_inicio}</td>
                            <td>${licencia.fecha_fin}</td>
                            <td>${licencia.nombre_escuela}</td>
                            <td>
                                <a href="licencias/update_licencia.php?id=${licencia.id_licencia}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                <a href="../ajax/delete_licencia.php?id=${licencia.id_licencia}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
        // Manejar el evento de búsqueda
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Evitar el envío del formulario
            getLicencias(); // Llamar a la función para obtener los licencias
        });
        // Cargar las licencias al inicio
        document.addEventListener('DOMContentLoaded', function () {
            getLicencias();
        });
    </script>
</html>