<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
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
    <main class="container mt-4">
        <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Directores</h5>
                            <p class="card-text display-4" id='TotalUsers2'>
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

                $sqlDias = $con->query("SELECT licencias.licencia_id, licencias.fecha_fin, empresas.nombre_escuela FROM licencias
                    INNER JOIN escuelas ON licencias.escuelas_id = escuelas.escuelas_id
                    INNER JOIN estados ON licencias.estado_id = estados.estado_id
                    WHERE estados.estado_id = 1 
                    AND licencias.fecha_fin BETWEEN '$hoy' AND '$treinta_dias'
                    ORDER BY licencias.fecha_fin ASC");
                $licencias = $sqlDias->fetchAll(PDO::FETCH_ASSOC);

                if (count($licencias) > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Empresa</th>
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
                <h2>Usuarios Recientes</h2>
                <table class="table-users table-striped table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody >
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <h2>Productos Recientes</h2>
                <table class="table-products table-striped table-hover table-dark">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody >
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers2').textContent = data.TotalUsers2;
                    document.getElementById('TotalLicencias').textContent = data.TotalLicencias;
                    document.getElementById('TotalSchools').textContent = data.TotalSchools;
                })
                .catch(error => console.error('Error al obtener datos:', error));
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

        setInterval(function () {
            updateCounts();
            getUsers();
            getProducts();
        }, 1000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>
