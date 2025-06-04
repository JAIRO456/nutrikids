<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $sqlInfoNutriconal = $con -> prepare("SELECT SUM(calorias) AS total_cal, SUM(proteinas) AS total_pro, SUM(carbohidratos) AS total_car,
    SUM(grasas) AS total_gras, SUM(azucares) AS total_azu, SUM(sodio) AS total_sod FROM informacion_nutricional");
    $sqlInfoNutriconal -> execute();
    $InfoNutric = $sqlInfoNutriconal -> fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <main class="container mt-2" style='background-color: #f3f4f6;'>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Directores</h5>
                        <p class="card-text display-4" id='TotalUsers'>
                            <i class="bi bi-person-fill"></i> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Licencias Activas</h5>
                        <p class="card-text display-4" id='TotalLicencias'>
                            <i class="bi bi-file-earmark-check-fill"></i> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Escuelas</h5>
                        <p class="card-text display-4" id='TotalSchools'>
                            <i class="bi bi-house-fill"></i> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text display-4" id='TotalProducts'>
                            <i class="bi bi-basket"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow mb-4">
            <h2 class="text-2xl font-semibold mb-2">Reportes Nutricionales</h2>
            <div class="flex space-x-4" style='width: 500px; height: 600px;'>
                <div class="flex-1">
                    <h4 class="text-lg font-semibold">Distribución de Nutrientes</h4>
                    <canvas id="nutrient" class="mt-4"></canvas>
                </div>
            </div>
        </div>
        <div class="card shadow">
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
                                <td><?= $licencia['nombre_escuela']; ?></td>
                                <td><?= date('d/m/Y', strtotime($licencia['fecha_fin'])) ?></td>
                                <td><?= $dias_restantes ?></td>
                                <td>
                                    <a href="licencias/update_licencia.php?id=<?= $licencia['id_licencia'] ?>" class="btn btn-sm btn-warning">Renovar</a>
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
        <div class="card shadow mt-4">
            <div class="card-header">
                <h4>Usuarios Recientes</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-users">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-header">
                <h4>Productos Recientes</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-products">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">

                    </tbody>
                </table>
            </div>
        </div>
        
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Nutrient Distribution Chart
        const nutrientChart = new Chart(document.getElementById('nutrient'), {
            type: 'pie',
            data: {
                labels: ['Calorias', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azucares', 'Sodio'],
                datasets: [{
                    data: [<?= $InfoNutric['total_cal'] ?>, <?= $InfoNutric['total_pro'] ?>,  <?= $InfoNutric['total_car'] ?>, <?= $InfoNutric['total_gras'] ?>, <?= $InfoNutric['total_azu'] ?>, <?= $InfoNutric['total_sod'] ?>],
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#36A2EB', '#FF6384', '#FFCE56']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers').innerHTML = `<i class="bi bi-person-fill"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalLicencias').innerHTML = `<i class="bi bi-file-earmark-check-fill"></i> ${data.TotalLicencias}`;
                    document.getElementById('TotalSchools').innerHTML = `<i class="bi bi-house-fill"></i> ${data.TotalSchools}`;
                    document.getElementById('TotalProducts').innerHTML = `<i class="bi bi-basket"></i> ${data.TotalProducts}`;
                })
                .catch(error => console.error('Error al obtener datos:', error));
        }

        function getUsers() {
            fetch('../ajax/get_users_limit.php')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.querySelector('#table-users tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td class="d-none d-sm-table-cell">${user.email}</td>
                            <td>
                                <a class='btn btn-primary' href="directores/update_admin.php?id=${user.documento}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="directores/delete_admin.php?id=${user.documento}"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        function getProducts() {
            fetch('../ajax/get_products_limit.php')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.querySelector('#table-products tbody')
                    tbody.innerHTML = '';
            
                    products.forEach(product => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${product.id_producto}</td>
                            <td>${product.nombre_prod}</td>
                            <td>${product.categoria}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los productos:', error));
        }
        // Cargar los datos al inicio
        document.addEventListener('DOMContentLoaded', function () {
            updateCounts();
            getUsers();
            getProducts();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>
