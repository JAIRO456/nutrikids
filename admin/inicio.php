<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
<<<<<<< HEAD
=======
=======

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
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    <main class="container mt-4">
        <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Directores</h5>
                            <p class="card-text display-4" id='TotalUsers'>
                                <i class="bi bi-person-fill"></i> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Licencias Activas</h5>
                            <p class="card-text display-4" id='TotalLicencias'>
                                <i class="bi bi-file-earmark-check-fill"></i> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Escuelas</h5>
                            <p class="card-text display-4" id='TotalSchools'>
                                <i class="bi bi-house-fill"></i> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Licencias por expirar (próximos 30 días)</h4>
            </div>
            <div class="card-body">
                <?php
                $hoy = date('Y-m-d');
                $treinta_dias = date('Y-m-d', strtotime('+30 days'));

                $sqlDias = $con->query("SELECT licencias.id_licencia, licencias.fecha_fin, escuelas.nombre_escuela FROM licencias
                INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
                INNER JOIN estados ON licencias.id_estado = estados.id_estado
                WHERE estados.id_estado = 1 
                AND licencias.fecha_fin BETWEEN '$hoy' AND '$treinta_dias'
                ORDER BY licencias.fecha_fin ASC");
                $licencias = $sqlDias->fetchAll(PDO::FETCH_ASSOC);

                if (count($licencias) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Escuela</th>
                                <th>Fecha Expiración</th>
                                <th>Días Restantes</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($licencias as $licencia): 
                                $dias_restantes = (new DateTime($licencia['fecha_fin']))->diff(new DateTime($hoy))->days;
                            ?>
                            <tr>
                                <td><?= $licencia['nombre_emp']; ?></td>
                                <td><?= date('d/m/Y', strtotime($licencia['fecha_fin'])) ?></td>
                                <td><?= $dias_restantes ?></td>
                                <td>
                                    <a href="licencias/editar.php?id=<?= $licencia['licencia_id'] ?>" class="btn btn-sm btn-warning">Renovar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-success">No hay licencias por expirar en los próximos 30 días.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Usuarios Recientes</h2>
                    <table class="table table-bordered table-striped" id="table-users">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Productos Recientes</h2>
                    <table class="table table-bordered table-striped" id="table-products">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
<<<<<<< HEAD
=======
=======
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

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        </div>
    </main>
</body>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                    document.getElementById('TotalUsers').innerHTML = `<i class="bi bi-person-fill"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalLicencias').innerHTML = `<i class="bi bi-file-earmark-check-fill"></i> ${data.TotalLicencias}`;
                    document.getElementById('TotalSchools').innerHTML = `<i class="bi bi-house-fill"></i> ${data.TotalSchools}`;
                })
                .catch(error => console.error('Error al obtener datos:', error));
<<<<<<< HEAD
=======
=======
                    document.getElementById('totalProducts').textContent = data.TotalProducts;
                    document.getElementById('totalUsers').textContent = data.TotalUser;
                    document.getElementById('totalEstudiantes').textContent = data.TotalEstudiantes;
                    document.getElementById('totalSchools').textContent = data.TotalSchools;
                })
                .catch(error => console.error('Error fetching data:', error));
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
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

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
        // Actualizar las funciones cada 1 segundos
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        setInterval(function () {
            updateCounts();
            getUsers();
            getProducts();
        }, 1000);
    </script>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>
