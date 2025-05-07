<?php

session_start();
require_once('../conex/conex.php');
// require_once('../include/validate_login.php');
include 'adm_menu.html';
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $sqlMensajes = $con -> prepare("SELECT * FROM mensajes INNER JOIN escuelas ON mensajes.id_escuela = escuelas.id_escuela WHERE respondido = 0 ORDER BY fecha_men DESC");
    $sqlMensajes->execute();
    $mensajes = $sqlMensajes->fetchAll(PDO::FETCH_ASSOC);
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
    <?php include "header_user.php"; ?>

    <main class="container-main">
        <div class="container1">
            <h3>Cantidad de registros:</h3>
            <section class="container-section">
                <div class="container-div1">
                    <i class="bi bi-basket-fill"></i>
                    <h1>Productos</h1>
                    <div id="totalProducts">

                    </div>
                </div>
                <div class="container-div1">
                    <i class="bi bi-person-lines-fill"></i>
                    <h1>Usuarios</h1>
                    <div id="totalUsers">

                    </div>
                </div>
                <div class="container-div1">
                    <i class="bi bi-person-fill"></i>
                    <h1>Estudiantes</h1>
                    <div id="totalEstudiantes">

                    </div>
                </div>
                <div class="container-div1">
                    <i class="bi bi-house-fill"></i>
                    <h1>Escuelas</h1>
                    <div id="totalSchools">

                    </div>
                </div>
                <div class="container-div1">
                    <i class="bi bi-activity"></i>
                    <h1>Ventas</h1>
                    <div id="totalVentas">
                        <h1>---</h1>
                    </div>
                </div>
            </section>
        </div>

        <div class="container3">
            <h3>Usuarios Recientes</h3>
            <table class="table" id="table-users">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="container3">
            <h3>Productos Recientes</h3>
            <table class="table" id="table-products">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>

        <div class="container4">
            <h3>Notificaciones Recientes</h3>
            <table>
                <tr>
                    <th>Nombres</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Escuela</th>
                    <th>Mensaje</th>
                    <th>Fecha</th>
                </tr>

                <?php foreach ($mensajes as $m){ ?>
                    <tr>
                        <td><?php echo $m['nombre_men']; ?></td>
                        <td><?php echo $m['email_men']; ?></td>
                        <td><?php echo $m['telefono_men']; ?></td>
                        <td><?php echo $m['nombre_escuela']; ?></td>
                        <td><?php echo $m['mensaje']; ?></td>
                        <td><?php echo $m['fecha_men']; ?></td>
                        <td><a href="" onclick="window.open ('responder.php?id2=<?php echo $m['id'];?> ',' ', 'width=600. heigth=500, toolbar=No')"><button type="submit">Responder</button></a></td>
                <?php
                    }
                ?>
            </table>

        </div>
    </main>
</body>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalProducts').textContent = data.TotalProducts;
                    document.getElementById('totalUsers').textContent = data.TotalUser;
                    document.getElementById('totalEstudiantes').textContent = data.TotalEstudiantes;
                    document.getElementById('totalSchools').textContent = data.TotalSchools;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function getUsers() {
            fetch('../ajax/get_users.php')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.querySelector('#table-users tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${user.nombre}</td>
                            <td>${user.apellido}</td>
                            <td>${user.email}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        function getProducts() {
            fetch('../ajax/get_products.php')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.querySelector('#table-products tbody')
                    tbody.innerHTML = '';
            
                    products.forEach(product => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${product.nombre_prod}</td>
                            <td>${product.categoria}</td>
                            <td>${product.precio}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los productos:', error));
        }

        // Actualizar las funciones cada 1 segundos
        setInterval(function () {
            updateCounts();
            getUsers();
            getProducts();
        }, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>
