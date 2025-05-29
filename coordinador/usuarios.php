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
    // renposive a la table
    <style>
        @media (max-width: 768px) {
            @media screen and (max-width: 768px) {
                .table {
                    overflow-x: auto;
                    display: grid;
                    grid-template-columns: repeat();
                }
                
            }
        }
    </style>
</head>
<body>
    <main class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-3">Usuarios</h2>
                <div class="row mb-1 justify-content-end">
                    <div class="col-md-6">
                        <form id="search-form" class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Buscar usuario..." aria-label="Buscar" id="search-input">
                            <select class="form-select me-2" id="rol-select">
                                <option value="">Todas los roles</option>
                                <?php
                                    $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol > 2 ORDER BY id_rol");
                                    $sqlRoles->execute();
                                    while ($row = $sqlRoles->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_rol']}'>{$row['rol']}</option>";
                                    }
                                ?>
                            </select>
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
                // renposive si el ancho de la pantalla es menor a 768px
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <a href="usuarios/create_users.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Agregar Usuario</a>
                    </div>
                </div>
                <table class="table table-bordered table-striped text-center" id="table-users">
                    <thead class="table-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
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
                            <td><img src="../img/users/${user.imagen}" alt="Imagen" class="img-fluid" style="width: 50px; height: 50px;"></td>
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td>${user.rol}</td>
                            <td>${user.estado}</td>
                            <td>
                                <a class='btn btn-primary' href="usuarios/update_users.php?id=${user.documento}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="usuarios/delete_users.php?id=${user.documento}"><i class="bi bi-trash"></i></a>
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