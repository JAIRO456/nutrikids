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
<body onload="form.documento.focus()">
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Licencias</h2>
                    <a href="licencias/crear_licencia.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Registrar Licencia</a>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Escuela</th>
                                <!-- <th>Estado</th> -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
    <script>
        function getLicencias() {
            fetch('../ajax/get_licencias.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(licencia => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${licencia.id_licencia}</td>
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
        setInterval(function () {
            getLicencias();
        }, 3000);
    </script>
</html>