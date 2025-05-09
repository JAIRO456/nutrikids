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
    <title>Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Menus</h2>
                    <table class="table table-bordered table-striped" id="table-menus">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Estudiante</th>
                                <th>Menu</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        function getMenus() {
            fetch('../ajax/get_menus.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-menus tbody')
                    tbody.innerHTML = '';
            
                    data.forEach(menu => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${menu.id_menu}</td>
                            <td>${menu.nombre}</td>
                            <td>${menu.nombre_menu}</td>
                            <td>${menu.estado}</td>
                            <td>
                                <a class='btn btn-primary' href="pedidos.php?id=${menu.id_det_ped_prod}"><i class="bi bi-info-circle"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los Menus:', error));
        }
        setInterval(function () {
            getMenus();
        }, 3000);
    </script>
</html>